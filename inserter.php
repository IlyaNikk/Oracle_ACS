<?php
include 'library.php';

$con = connectToOracle();
if (!$con)
    die();

$table_name = $_GET['table_name'];
$columns_names = tableColumnsNames($con, $table_name);

$values = $_GET;
unset($values['table_name']);

$insert_query =
    "INSERT INTO $table_name (" . implode(',', $columns_names) . ") VALUES (" . implode(',', $values) . ")";
$s = oci_parse($con, $insert_query);
oci_execute($s, OCI_DEFAULT);

echo("<p><a href='home.php'>Назад</a></p>");
closeConnection($con);
