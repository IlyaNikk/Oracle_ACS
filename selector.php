<?php
include 'library.php';

$con = connect_to_oracle();
if (!$con)
    die();

if (!isset($_GET['table_name'])) {
    echo("<h3 class='font-weight-light'>Стартовая страница</h3>");
    return;
}

$table_name = $_GET['table_name'];
echo("<h3 class='font-weight-light'>$table_name</h3>");

echo("<div class='row'>");
$columns_names = table_columns_names($con, $table_name);
$count = 0;
foreach ($columns_names as $name) {
    if ($count != 0)
        echo("<div class='col border border-dark bg-light'>$name</div>");
    $count++;
}
echo("<div class='col border border-dark bg-light'></div>");
echo("<div class='col border border-dark bg-light'></div>");
echo("</div>");

$s = oci_parse($con, "SELECT * FROM $table_name");
oci_execute($s, OCI_DEFAULT);

while (oci_fetch($s)) {
    echo("<div class='row'>");
    $count = 0;
    foreach ($columns_names as $name) {
        if ($count != 0) {
            echo("<div class='col border border-dark bg-light'>" . oci_result($s, $name) . "</div>");
        }
        $count++;
    }
    if ($_COOKIE["persType"] == 'admin') {
        echo("<a href='#' class='col border border-dark bg-light'>Редактировать</a>");
        echo("<a href='delete.php?table_name=" . $table_name . "&id=" . oci_result($s, $columns_names[0]) . "'
                class='col border border-dark bg-light'>Удалить</a>");
    }
    echo("</div>");
}

if ($_COOKIE["persType"] == 'admin') {
    echo("<form action='inserter.php' method='get'>");
    echo("<div class='row'>");
    $count = 0;
    foreach ($columns_names as $name) {
        if ($count != 0) {
            echo("<div class='col border border-dark bg-light'>");
            echo("<input type='text' class='form-control' placeholder='$name' name='$name'>");
            echo("</div>");
        }
        $count++;
    }
    echo("<div class='col border border-dark bg-light'></div>");
    echo("<div class='col border border-dark bg-light'></div>");
    echo("<input type='hidden' name='table_name' value='$table_name'>");
    echo("</div>");
    echo("<button type='submit' class='btn btn-primary'>Добавить</button>");
    echo("</form>");
    echo("<p class='font-weight-light'><a href='read_file/read_file.html'>Считать из файла</a></p>");
}

close_connection($con);
