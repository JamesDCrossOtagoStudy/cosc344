<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 8:24 PM
 */
/**
SQL> describe book;
Name					   Null?    Type
----------------------------------------- -------- ----------------------------
TITLE					   NOT NULL VARCHAR2(30)
ISBN					   NOT NULL CHAR(17)
FNAME					   NOT NULL VARCHAR2(15)
MIDDLE_INIT					    CHAR(1)
LNAME					   NOT NULL VARCHAR2(15)
PRICE						    NUMBER(5)
AMOUNT_IN_STOCK				    NUMBER(2)
 */


require_once ('../Connection.php');

class BookTable extends Connection {
    private static $table = [];
    private $stid = null;

    public function __toString()
    {
        $str = "<table border='1'>\n";

        $str .= "\n";
        $str .= "<tr>\n";
        $str .= '<td>' . "title" . '</td>';
        $str .= '<td>' . "ISBN" . '</td>';
        $str .= '<td>' . "first name" . '</td>';
        $str .= '<td>' . "middle_init" . '</td>';
        $str .= '<td>' . "last name" . '</td>';
        $str .= '<td>' . "price" . '</td>';
        $str .= '<td>' . "amount_in_stock" . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        foreach (self::$table as $eachRow) {
            $str .= $eachRow;
        }
        $str .= '</table>';

        return $str;
    }

    public function getBookTable() {
        if ($this->testConnection()) {
            $this->stid = oci_parse(self::$conn, 'select * from book');
            $result = oci_execute($this->stid);

            while ($row = oci_fetch_array($this->stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $eachCustomer = new Book();

                $eachCustomer->title = $row['TITLE'];
                $eachCustomer->isbn = $row['ISBN'];
                $eachCustomer->fname = $row['FNAME'];
                $eachCustomer->middle_init = $row['MIDDLE_INIT'];
                $eachCustomer->lname = $row['LNAME'];
                $eachCustomer->price = $row['PRICE'];
                $eachCustomer->amount_in_stock = $row['AMOUNT_IN_STOCK'];
                array_push(self::$table, $eachCustomer);
            }
        }
    }
}

/**
SQL> describe book;
Name					   Null?    Type
----------------------------------------- -------- ----------------------------
TITLE					   NOT NULL VARCHAR2(30)
ISBN					   NOT NULL CHAR(17)
FNAME					   NOT NULL VARCHAR2(15)
MIDDLE_INIT					    CHAR(1)
LNAME					   NOT NULL VARCHAR2(15)
PRICE						    NUMBER(5)
AMOUNT_IN_STOCK				    NUMBER(2)
 */


class Book {
    public $title = "";
    public $isbn = "";
    public $fname = "";
    public $middle_init = "";
    public $lname = "";
    public $price = 0;
    public $amount_in_stock = 0;

    public function __toString()
    {
        $str = "\n";
        $str .= "<tr>\n";
        $str .= '<td>' . ($this->title !== null ? htmlentities($this->title, ENT_QUOTES) : '&nbsp') . '</td>';

        if ($this->isbn !== null) {
            $tmp = htmlentities($this->isbn, ENT_QUOTES);
        } else {
            $tmp = '&nbsp';
        }
        $str .= '<td>' . "<a href=bookForm.php?ird=$tmp>" . $tmp . "</a>" . '</td>';
        
        $str .= '<td>' . ($this->fname !== null ? htmlentities($this->fname, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->middle_init !== null ? htmlentities($this->middle_init, ENT_QUOTES) : '&nbsp') . '</td>';
        
        $str .= '<td>' . ($this->lname !== null ? htmlentities($this->lname, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->price !== null ? htmlentities($this->price, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->amount_in_stock !== null ? htmlentities($this->amount_in_stock, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";
        return $str;
    }

}