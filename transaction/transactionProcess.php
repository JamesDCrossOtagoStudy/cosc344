<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 10:30 PM
 */
require_once ('../customer/customerTable.php');
require_once ('../employee/employeeTable.php');
require_once ('../book/bookTable.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>
    <h2>
        Shopping Simulation:
    </h2>
    <div class="container">
        <form id="processForm" name="processForm">
            <select name="employee" id="employee">
                <option>
                    Select employee who do the operation:
                </option>
            </select>
            <select name="customer" id="customer">
                <option>
                    Select the customer who buy the book:
                </option>
            </select>
            <select>
                <option>
                    Select the book you want to buy:
                </option>
            </select>
            <select>
                <option>
                    Available number of this book:
                </option>
            </select>
        </form>
    </div>
    <?php
}