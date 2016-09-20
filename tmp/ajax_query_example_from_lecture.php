<?php

// This script queries the employee table which is loaded by running the sql script
// company.sql which can be found in /coursework/344/pickup/oracle-sql

if (!isset($_GET['id'])) {
    echo 'No id passed';
}
else {
    $id = $_GET['id'];


// Create connection to Oracle
// include file containing your login details
// replacing USERNAME with your server login name

    include("/home/includes/USERNAME/connenv");

    $query = 'select pname, pnumber from project where plocation = :id';

    $s = oci_parse($conn, $query);
    oci_bind_by_name($s, ":id", $id);
    oci_execute($s);

    echo "<table border='1'>".PHP_EOL;
    while ($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) {
        echo "<tr>".PHP_EOL;
        foreach ($row as $item) {
            echo "  <td>".($item?htmlentities($item):"&nbsp;")."</td>".PHP_EOL;
        }
        echo "</tr>".PHP_EOL;
    }
    echo "</table>".PHP_EOL;
}

?>
