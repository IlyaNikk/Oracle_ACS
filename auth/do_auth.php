<?php
include '../library.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) && isset($_POST['password']))
{
    $c = connect_to_oracle($_POST['login'], $_POST['password']);
    if (!$c)
    {
        echo("<p>Неправильный логин/пароль</p>");
        echo("<p><a href='auth.html'>Назад</a></p>");
    }
    else
    {
        echo("<p>Успех</p>");
        echo("<p><a href='../home.php'>Перейти на сайт</a></p>");
        close_connection($c);
    }
}
