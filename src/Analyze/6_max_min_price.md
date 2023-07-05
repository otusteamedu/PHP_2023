#  Схема зала. Свободные и занятые места на конкретный сеанс

Sql запрос:

```postgresql
EXPLAIN SELECT hr.id row_id, hr.seats, array_agg(t.seat) occupied_seats
        FROM hall_row hr
                 LEFT JOIN ticket t ON t.showtime_id = 2 AND t.row = hr.id
        WHERE hr.hall_id = 3
        GROUP BY hr.id, hr.seats;
```

## Explain до оптимизации

### 10 тысяч записей

```csv
Aggregate  (cost=120.92..120.93 rows=1 width=64)
  ->  Nested Loop  (cost=0.14..120.65 rows=54 width=6)
        ->  Index Only Scan using showtime_pkey on showtime s  (cost=0.14..2.36 rows=1 width=4)
              Index Cond: (id = 2)
        ->  Seq Scan on ticket t  (cost=0.00..117.75 rows=54 width=10)
              Filter: (showtime_id = 2)
```

### 10 миллионов записей

```csv
Aggregate  (cost=83477.98..83477.99 rows=1 width=64)
  ->  Nested Loop  (cost=1000.28..83163.50 rows=62896 width=6)
        ->  Index Only Scan using showtime_pkey on showtime s  (cost=0.28..1.40 rows=1 width=4)
              Index Cond: (id = 2)
        ->  Gather  (cost=1000.00..82533.14 rows=62896 width=10)
              Workers Planned: 2
              ->  Parallel Seq Scan on ticket t  (cost=0.00..75243.54 rows=26207 width=10)
                    Filter: (showtime_id = 2)
```

## Оптимизация

~

## Explain после оптимизации

```csv
Aggregate  (cost=83477.24..83477.25 rows=1 width=64)
  ->  Nested Loop  (cost=1000.28..83162.76 rows=62895 width=6)
        ->  Index Only Scan using showtime_pkey on showtime s  (cost=0.28..1.40 rows=1 width=4)
              Index Cond: (id = 2)
        ->  Gather  (cost=1000.00..82532.42 rows=62895 width=10)
              Workers Planned: 2
              ->  Parallel Seq Scan on ticket t  (cost=0.00..75242.92 rows=26206 width=10)
                    Filter: (showtime_id = 2)
```