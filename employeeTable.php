<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/19/16
 * Time: 2:43 PM
 */
require_once('Connection.php');

class EmployeeTable extends Connection{
    private static $table = array();
    private $stid = null;

    public function __toString()
    {
        $str = "<table border='1'>\n";

        $str .= "\n";
        $str .= "<tr>\n";
        $str .= '<td>' . "fname" . '</td>';
        $str .= '<td>' . "middle_init" . '</td>';
        $str .= '<td>' . "lname" . '</td>';
        $str .= '<td>' . "ird_number" . '</td>';
        $str .= '<td>' . "contact_number" . '</td>';
        $str .= '<td>' . "weekly_hours" . '</td>';
        $str .= '<td>' . "hourly_rate" . '</td>';
        $str .= '<td>' . "bookstore_address" . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        foreach (self::$table as $eachRow) {
            $str .= $eachRow;
        }
        $str .= '</table>';

        return $str;
    }

    public function getAllEmployee() {
        if ($this->testConnection()) {
            $this->stid = oci_parse(self::$conn, 'select * from employee');
            $result = oci_execute($this->stid);

            while ($row = oci_fetch_array($this->stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $fname = $row['FNAME'];
                $middle_init = $row['MIDDLE_INIT'];
                $lname = $row['LNAME'];
                $ird_number = $row['IRD_NUMBER'];
                $contact_number = $row['CONTACT_NUMBER'];
                $weekly_hours = $row['WEEKLY_HOURS'];
                $hourly_rate = $row['HOURLY_RATE'];
                $baddress = $row['BADDRESS'];
                $eachEmployee = new employee($fname, $middle_init, $lname, $ird_number, $contact_number,$weekly_hours,$hourly_rate,$baddress);
                array_push(self::$table, $eachEmployee);
            }
        }
    }

    public function insertEmployee($fname, $middle_init, $lname, $contact_number,$weekly_hours,$hourly_rate, $baddress) {
        $insertString = "insert into employee VALUES ('{$fname}', '{$middle_init}', '{$lname}', {$contact_number}, {$weekly_hours}, {$hourly_rate}, {$baddress})";

        $this->stid = oci_parse(self::$conn, $insertString);
        $result = oci_execute($this->stid);

        if ($result && count(self::$bookstores) != 0) {
            $newEmployee = new employee($fname, $middle_init, $lname, $contact_number,$weekly_hours,$hourly_rate, $baddress);
            array_push(self::$table, $newEmployee);
            return $this;
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



class employee extends EmployeeTable
{
//fname    VARCHAR2(15) NOT NULL,
//middle_init    CHAR,
//lname    VARCHAR2(15) NOT NULL,
//ird_number      CHAR(11)      PRIMARY KEY,
//contact_number  CHAR(10),
//weekly_hours   NUMBER(2),
//hourly_rate    NUMBER(5) NOT NULL, /*Currency*/
//baddress

    private $fname;
    private $middle_init;
    private $lanme;
    private $ird_number;
    private $contact_number;
    private $weekly_hours;
    private $hourly_rate;
    private $baddress;

    private $stid = null;


    public function __construct($fname, $middle_init, $lanme, $ird_number, $contact_number, $weekly_hours, $hourly_rate, $baddress)
    {
        parent::__construct();
        $this->fname = $fname;
        $this->middle_init = $middle_init;
        $this->lanme = $lanme;
        $this->ird_number = $ird_number;
        $this->contact_number = $contact_number;
        $this->weekly_hours = $weekly_hours;
        $this->hourly_rate = $hourly_rate;
        $this->baddress = $baddress;

    }

    public function __toString()
    {
        $str = "\n";
        $str .= "<tr>\n";
        $str .= '<td>' . ($this->fname !== null ? htmlentities($this->fname, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->middle_init !== null ? htmlentities($this->middle_init, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->lanme !== null ? htmlentities($this->lanme, ENT_QUOTES) : '&nbsp') . '</td>';

        
        $str .= '<td>' . ($this->ird_number !== null ? htmlentities($this->ird_number, ENT_QUOTES) : '&nbsp') . '</td>';


        $str .= '<td>' . ($this->contact_number !== null ? htmlentities($this->contact_number, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->weekly_hours !== null ? htmlentities($this->weekly_hours, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->hourly_rate !== null ? htmlentities($this->hourly_rate, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->baddress !== null ? htmlentities($this->baddress, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        return $str;
    }

    public function getEmployeeWithWord($word)
    {
        if (strpos($this->fname, $word) != false
            || strpos($this->middle_init, $word) != false
            || strpos($this->lanme, $word) != false
            || $this->fname == $word || $this->middle_init == $word || $this->lanme == $word
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function setNewContactNumber($contact_number) {
        $updateString = "update employee set contact_number = '{$contact_number}'  where contact_number = '{$this->contact_number}'";
        $this->stid = oci_parse(self::$conn, $updateString);
        $result = oci_execute($this->stid);
        if (!$result) {
            printf("update failure\n");
        } else {
            $this->contact_number = $contact_number;
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


