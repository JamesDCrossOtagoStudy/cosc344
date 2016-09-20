<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>-->
<!--    <script>-->
<!--        $(document).ready(function () {-->
<!--            $('#weekly_hours').on('change', function () {-->
<!--                var selectedValue = $(this).val();-->
<!--                if (selectedValue) {-->
<!--                    $.ajax('ajaxData.php', {-->
<!--                        type: 'POST',-->
<!--                        data: 'selected_weekly_hours=' + selectedValue,-->
<!--                        success: function (html) {-->
<!--                            $('#hourly_rate').html(html);-->
<!--                        }-->
<!--                    });-->
<!--                } else {-->
<!--                    $('#hourly_rate').html('<option value="">Select Hourly Rate</option>')-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    </script>-->
</head>
<body>
<?php
include_once('Connection.php');
include_once('EmployeeTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = new EmployeeTable();
    $table->update();
    printf($table);
}
?>

<!--<select name="weekly_hours" id="weekly_hours">-->
<!--    <option value="">Select Weekly Hours</option>-->
<!--    --><?php
//    // for employee wage selection
//    $connection = new Connection();
//    if ($connection->testConnection()) {
//        $conn = $connection->getConnection();
//        $queryString = "select distinct(weekly_hours) from employee_wage";
//        $stid = oci_parse($conn, $queryString);
//
//        $result = oci_execute($stid);
//        if ($result) {
//            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
//                echo "<option value={$row['WEEKLY_HOURS']}>" . $row['WEEKLY_HOURS'] . "</option>";
//            }
//        }
//        oci_free_statement($stid);
//    }
//    ?>
<!--</select>-->
<!--<select name="hourly_rate" id="hourly_rate">-->
<!--    <option value="">Select Hourly Rate</option>-->
<!--</select>-->
</body>
</html>