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
<div id="bookstoreForm">
    <div id="insertionForm">
        <button id="add">Add another Bookstore?</button>
    </div>
</div>
<p>
    <a href="../index.html" id="go_back_home">Go back to home page</a>
</p>
</body>
</html>

