<?php

namespace IilyukDmitryi\App\Form;

class View
{
    public static function show(string $emails): void
    {
        ?>
        <form method="post">
            <label for="text">Введите email, каждый с новой строки:</label>
            <textarea id="text" name="emails" rows="10" required><?=$emails ?></textarea>
            <button type="submit">Проверить</button>
        </form>
        <?php
    }
}
