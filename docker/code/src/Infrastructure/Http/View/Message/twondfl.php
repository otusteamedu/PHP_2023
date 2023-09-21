<?php

include dirname(__DIR__) . "/header.php" ?>
<?php
$formData = $arrResult['formData'] ?? [];

if (!empty($arrResult['error'])) {
    echo '<span style="color: red">' . $arrResult['error'] . '</span>';
}

if (!empty($arrResult['message'])) {
    echo '<span style="color: green">' . $arrResult['message'] . '</span>'
    ?>
    <style>
        #resultRequest {
            display: flex;
            align-items: center;
        }
    </style>
    <div id="resultRequest">Ожидаем результат
        <img src="/img/1490.gif">
    </div>
    <script>
        function sendAjaxRequest(url, callback) {
            let xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    callback(xhr.responseText);
                } else if (xhr.readyState === 4 && xhr.status === 202) {
                    waitRecive();
                } else if (xhr.readyState === 4 && xhr.status !== 200) {
                    callback(null);
                }
            };

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send();
        }

        function waitRecive() {
            sendAjaxRequest('/message/reciveTwoNdfl/', function (response) {
                let message = '';
                if (response) {
                    let json = JSON.parse(response);
                    message = json.message;
                } else {
                    message = 'Произошла ошибка AJAX-запроса';
                }
                let resultRequest = document.getElementById("resultRequest");
                resultRequest.innerHTML = message;
            });
        }

        waitRecive()
    </script>
    <?php
} else {
    ?>

    <form id="myForm" action="" method="post">
        <div class="form-group">
            <label for="dateStart">За сколько месяцев нужна справка:</label>
            <input name="numMonth" min="6" max="24" type="number" inputmode="numeric" pattern="\d*"  step="1" value="<?php
            echo $formData['numMonth'] ?? "6" ?>" required>
        </div>
        <div class="form-group">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" value="<?php
            echo $formData['email'] ?? "" ?>" required>
        </div>

        <hr>
        <div class="form-group">
            <input type="submit" value="Отправить">
        </div>
    </form>
    <?php
}
include dirname(__DIR__) . "/footer.php" ?>