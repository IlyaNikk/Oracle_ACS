<?php
include '../library.php';

$barcodes = array(
    "123456" => "pavel,golubev,17-FEB-18",
    "189723" => "alex,demin,18-MAY-17",
    "123621" => "ivan,urgant,10-SEP-17"
);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['barcode']))
{
    if (!isset($barcodes[$_POST['barcode']]))
    {
        echo("<p>Такого штрихкода нет</p>");
        return;
    }

    $con = connectToOracle();
    if (!$con)
        die();

    $table_name = 'employee';
    $columns_names = tableColumnsNames($con, $table_name);

    $insert_query =
        "INSERT INTO $table_name (" . implode(',', $columns_names) . ") VALUES (" . $barcodes[$_POST['barcode']]. ")";
    oci_execute(oci_parse($con, $insert_query), OCI_DEFAULT);

    closeConnection($con);
}
