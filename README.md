# Домашнее задание

## Цель:

Научиться взаимодействовать с Redis.

## Описание/Пошаговая инструкция выполнения домашнего задания:

Аналитик хочет иметь систему со следующими возможностями:

1.  Система должна хранить события, которые в последующем будут отправляться сервису событий
2.  События характеризуются важностью (аналитик готов выставлять важность в целых числах)
3.  События характеризуются критериями возникновения. Событие возникает только если выполнены все критерии его возникновения. Для простоты все критерии заданы так: &lt;критерий&gt;=&lt;значение&gt;  
    Таким образом предположим, что аналитик заносит в систему следующие события:
```
{
priority: 1000,
conditions: {
param1 = 1
},
event: {
::event::
},
},
{
priority: 2000,
conditions: {
param1 = 2,
param2 = 2
},
event: {
::event::
},
},
{
priority: 3000,
conditions: {
param1 = 1,
param2 = 2
},
event: {
::event::
},
},
#От пользователя приходит запрос:
{
params: {
param1 = 1,
param2 = 2
}
}
```

Под этот запрос подходят первая и третья запись, т.к. в них обеих выполнены все условия, но приоритетнее третья, так как имеет больший priority.

Написать систему, которая будет уметь:

1.  добавлять новое событие в систему хранения событий
2.  очищать все доступные события
3.  отвечать на запрос пользователя наиболее подходящим событием
4.  использовать для хранения событий redis

## Критерии оценки:

- Желательно параллельно попрактиковаться и выполнить ДЗ в других NoSQL хранилищах
- Слой кода, отвечающий за работу с хранилищем должен позволять легко менять -хранилище.

## Как проверить
Задаем переменные окружения и запускаем `docker-compose up`

Добавление записей:
```bash
php console.php storage:add 1000 "param1=1" "event=event1"
php console.php storage:add 2000 "param1=2;param2=2" "event=event2"
php console.php storage:add 3000 "param1=1;param2=2" "event=event3;system=start"
php console.php storage:add 900 "param1=1" "event=event1"
php console.php storage:add 3000 "param1=2;param2=2" "event=event2"
php console.php storage:add 2700 "param1=1;param2=2" "event=event3;system=start"
php console.php storage:add 7000 "param1=1" "event=event1"
php console.php storage:add 200 "param1=2;param2=2" "event=event2"
php console.php storage:add 300 "param1=1;param2=2" "event=event3;system=start"
```

Поиск записи:
```bash
php console.php storage:search "param1=1"
php console.php storage:search "param1=1;param2=2"
php console.php storage:search "param1=2;param2=2"
```

Очистка хранилища:
```bash
php console.php storage:clear
```
