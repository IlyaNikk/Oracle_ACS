<?php
include 'library.php';
echo('<link rel="stylesheet" type="text/css" href="main.css">');
echo('<main>');

$con = connectToOracle();
if (!$con)
    die();

$table_name = $_GET['table_name'];
$id = $_GET['id'];

$columns_names = tableColumnsNames($con, $table_name);
$s = oci_parse($con, "SELECT * FROM $table_name WHERE $columns_names[0] = $id");
oci_execute($s, OCI_DEFAULT);

echo("<div class='update-result__columns' style='display: flex'> ");
$columns_names = tableColumnsNames($con, $table_name);
$count = 0;
foreach ($columns_names as $name) {
    if ($count != 0) {
        echo("<div class='col border border-dark bg-light'>" . dict($name) . "</div>");
    } else {
        echo("<div class='hidden'></div>");
    }
    $count++;
}
echo("<div class='col border border-dark bg-light'></div>");
echo("<div class='col border border-dark bg-light'></div>");
echo("</div>");
echo("</div>");

echo("<form action='update.php?table_name=" . $table_name . "&id=" . $id . "&operation=update' method='post'>");
echo("<div class='update-result__result'>");
while (oci_fetch($s)) {
    $count = 0;
    foreach ($columns_names as $name) {
        if ($count != 0) {
            echo("<input class='form-insert' type='text' placeholder='$name' name='$name' value='" . dict(oci_result($s, $name)) . "'>");
        }
        $count++;
    }
}
echo("</div>");
echo("<input type='hidden' name='table_name' value='$table_name'>");
echo("<input type='hidden' name='id' value='$id'>");
echo("<button type='submit' class='btn btn-primary'>Сохранить</button>");
echo("</form>");
echo("<a href='#'>Назад</a>");
echo('</main>');
echo("<script src='update.js'></script>");

closeConnection($con);
