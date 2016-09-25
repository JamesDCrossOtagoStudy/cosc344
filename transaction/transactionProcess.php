<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 10:30 PM
 */
require_once('../customer/customerTable.php');
require_once('../employee/employeeTable.php');
require_once('../book/bookTable.php');
require_once('../Connection.php');

$connection = new Connection();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>
    <style type="text/css">
        form {
            display: table;
        }

        p {
            display: table-row;
        }

        label {
            display: table-cell;
        }

        input {
            display: table-cell;
        }

        select {
            display: table-cell;
        }

        option:nth-child(1) {
            font-weight: bold;
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            //create book selection list
            $('#selectedBook').on('change', function () {
                var selectedBookISBN = $(this).val();
                if (selectedBookISBN) {
                    $.ajax('ajaxForSelectingISBN.php', {
                        type: 'POST',
                        data: 'selectedBookISBN=' + selectedBookISBN,
                        success: function (html) {
                            $('#numberOfBookSelected').html(html);
                            var selectedNumOfBook = $('#numberOfBookSelected').val();
                            if (selectedNumOfBook) {
                                $('#addToShoppingList').prop('disabled', false);
                            }
                        }
                    });
                } else {
                    $('#numberOfBookSelected').html("<option value=''>Select the book First</option>")
                    $('#addToShoppingList').prop('disabled', true);
                }
            });

            // create shopping list table
            $('#addToShoppingList').on('click', function () {
                $('#purchasingItemsContainer').show();
                var selectedBookISBN = $('#selectedBook').val();
                var selectedNum = $('#numberOfBookSelected').val();
                var selectedBookName = $('#selectedBook option:selected').html()

                if (selectedBookISBN && selectedNum) {
                    var purchasingItem = selectedBookISBN;
                    var maxAvailableNumber = $('#numberOfBookSelected option:last-child').val();

                    var itemInfo = "<tr> <td class='rowISBN'>" + selectedBookISBN + "</td> <td>" + selectedBookName + "</td><td class='rowNumber'>"
                        + "<input value=" + selectedNum + "></td><td class='limit'>" + maxAvailableNumber + "</td></tr>"
                    var append = true;

                    $('.rowISBN').each(function () {
                        if (this.textContent == selectedBookISBN) {
                            var numberOfItemInputElement = $(this).siblings('.rowNumber').find('input');
                            var v = numberOfItemInputElement.val();
                            numberOfItemInputElement.val(Number(v) + Number(selectedNum));
                            if (Number(numberOfItemInputElement.val()) > Number(maxAvailableNumber)) {

                                alert("The maxinum number of this book you can buy is: " + maxAvailableNumber);
                                numberOfItemInputElement.val(maxAvailableNumber);
                            }
                            append = false;
                        }
                    });

                    if (append) {
                        $('#purchasingInfo').append(itemInfo);
                    }
                }
            });

            // checkout action
            $('#checkout').on('click', function () {
                var purchasedBook = {};

                $('.rowISBN').each(function () {
                    var purchasingBookISBN = this.textContent;
                    purchasedBook[purchasingBookISBN] = $(this).siblings('.rowNumber').find('input').val();
                });


                var employee = $('#employee').val();
                var customer = $('#customer').val();
                if (checkoutFormValidation()) {
                    $.ajax('ajaxForTransactionRecord.php', {
                        type: 'POST',
                        data: {'employeeID': employee, 'customerID': customer, 'purchasedBook': purchasedBook},
                        success: function (html) {
                            $('.container').after(html);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function checkoutFormValidation() {
            if ($('#employee').val() == '') {
                alert('You must select the employee who do the operation.');
                return false;
            }
            if ($('#customer').val() == '') {
                alert('You must select the customer who purchase the book.');
                return false;
            }

            var inputValueValid = true;
            $('.rowISBN').each(function () {
                var numberOfItemInputElement = $(this).siblings('.rowNumber').find('input');
                var v = numberOfItemInputElement.val();

                var maxLimit = Number($(this).siblings('.limit').html());
                if (v > maxLimit || v <= 0) {
                    alert("The number of book cannot > max or <= 0");
                    inputValueValid = false;
                    return false;
                }
            });
            return inputValueValid;
        }
    </script>
    <h2>
        Shopping Simulation:
    </h2>


    <div class="container">
        <form id="processForm" name="processForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
              onsubmit="return checkoutFormValidation()">
            <p>
                <label>the employee who do the operation</label>
                <select name="employee" id="employee">
                    <?php
                    if ($connection->testConnection()) {
                        $conn = $connection->getConnection();
                        $queryString = "select ird_number from employee";
                        $stid = oci_parse($conn, $queryString);
                        $result = oci_execute($stid);
                        if ($result) {
                            echo "<option value=''>Select employee who do the operation:</option>";
                            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                echo "<option value='{$row['IRD_NUMBER']}'>" . $row['IRD_NUMBER'] . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label>the customer who do the purchase</label>
                <select name="customer" id="customer">
                    <?php
                    if ($connection->testConnection()) {
                        $conn = $connection->getConnection();
                        $queryString = "select CUSTOMER_ID from customer";
                        $stid = oci_parse($conn, $queryString);
                        $result = oci_execute($stid);
                        if ($result) {
                            echo "<option value=''>Select customer who do the operation:</option>";
                            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                echo "<option value='{$row['CUSTOMER_ID']}'>" . $row['CUSTOMER_ID'] . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label>the book to purchase</label>
                <select id="selectedBook" name="selectedBook">
                    <?php
                    if ($connection->testConnection()) {
                        $conn = $connection->getConnection();
                        $queryString = "select TITLE, ISBN from book";
                        $stid = oci_parse($conn, $queryString);
                        $result = oci_execute($stid);
                        if ($result) {
                            echo "<option value=''>Select the book you want to buy</option>";
                            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                echo "<option value='{$row['ISBN']}'>" . $row['TITLE'] . "</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label>Please select the number of books you want to buy</label>
                <select id="numberOfBookSelected" name="numberOfBookSelected">
                    <option value=''>Select the book First</option>
                </select>
                <button type="button" name="addToShoppingList" id="addToShoppingList" disabled>Add to shopping list
                </button>
            </p>
            <div id="purchasingItemsContainer" hidden>
                <p>Purchasing Item:</p>
                <table id="purchasingInfo" border="1">
                    <tr>
                        <td>Book ISBN</td>
                        <td>Book Name</td>
                        <td>Number of Item</td>
                        <td>Max available num</td>
                    </tr>
                </table>
                <button type="submit" id="checkout" name="checkout">checkout</button>
            </div>
        </form>
    </div>
    <div id="transactionContainer">
        <?php
        if ($connection->testConnection()) {
            $conn = $connection->getConnection();
            $queryString = "select transaction_number, ird_number, e.fname as employee_name, customer_id, " .
                "c.fname as customer_name, isbn, title from employee e, customer c, book b, transactions t, book_tran bt ".
                "where b.isbn = bt.bisbn and e.ird_number = t.eird_number and c.customer_id = t.ccustomer_id ".
                " and t.transaction_number = bt.ttransaction_number";

            $stid = oci_parse($conn, $queryString);
            $result = oci_execute($stid);

            if ($result) {
                ?>
                <table border="">
                    <tr>
                        <td>Transaction Number</td>
                        <td>Employee Number</td>
                        <td>Employee Fname</td>
                        <td>Customer ID</td>
                        <td>Customer Fname</td>
                        <td>Book ISBN</td>
                        <td>Book Name</td>
                    </tr>
                    <?php
                    while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS + OCI_ASSOC)) {
                        print '<tr>';
                        foreach ($row as $item) {
                            print '<td>' . ($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp') . '</td>';
                        }
                        print '</tr>';
                    }
                    ?>
                </table>
                    <?php
            }
        }
        ?>
    </div>
    <a href="../index.html" id="go_back_home">Go back to home page</a>
        <?php
} else {
    header('Location: ' . $_SERVER['REQUEST_URI']);
}