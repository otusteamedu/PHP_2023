# HW10

## Список из 6-ти основных запросов к БД

### 1.Выбор всех фильмов на сегодня
#### Запрос
db/requests/1_movie_today.sql
#### Результат
results/1_movie_today.html

### 2.Подсчёт проданных билетов за неделю
#### Запрос
db/requests/2_tickets_sales_by_week.sql
#### Результат
results/2_tickets_sales_by_week.html

### 3.Формирование афиши (фильмы, которые показывают сегодня)
#### Запрос
db/requests/3_afisha_today.sql
#### Результат
results/3_afisha_today.html

### 4.Поиск 3 самых прибыльных фильмов за неделю
#### Запрос
db/requests/4_three_most_profitable_movies.sql
#### Результат
results/4_three_most_profitable_movies.html


### 5.Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
#### Запрос
db/requests/5_session_places.sql
#### Результат
results/5_session_places.html

#### 6.Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
#### Запрос
db/requests/6_min_max_price_range.sql
#### Результат
results/6_min_max_price_range.html

## Скрипты создания и заполнения таблиц

### скрипт создания БД
db/create_tables.sql
### скрипт заполнения БД тестовыми данными
db/random_date.sql
db/random_string.sql
db/test_data.sql

## Анализ производительности и оптимизация запросов
explain_results


## Списки объектов
### отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
results\fifteen_biggest_objects.html
### отсортированный список (5 значений) самых редко используемых индексов
results\five_often_used_indexes.html
### отсортированный список (5 значений) самых часто используемых индексов
results\five_rarely_used_indexes.html
