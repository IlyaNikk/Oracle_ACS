<?php
include 'library.php';

$con = connect_to_oracle();
if (!$con)
    die();

$table_name = $_GET['table_name'];
$id = $_GET['id'];

$columns_names = table_columns_names($con, $table_name);

$delete_query =
    "DELETE FROM $table_name WHERE $columns_names[0] = $id";
$s = oci_parse($con, $delete_query);
oci_execute($s, OCI_DEFAULT);

echo("<p><a href='home.php?table_name=".$table_name."'>Назад</a></p>");
close_connection($con);
