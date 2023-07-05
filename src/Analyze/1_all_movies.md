# Все фильмы на сегодня

Sql запрос:

```postgresql
EXPLAIN SELECT name FROM movie
    INNER JOIN showtime s on movie.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE;
```

## Explain до оптимизации

### 10 тысяч записей

```csv
Nested Loop  (cost=0.14..40.22 rows=6 width=516)
  ->  Seq Scan on showtime s  (cost=0.00..31.53 rows=6 width=4)
        Filter: (date(start_time) = CURRENT_DATE)
  ->  Index Scan using movie_pkey on movie  (cost=0.14..1.44 rows=1 width=520)
        Index Cond: (id = s.movie_id)
```

### 10 миллионов записей

```csv
Merge Join  (cost=48.67..50.08 rows=9 width=68)
  Merge Cond: (movie.id = s.movie_id)
  ->  Index Scan using movie_pkey on movie  (cost=0.15..18.65 rows=300 width=38)
  ->  Sort  (cost=48.52..48.54 rows=9 width=30)
        Sort Key: s.movie_id
        ->  Seq Scan on showtime s  (cost=0.00..48.38 rows=9 width=30)
              Filter: (date(start_time) = CURRENT_DATE)
```

## Оптимизация

Добавил индекс на поле `start_time` таблицы `showtime`:

```postgresql
CREATE INDEX idx_showtime_start_time ON showtime (start_time);
```

Переделал сам запрос, чтобы использовался индекс:
```postgresql
EXPLAIN SELECT name FROM movie
    INNER JOIN showtime s on movie.id = s.movie_id
WHERE s.start_time BETWEEN '2019-05-28 00:00:00' AND '2019-05-28 23:59:59';
```

## Explain после оптимизации

```csv
Merge Join  (cost=3.71..4.45 rows=2 width=9)
  Merge Cond: (movie.id = s.movie_id)
  ->  Index Scan using movie_pkey on movie  (cost=0.15..9.95 rows=300 width=13)
  ->  Sort  (cost=3.57..3.57 rows=2 width=4)
        Sort Key: s.movie_id
        ->  Bitmap Heap Scan on showtime s  (cost=1.40..3.56 rows=2 width=4)
              Recheck Cond: ((start_time >= '2019-05-28 00:00:00'::timestamp without time zone) AND (start_time <= '2019-05-28 23:59:59'::timestamp without time zone))
              ->  Bitmap Index Scan on idx_showtime_start_time  (cost=0.00..1.40 rows=2 width=0)
                    Index Cond: ((start_time >= '2019-05-28 00:00:00'::timestamp without time zone) AND (start_time <= '2019-05-28 23:59:59'::timestamp without time zone))
```