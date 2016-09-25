<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/25/16
 * Time: 5:51 PM
 */
require_once ('../Connection.php');
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
} else {
    echo "ajaxForEmployeeFailed";
}