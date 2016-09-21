<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script>
        
    </script>
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
<div id="employeeForm">
    <button id="add">Add another Employee?</button>
</div>
<p>
    <a href="index.html">Go back to home page</a>
</p>
</body>
</html>