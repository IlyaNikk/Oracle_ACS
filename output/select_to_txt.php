<?php
include '../library.php';

$con = connect_to_oracle();
if (!$con)
    die();

$columns_names = array(
    "THROUGH_NUMBER" => "Сквозной №",
    "GROUP_NUMBER" => "№ в группе",
    "FIRST_NAME" => "Имя",
    "LAST_NAME" => "Фамилия",
);

$file_name = "report.txt";

$handle = fopen($file_name, "w+");

mb_internal_encoding("utf-8");

foreach ($columns_names as $value)
{
   fwrite($handle, "|" . str_pad_unicode($value, 20) . "|");
}
fwrite($handle,"\n" . str_repeat("-", 88) . "\n");

$query = '
    SELECT
      row_number() 
        OVER(order by Last_name, First_name) AS THROUGH_NUMBER
      , row_number() 
        OVER(PARTITION BY Last_name, First_name ORDER BY Last_name, First_name) AS GROUP_NUMBER
      , First_name AS FIRST_NAME
      , Last_name AS LAST_NAME
    FROM
      EMP_SELECTED
      , (SELECT level Lev FROM DUAL CONNECT BY Level
        <= (SELECT max(n) FROM EMP_SELECTED))
    WHERE Lev <= N
    ORDER BY Last_name, First_name
';

$s = oci_parse($con, $query);
oci_execute($s, OCI_DEFAULT);

while (oci_fetch($s))
{
    foreach ($columns_names as $key => $value)
    {
        fwrite($handle, "|" . str_pad(oci_result($s, $key), 20) . "|");
    }
    fwrite($handle,"\n");
}

fclose($handle);
close_connection($con);
