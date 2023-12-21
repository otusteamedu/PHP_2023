## Развертывания БД

1. Выбрать БД и выполнить код из файла [scheme_DDL.sql](./app/scheme_DDL.sql)
2. Создать необходимые функции из файла [function.sql](./app/function.sql)
3. Заполнить схему зала из файла [cinema_data.sql](./app/cinema_data.sql)
4. Заполнить тестовыми данными из файла [10000_data.sql](./app/10000_data.sql)
5. Заполнить тестовыми данными из файла [1000000_data.sql](./app/1000000_data.sql)

## Оптимизация 

### Выбор всех фильмов на сегодня

* Запрос 

```SQL
    SELECT 
        films.name as name, halls.name as hall, to_char(sessions.start_at, 'HH24:MI')
    FROM Sessions
    LEFT JOIN films ON films.id = sessions.film_id
    LEFT JOIN halls ON halls.id = sessions.hall_id
    WHERE DATE(sessions.start_at) = current_date
    ORDER BY sessions.start_at;
```

* EXPLAIN до оптимизации

```BASH
      QUERY PLAN                                    
---------------------------------------------------------------------------------
 Sort  (cost=767.58..767.96 rows=150 width=291)
   Sort Key: sessions.start_at
   ->  Hash Left Join  (cost=44.00..762.16 rows=150 width=291)
         Hash Cond: (sessions.hall_id = halls.id)
         ->  Hash Left Join  (cost=26.80..744.19 rows=150 width=45)
               Hash Cond: (sessions.film_id = films.id)
               ->  Seq Scan on sessions  (cost=0.00..717.00 rows=150 width=16)
                     Filter: (date(start_at) = CURRENT_DATE)
               ->  Hash  (cost=21.91..21.91 rows=391 width=37)
                     ->  Seq Scan on films  (cost=0.00..21.91 rows=391 width=37)
         ->  Hash  (cost=13.20..13.20 rows=320 width=222)
               ->  Seq Scan on halls  (cost=0.00..13.20 rows=320 width=222)
```

* Добавил INDEX на основе выражений

```SQL
    CREATE INDEX indx_sessions_create_at_to_date ON sessions (DATE(sessions.start_at));
```

* EXPLAIN после добовления index
```bash
      QUERY PLAN                                                    
-------------------------------------------------------------------------------------------------
 Sort  (cost=247.66..248.03 rows=150 width=291)
   Sort Key: sessions.start_at
   ->  Hash Left Join  (cost=49.45..242.24 rows=150 width=291)
         Hash Cond: (sessions.hall_id = halls.id)
         ->  Hash Left Join  (cost=32.25..224.27 rows=150 width=45)
               Hash Cond: (sessions.film_id = films.id)
               ->  Bitmap Heap Scan on sessions  (cost=5.45..197.08 rows=150 width=16)
                     Recheck Cond: (date(start_at) = CURRENT_DATE)
                     ->  Bitmap Index Scan on indx_sessions_create_at_to_date  (cost=0.00..5.42 rows=150 width=0)
                           Index Cond: (date(start_at) = CURRENT_DATE)
               ->  Hash  (cost=21.91..21.91 rows=391 width=37)
                     ->  Seq Scan on films  (cost=0.00..21.91 rows=391 width=37)
         ->  Hash  (cost=13.20..13.20 rows=320 width=222)
               ->  Seq Scan on halls  (cost=0.00..13.20 rows=320 width=222)
```

---

### Подсчёт проданных билетов за неделю

* Запрос 

```SQL
   SELECT COUNT(*) FROM 
        orders
    WHERE 
        DATE(created_at) >= DATE( CURRENT_TIMESTAMP - '7 days'::interval ) 
        and DATE(created_at) < CURRENT_DATE 
        and status = 'purchased';
```

* EXPLAIN до оптимизации
```bash
    QUERY PLAN                                                                                     
----------------------------------------------------------------------------------------------------------------
 Finalize Aggregate  (cost=24627.10..24627.11 rows=1 width=8)
   ->  Gather  (cost=24626.89..24627.10 rows=2 width=8)
         Workers Planned: 2
         ->  Partial Aggregate  (cost=23626.89..23626.90 rows=1 width=8)
               ->  Parallel Seq Scan on orders  (cost=0.00..23625.00 rows=756 width=0)
                     Filter: ((status = 'purchased'::status_order) AND (date(created_at) < CURRENT_DATE) AND (date(created_at) >= date((CURRENT_TIMESTAMP - '7 days'::interval))))
```


* Добавил состовной INDEX с выражением
```sql
    CREATE INDEX indx_orders_week_purchased ON orders (status, date(created_at));
```


* EXPLAIN после добовления index
```bash
    QUERY PLAN                                                                                    
-----------------------------------------------------------------------------------------------
 Aggregate  (cost=4573.57..4573.58 rows=1 width=8)
   ->  Bitmap Heap Scan on orders  (cost=31.58..4569.03 rows=1815 width=0)
         Recheck Cond: ((status = 'purchased'::status_order) AND (date(created_at) >= date((CURRENT_TIMESTAMP - '7 days'::interval))) AND (date(created_at) < CURRENT_DATE))
         ->  Bitmap Index Scan on indx_orders_week_purchased  (cost=0.00..31.12 rows=1815 width=0)
               Index Cond: ((status = 'purchased'::status_order) AND (date(created_at) >= date((CURRENT_TIMESTAMP - '7 days'::interval))) AND (date(created_at) < CURRENT_DATE))
```


---

###  Формирование афиши (фильмы, которые показывают сегодня)

* Запрос 

```SQL
    SELECT 
        films.name as name, halls.name as hall, to_char(sessions.start_at, 'HH24:MI')
    FROM Sessions
    LEFT JOIN films ON films.id = sessions.film_id
    LEFT JOIN halls ON halls.id = sessions.hall_id
    WHERE 
        DATE(sessions.start_at) = CURRENT_DATE
        AND sessions.start_at > CURRENT_TIMESTAMP
    ORDER BY sessions.start_at;
```

* EXPLAIN
```bash
    Sort  (cost=243.77..243.91 rows=54 width=291)
   Sort Key: sessions.start_at
   ->  Hash Left Join  (cost=49.43..242.22 rows=54 width=291)
         Hash Cond: (sessions.hall_id = halls.id)
         ->  Hash Left Join  (cost=32.23..224.74 rows=54 width=45)
               Hash Cond: (sessions.film_id = films.id)
               ->  Bitmap Heap Scan on sessions  (cost=5.43..197.80 rows=54 width=16)
                     Recheck Cond: (date(start_at) = CURRENT_DATE)
                     Filter: (start_at > CURRENT_TIMESTAMP)
                     ->  Bitmap Index Scan on indx_sessions_create_at_to_date  (cost=0.00..5.42 rows=150 width=0)
                           Index Cond: (date(start_at) = CURRENT_DATE)
               ->  Hash  (cost=21.91..21.91 rows=391 width=37)
                     ->  Seq Scan on films  (cost=0.00..21.91 rows=391 width=37)
         ->  Hash  (cost=13.20..13.20 rows=320 width=222)
               ->  Seq Scan on halls  (cost=0.00..13.20 rows=320 width=222)
```

* Планировщик использует ранее добавленный INDEX indx_orders_week_purchased

---

### Поиск 3 самых прибыльных фильмов за неделю

* Запрос 

```SQL
   SELECT 
        films.name, max(orders.price) as total 
    FROM 
        orders
    LEFT JOIN sessions ON sessions.id = orders.session_id	
    LEFT JOIN films ON films.id = sessions.film_id	
    WHERE 
        DATE(created_at) >= DATE( CURRENT_TIMESTAMP - '7 days'::interval ) 
        and DATE(created_at) < CURRENT_DATE 
        and status = 'purchased'
    GROUP BY films.id
    ORDER BY total DESC LIMIT 3;
```

* EXPLAIN до оптимизации
```bash
    QUERY PLAN                                                                                                
-------------------------------------------------------------------------------------------
 Limit  (cost=25671.67..25671.68 rows=3 width=69)
   ->  Sort  (cost=25671.67..25672.65 rows=391 width=69)
         Sort Key: (max(orders.price)) DESC
         ->  Finalize GroupAggregate  (cost=25558.96..25666.62 rows=391 width=69)
               Group Key: films.id
               ->  Gather Merge  (cost=25558.96..25658.80 rows=782 width=69)
                     Workers Planned: 2
                     ->  Partial GroupAggregate  (cost=24558.93..24568.51 rows=391 width=69)
                           Group Key: films.id
                           ->  Sort  (cost=24558.93..24560.82 rows=756 width=43)
                                 Sort Key: films.id
                                 ->  Hash Left Join  (cost=893.80..24522.79 rows=756 width=43)
                                       Hash Cond: (sessions.film_id = films.id)
                                       ->  Hash Left Join  (cost=867.00..24493.98 rows=756 width=10)
                                             Hash Cond: (orders.session_id = sessions.id)
                                             ->  Parallel Seq Scan on orders  (cost=0.00..23625.00 rows=756 width=10)
                                                   Filter: ((status = 'purchased'::status_order) AND (date(created_at) < CURRENT_DATE) AND (date(created_at) >= date((CURRENT_TIMESTAMP - '7 days'::interval))))
                                             ->  Hash  (cost=492.00..492.00 rows=30000 width=8)
                                                   ->  Seq Scan on sessions  (cost=0.00..492.00 rows=30000 width=8)  
                                       ->  Hash  (cost=21.91..21.91 rows=391 width=37)
                                             ->  Seq Scan on films  (cost=0.00..21.91 rows=391 width=37)
```


* Планировщик использует ранее добавленный indx_sessions_create_at_to_date


* EXPLAIN после добовления index
```bash
    QUERY PLAN                                                                                    
-----------------------------------------------------------------------------------------------
 Limit  (cost=5490.45..5490.46 rows=3 width=69)
   ->  Sort  (cost=5490.45..5491.43 rows=391 width=69)
         Sort Key: (max(orders.price)) DESC
         ->  HashAggregate  (cost=5481.49..5485.40 rows=391 width=69)
               Group Key: films.id
               ->  Hash Left Join  (cost=925.38..5472.41 rows=1815 width=43)
                     Hash Cond: (sessions.film_id = films.id)
                     ->  Hash Left Join  (cost=898.58..5440.79 rows=1815 width=10)
                           Hash Cond: (orders.session_id = sessions.id)
                           ->  Bitmap Heap Scan on orders  (cost=31.58..4569.03 rows=1815 width=10)
                                 Recheck Cond: ((status = 'purchased'::status_order) AND (date(created_at) >= date((CURRENT_TIMESTAMP - '7 days'::interval))) AND (date(created_at) < CURRENT_DATE))
                                 ->  Bitmap Index Scan on indx_orders_week_purchased  (cost=0.00..31.12 rows=1815 width=0)
                                       Index Cond: ((status = 'purchased'::status_order) AND (date(created_at) >= date((CURRENT_TIMESTAMP - '7 days'::interval))) AND (date(created_at) < CURRENT_DATE))
                           ->  Hash  (cost=492.00..492.00 rows=30000 width=8)
                                 ->  Seq Scan on sessions  (cost=0.00..492.00 rows=30000 width=8)
                     ->  Hash  (cost=21.91..21.91 rows=391 width=37)
                           ->  Seq Scan on films  (cost=0.00..21.91 rows=391 width=37)
```

---

### Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс


* Запрос

```SQL
  WITH s as (
      SELECT * FROM 
        sessions
      WHERE sessions.id = 11667
      )
      SELECT places.row_id as row, places.number, orders.status FROM s
      RIGHT JOIN rows ON rows.hall_id = s.hall_id
      RIGHT JOIN places ON places.row_id = rows.id
      LEFT JOIN orders ON orders.place_id = places.id AND orders.session_id = s.id
      WHERE rows.hall_id = s.hall_id
      ORDER BY row, number;
```

* EXPLAIN до оптимизации

```bash
    QUERY PLAN                                                                                                
-------------------------------------------------------------------------------------------
 Sort  (cost=15744.24..15746.24 rows=800 width=10)
   Sort Key: places.row_id, places.number
   ->  Hash Right Join  (cost=1076.67..15705.66 rows=800 width=10)
         Hash Cond: ((orders.session_id = sessions.id) AND (orders.place_id = places.id))
         ->  Gather  (cost=1000.00..15628.60 rows=36 width=12)
               Workers Planned: 2
               ->  Parallel Seq Scan on orders  (cost=0.00..14625.00 rows=15 width=12)
                     Filter: (session_id = 11667)
         ->  Hash  (cost=64.67..64.67 rows=800 width=14)
               ->  Hash Join  (cost=10.67..64.67 rows=800 width=14)
                     Hash Cond: (places.row_id = rows.id)
                     ->  Seq Scan on places  (cost=0.00..37.00 rows=2400 width=10)
                     ->  Hash  (cost=10.42..10.42 rows=20 width=8)
                           ->  Hash Join  (cost=8.44..10.42 rows=20 width=8)
                                 Hash Cond: (rows.hall_id = sessions.hall_id)
                                 ->  Seq Scan on rows  (cost=0.00..1.60 rows=60 width=8)
                                 ->  Hash  (cost=8.43..8.43 rows=1 width=8)
                                       ->  Index Scan using sessions_pkey on sessions  (cost=0.41..8.43 rows=1 width=8)
```

* Добовляем Index

```sql
 CREATE INDEX indx_orders_session_place ON orders (session_id, place_id);
```

* EXPLAIN после добовления index
```bash
    QUERY PLAN                                                                                    
-----------------------------------------------------------------------------------------------
 Sort  (cost=257.96..259.96 rows=800 width=10)
   Sort Key: places.row_id, places.number
   ->  Hash Right Join  (cost=81.38..219.39 rows=800 width=10)
         Hash Cond: ((orders.session_id = sessions.id) AND (orders.place_id = places.id))
         ->  Bitmap Heap Scan on orders  (cost=4.71..142.33 rows=36 width=12)
               Recheck Cond: (session_id = 11667)
               ->  Bitmap Index Scan on indx_orders_session_place  (cost=0.00..4.70 rows=36 width=0)
                     Index Cond: (session_id = 11667)
         ->  Hash  (cost=64.67..64.67 rows=800 width=14)
               ->  Hash Join  (cost=10.67..64.67 rows=800 width=14)
                     Hash Cond: (places.row_id = rows.id)
                     ->  Seq Scan on places  (cost=0.00..37.00 rows=2400 width=10)
                     ->  Hash  (cost=10.42..10.42 rows=20 width=8)
                           ->  Hash Join  (cost=8.44..10.42 rows=20 width=8)
                                 Hash Cond: (rows.hall_id = sessions.hall_id)
                                 ->  Seq Scan on rows  (cost=0.00..1.60 rows=60 width=8)
                                 ->  Hash  (cost=8.43..8.43 rows=1 width=8)
                                       ->  Index Scan using sessions_pkey on sessions  (cost=0.41..8.43 rows=1 width=8)
```

---


### Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

* Запрос

```SQL
  WITH s as (
    SELECT * FROM 
        sessions
    WHERE sessions.id = 11667
      )
      SELECT max(SessionPrices.price), min(SessionPrices.price) FROM s
      RIGHT JOIN rows ON rows.hall_id = s.hall_id
      RIGHT JOIN places ON places.row_id = rows.id
      LEFT JOIN orders ON orders.place_id = places.id AND orders.session_id = s.id
      LEFT JOIN SessionPrices ON SessionPrices.type_id = rows.type_id AND SessionPrices.session_id = s.id
      WHERE rows.hall_id = s.hall_id;
```

* EXPLAIN 

```bash
    QUERY PLAN                                                                                                
-------------------------------------------------------------------------------------------
 Aggregate  (cost=98.12..98.13 rows=1 width=64)
   ->  Hash Right Join  (cost=89.10..94.12 rows=800 width=6)
         Hash Cond: ((orders.session_id = sessions.id) AND (orders.place_id = places.id))
         ->  Index Only Scan using indx_orders_session_place on orders  (cost=0.43..5.06 rows=36 width=8)
               Index Cond: (session_id = 11667)
         ->  Hash  (cost=76.67..76.67 rows=800 width=14)
               ->  Hash Join  (cost=22.67..76.67 rows=800 width=14)
                     Hash Cond: (places.row_id = rows.id)
                     ->  Seq Scan on places  (cost=0.00..37.00 rows=2400 width=8)
                     ->  Hash  (cost=22.42..22.42 rows=20 width=14)
                           ->  Hash Left Join  (cost=20.21..22.42 rows=20 width=14)
                                 Hash Cond: ((sessions.id = sessionprices.session_id) AND (rows.type_id = sessionprices.type_id))
                                 ->  Hash Join  (cost=8.44..10.42 rows=20 width=12)
                                       Hash Cond: (rows.hall_id = sessions.hall_id)
                                       ->  Seq Scan on rows  (cost=0.00..1.60 rows=60 width=12)
                                       ->  Hash  (cost=8.43..8.43 rows=1 width=8)
                                             ->  Index Scan using sessions_pkey on sessions  (cost=0.41..8.43 rows=1 width=8)
                                                   Index Cond: (id = 11667)
                                 ->  Hash  (cost=11.74..11.74 rows=2 width=14)
                                       ->  Bitmap Heap Scan on sessionprices  (cost=4.31..11.74 rows=2 width=14)
                                             Recheck Cond: (session_id = 11667)
                                             ->  Bitmap Index Scan on sessionprices_session_id_type_id_key  (cost=0.00..4.30 rows=2 width=0)
```

---


### отсортированный список (15 значений) самых больших по размеру объектов БД

```sql
SELECT nspname || '.' || relname as name,
      pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
      pg_size_pretty(pg_relation_size(C.oid)) as relsize
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;
```

![list](app/img/list15.png)

---


### Список используемых индексов

```sql
SELECT
    idstat.relname AS TABLE_NAME, -- имя таблицы
    indexrelname AS index_name, -- индекс
    idstat.idx_scan AS index_scans_count, -- число сканирований по этому индексу
    pg_size_pretty(pg_relation_size(indexrelid)) AS index_size, -- размер индекса
    tabstat.idx_scan AS table_reads_index_count, -- индексных чтений по таблице
    tabstat.seq_scan AS table_reads_seq_count, -- последовательных чтений по таблице
    tabstat.seq_scan + tabstat.idx_scan AS table_reads_count, -- чтений по таблице
    n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count, -- операций записи
    pg_size_pretty(pg_relation_size(idstat.relid)) AS table_size -- размер таблицы
FROM
    pg_stat_user_indexes AS idstat
JOIN
    pg_indexes
    ON
    indexrelname = indexname
    AND
    idstat.schemaname = pg_indexes.schemaname
JOIN
    pg_stat_user_tables AS tabstat
    ON
    idstat.relid = tabstat.relid
WHERE
    indexdef !~* 'unique'
ORDER BY
    idstat.idx_scan DESC,
    pg_relation_size(indexrelid) DESC;  
```

![index_list](app/img/list_index.png)