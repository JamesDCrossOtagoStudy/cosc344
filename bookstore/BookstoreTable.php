<?php

/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/16/16
 * Time: 11:37 AM
 */
require ('../Connection.php');

// A class hold the table of bookstore
class BookstoreTable extends Connection
{
    /*
     * In the class, it hold a array of SingleBookstore, each instance of SingleBookstore represent a row of records in
     * the bookstore table in db.
     * */
    private static $bookstores = array();
    private $stid = null;

    /*
     * return a string which can be embed
     * */
    public function __toString()
    {
        $str = "<table border='1'>\n";
        foreach (self::$bookstores as $eachBookstore) {
            $str .= $eachBookstore;
        }
        $str .= '</table>';

        return $str;
    }

    // get a book by providing ID
    public function getBookstoreByID($id)
    {
        if ($this->testConnection()) {
            $this->stid = oci_parse(self::$conn, "select * from bookstore WHERE storeID='{$id}'");
            $result = oci_execute($this->stid);

            while ($row = oci_fetch_array($this->stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $storeID = $row['STOREID'];
                $city = $row['CITY'];
                $address = $row['ADDRESS'];
                $account = $row['ACCOUNT'];
                $date_opened = $row['DATE_OPENED'];
                $total_salary = $row['TOTAL_SALARY'];
                $theBookstore = new SingleBookstore($storeID, $city, $address, $account, $date_opened, $total_salary);
                return $theBookstore;
            }
        }
    }

    // return an array of bookstore which contains the word you specified
    public function getBookStoreWithWord($word)
    {
        $someBookStores = array();
        foreach (self::$bookstores as $eachBookstore) {
            if ($eachBookstore->containWord($word)) {
                array_push($someBookStores, $eachBookstore);
            }
        }

        return $someBookStores;
    }

    // get all the books in book table
    public function getAllBookStores()
    {
        if ($this->testConnection()) {
            $this->stid = oci_parse(self::$conn, 'select * from bookstore');
            $r = oci_execute($this->stid);

            self::$bookstores = [];
            while ($row = oci_fetch_array($this->stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $storeID = $row['STOREID'];
                $city = $row['CITY'];
                $address = $row['ADDRESS'];
                $account = $row['ACCOUNT'];
                $date_opened = $row['DATE_OPENED'];
                $total_salary = $row['TOTAL_SALARY'];
                $eachBookstore = new SingleBookstore($storeID, $city, $address, $account, $date_opened, $total_salary);
                array_push(self::$bookstores, $eachBookstore);
            }
        }
    }

    // create a new book by proving: $storeID, $city, $address, $account, $data_opened
    public function insertBookstore($storeID, $city, $address, $account, $data_opened) {
        $date = "TO_DATE('{$data_opened}','MM/DD/YYYY')";
        $insertString = "insert into bookstore VALUES ('{$storeID}', '{$city}', '{$address}', '{$account}',  $date, '0')";
        echo $insertString;
        $this->stid = oci_parse(self::$conn, $insertString);
        $result = oci_execute($this->stid);
    }
    
    // update a bookstore by $storeID, with value: $city, $address, $account, $data_opened
    public function updateBookstoreWithID($city, $address, $account, $data_opened, $storeID) {
        $updateString = "update bookstore set CITY='{$city}', address='{$address}', account='{$account}', date_opened='{$data_opened}' where storeID='{$storeID}'";
        echo "update string is: \n $updateString";

        $this->stid = oci_parse(self::$conn, $updateString);
        $result = oci_execute($this->stid);
        
        if (!$result) {
            echo "<p>Update failed, updateString is:" . $updateString . "</p>";
        }
    }

    public function __destruct()
    {
        if ($this->stid != null) {
            oci_free_statement($this->stid);
        }
        parent::__destruct();
    }
}

/*
 * This class represent one row of records of book table in db.
 * */
class SingleBookstore extends BookstoreTable
{
    public $storeID;
    public $city;
    public $address;
    public $account;
    public $date_opened;
    public $total_salary;

    
    private $stid = null;
    
    public function __construct($storeID, $city, $address, $account, $data_opened, $total_salary)
    {
        parent::__construct();
        $this->storeID = $storeID;
        $this->city = $city;
        $this->address = $address;
        $this->account = $account;
        $this->date_opened = $data_opened;
        $this->total_salary = $total_salary;
    }

    public function __toString()
    {
        $str = "\n";
        $str .= "<tr>\n";
        if ($this->storeID !== null) {
            $tmp = htmlentities($this->storeID, ENT_QUOTES);
        } else {
            $tmp = '&nbsp';
        }
        $str .= '<td>' . "<a href=bookstoreForm.php?storeID=$tmp>" . $tmp . "</a>" . '</td>';
        
        $str .= '<td>' . ($this->city !== null ? htmlentities($this->city, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->address !== null ? htmlentities($this->address, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->account !== null ? htmlentities($this->account, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->date_opened !== null ? htmlentities($this->date_opened, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->total_salary !== null ? htmlentities($this->total_salary, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        return $str;
    }
    

    public function __destruct()
    {
        if ($this->stid != null) {
            oci_free_statement($this->stid);
        }
    }
}





