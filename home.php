<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>

<div class="col-11 container">
    <div class="row">
        <div class="col-4 border border-dark bg-warning">
            <h1 class="font-weight-light">ИУ4</h1>
        </div>
        <div class="col-8 border border-dark bg-warning">
            <h1 class="font-weight-light">АСУ: HR-отдел</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-4 border border-dark bg-warning">
            <p class="font-weight-light"><a href="home.php?table_name=ELEMENT">Элементы</a></p>
            <p class="font-weight-light"><a href="home.php?table_name=BOARD">Платы</a></p>
            <p class="font-weight-light"><a href="home.php?table_name=FACILITY">Оснастка</a></p>
            <p class="font-weight-light"><a href="home.php?table_name=OPERATION">Операции</a></p>
            <p class="font-weight-light"><a href="home.php?table_name=PERSONAL">Персонал</a></p>
            <p class="font-weight-light"><a href="home.php?table_name=UTILITY">Изделия</a></p>
            <br>
            <a href="auth.html" class="font-weight-light">Выход</a>
        </div>
        <div class="col-8 border border-dark bg-warning">
            <div class="col-11 container">
                <?php include 'selector.php';?>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>