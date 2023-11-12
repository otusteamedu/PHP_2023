<?php
session_start();

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME']."<br><br>";

echo "Session ID: " . session_id();
