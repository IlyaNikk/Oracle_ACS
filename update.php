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
$operation = $_GET['operation'];

$columns_names = getReadableColName($con, $table_name);

switch ($operation) {
    case 'update':
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
        $s = oci_parse($con, $update_query);
        break;
    case 'delete':
        $delete_query =
            "DELETE FROM $table_name WHERE $columns_names[0] = $id";
        $s = oci_parse($con, $delete_query);

        break;
    case 'insert':
        array_pop($params);
        array_shift($columns_names);
        $insert_query =
            "INSERT INTO $table_name (" . implode(',', $columns_names) . ") VALUES (";
        $count = 0;
        foreach ($params as $param) {
            $insert_query .= "'" . $param . "'";
            if ($count < count($params) - 1) {
                $insert_query .= ",";
            }
            ++$count;
        }
        $insert_query .= ")";
        $s = oci_parse($con, $insert_query);
        break;
}
oci_execute($s, OCI_DEFAULT);


$home = file_get_contents('home.php');
$selector = file_get_contents('selector.php');
echo str_replace("<?php include \'selector.php\';?>",
    $selector, $home);
closeConnection($con);
return $home;