<?php
/**
 * @var string $container
 * @var int $validTestCount
 * @var int $invalidTestCount
 * @var string $string
 * @var bool $isValidString
 * @var string|null $message
 */
?><!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homework 4</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form {
            max-width: 350px;
            padding: 100px 0;
        }
    </style>
</head>
<body class="text-center">

    <main class="form m-auto">
        <form method="post" action="./">
            <h1 class="h3 mb-3">Проверка строки</h1>

            <p>Контейнер: <?= $container ?></p>
            <p>Валидных проверок: <?= $validTestCount ?></p>
            <p>Невалидных проверок: <?= $invalidTestCount ?></p>

            <?php if (null !== $message) : ?>
                <div class="alert <?= $isValidString ? 'alert-success' : 'alert-danger' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input
                    autofocus="autofocus"
                    id="string"
                    type="text"
                    name="string"
                    class="form-control"
                    value="<?= htmlspecialchars($string) ?>"
                >
                <label for="string">Введите строку</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Проверить</button>
            <a href="./" class="link-secondary">
                На главную
            </a>
        </form>
    </main>

</body>
</html>
