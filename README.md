# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

## Описание/Пошаговая инструкция выполнения домашнего задания

Подготовить список из 6 основных запросов к БД, разработанной на предыдущих занятиях

* Выбор всех фильмов на сегодня
* Подсчёт проданных билетов за неделю
* Формирование афиши (фильмы, которые показывают сегодня)
* Поиск 3 самых прибыльных фильмов за неделю
* Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
* Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс 
 
Целесообразно выбрать 3 "простых" (задействована 1 таблица), 3 "сложных" (агрегатные функции, связи таблиц).

Далее нужно заполнить таблицы, увеличив общее количество строк текстовых данных до 10000.

Затем проведите анализ производительности запросов к БД, сохранить планы выполнения.

Заполните таблицы, увеличив общее количество строк текстовых данных до 10000000.

Затем проведите анализ производительности запросов к БД, сохранить планы выполнения.

На основе анализа запросов и планов предложить оптимизации (индексы, структура, параметры и др.
Добавьте индексы и сравните результат, приложив планы выполнения.

## Критерии оценки:
### Результат:

* скрипт создания БД (с предыдущих занятий)
* скрипт заполнения БД тестовыми данными
* таблица с результатами по каждому из 6 запросов
* запрос
* план на БД до 10000 строк
* план на БД до 10000000 строк
* план на БД до 10000000 строк, что удалось улучшить
* перечень оптимизаций с пояснениями
* отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
* отсортированные списки (по 5 значений) самых часто и редко используемых индексов


# Установка

## Изолированное окружение

Для развёртывания изолированного окружения пропишите команду
```bash
vagrant up
```

После установки, зайдите в ОС
```bash
vagrant ssh
```

## Подготовка и запуск среды
```bash
cd application && cp .env.example .env
```

Далее, заполните все пустые строки нужными данными в файле `.env`

Перед запуском контейнеров, командой ниже обратите внимание на это уточнение:

Если ранее вами уже создавались контейнеры в этом окружении, то нужно удалить `volume` базы данных, для того, чтобы новые данные корректно добавились. Для этого проверьте наличие этого `volume`

```bash
sudo docker volume ls | grep 'myapp-psvolume'
```

Если он есть, выполните следующую команду:

```bash
sudo docker volume rm <название из результата выше>
```

После чего можете запускать команду:

```bash
sudo docker compose up -d
```

# Работа с бд

## Подключение к контейнеру с бд

Перейти в папку с проектом и выполнить команду:
```bash
cd /vagrant/application && sudo docker compose exec -it postgres bash
```

## Настройка структуры бд

```bash
dropdb -U postgres mydb && psql -U postgres -f docker-entrypoint-initdb.d/structure.pgsql
```

## Добавление тестовых данных

Файлы:
* [10000.pgsql](application%2Fpostgres%2Fshared%2F10000.pgsql) - на 10 тыс срок
* [1M.pgsql](application%2Fpostgres%2Fshared%2F1M.pgsql) - на 1 млн строк

```bash
psql -U postgres -f docker-entrypoint-initdb.d/10000.pgsql
```

## Добавление индексов

```bash
psql -U postgres -f docker-entrypoint-initdb.d/indexes.pgsql
```

# Аналитика

Файл
[analytic_1M.pgsql](application%2Fpostgres%2Fanalytic_1M.pgsql)

Содержит планы запросов и предполагаемые индексы для них. Каждый запрос разделён на части:
* QUERY - сам запрос
* EXPLAIN - план запроса
* POSSIBLE INDEXES - индексы, которые могут быть использованы
* EXPLAIN AFTER INDEXES - план запроса после добавления индексов

Файл
[analytic_1M.pgsql](application%2Fpostgres%2Fanalytic_1M.pgsql)

содержит планы запросов на большом объеме данных при использовании индексов.

Файл
[analytic_tables_and_indexes.pgsql](application%2Fpostgres%2Fanalytic_tables_and_indexes.pgsql)
содержит список таблиц и индексов, отсортированных по размеру.



