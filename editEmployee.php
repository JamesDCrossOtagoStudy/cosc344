<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/19/16
 * Time: 4:49 PM
 */
   if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       printf("the value we received is %s", $_GET['ird']);
   } else {
       printf("you are posting info");
   }
?>

<form action="editEmployee.php" method="post">
    <table>
        <tr>
            <td>
                First Name<input type="text" name="fname">
            </td>
        </tr>
        <tr>
            <td>
                Middle Name<input type="text" name="middle">
            </td>
        </tr>
        <tr>
            <td>
                Last Name <input type="text" name="lname">
            </td>
        </tr>
        <tr>
            <td>
                IRD Number <input type="text" name="ird_number">
            </td>
        </tr>
        <tr>
            <td>
                Contact Number <input type="text" name="contact_number">
            </td>
        </tr>
        <tr>
            <td>
                Weekly Hours <input type="text" name="weekly_hours">
            </td>
        </tr>
        <tr>
            <td>
                Hourly Rate <input type="text" name="hourly_rate">
            </td>
        </tr>
        <tr>
            <td>
                Bookstore Address <input type="text" name="baddress">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit">
            </td>
        </tr>
    </table>
</form>
