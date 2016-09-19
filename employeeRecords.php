<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <?php
        include_once ('EmployeeTable.php');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $table = new EmployeeTable();
            $table->getAllEmployee();
            printf($table);
        }
    ?>
<a href=""></a>
</body>
</html>