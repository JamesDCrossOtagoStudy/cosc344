<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/23/16
 * Time: 7:57 PM
 */

//SQL> describe customer;
// Name					   Null?    Type
//----------------------------------------- -------- ----------------------------
//STREET_NUMBER					    NUMBER(5)
// STREET_NAME					    VARCHAR2(30)
// POSTCODE				   NOT NULL NUMBER(4)
// CUSTOMER_ID				   NOT NULL CHAR(7)
// FNAME					   NOT NULL VARCHAR2(15)
// LNAME					   NOT NULL VARCHAR2(15)
// PHONE						    CHAR(10)


require_once ('../Connection.php');
class CustomerTable extends Connection {
    private static $table = [];
    private $stid = null;

    public function __toString()
    {
        $str = "<table border='1'>\n";

        $str .= "\n";
        $str .= "<tr>\n";
        $str .= '<td>' . "street number" . '</td>';
        $str .= '<td>' . "street name" . '</td>';
        $str .= '<td>' . "postcode" . '</td>';
        $str .= '<td>' . "customerID" . '</td>';
        $str .= '<td>' . "first name" . '</td>';
        $str .= '<td>' . "last name" . '</td>';
        $str .= '<td>' . "phone" . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        foreach (self::$table as $eachRow) {
            $str .= $eachRow;
        }
        $str .= '</table>';

        return $str;
    }

    public function getCustomerTable() {
        if ($this->testConnection()) {
            $this->stid = oci_parse(self::$conn, 'select * from customer');
            $result = oci_execute($this->stid);

            while ($row = oci_fetch_array($this->stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $eachCustomer = new Customer();

                $eachCustomer->street_number = $row['STREET_NUMBER'];
                $eachCustomer->street_name = $row['STREET_NAME'];
                $eachCustomer->postcode = $row['POSTCODE'];
                $eachCustomer->customer_id = $row['CUSTOMER_ID'];
                $eachCustomer->fname = $row['FNAME'];
                $eachCustomer->lname = $row['LNAME'];
                $eachCustomer->phone = $row['PHONE'];
                array_push(self::$table, $eachCustomer);
            }
        }
    }
}

class Customer {
    public $street_number = "";
    public $street_name = "";
    public $postcode = "";
    public $customer_id = "";
    public $fname = "";
    public $lname = "";
    public $phone = "";

    public function __toString()
    {
        $str = "\n";
        $str .= "<tr>\n";
        $str .= '<td>' . ($this->street_number !== null ? htmlentities($this->street_number, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->street_name !== null ? htmlentities($this->street_name, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->postcode !== null ? htmlentities($this->postcode, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->customer_id !== null ? htmlentities($this->customer_id, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->fname !== null ? htmlentities($this->fname, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->lname !== null ? htmlentities($this->lname, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->phone !== null ? htmlentities($this->phone, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        return $str;
    }

}

