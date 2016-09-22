<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
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
            $('#add').on('click', function () {
               $.ajax('employeeForm.php', {
                   data: "addNewEmployee=1",
                   success: function (html) {
                       $('#insertionForm').html(html);
                       $('#ird').prop('disabled', false);
                       $('#submit').val('Add');
                       $('#go_back_home').prop('disable', true).hide();
                   }
               });
            });
        });
    </script>
</head>
<body>
<?php
include_once('../Connection.php');
include_once('employeeTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = new EmployeeTable();
    $table->update();
    printf($table);
}
?>
<br>
<div id="employeeForm">
    <div id="insertionForm">
        <button id="add">Add another Employee?</button>
    </div>
</div>
<p>
    <a href="../index.html" id="go_back_home">Go back to home page</a>
</p>
</body>
</html>