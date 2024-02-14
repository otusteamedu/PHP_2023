# Развертывание

После запуска контейнеров выполнить следующие команды

```
docker-compose exec php composer install
```

# Использование

## Завести задачу

Перейти на [главную](http://localhost:8080) и заполнить форму. Скопировать id задачи

## Посмотреть статус

Перейти на [страницу проверки](http://localhost:8080/check) в поле ввесли id задачи

## Просмотр всех задач в консоле

```
docker-compose exec php php console.php readQueue
```

## Изменение статуса задачи на completed

Вторым аргументом передать id задачи

```
docker-compose exec php php console.php completed {id}
```
