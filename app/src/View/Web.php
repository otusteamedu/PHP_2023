<?php

namespace Nikitaglobal\View;

class Web
{
    public static function showForm()
    {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запрос на банковскую выписку</title>
</head>
<body>
    <h1>Запрос на банковскую выписку</h1>
    <form method="POST" action="index.php">
        <label for="start_date">Дата начала:</label>
        <input type="date" id="start_date" name="start_date" required>
        <br>
        <label for="end_date">Дата окончания:</label>
        <input type="date" id="end_date" name="end_date" required>
        <br>
        <input type="submit" value="Отправить запрос">
    </form>
</body>
</html>
        <?php
    }
    public static function showError($message)
    {
        ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ошибка</title>
</head>
<body>
    <h1>Ошибка</h1>
    <p><?php echo $message ?></p>
</body>
</html><?php
    }

    public static function showSuccess($message)
    {
        ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Успех</title>
</head>
<body>
    <h1>Успех</h1>
    <p><?php echo $message ?></p>
</body>
</html><?php
    }
}