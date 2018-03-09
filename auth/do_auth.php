<?php
include '../library.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) && isset($_POST['password']))
{
    $c = connect_to_oracle();
    $res = login($c, $_POST['login'], $_POST['password']);
    if (!$res)
    {
        $pageContents = file_get_contents('auth.html');
        echo str_replace( '<div class="error"></div>',
        '<div class="error">Неправильный логин/пароль</div>', $pageContents);
        return $pageContents;
    }
    else {
        close_connection($c);
        return (include '../home.php');
    }
}
