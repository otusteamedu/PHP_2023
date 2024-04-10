<?php
require __DIR__ . "/../code/Validator.php";

if (isset($_POST['validator'])) {
    if (!empty($_POST['validator'])) {
        $result = \Ashishak\Balancer\code\Validator::validateText($_POST['validator']);
        if ($result === true) {
            $message = '"' . $_POST['validator'] . '" - Строка корректна';
            http_response_code(200);
        } else {
            $message = '"' . $_POST['validator'] . '" - В строке ошибки';
            http_response_code(400);
        }
    } else {
        $message = 'Ошибка - строка пуста!';
        http_response_code(400);
    }
}
?>

<!DOCTYPE html>
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
<div class="col-sm-12">
    <div class="col-sm-5">
        <h2>Валидатор скобочек</h2>
        <form action="index.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="validator" id="validator" aria-describedby="emailHelp" placeholder="Введите текст">
                <small id="emailHelp" class="form-text text-muted">Валидатор проверяет строку со скобочками</small>
            </div>
            <button type="submit" class="btn btn-primary">Проверить</button>
        </form>
    </div>

    <div class="col-sm-5">
        <h2>Результат проверки:</h2>
        <div>
            <?php if (!empty($message) && http_response_code() == 200) {?>
                <div class="alert alert-success" role="alert">
                    <?php echo $message;?>
                </div>
            <?php } else if (!empty($message) && http_response_code() == 400) {?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $message;?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
