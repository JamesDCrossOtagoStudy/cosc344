<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 11:09 AM
 */
require_once('bookstoreTable.php');

$theBookstore = null;

// if it is directed to this page by click the storeID
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = null;

    if ((isset($_GET['storeID'])) && !empty($_GET['storeID'])) {
        $id = $_GET['storeID'];

        if ($id != null) {
            $table = new BookstoreTable();
            $table->getAllBookStores();
            $theBookstore = $table->getBookstoreByID($id);
        }

    }

    $storeID = $theBookstore == null ? "" : $theBookstore->storeID;
    $city = $theBookstore == null ? "" : $theBookstore->city;
    $address = $theBookstore == null ? "" : $theBookstore->address;
    $account = $theBookstore == null ? "" : $theBookstore->account;
    $date_opened = $theBookstore == null ? "" : $theBookstore->date_opened;
    $total_salary = $theBookstore == null ? "" : $theBookstore->total_salary;
}

?>

<style type="text/css">
    form  { display: table;      }
    p     { display: table-row;  }
    label { display: table-cell; }
    input { display: table-cell; }
    select{ display: table-cell; }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="../js/formValidation.js"></script>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
        <div class="container">
            <form action="bookstoreForm.php" method="post" id="bookstoreForm">
                <p>
                    <label>Bookstore ID</label>
                    <input type="text" name="storeID" id="storeID" value="<?php echo $storeID; ?>" disabled>
                </p>
                <p>
                    <label>City</label>
                    <input type="text" name="city" id="city" value="<?php echo $city; ?>">
                </p>
                <p>
                    <label>Address</label>
                    <input type="text" name="address" id="address" value="<?php echo $address; ?>">
                </p>
                <p>
                    <label>Account Number</label>
                    <input type="text" name="account" id="account" value="<?php echo $account; ?>">
                </p>
                <p>
                    <label>Open Date</label>
                    <input type="text" name="date_opened" id="date_opened" value="<?php echo $date_opened; ?>">
                </p>
                <p>
                    <label>Total Salary</label>
                    <input type="text" name="total_salary" id="total_salary" value="<?php echo $total_salary; ?>" disabled>
                </p>
                <p>
                    <input type="submit" value="Save" id="submit" name="submit" onclick="return=false">
                </p>
            </form>
        </div>
        <?php
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    }