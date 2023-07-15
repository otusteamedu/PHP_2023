# HW10

## Схема данных
- scheme.drawio
- scheme.jpg

## Установка и запуск

Запускаем db/install.sql
Запускаем db/random_string.sql
Запускаем db/mocks/all.sql

## Запросы

### Выбор всех фильмов на сегодня
#### запрос
db/select/movie_today.sql
#### результат
Результат results/1_movie_today.html

### Подсчёт проданных билетов за неделю
#### запрос
db/select/tickets_by_week.sql
#### результат
Результат results/2_tickets_by_week.html

### Формирование афиши (фильмы, которые показывают сегодня)
#### запрос
db/select/afisha.sql
#### результат
Результат results/3_afisha.html

### Поиск 3 самых прибыльных фильмов за неделю
#### запрос
db/select/3_most_movies.sql
#### результат
Результат results/4_3_most_movies.html


### Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
#### запрос
db/select/session_places.sql
#### результат
Результат results/5_session_places.html

#### Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
#### запрос
db/select/min_max.sql
#### результат
Результат results/6_min_max.html

## Анализ производительности
В директории explain_results


## Списки объектов
### отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
results\15_biggest_objects.html
### отсортированный список (5 значений) самых редко используемых индексов
results\5_often_used_indexes.html
### отсортированный список (5 значений) самых часто используемых индексов
results\5_rarely_used_indexes.html
