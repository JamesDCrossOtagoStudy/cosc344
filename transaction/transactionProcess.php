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
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#selectedBook').on('change', function () {
                var selectedBookISBN = $(this).val();
                if (selectedBookISBN) {
                    $.ajax('../ajaxData.php', {
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

            $('#addToShoppingList').on('click', function () {
                $('#purchasingItemsContainer').show();
                var selectedBookISBN = $('#selectedBook').val();
                var selectedNum = $('#numberOfBookSelected').val();
                var selectedBookName = $('#selectedBook option:selected').html()

                if (selectedBookISBN && selectedNum) {
                    var purchasingItem = selectedBookISBN
                    var itemInfo = "<tr> <td>" + selectedBookISBN + "</td> <td>" + selectedBookName + "</td><td>" + selectedNum + "</td></tr>"
                    $('#purchasingInfo').append(itemInfo);
                }
            });
        });
    </script>
    <h2>
        Shopping Simulation:
    </h2>
    <div class="container">
        <form id="processForm" name="processForm" action="transactionProcess.php">
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
                            echo "<option>Select employee who do the operation:</option>";
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
                            echo "<option>Select customer who do the operation:</option>";
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
                <button type="button" name="addToShoppingList" id="addToShoppingList" disabled>Add to shopping list</button>
            </p>
            <div id="purchasingItemsContainer" hidden>
                <p>Purchasing Item:</p>
                <table id="purchasingInfo" border="1">
                    <tr>
                        <td>Book ISBN</td>
                        <td>Book Name</td>
                        <td>Number of Item</td>
                    </tr>
                </table>
                <button type="submit" id="payButton">Pay the bill</button>
            </div>
        </form>
    </div>
    <?php
}