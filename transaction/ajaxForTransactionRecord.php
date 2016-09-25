<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/25/16
 * Time: 5:52 PM
 */
require_once ('../Connection.php');
$connection = new Connection();

if (isset($_POST['purchasedBook']) && !empty($_POST['purchasedBook'])) {
    $customerID = $_POST['customerID'];
    $employeeID = $_POST['employeeID'];
    $purchasedBook = $_POST['purchasedBook'];

    // insert transaction into db:
    date_default_timezone_set("Pacific/Auckland");
    $date = date("d-m-Y");
    $time = date("H:i:s");

    $transaction_number = $date.$time;

    $insertString = "";
    // insert transaction first
    $insertString = "insert into TRANSACTIONS VALUES (TO_DATE('{$date}', 'DD-MM-YYYY'), TO_DATE('{$time}', 'hh24:mi:ss') ,'{$transaction_number}', '${employeeID}', '${customerID}')";


    $conn = $connection->getConnection();
    $stid = oci_parse($conn, $insertString);
    $result = oci_execute($stid);

    // insert book_tran second
    foreach ($purchasedBook as $key => $value) {
        $insertString = "insert into BOOK_TRAN VALUES ('${key}', '${transaction_number}')";
        $stid = oci_parse($conn, $insertString);
        $result = oci_execute($stid);
        if ($result) {
            $checkCurrentStockString = "select AMOUNT_IN_STOCK from book where ISBN='${key}'";
            $stid = oci_parse($conn, $checkCurrentStockString);
            $result = oci_execute($stid);
            $numberAvailable = -1;
            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $numberAvailable = $row['AMOUNT_IN_STOCK'];
            }
            if ($numberAvailable != -1) {
                $setValue = $numberAvailable - $value;
                $updateString = "update book set AMOUNT_IN_STOCK='{$setValue}' WHERE ISBN='{$key}'";
                $stid = oci_parse($conn, $updateString);

                $result = oci_execute($stid);
                if (!$result) {
                    echo "Updating Available number of book failed\n";
                }
            }

        }
    }
    oci_free_statement($stid);
    oci_close($conn);
}
else {
    echo "<p>Ajax Data Failed for checkout!</p>";
}