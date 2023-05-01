<?php

declare(strict_types=1);

echo "<h4>Сервер:{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}</h4>";
echo '<h4>Номер сессии: ' . session_id() . '</h4>';
