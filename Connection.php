<?php

/*
 * Connection class which get a connection from oracle
 * */
class Connection
{
    protected static $conn;
    
    // constructor, when create an instance of Connection. The instance will connect to oracle.
    function __construct()
    {
        // lab oracle connection
//        putenv("ORACLE_SID=".getenv("ORACLE_SID"));
//        putenv("ORACLE_HOME=".getenv("ORACLE_HOME"));
//        putenv("ORACLE_BASE=".getenv("ORACLE_BASE"));
//        putenv("TWO_TASK=".getenv("TWO_TASK"));
//        include("/home/includes/wzhao/connenv");
//        self::$conn = oci_connect("wzhao", "GGhh3344");

        // my local oracle connection
        self::$conn = oci_connect('hr', 'oracle', 'localhost:1521/ords');

    }

    // helper function to test if the connection is whether successful or not
    public function testConnection()
    {
        if (!self::$conn) {
            $m = oci_error();
            echo $m['message'], "\n";
            return false;
        } elseif (self::$conn) {
            return true;
        }
    }

    // when the instance of Connection is destruct, it will release the connection to oracle
    public function __destruct() {
        if (self::$conn != null) {
            oci_close(self::$conn);
        }
    }

    // return an connection
    public function getConnection() {
        return self::$conn;
    }
}
