<?php
/**
 * Created by PhpStorm.
 * User: zw
 * Date: 9/19/16
 * Time: 2:43 PM
 */
require_once('../Connection.php');

class EmployeeTable extends Connection{
    private static $table = [];
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
        $str .= '<td>' . "bookstoreID" . '</td>';
        $str .= "\n";
        $str .= "</tr>\n";

        foreach (self::$table as $eachRow) {
            $str .= $eachRow;
        }
        $str .= '</table>';

        return $str;
    }

    public function update() {
        self::$table = [];
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
                $bookstoreID = $row['BOOKSTOREID'];
                $eachEmployee = new Employee($fname, $middle_init, $lname, $ird_number, $contact_number,$weekly_hours,$hourly_rate,$bookstoreID);
                array_push(self::$table, $eachEmployee);
            }
        }
    }

    public function getEmployeeByIRD($ird) {
        if ($this->testConnection()) {
            $this->stid = oci_parse(self::$conn, "select * from employee WHERE ird_number='{$ird}'");
            $result = oci_execute($this->stid);

            while ($row = oci_fetch_array($this->stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $fname = $row['FNAME'];
                $middle_init = $row['MIDDLE_INIT'];
                $lname = $row['LNAME'];
                $ird_number = $row['IRD_NUMBER'];
                $contact_number = $row['CONTACT_NUMBER'];
                $weekly_hours = $row['WEEKLY_HOURS'];
                $hourly_rate = $row['HOURLY_RATE'];
                $bookstoreID = $row['BOOKSTOREID'];
                $theEmployee = new Employee($fname, $middle_init, $lname, $ird_number, $contact_number, $weekly_hours, $hourly_rate, $bookstoreID);
                return $theEmployee;
            }
        }
    }

    public function insertEmployee($fname, $middle_init, $lname, $ird_number, $contact_number,$weekly_hours,$hourly_rate, $bookstoreID) {
        $insertString = "insert into employee VALUES ('{$fname}', '{$middle_init}', '{$lname}', '{$ird_number}', '{$contact_number}', '{$weekly_hours}', '{$hourly_rate}', '{$bookstoreID}')";
        $this->stid = oci_parse(self::$conn, $insertString);
        $result = oci_execute($this->stid);
        
        echo "insertion string is:\n {$insertString}";
        
        if ($result && count(self::$table) != 0) {
            $newEmployee = new Employee($fname, $middle_init, $lname, $contact_number,$weekly_hours,$hourly_rate, $bookstoreID);
            array_push(self::$table, $newEmployee);
            return $this;
        }
    }

    public function updateEmployee($newEmployee, $old_ird_number) {
        $fname = $newEmployee->fname;
        $middle = $newEmployee->middle_init;
        $lname = $newEmployee->lname;
        $ird_number = $newEmployee->ird_number;
        $contact_number =$newEmployee->contact_number;
        $weekly_hours = $newEmployee->weekly_hours;
        $hourly_rate = $newEmployee->hourly_rate;
        $bookstoreID = $newEmployee->bookstoreID;

        $updateString = "update employee set FNAME='{$fname}', MIDDLE_INIT='{$middle}', LNAME='{$lname}', IRD_NUMBER = '{$ird_number}',
                        CONTACT_NUMBER='{$contact_number}', WEEKLY_HOURS='{$weekly_hours}', HOURLY_RATE='{$hourly_rate}', BOOKSTOREID='{$bookstoreID}'
                        where ird_number='{$old_ird_number}'";
        
        echo "update string is:\n {$updateString}";
        $this->stid = oci_parse(self::$conn, $updateString);
        
        $result = oci_execute($this->stid);

        if (!$result) {
            printf('execution failed');
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



class Employee extends EmployeeTable
{
    public $fname;
    public $middle_init;
    public $lname;
    public $ird_number;
    public $contact_number;
    public $weekly_hours;
    public $hourly_rate;
    public $bookstoreID;

    private $stid = null;


    public function __construct($fname, $middle_init, $lanme, $ird_number, $contact_number, $weekly_hours, $hourly_rate, $bookstoreID)
    {
        parent::__construct();
        $this->fname = $fname;
        $this->middle_init = $middle_init;
        $this->lname = $lanme;
        $this->ird_number = $ird_number;
        $this->contact_number = $contact_number;
        $this->weekly_hours = $weekly_hours;
        $this->hourly_rate = $hourly_rate;
        $this->bookstoreID = $bookstoreID;

    }

    public function __toString()
    {
        $str = "\n";
        $str .= "<tr>\n";
        $str .= '<td>' . ($this->fname !== null ? htmlentities($this->fname, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->middle_init !== null ? htmlentities($this->middle_init, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->lname !== null ? htmlentities($this->lname, ENT_QUOTES) : '&nbsp') . '</td>';

        if ($this->ird_number !== null) {
            $tmp = htmlentities($this->ird_number, ENT_QUOTES);
        } else {
            $tmp = '&nbsp';
        }
        $str .= '<td>' . "<a href=employeeForm.php?ird=$tmp>" . $tmp . "</a>" . '</td>';
        $str .= '<td>' . ($this->contact_number !== null ? htmlentities($this->contact_number, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->weekly_hours !== null ? htmlentities($this->weekly_hours, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->hourly_rate !== null ? htmlentities($this->hourly_rate, ENT_QUOTES) : '&nbsp') . '</td>';
        $str .= '<td>' . ($this->bookstoreID !== null ? htmlentities($this->bookstoreID, ENT_QUOTES) : '&nbsp') . '</td>';
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


