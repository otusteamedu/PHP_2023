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
GroupAggregate  (cost=121.14..121.74 rows=30 width=38)
  Group Key: hr.id
  ->  Sort  (cost=121.14..121.21 rows=30 width=8)
        Sort Key: hr.id
        ->  Hash Right Join  (cost=2.50..120.40 rows=30 width=8)
"              Hash Cond: (t.""row"" = hr.id)"
              ->  Seq Scan on ticket t  (cost=0.00..117.75 rows=54 width=4)
                    Filter: (showtime_id = 2)
              ->  Hash  (cost=2.12..2.12 rows=30 width=6)
                    ->  Seq Scan on hall_row hr  (cost=0.00..2.12 rows=30 width=6)
                          Filter: (hall_id = 3)
```

### 10 миллионов записей

```csv
HashAggregate  (cost=83187.49..83187.87 rows=30 width=38)
  Group Key: hr.id
  ->  Hash Right Join  (cost=1002.50..83076.68 rows=22163 width=8)
"        Hash Cond: (t.""row"" = hr.id)"
        ->  Gather  (cost=1000.00..82891.43 rows=66488 width=4)
              Workers Planned: 2
              ->  Parallel Seq Scan on ticket t  (cost=0.00..75242.62 rows=27703 width=4)
                    Filter: (showtime_id = 2)
        ->  Hash  (cost=2.12..2.12 rows=30 width=6)
              ->  Seq Scan on hall_row hr  (cost=0.00..2.12 rows=30 width=6)
                    Filter: (hall_id = 3)
```

## Оптимизация

~

## Explain после оптимизации

```csv
HashAggregate  (cost=82895.65..82896.03 rows=30 width=38)
  Group Key: hr.id
  ->  Hash Right Join  (cost=1002.50..82789.50 rows=21231 width=8)
"        Hash Cond: (t.""row"" = hr.id)"
        ->  Gather  (cost=1000.00..82611.93 rows=63693 width=4)
              Workers Planned: 2
              ->  Parallel Seq Scan on ticket t  (cost=0.00..75242.62 rows=26539 width=4)
                    Filter: (showtime_id = 2)
        ->  Hash  (cost=2.12..2.12 rows=30 width=6)
              ->  Seq Scan on hall_row hr  (cost=0.00..2.12 rows=30 width=6)
                    Filter: (hall_id = 3)
```