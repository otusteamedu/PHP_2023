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
Запросы для замеров производительсности в db/explain
Результаты при 10000 строк explain_results/10000
Результаты при 10000000 строк explain_results/10000000
Результаты при 10000000 строк после оптимизации explain_results/optimized

### Что было добавлено
#### 1.sql
Составной индекс ticket_price_session_id_id_index в db/explain/indexes/1.sql:
цена по возрастанию + id сеанса + id записи
#### 2.sql
Подошел индекс из 1.sql
#### 3.sql
Не нашел адекватных решений, кроме ограничения полей в выборке и добавления составного индекса для этих полей
#### 4.sql
1. Использование интервала in вместо 2 сравнений > and <
2. Добавление в таблицу ticket поля movie_id и убрать join c таблицей session
#### 5.sql
1. Создание составного индекса start_date, cinema_hall_id, movie_id
2. Убрать приведение типа к date() и все вычисление current_date +/- interval
3. Использовать в условии in (...) вместо > and <
#### 6.sql
1. Добавление индекса в session_movie_price session_id + price
2. Убрать подзапрос в where и задать диапазон явно