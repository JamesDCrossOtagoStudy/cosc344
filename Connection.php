<?php

class Connection
{
    protected static $conn;
    
    function __construct()
    {
//        putenv("ORACLE_SID=".getenv("ORACLE_SID"));
//        putenv("ORACLE_HOME=".getenv("ORACLE_HOME"));
//        putenv("ORACLE_BASE=".getenv("ORACLE_BASE"));
//        putenv("TWO_TASK=".getenv("TWO_TASK"));
//
//        include("/home/includes/wzhao/connenv");
//        self::$conn = oci_connect("wzhao", "GGhh3344");


//        putenv("ORACLE_SID="."﻿orcl12c");
//        putenv("ORACLE_HOME="."﻿http://localhost:8080/ords");
//        putenv("ORACLE_BASE=".getenv("ORACLE_BASE"));
//        putenv("TWO_TASK=".getenv("TWO_TASK"));

        self::$conn = oci_connect('hr', 'oracle', 'localhost:1521/ords');

    }

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

    public function __destruct() {
        oci_close(self::$conn);
    }

    public function getConnection() {
        return self::$conn;
    }
}

$testConn = new Connection();
$testConn->testConnection();