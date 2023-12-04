# Консольный чат на сокетах

Скрипты запускаются в режиме прослушивания STDIN и обмениваются друг с другом вводимыми сообщениями через unix-сокеты.

- сервер поднимается всегда первым
- клиент ожидает ввод из STDIN и отправляет сообщения серверу
- сервер выводит полученное сообщение в STDOUT и отправляет клиенту подтверждение:  Сервер получил 14 bytes (для
  примера)
- клиент выводит полученное подтверждение в STDOUT и начинает новую итерацию цикла

## Запуск сервера

```bash
docker compose run server php app.php server
```

## Запуск клиента

```bash
docker compose run client php app.php client
```