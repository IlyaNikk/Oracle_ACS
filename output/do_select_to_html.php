<?php
include '../library.php';

$con = connect_to_oracle();
if (!$con)
    die();

$columns_names = array(
    "LAST_NAME_A" => "Фамилия",
    "SALARY_A" => "Зарплата",
    "LAST_NAME_B" => "Фамилия",
    "SALARY_B" => "Зарплата",
    "DEPARTMENT_ID" => "Отдел",
    "AVSAL" => "Ср.оклад",
);

echo("<div class='row'>");
foreach ($columns_names as $value)
{
    echo("<div class='col border border-dark bg-danger'>$value</div>");
}
echo("</div>");

$query = '
    SELECT
      E.Last_name AS LAST_NAME_A
      , E.Salary AS SALARY_A
      , C.Last_name AS LAST_NAME_B
      , C.Salary AS SALARY_B
      , E.Department_id AS DEPARTMENT_ID
      , G.Avsal AS AVSAL
    FROM
      EMPLOYEES E
      , EMPLOYEES C
      , (SELECT Department_id, round(avg(Salary)) Avsal
        FROM EMPLOYEES
        GROUP BY Department_id
      ) G
    WHERE
      E.Department_id = C.Department_id
      AND C.Department_id = G.Department_id
      AND E.Salary > G.Avsal
      AND E.Salary < C.Salary
      AND C.Employee_id <> E.Employee_id
      AND E.Department_id IN (60,80)
    ORDER BY
      E.Department_id
      , E.Salary
      , E.Last_name
      , C.Salary
      , C.Last_name
';

$s = oci_parse($con, $query);
oci_execute($s, OCI_DEFAULT);

while (oci_fetch($s))
{
    echo("<div class='row'>");
    foreach ($columns_names as $key => $value)
    {
        echo("<div class='col border border-dark bg-light'>" . oci_result($s, $key) . "</div>");
    }
    echo("</div>");
}

close_connection($con);
