<html lang="">
<header>
    <title>Home Work 4</title>
</header>
<form action="" id="form" method="post">
    <input type="text" name="string"
           value="(()()()()))((((()()()))(()()()(((()))))))">
    <input type="submit" value="Проверить">
</form>
<div id="result"></div>
<script>
    let status = '';
    let statusText = '';
    let form = document.getElementById('form');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        let string = form.querySelector('input[name="string"]');
        let formData = new FormData();
        formData.append('string', string.value);
        fetch('/', {
            method: 'POST',
            body: formData
        }).then((response) => {
            status = response.status;
            statusText = response.statusText;
            return response.text();
        }).then((text) => {
            let nodeHtml = document.createElement('div');
            nodeHtml.innerHTML = status + ' ' + statusText + ' ' + text;
            let container = document.getElementById('result');
            container.appendChild(nodeHtml);
        })
    })
</script>
</html>
