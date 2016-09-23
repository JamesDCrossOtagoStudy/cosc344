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
                            $('#stock_available').html(html);
                        }
                    });
                }
            });
        });
    </script>

    <h2>
        Shopping Simulation:
    </h2>
    <div class="container">
        <form id="processForm" name="processForm">
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
            <select id="selectedBook" name="selectedBook">
                <?php
                if ($connection->testConnection()) {
                    $conn = $connection->getConnection();
                    $queryString = "select TITLE, ISBN from book";
                    $stid = oci_parse($conn, $queryString);
                    $result = oci_execute($stid);
                    if ($result) {
                        echo "<option>Select the book you want to buy:</option>";
                        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                            echo "<option value='{$row['ISBN']}'>" . $row['TITLE'] . "</option>";
                        }
                    }
                }
                ?>
            </select>
            <select id="stock_available" name="stock_available">
                <option>Select the book First</option>
            </select>
        </form>
    </div>
    <?php
}