<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <?php

    //echo phpinfo();
    echo "Привет!<br>" . date("Y-m-d H:i:s") . "<br><br>";

    echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];

    ?>

    <form action="/check-brackets" method="POST">
        <input type="text" class="form-control mb-2" name="bracket">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>