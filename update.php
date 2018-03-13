<?php
include 'library.php';

$con = connectToOracle();
if (!$con)
    die();

$params = array();
foreach ($_POST as $get) {
    array_push($params, $get);
}

$table_name = $_GET['table_name'];
$id = $_GET['id'];

$columns_names = tableColumnsNames($con, $table_name);

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

$home = file_get_contents('home.php');
$selector = file_get_contents('selector.php');
echo str_replace( "<?php include \'selector.php\';?>",
    $selector, $home);
closeConnection($con);
return $home;