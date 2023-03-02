<?php

/**
 * @var string $container
 * @var int $successfulCount
 * @var int $failedCount
 */
?><main class="m-auto" style="max-width: 350px; padding: 100px 0;">
    <form method="post" action="">
        <h1 class="h3 mb-3">Проверка строки</h1>

        <p>Контейнер: <?= $container ?></p>
        <p>Валидных проверок: <?= $successfulCount ?></p>
        <p>Невалидных проверок: <?= $failedCount ?></p>

        <div class="form-floating mb-3">
            <input
                autofocus="autofocus"
                id="string"
                type="text"
                name="string"
                class="form-control"
                value=""
            >
            <label for="string">Введите строку</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Проверить</button>
        <a href="" class="link-secondary">
            На главную
        </a>
    </form>
</main>
