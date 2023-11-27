<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Проверка email на валидность - Home Work 5</title>
</head>
<body>
<form action="/app.php" id="form">
    <textarea name="emails" id="emails" cols="30" rows="10">
test@test.ru
info@google.com
help@otus.ru
    </textarea>
    <input type="submit" value="Проверить">
</form>
<div id="result"></div>
<script>
    let form = document.getElementById('form');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        let emails = form.querySelector('textarea[name="emails"]');
        let href = form.action;
        let formData = new FormData();
        formData.append('emails', emails.value);
        fetch(href, {
            method: 'POST',
            body: formData
        }).then((response) => {
            return response.json();
        }).then((json) => {
            let nodeHtml = document.createElement('div');
            for (let email in json) {
                let validText = json[email] ? 'проверка пройдена успешно<br>' : '<span style="color:red">email невалидный</span><br>';
                nodeHtml.innerHTML += email + ' - ' + validText;
            }
            nodeHtml.innerHTML += "<hr>";
            let container = document.getElementById('result');
            container.appendChild(nodeHtml);
        })
    })
</script>
</body>
</html>
