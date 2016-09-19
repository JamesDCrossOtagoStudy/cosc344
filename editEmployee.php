<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/19/16
 * Time: 4:49 PM
 */
require_once ('EmployeeTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    printf("the value we received is %s", $_GET['ird']);
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
</style>

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
            <input type="text" name="weekly_hours" id="weekly_hours" value="<?php echo $theEmployee->weekly_hours; ?>"
        </p>
        <p>
            <label>Hourly Rate</label>
            <input type="text" name="hourly_rate" id="hourly_rate" value="<?php echo $theEmployee->hourly_rate; ?>"
        </p>
        <p>
            <label>Bookstore Address</label>
            <input type="text" name="baddress" id="baddress" value="<?php echo $theEmployee->baddress; ?>"
        </p>
        <p>
            <input type="submit">
        </p>
    </form>
</div>



