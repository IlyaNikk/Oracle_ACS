<?php
include 'library.php';

$con = connect_to_oracle();
if (!$con)
    die();

$table_name = $_GET['table_name'];
$id = $_GET['id'];

$columns_names = table_columns_names($con, $table_name);
$s = oci_parse($con, "SELECT * FROM $table_name WHERE $columns_names[0] = $id");
oci_execute($s, OCI_DEFAULT);

$count = 0;
foreach ($columns_names as $name) {
    if ($count != 0)
        echo("<div class='col border border-dark bg-light'>$name</div>");
    $count++;
}

echo("<form action='update.php?table_name=" . $table_name . "&id=" . $id . "' method='get'>");
echo("<div class='row'>");
while (oci_fetch($s)) {
    echo("<div class='row'>");
    $count = 0;
    foreach ($columns_names as $name) {
        if ($count != 0) {
            echo("<input type='text' class='form-control' placeholder='$name' name='$name' value='".oci_result($s, $name)."'>");
        }
        $count++;
    }
    echo("</div>");
}
echo("<input type='hidden' name='table_name' value='$table_name'>");
echo("<input type='hidden' name='id' value='$id'>");
echo("<button type='submit' class='btn btn-primary'>Добавить</button>");
echo("</form>");

close_connection($con);
