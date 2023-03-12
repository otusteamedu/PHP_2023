<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>OTUS homework #4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <form method="post">
        <div class="mb-3">
            <label for="exampleInput" class="form-label">Строка</label>
            <input type="text" class="form-control" id="exampleInput" name="string" value="<?= $_POST['string'] ?? ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?= $data['validator']; ?>
</div>

</body>
</html>


