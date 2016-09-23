<?php

/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/16/16
 * Time: 11:37 AM
 */
require_once('../Connection.php');

// represent a tuple of record of bookstore table

// A class hold the table of bookstore
class BookstoreTable extends Connection
{
    private static $bookstores = array();
    private $stid = null;

    public function __toString()
    {
        $str = "<table border='1'>\n";
        foreach (self::$bookstores as $eachBookstore) {
            $str .= $eachBookstore;
        }
        $str .= '</table>';

        return $str;
    }

    public function getBookStoreAtIndex($num)
    {
        return self::$bookstores[$num];
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

    public function getAllBookStores()
    {
        if ($this->testConnection()) {
            $this->stid = oci_parse(self::$conn, 'select * from bookstore');
            $r = oci_execute($this->stid);

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

    public function insertBookstore($storeID, $city, $address, $account, $data_opened, $total_salary) {
        $date = "TO_DATE('{$data_opened}','MM/DD/YYYY')";
        $insertString = "insert into bookstore VALUES ('{$storeID}', '{$city}', '{$address}', '{$account}', {$date}, {$total_salary})";

        $this->stid = oci_parse(self::$conn, $insertString);
        $result = oci_execute($this->stid);
    }

    public function __destruct()
    {
        if ($this->stid != null) {
            oci_free_statement($this->stid);
        }
        parent::__destruct();
    }
}

class SingleBookstore extends BookstoreTable
{
    private $storeID;
    private $city;
    private $address;
    private $account;
    private $date_opened;
    private $total_salary;

    
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
        $str .= '<td>' . ($this->storeID !== null ? htmlentities($this->storeID, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->city !== null ? htmlentities($this->city, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->address !== null ? htmlentities($this->address, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->account !== null ? htmlentities($this->account, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->date_opened !== null ? htmlentities($this->date_opened, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->total_salary !== null ? htmlentities($this->total_salary, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        return $str;
    }

    public function containWord($word)
    {
        if (strpos($this->address, $word) !== false
            || strpos($this->city, $word) !== false
            || $this->city == $word || $this->address == $word
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function setNewAddress($address, $storeID) {
        $updateString = "update bookstore set address = '{$address}'  where storeID = '{$this->storeID}'";
        $this->stid = oci_parse(self::$conn, $updateString);
        $result = oci_execute($this->stid);
        if (!$result) {
            printf("update failure\n");
        } else {
            $this->address = $address;
        }
        return $this;
    }

    public function __destruct()
    {
        if ($this->stid != null) {
            oci_free_statement($this->stid);
        }
    }
}





