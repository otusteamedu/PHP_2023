<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h1>Браузерное приложение</h1>
    <form method="post" action="/">
        <label for="string">Введите любой текст</label>
        <label>
            <input type="text" name="string"/>
        </label>

        <button>Submit</button>
    </form>
    <?php if (isset($response_validator)) : ?>
        <h3> <?php echo $response_validator ?></h3>
    <?php endif; ?>
</div>
</body>
</html>
