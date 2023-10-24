-- Выбор всех фильмов на сегодня
explain analyse
    select
        f.title,
        s.day,
        s.year
    from
        films as f
        join sessions s on f.id = s.film_id
    where
        s.date = CURRENT_DATE;

--QUERY PLAN                                                               
-- ---------------------------------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=1000.43..117679.22 rows=1 width=13) (actual time=232.328..239.200 rows=0 loops=1)
--   ->  Gather  (cost=1000.00..117670.77 rows=1 width=4) (actual time=232.327..239.198 rows=0 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Parallel Seq Scan on ticket_sales ts  (cost=0.00..116670.67 rows=1 width=4) (actual time=175.479..175.479 rows=0 loops=3)
--               Filter: (sale_date = CURRENT_DATE)
--               Rows Removed by Filter: 3336667
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=17) (never executed)
--         Index Cond: (id = s.film_id)
-- Planning Time: 0.820 ms
-- JIT:
--   Functions: 17
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 1.160 ms, Inlining 0.000 ms, Optimization 0.526 ms, Emission 10.783 ms, Total 12.469 ms
-- Execution Time: 239.594 ms
--(15 rows)

-- Добавил составной ндекс по полю day, year
CREATE INDEX idx_date ON sessions(date);

--QUERY PLAN                                                                    
--------------------------------------------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=0.87..16.91 rows=1 width=13) (actual time=0.056..0.057 rows=0 loops=1)
--   ->  Index Scan using idx_date on sessions f  (cost=0.44..8.46 rows=1 width=4) (actual time=0.055..0.055 rows=0 loops=1)
--         Index Cond: (date = CURRENT_DATE)
--   ->  Index Scan using films_pkey on films f  (cost=0.43..8.45 rows=1 width=17) (never executed)
--         Index Cond: (id = ts.movie_id)
-- Planning Time: 0.813 ms
-- Execution Time: 0.097 ms
-- (7 rows)

-- Вывод: индексирование ускоряет запрос в 2 раза
