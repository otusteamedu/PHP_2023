# Формирование афиши

Sql запрос:

```postgresql
EXPLAIN SELECT m.name movie, array_agg(s.start_time) FROM movie m
  INNER JOIN showtime s on m.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE
GROUP BY m.name;
```

## Explain до оптимизации

### 10 тысяч записей

```csv
GroupAggregate  (cost=7.69..7.71 rows=1 width=548)
  Group Key: m.name
  ->  Sort  (cost=7.69..7.70 rows=1 width=524)
        Sort Key: m.name
        ->  Nested Loop  (cost=0.14..7.68 rows=1 width=524)
              ->  Seq Scan on showtime s  (cost=0.00..5.24 rows=1 width=12)
                    Filter: (date(start_time) = CURRENT_DATE)
              ->  Index Scan using movie_pkey on movie m  (cost=0.14..2.36 rows=1 width=520)
                    Index Cond: (id = s.movie_id)
```

### 10 миллионов записей

```csv
GroupAggregate  (cost=49.65..49.83 rows=9 width=41)
  Group Key: m.name
  ->  Sort  (cost=49.65..49.67 rows=9 width=17)
        Sort Key: m.name
        ->  Merge Join  (cost=48.67..49.50 rows=9 width=17)
              Merge Cond: (m.id = s.movie_id)
              ->  Index Scan using movie_pkey on movie m  (cost=0.15..9.95 rows=300 width=13)
              ->  Sort  (cost=48.52..48.54 rows=9 width=12)
                    Sort Key: s.movie_id
                    ->  Seq Scan on showtime s  (cost=0.00..48.38 rows=9 width=12)
                          Filter: (date(start_time) = CURRENT_DATE)
```

## Оптимизация

Индекс `showtime.start_time`.

Исправил запрос, чтобы использовался индекс:
```postgresql
EXPLAIN SELECT m.name movie, array_agg(s.start_time) FROM movie m
    INNER JOIN showtime s on m.id = s.movie_id
WHERE s.start_time BETWEEN '2023-07-3 00:00:00' AND '2023-07-03 23:59:59'
GROUP BY m.name;
```

## Explain после оптимизации

```csv
GroupAggregate  (cost=4.46..4.50 rows=2 width=41)
  Group Key: m.name
  ->  Sort  (cost=4.46..4.46 rows=2 width=17)
        Sort Key: m.name
        ->  Merge Join  (cost=3.71..4.45 rows=2 width=17)
              Merge Cond: (m.id = s.movie_id)
              ->  Index Scan using movie_pkey on movie m  (cost=0.15..9.95 rows=300 width=13)
              ->  Sort  (cost=3.57..3.57 rows=2 width=12)
                    Sort Key: s.movie_id
                    ->  Bitmap Heap Scan on showtime s  (cost=1.40..3.56 rows=2 width=12)
                          Recheck Cond: ((start_time >= '2023-07-03 00:00:00'::timestamp without time zone) AND (start_time <= '2023-07-03 23:59:59'::timestamp without time zone))
                          ->  Bitmap Index Scan on idx_showtime_start_time  (cost=0.00..1.40 rows=2 width=0)
                                Index Cond: ((start_time >= '2023-07-03 00:00:00'::timestamp without time zone) AND (start_time <= '2023-07-03 23:59:59'::timestamp without time zone))
```