<?php
include '../library.php';

$con = connect_to_oracle();
if (!$con)
    die();

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue("A1" , "ID");
$sheet->setCellValue("B1" , "Имя");
$sheet->setCellValue("C1" , "Фамилия");
$sheet->setCellValue("D1" , "Дата выхода");
$sheet->setCellValue("E1" , "Штрихкод");

$query = '
    SELECT emp_id, emp_name, emp_surname, emp_startdate
    FROM employee
';

$s = oci_parse($con, $query);
oci_execute($s, OCI_DEFAULT);

$current_row = 2;
while (oci_fetch($s))
{
    $sheet->setCellValue("A$current_row" , oci_result($s, "EMP_ID"));
    $sheet->setCellValue("B$current_row" , oci_result($s, "EMP_NAME"));
    $sheet->setCellValue("C$current_row" , oci_result($s, "EMP_SURNAME"));
    $sheet->setCellValue("D$current_row" , oci_result($s, "EMP_STARTDATE"));
    $sheet->setCellValue("E$current_row" , rand(100000, 999999));
    $current_row++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('barcodes.xlsx');

close_connection($con);
