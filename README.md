# Чат на unix-сокете

## Установка
```shell
docker-compose up
```

## Запуск сервера
```shell
docker exec -it server_socket php public/app.php server
```

## Запуск клиента
```shell
docker exec -it server_socket php public/app.php client
```

## Поддерживаемые команды в клиентском чате:
- `\exit` - выход из клиента.
- `\stop` - остановка сервера и выход из клиента.
