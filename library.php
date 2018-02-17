<?php
function connect_to_oracle($login = "HR", $password = "oracle")
{
    $connection = oci_connect($login, $password, "127.0.0.1/orcl");
    if (!$connection)
    {
        $err = oci_error();
        echo ("Oracle Connect Error". $err["message"]);
    }

    return $connection;
}

function table_columns_names($connection, $table_name)
{
    $query = oci_parse($connection, "SELECT COLUMN_NAME FROM USER_TAB_COLUMNS WHERE TABLE_NAME = '$table_name'");
    oci_execute($query, OCI_DEFAULT);

    $names = array();
    while (oci_fetch($query))
        array_push($names, oci_result($query, "COLUMN_NAME"));
    // remove ID field
    unset($names['0']);

    return $names;
}

function close_connection($connection)
{
    oci_commit($connection);
    oci_close($connection);
}