<?php
function connect_to_oracle($login = "INIKITIN", $password = "INIKITIN")
{
    $connection = oci_connect($login, $password, "127.0.0.1/xe");
    if (!$connection) {
        $err = oci_error();
        echo("Oracle Connect Error" . $err["message"]);
    }

    return $connection;
}

function table_columns_names($connection, $table_name)
{
    $query = oci_parse($connection, "SELECT COLUMN_NAME FROM USER_TAB_COLUMNS WHERE TABLE_NAME = '$table_name'");
    oci_execute($query, OCI_DEFAULT);

    $names = array();
    while (oci_fetch($query))
        array_push($names, oci_result($query, "COLUMN_NAME"));
    // remove ID field

    return $names;
}

function close_connection($connection)
{
    oci_commit($connection);
    oci_close($connection);
}

function login($connection, $login, $password)
{
    $query = oci_parse($connection,
        "SELECT PERS_TYPE FROM PERSONAL WHERE PERS_LOGIN = '$login' AND PERS_PASS = '$password'");
    oci_execute($query, OCI_DEFAULT);

    $names = array();
    while (oci_fetch($query)) {
        return oci_result($query, "PERS_TYPE");
    }
}

function str_pad_unicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT)
{
    $str_len = mb_strlen($str);
    $pad_str_len = mb_strlen($pad_str);
    if (!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
        $str_len = 1; // @debug
    }
    if (!$pad_len || !$pad_str_len || $pad_len <= $str_len) {
        return $str;
    }

    $result = null;
    if ($dir == STR_PAD_BOTH) {
        $length = ($pad_len - $str_len) / 2;
        $repeat = ceil($length / $pad_str_len);
        $result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length))
            . $str
            . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));
    } else {
        $repeat = ceil($str_len - $pad_str_len + $pad_len);
        if ($dir == STR_PAD_RIGHT) {
            $result = $str . str_repeat($pad_str, $repeat);
            $result = mb_substr($result, 0, $pad_len);
        } else if ($dir == STR_PAD_LEFT) {
            $result = str_repeat($pad_str, $repeat);
            $result = mb_substr($result, 0,
                    $pad_len - (($str_len - $pad_str_len) + $pad_str_len))
                . $str;
        }
    }

    return $result;
}