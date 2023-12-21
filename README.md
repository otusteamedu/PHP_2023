# Brownchat

ДЗ № 6

### Требования 

- Docker
- Docker Compose
- Composer

## Установка зависимостей

Для установки зависимостей выполните команду `composer install` в папке `src`:

```bash
cd src
composer install
```

### Запуск приложения

#### Сервер

Для запуска сервера используйте следующую команду:

```bash
docker compose run server php app.php server
```

#### Клиент

Для запуска клиента используйте следующую команду:

```bash
docker compose run client php app.php client
```

## Настройки

Настройки для Brownchat находятся в файле `chat.app/config/App.ini`.

## Использование

Если вам нужно выйти из клиента, используйте следующую команду:

```
/exit
```

Также можно завершить работу сервера, и закрыть клиент с помощью команды:

```
/stopserver
```