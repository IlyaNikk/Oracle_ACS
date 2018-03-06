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
$sheet->setCellValue('A1', 'SALARY');

$writer = new Xlsx($spreadsheet);

$query = '
    SELECT Salary FROM
      (SELECT Salary, Max(Hire_Date) Hire_Date FROM
        (SELECT Hire_Date, Salary FROM
          (SELECT Hire_Date, Salary FROM Employees ORDER BY Hire_Date Desc, Salary desc)
        WHERE RowNum <= 50)
      GROUP BY Salary
      ORDER BY 2 desc)
    WHERE RowNum < 20
';

$s = oci_parse($con, $query);
oci_execute($s, OCI_DEFAULT);

$current_row = 2;
while (oci_fetch($s))
{
    $sheet->setCellValue("A$current_row" , oci_result($s, "SALARY"));
    $current_row++;
}

$writer->save('hello world.xlsx');

close_connection($con);
