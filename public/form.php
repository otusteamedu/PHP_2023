<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Генерация банковской выписки</title>
</head>
<body>
<h1>Запрос на генерацию банковской выписки</h1>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
    <p>Ответ: <?php echo htmlspecialchars($response); ?></p>
<?php endif; ?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="start_date">Начальная дата:</label>
    <input type="date" id="start_date" name="start_date" required>

    <label for="end_date">Конечная дата:</label>
    <input type="date" id="end_date" name="end_date" required>

    <button type="submit">Отправить запрос</button>
</form>
</body>
</html>
