<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 8:33 PM
 */

// get the all the book records in book table and display them as a table
include_once ('bookTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = new BookTable();
    $table->getBookTable();
    printf($table);
}