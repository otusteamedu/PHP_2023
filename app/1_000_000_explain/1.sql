-- Выбор всех фильмов на сегодня
explain analyse
select
    m.title,
    s.date
from
    movie m
    join session s on m.id = s.movie_id
where
    s.date = CURRENT_DATE;

-- QUERY PLAN
-- Nested Loop  (cost=0.29..2380.50 rows=38 width=43) (actual time=4.181..4.182 rows=0 loops=1)
--   ->  Seq Scan on session s  (cost=0.00..2137.00 rows=38 width=8) (actual time=4.181..4.181 rows=0 loops=1)
--         Filter: (date = CURRENT_DATE)
--         Rows Removed by Filter: 100000
--   ->  Index Scan using movie_pkey on movie m  (cost=0.29..6.41 rows=1 width=43) (never executed)
--         Index Cond: (id = s.movie_id)
-- Planning Time: 0.107 ms
-- Execution Time: 4.194 ms



-- Добавил индекс для таблицы session по полю date
CREATE INDEX idx_session_date ON session(date);

-- QUERY PLAN
-- Nested Loop  (cost=4.87..369.90 rows=38 width=43) (actual time=0.008..0.009 rows=0 loops=1)
--   ->  Bitmap Heap Scan on session s  (cost=4.59..126.41 rows=38 width=8) (actual time=0.008..0.008 rows=0 loops=1)
--         Recheck Cond: (date = CURRENT_DATE)
--         ->  Bitmap Index Scan on idx_session_date  (cost=0.00..4.58 rows=38 width=0) (actual time=0.007..0.007 rows=0 loops=1)
--               Index Cond: (date = CURRENT_DATE)
--   ->  Index Scan using movie_pkey on movie m  (cost=0.29..6.41 rows=1 width=43) (never executed)
--         Index Cond: (id = s.movie_id)
-- Planning Time: 0.154 ms
-- Execution Time: 0.020 ms




-- По результату анализа запроса можно сказать следующее:
-- при использовании индекса плановое время немного увеличилось, однако стоимость запроса
-- и реальное время выполнения запроса уменьшилось в разы

-- Вывод: применение индекса оправданно
