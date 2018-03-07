<?php
include '../library.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style;

function create_output_file()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(25);
    $sheet->setCellValue("A1" , "ID");
    $sheet->setCellValue("B1" , "Имя");
    $sheet->setCellValue("C1" , "Фамилия");
    $sheet->setCellValue("D1" , "Дата выхода");
    $sheet->setCellValue("E1" , "Штрихкод");
    $sheet->getStyle('A1:E1')->getFill()
        ->setFillType(Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('97D189');
    return $spreadsheet;
}

function add_barcode_to_cell($spreadsheet, $coordinates, $barcode_generator, $barcode)
{
    $image_str = $barcode_generator->getBarcode("$barcode", $barcode_generator::TYPE_CODE_128);
    $image = imagecreatefromstring($image_str);

    $drawing = new Worksheet\MemoryDrawing();
    $drawing->setCoordinates($coordinates);

    $drawing->setImageResource($image);
    $drawing->setRenderingFunction(Worksheet\MemoryDrawing::RENDERING_JPEG);
    $drawing->setMimeType(Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
    $drawing->setWorksheet($spreadsheet->getActiveSheet());
}

$barcode_generator = new Picqer\Barcode\BarcodeGeneratorJPG();
$spreadsheet = create_output_file();
$sheet = $spreadsheet->getActiveSheet();

$con = connect_to_oracle();
if (!$con)
    die();

$s = oci_parse($con, 'SELECT emp_id, emp_name, emp_surname, emp_startdate FROM employee');
oci_execute($s, OCI_DEFAULT);

$current_row = 2;
while (oci_fetch($s))
{
    $sheet->getRowDimension($current_row)->setRowHeight(40);
    $sheet->setCellValue("A$current_row" , oci_result($s, "EMP_ID"));
    $sheet->setCellValue("B$current_row" , oci_result($s, "EMP_NAME"));
    $sheet->setCellValue("C$current_row" , oci_result($s, "EMP_SURNAME"));
    $sheet->setCellValue("D$current_row" , oci_result($s, "EMP_STARTDATE"));
    add_barcode_to_cell($spreadsheet, "E$current_row", $barcode_generator, rand(100000, 999999));
    $current_row++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('barcodes.xlsx');

close_connection($con);
