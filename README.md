# Домашнее задание

Анализ кода

## Цель:

Применить на практике изученные принципы;
Научиться работать над аналитическими задачами в отношении кода.

## Описание/Пошаговая инструкция выполнения домашнего задания:

Выберите один из своих проектов.
Проведите анализ на предмет соответствия изученным принципам.
Предложите свои варианты исправления.

## Критерии оценки:

1. Все утверждения подкреплены кодом "до" и "после" (8 баллов)
2. Желательно составить uml-схемы "до" и "после" (2 балла)


## Исходный проект
В качестве исходного проекта было использовано ДЗ№12(ветка hw12) 

## Как проверить

Задаем переменные окружения и запускаем `docker-compose up`

Добавление записей:

```bash
bin/console storage:add 1000 "param1=1" "event=event1"
bin/console storage:add 2000 "param1=2;param2=2" "event=event2"
bin/console storage:add 3000 "param1=1;param2=2" "event=event3;system=start"
bin/console storage:add 900 "param1=1" "event=event1"
bin/console storage:add 3000 "param1=2;param2=2" "event=event2"
bin/console storage:add 2700 "param1=1;param2=2" "event=event3;system=start"
bin/console storage:add 7000 "param1=1" "event=event1"
bin/console storage:add 200 "param1=2;param2=2" "event=event2"
bin/console storage:add 300 "param1=1;param2=2" "event=event3;system=start"
```

Поиск записи:

```bash
bin/console storage:search "param1=1"
bin/console storage:search "param1=1;param2=2"
bin/console storage:search "param1=2;param2=2"
```

Очистка хранилища:

```bash
bin/console storage:clear
```
