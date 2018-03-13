<?php
include '../library.php';

$con = connectToOracle();
if (!$con)
    die();

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'PERS_LAST_NAME');
$sheet->setCellValue('B1', 'PERS_FIRST_NAME');
$sheet->setCellValue('C1', 'PERS_MIDDLE_NAME');
$sheet->setCellValue('D1', 'PERS_JOB');
$sheet->setCellValue('E1', 'PERS_TYPE');

$writer = new Xlsx($spreadsheet);

//$query = '
//    SELECT Salary FROM
//      (SELECT Salary, Max(Hire_Date) Hire_Date FROM
//        (SELECT Hire_Date, Salary FROM
//          (SELECT Hire_Date, Salary FROM Employees ORDER BY Hire_Date Desc, Salary desc)
//        WHERE RowNum <= 50)
//      GROUP BY Salary
//      ORDER BY 2 desc)
//    WHERE RowNum < 20
//';

$query = 'SELECT * FROM PERSONAL';

$s = oci_parse($con, $query);
oci_execute($s, OCI_DEFAULT);

$current_row = 2;
while (oci_fetch($s))
{
    $sheet->setCellValue("A$current_row" , oci_result($s, "PERS_LAST_NAME"));
    $sheet->setCellValue("B$current_row" , oci_result($s, "PERS_FIRST_NAME"));
    $sheet->setCellValue("C$current_row" , oci_result($s, "PERS_MIDDLE_NAME"));
    $sheet->setCellValue("D$current_row" , oci_result($s, "PERS_JOB"));
    $sheet->setCellValue("E$current_row" , oci_result($s, "PERS_TYPE"));
    $current_row++;
}

$writer->save('hello world.xlsx');

closeConnection($con);
