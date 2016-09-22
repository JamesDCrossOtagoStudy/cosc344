<?php
//require_once('bookstoreTable.php');
//?>
<!--    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
<!--    <link rel="stylesheet" href="/resources/demos/style.css">-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>-->
<!--    <script>-->
<!--        $( function() {-->
<!--            $( "#datepicker" ).datepicker({-->
<!--                changeMonth: true,-->
<!--                changeYear: true-->
<!--            });-->
<!--        } );-->
<!--    </script>-->
<?php
//
//if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//    ?>
<!--    <form action="insertBookstore.php" method="post"><pre>-->
<!--        CITY        <input type="text" name="city">-->
<!--        ADDRESS     <input type="text" name="address">-->
<!--        ACCOUNT     <input type="text" name="account">-->
<!--        DATE_OPENED <input type="text" name="date_opened" id="datepicker">-->
<!--        TOTAL_SALARY<input type="text" name="total_salary">-->
<!--        <input type="submit">-->
<!--    </pre></form>-->
<!--    <p>-->
<!--        <a href="../index.html">home</a>-->
<!--    </p>-->
<!--    --><?php
//} else {
//    $bookstoreTable = new BookstoreTable();
//    $city = $_POST["city"];
//    $address = $_POST["address"];
//    $account = $_POST["account"];
//    $date_opened = $_POST["date_opened"];
//    $total_salary = $_POST["total_salary"];
//
//    $bookstoreTable->insertBookstore($city, $address, $account, $date_opened, $total_salary);
//    header('Location: '.'http://titanium.otago.ac.nz:8080/wzhao/projects/index.html');
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style type="text/css">
        form {
            display: table;
        }

        p {
            display: table-row;
        }

        label {
            display: table-cell;
        }

        input {
            display: table-cell;
        }

        select {
            display: table-cell;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
<?php
include_once('../Connection.php');
include_once('bookstoreTable.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = new BookstoreTable();
    $table->getAllBookStores();
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

