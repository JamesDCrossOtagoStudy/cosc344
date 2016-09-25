<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/25/16
 * Time: 5:52 PM
 */
require_once ('../Connection.php');
$connection = new Connection();

if (isset($_POST['selectedBookISBN']) && !empty($_POST['selectedBookISBN'])) {
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

} else {
    echo "<p>Ajax Data Failed for getting book with specified ISBN</p>";
}