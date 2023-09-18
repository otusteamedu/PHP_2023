<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя Страница</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: #fff;
            padding: 10px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px;
            position: relative; /* Добавляем для псевдоэлемента */
        }

        nav a::after {
            content: '|'; /* Здесь можно указать другой разделитель */
            position: absolute;
            top: 50%;
            right: -5px;
            transform: translateY(-50%);
        }

        nav a:last-child::after {
            content: none; /* Удаляем разделитель для последнего пункта меню */
        }

        nav a:hover {
            background-color: #555;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            flex-grow: 1;
        }

        h1 {
            margin-top: 0;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
<header>
    <h1><?php
        /** @var array $arrResult */
        echo $arrResult['TITLE'] ?? 'НЕТ ЗАГОЛОВКА' ?></h1>
</header>

<nav>
    <a href="/">Главная</a>
    <a href="/message/send/">Получить банковскую выписку</a>

</nav>

<div class="container">
