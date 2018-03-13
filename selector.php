<?php
include 'library.php';

$con = connectToOracle();
if (!$con)
    die();

if (!isset($_GET['table_name'])) {
    echo("<h3 class='font-weight-light'>Стартовая страница</h3>");
    return;
}

$tableName = $_GET['table_name'];
$tabName = getReadableTabName($con, $tableName);
echo("<h3 class='font-weight-light'>$tabName</h3>");
echo("<table>");

echo("<tr class='select-result'>");
$columnsNames = tableColumnsNames($con, $tableName);
$readColumnsNames = getReadableColName($con, $tableName);
$count = 0;
foreach ($readColumnsNames as $name) {
    if ($count != 0) {
        echo("<td class='col'>$name</td>");
    } else {
        echo("<td class='hidden'>");
    }
    $count++;
}
echo("<td class='col'></td>");
echo("<td class='col'></td>");
echo("</tr>");

$s = oci_parse($con, "SELECT * FROM $tableName");
oci_execute($s, OCI_DEFAULT);

while (oci_fetch($s)) {
    echo("<tr class='select-result'>");
    $count = 0;
    foreach ($columnsNames as $name) {
        if ($count != 0) {
            echo("<td class='select-result__cell'>" . dict(oci_result($s, $name)) . "</td>");
        } else {
            echo("<td class='hidden'><input type='hidden' value='" . dict(oci_result($s, $name)) . "'></td>");
        }
        $count++;
    }
    if ($_COOKIE["persType"] == 'admin') {
        echo("<td><a href='updater.php?table_name=" . $tableName . "&id=" . oci_result($s, $columnsNames[0]) . "'
                class='col'>Редактировать</a></td>");
        echo("<td><a href='update.php?table_name=" . $tableName . "&id=" . oci_result($s, $columnsNames[0]) . "&operation=delete'
                class='col'>Удалить</a></td>");
    }
    echo("</tr>");
}

echo("</table>");

if ($_COOKIE["persType"] == 'admin') {
    echo("<form action='update.php?operation=insert' method='post'>");
    echo("<div class='form__select-result'>");
    echo("<div class='hidden'><input type='hidden'>" . oci_result($s, $name) . "</input></div>");
    $count = 0;
    foreach ($readColumnsNames as $name) {
        if ($count != 0) {
            echo("<div class='col border border-dark bg-light'>");
            echo("<input type='text' class='form-insert' placeholder='$readColumnsNames[$count]' name='$name'>");
            echo("</div>");
        }
        $count++;
    }
    echo("<div class='col border border-dark bg-light'></div>");
    echo("<div class='col border border-dark bg-light'></div>");
    echo("<input type='hidden' name='table_name' value='$tableName'>");
    echo("</div>");
    echo("<button type='submit' class='btn btn-primary'>Добавить</button>");
    echo("</form>");
    echo("<p class='font-weight-light'><a href='read_file/read_file.html'>Считать из файла</a></p>");
}
echo("<script src='render.js'></script>");
closeConnection($con);
