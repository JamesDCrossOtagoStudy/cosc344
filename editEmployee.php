<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/19/16
 * Time: 4:49 PM
 */
require_once ('EmployeeTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $ird = $_GET['ird'];
    if ($ird != null) {
        $table = new EmployeeTable();
        $theEmployee = $table->getEmployeeByIRD($ird);
    }
} else {
    printf("you are posting info");
}
?>
<style type="text/css">
    form  { display: table;      }
    p     { display: table-row;  }
    label { display: table-cell; }
    input { display: table-cell; }
    select{ display: table-cell; }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#weekly_hours').on('change', function () {
            var selectedValue = $(this).val();
            if (selectedValue) {
                $.ajax('ajaxData.php', {
                    type: 'POST',
                    data: 'selected_weekly_hours=' + selectedValue,
                    success: function (html) {
                        $('#hourly_rate').html(html);
                    }
                });
            } else {
                $('#hourly_rate').html('<option value="">Select Hourly Rate</option>')
            }
        });
    });
</script>


<div class="container">
    <form action="editEmployee.php" method="post">
        <p>
            <label>First Name</label>
            <input type="text" name="fname" id="fname" value="<?php echo $theEmployee->fname; ?>"
        </p>
        <p>
            <label>Middle Name</label>
            <input type="text" name="middle" id="middle" value="<?php echo $theEmployee->middle_init; ?>"
        </p>
        <p>
            <label>Last Name</label>
            <input type="text" name="lname" id="lname" value="<?php echo $theEmployee->lanme; ?>"
        </p>
        <p>
            <label>IRD Number</label>
            <input type="text" name="ird_number" id="ird" value="<?php echo $theEmployee->ird_number; ?>"
        </p>
        <p>
            <label>Contact Number</label>
            <input type="text" name="contact_number" id="contact" value="<?php echo $theEmployee->contact_number; ?>"
        </p>
        <p>
            <label>Weekly Hours</label>
            <select name="weekly_hours" id="weekly_hours">
                <option value=""><?php echo $theEmployee->weekly_hours; ?></option>
                <?php
                // for employee wage selection
                $connection = new Connection();
                if ($connection->testConnection()) {
                    $conn = $connection->getConnection();
                    $queryString = "select distinct(weekly_hours) from employee_wage";
                    $stid = oci_parse($conn, $queryString);

                    $result = oci_execute($stid);
                    if ($result) {
                        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                            echo "<option value={$row['WEEKLY_HOURS']}>" . $row['WEEKLY_HOURS'] . "</option>";
                        }
                    }
                }
                ?>
            </select>
        </p>
        <p>
            <label>Hourly Rate</label>
            <select name="hourly_rate" id="hourly_rate">
                <option value=""><?php echo $theEmployee->hourly_rate; ?></option>
            </select>
        </p>
        <p>
            <label>Bookstore Address</label>
            <select name="baddress" id="baddress">
                <option value=""><?php echo $theEmployee->baddress; ?></option>
                <?php
                    if ($connection->testConnection()) {
                        $conn = $connection->getConnection();
                        $queryString = "select distinct(address) from bookstore";
                        $stid = oci_parse($conn, $queryString);

                        $result = oci_execute($stid);
                        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                            echo "<option value={$row['ADDRESS']}>" . $row['ADDRESS'] . "</option>";
                        }
                    }
                ?>
            </select>
<!--            <input type="text" name="baddress" id="baddress" value="--><?php //echo $theEmployee->baddress; ?><!--"-->
        </p>
        <p>
            <input type="submit" value="save">
        </p>
    </form>
</div>



