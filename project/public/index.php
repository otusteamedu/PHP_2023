<?php

declare(strict_types=1);

?>
<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Приложение для обработки отложенных запросов">
        <meta name="author" content="">
        <meta name="generator" content="">
        <title>Отправить запрос</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="icon" href="assets/ico/favicon.ico">
        <meta name="theme-color" content="#7952b3">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>

    </head>
    <body>
        <header>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <a class="navbar-brand d-flex align-items-center">
                        <strong>Application for handling pending requests</strong>
                    </a>
                </div>
            </div>
        </header>
        <main>
            <section class="py-1 text-center container">
                <div class="row py-lg-3">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <h1 class="fw-light">Запросить банковскую выписку</h1>
                    </div>
                </div>
            </section>
            <div class="album py-5 bg-light">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        <div class="col-6">
                            <div class="simple-email pb-5">
                                <form class="email-form simpleEmail">
                                    <div class="mb-3">
                                        <label for="simpleInputEmail" class="form-label">Email</label>
                                        <div class="error-box"></div>
                                        <input type="text" name="email" class="form-control" id="simpleInputEmail" aria-describedby="emailHelp">
                                        <div id="emailHelp" class="form-text">Введите email для получения выписки</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="dateStart" class="form-label">Дата начала периода</label>
                                                <div class="error-box"></div>
                                                <input type="date" name="dateStart" class="form-control" id="dateStart">

                                            </div>
                                            <div class="col-6">
                                                <label for="dateEnd" class="form-label">Дата окончания периода</label>
                                                <div class="error-box"></div>
                                                <input type="date" name="dateEnd" class="form-control" id="dateEnd">

                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="verification-result pb-5">
                                <div class="text-center">Результат</div>
                                <div class="py-3 text-center result-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="assets/js/script.js"></script>
    </body>
</html>
