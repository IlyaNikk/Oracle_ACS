<?php
include 'library.php';

$con = connect_to_oracle();
if (!$con)
    die();

$params = array();
foreach ($_GET as $get) {
    array_push($params, $get);
}

$table_name = $_GET['table_name'];
$id = $_GET['id'];

$columns_names = table_columns_names($con, $table_name);

$update_query =
    "UPDATE $table_name SET ";
$count = 0;
foreach ($params as $param) {
    if ($count < count($params) - 2) {
        $update_query .= $columns_names[$count + 1];
        $update_query .= "=";
        $update_query .= "'" . $param . "'";
        $update_query .= ", ";
    }
    $count++;
}
$update_query .= "WHERE $columns_names[0] = $id";
$update_query = str_replace(", WHERE", " WHERE", $update_query);
echo($update_query);
$s = oci_parse($con, $update_query);
oci_execute($s, OCI_DEFAULT);

echo("<p><a href='home.php?table_name=" . $table_name . "'>Назад</a></p>");
close_connection($con);
