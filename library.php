<?php
function connectToOracle($login = "INIKITIN", $password = "INIKITIN")
{
    $connection = oci_connect($login, $password, "127.0.0.1/xe");
    if (!$connection) {
        $err = oci_error();
        echo("Oracle Connect Error" . $err["message"]);
    }

    $query = oci_parse($connection, "alter session set NLS_LANGUAGE = 'RUSSIAN'");
    oci_execute($query, OCI_DEFAULT);
    return $connection;
}

function tableColumnsNames($connection, $table_name)
{
    $query = oci_parse($connection, "SELECT COLUMN_NAME FROM USER_TAB_COLUMNS WHERE TABLE_NAME = '$table_name' ORDER BY COLUMN_ID");
    oci_execute($query, OCI_DEFAULT);

    $names = array();
    while (oci_fetch($query))
        array_push($names, oci_result($query, "COLUMN_NAME"));

    return $names;
}

function getReadableColName($connection, $table_name)
{
    $query = oci_parse($connection, "SELECT COLUMN_NAME FROM ALL_COL_COMMENTS WHERE TABLE_NAME = '$table_name'");
    oci_execute($query, OCI_DEFAULT);

    $names = array();
    while (oci_fetch($query)) {
        array_push($names, dict(oci_result($query, "COLUMN_NAME")));
    }
    return $names;
}

function getReadableTabName($connection, $table_name)
{
    $query = oci_parse($connection, "SELECT TABLE_NAME FROM all_tab_comments WHERE TABLE_NAME = '$table_name'");
    oci_execute($query, OCI_DEFAULT);

    while (oci_fetch($query)) {
        return dict(oci_result($query, "TABLE_NAME"));
    }
}

function closeConnection($connection)
{
    oci_commit($connection);
    oci_close($connection);
}

function login($connection, $login, $password)
{
    $query = oci_parse($connection,
        "SELECT PERS_TYPE FROM PERSONAL WHERE PERS_LOGIN = '$login' AND PERS_PASS = '$password'");
    oci_execute($query, OCI_DEFAULT);

    while (oci_fetch($query)) {
        return oci_result($query, "PERS_TYPE");
    }
}

function strPadUnicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT)
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

function dict($name)
{
    switch ($name) {
//        case 'PERSONAL':
//            return 'Сотрудники';
//        case 'PERS_FIRST_NAME':
//            return 'Имя';
//        case 'PERS_LAST_NAME':
//            return 'Фамилия';
//        case 'PERS_MIDDLE_NAME':
//            return 'Отчество';
//        case 'PERS_JOB':
//            return 'Должность';
//        case 'PERS_LOGIN':
//            return 'Логин';
//        case 'PERS_PASS':
//            return 'Пароль';
//        case 'PERS_TYPE':
//            return 'Тип пользователя';
//        case 'Andry':
//            return 'Андрей';
//        case 'Alex':
//            return 'Алексей';
//        case 'Demin':
//            return 'Демин';
//        case 'Vlasov':
//            return 'Власов';
//        case 'Igor':
//            return 'Игоревич';
//        case 'Anatol':
//            return 'Анатольевич';
//        case 'Direct':
//            return 'Директор';
//        case 'Ilya':
//            return 'Илья';
//        case 'Vladimir':
//            return 'Владимирович';
//        case 'Nikitin':
//            return 'Никитин';
//        case 'stager':
//            return 'Стажер';
//        case 'sotr':
//            return 'Сотрудник';
        default:
            return $name;
    }
}