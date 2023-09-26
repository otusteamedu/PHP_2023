<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Запрос банковской выписки</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="py-5 text-center">
        <h2>Получить выписку за период</h2>
    </div>

    <form action=/statement/get method="post" enctype="multipart/form-data" class="card p-2">

        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Данные для формирования</h4>

            <div class="row">
                <div class="mb-3">
                    <label for="email">Email </label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Введите Ваш email для отправки выписки
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <label for="email">Дата начала периода </label>
                    <input type="text" name="dateFrom" class="datepicker form-control" id="email" placeholder="2023-01-01"
                           value="<?= date("Y-m-d", time() - 3600 * 24 * 30) ?>">
                    <div class="invalid-feedback">
                        Пожалуйста, введите дату начала периода.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <label for="address">Дата конца периода </label>
                    <input type="text" name="dateTill" class="datepicker form-control" id="dateTill" placeholder="2023-01-31" required
                           value="<?= date("Y-m-d") ?>">
                    <div class="invalid-feedback">
                        Пожалуйста, введите дату окончания периода.
                    </div>
                </div>
            </div>

            <div style="padding-left: 100px; padding-top: 30px;">
                <button type="submit" name="created" value="created" class="btn btn-primary">Получить выписку</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>