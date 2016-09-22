<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/17/16
 * Time: 5:17 PM
 */
require_once('bookstoreTable.php');
$bookstoreTable = new BookstoreTable();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $bookstoreTable->getAllBookStores();
    printf($bookstoreTable);
}
?>
<h4>
    Search specific bookstores based on the address or city:
</h4>

<?php
?>

<p>
    <a href="../index.html">go back to homepage</a>
</p>
