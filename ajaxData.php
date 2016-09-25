<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/19/16
 * Time: 11:53 PM
 */
require_once ('Connection.php');
$connection = new Connection();

// generate data from selection of hourly_rate
if (isset($_POST['selected_weekly_hours']) && !empty($_POST['selected_weekly_hours'])) {
    // get hourly rate based on selected weekly_hours
    $conn = $connection->getConnection();
    $queryString = "select distinct(hourly_rate) from employee_wage where weekly_hours=".$_POST['selected_weekly_hours'];
    $stid = oci_parse($conn, $queryString);

    $result = oci_execute($stid);
    if ($result) {
        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
            $hourly_rate = $row['HOURLY_RATE'];
           echo "<option value=" . $hourly_rate .">" . $row['HOURLY_RATE'] . "</option>";
        }
    } else {
        echo '<option value="">No Hourly Rate available</option>';
    }
    oci_free_statement($stid);
    oci_close($conn);

    //generate available book number
} elseif (isset($_POST['selectedBookISBN']) && !empty($_POST['selectedBookISBN'])) {
    echo "<p>Success!</p>";
    $conn = $connection->getConnection();
    $isbn = $_POST['selectedBookISBN'];

    $queryString = "select AMOUNT_IN_STOCK from book where ISBN=" . "'{$isbn}'";

    echo $queryString;

    $stid = oci_parse($conn, $queryString);

    $result = oci_execute($stid);
    if ($result) {
        $available = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
            $available = $row['AMOUNT_IN_STOCK'];
        }

        if ($available != 0 || $available != "0" || $available == "") {
            for ($i = 1; $i <= $available; $i++) {
                echo "<option value=" . $i . ">" . $i . "</option>";
            }
        } else {
            echo  "<option value='0' selected disabled>0</option>";
        }
    }
    oci_free_statement($stid);
    oci_close($conn);

} elseif (isset($_POST['purchasedBook']) && !empty($_POST['purchasedBook'])) {
    $customerID = $_POST['customerID'];
    $employeeID = $_POST['employeeID'];
    $purchasedBook = [];
    $purchasedBook = $_POST['purchasedBook'];

    // insert transaction into db:
    date_default_timezone_set("Pacific/Auckland");
    $date = date("d-m-Y");
    $time = date("H:i:s");

    $transaction_number = $date.$time;

    $insertString = "";
    // insert transaction first
    $insertString = "insert into TRANSACTIONS VALUES (TO_DATE('{$date}', 'DD-MM-YYYY'), TO_DATE('{$time}', 'hh24:mi:ss') ,'{$transaction_number}', '${employeeID}', '${customerID}')";
    echo $insertString;
    echo "<br>";

    $conn = $connection->getConnection();
    $stid = oci_parse($conn, $insertString);
    $result = oci_execute($stid);

    // insert book_tran second
    foreach ($purchasedBook as $key => $value) {
        echo "key->" . $key . " value->" . $value . "<br>";
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
    echo "<p>Ajax Data Failed!</p>";
}


