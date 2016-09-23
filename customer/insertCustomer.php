<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 8:33 PM
 */
require_once ('customerTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = new CustomerTable();
    $table->getCustomerTable();
    printf($table);
}