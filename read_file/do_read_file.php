<?php
include 'library.php';

function get_lines($file_name)
{
    $handle = fopen($file_name, "r");
    $lines = array();
    if ($handle)
    {
        while (($line = fgets($handle)) !== false)
            array_push($lines, $line);
        fclose($handle);
    }
    return $lines;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['table_name']) && isset($_POST['file']))
{
    $con = connect_to_oracle();
    if (!$con)
        die();

    $table_name = $_POST['table_name'];
    $columns_names = table_columns_names($con, $table_name);

    foreach(get_lines($_POST['file']) as $line)
    {
        $insert_query =
            "INSERT INTO $table_name (" . implode(',', $columns_names) . ") VALUES ($line)";
        oci_execute(oci_parse($con, $insert_query), OCI_DEFAULT);
    }

    close_connection($con);
}
