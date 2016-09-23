<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 8:33 PM
 */
include_once ('bookTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = new BookTable();
    $table->getBookTable();
    printf($table);
}