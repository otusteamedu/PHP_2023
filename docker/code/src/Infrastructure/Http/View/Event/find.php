<?php

include dirname(__DIR__)."/header.php" ?>
<?php
$formData = $arrResult['formData'] ?? [];

if (!empty($arrResult['error'])) {
    echo '<span style="color: red">'.$arrResult['error'].'</span>';
}

if (!empty($arrResult['message'])) {
    echo '<span style="color: green">'.$arrResult['message'].'</span>';
}
if (!empty($arrResult['event'])) {
    echo '<span style="color: green"> <b>'.$arrResult['event']['event'].", приоритет ".$arrResult['event']['priority'].'</b></span>';
}
?>
    <form id="myForm" action="" method="post">
        <div id="blockParams">
            <div class="form-group" id="originalBlock">
                <label>Параметр 1:</label>
                <input type="text" name="params[]" value="<?php
                echo $formData['params'][0] ?? '' ?>" required>
            </div>
            <?php
            if (!empty($formData['params']) && count($formData['params']) > 1) {
                foreach ($formData['params'] as $key => $value) {
                    if ($key === 0) {
                        continue;
                    }
                    ?>
                    <div class="form-group">
                        <label for="param2">Параметр <?php
                            echo($key + 1) ?>:</label>
                        <input type="text" name="params[]" value="<?php
                        echo $value ?>">
                    </div>
                    <?php
                }
            } ?>
        </div>
        <button type="button" id="copyButton">Добавить параметр</button>
        <hr>
        <div class="form-group">
            <input type="submit" value="Отправить">
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("myForm");
            const block = document.getElementById("blockParams");
            const copyButton = document.getElementById("copyButton");
            copyButton.addEventListener("click", function () {
                const originalBlock = document.getElementById("originalBlock");
                const newBlock = originalBlock.cloneNode(true);
                const inputFields = form.querySelectorAll("input[name='params[]']");
                const currentNumber = inputFields.length + 1;

                const inputField = newBlock.querySelector("input[name='params[]']");
                inputField.value = "";
                inputField.removeAttribute("required");
                newBlock.removeAttribute("id");
                const label = newBlock.querySelector("label");
                label.textContent = `Параметр ${currentNumber}:`;
                block.insertBefore(newBlock, null);
            });
        });
    </script>
<?php
include dirname(__DIR__)."/footer.php" ?>