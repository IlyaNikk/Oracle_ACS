<?php
include '../library.php';

$con = connect_to_oracle();
if (!$con)
    die();

require '../vendor/autoload.php';

function generate_table($pdf, $header, $data)
{
    // Header
    foreach($header as $col)
        $pdf->Cell(40,7,$col,1);
    $pdf->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $pdf->Cell(40,6,$col,1);
        $pdf->Ln();
    }
}

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

$data = array();
while (oci_fetch($s))
{
    $data[] = array(oci_result($s, "SALARY"));
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$headers = array('Salary');
generate_table($pdf, $headers, $data);

close_connection($con);
$pdf->Output();
