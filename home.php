<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="main.css">

    <title>Hello, world!</title>
</head>
<body>

<header>
    <span>
        <h1>ИУ4</h1>
    </span>
    <section class="menu">
        <a href="home.php?table_name=ELEMENT">Элементы</a>
        <a href="home.php?table_name=BOARD">Платы</a>
        <a href="home.php?table_name=FACILITY">Оснастка</a>
        <a href="home.php?table_name=OPERATION">Операции</a>
        <a href="home.php?table_name=PERSONAL">Персонал</a>
        <a href="home.php?table_name=UTILITY">Изделия</a>
        <a href="auth.html">Выход</a>
    </section>
</header>
<main class="">
        <?php include 'selector.php'; ?>
</main>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>
</html>