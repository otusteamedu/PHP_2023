INSERT INTO cinema (name, count_rooms, address)
VALUES ('soft cinema', 10, 'samara,novo-sadovaya 206-30');

-- #############################################################################

INSERT INTO room (ID, cinema_id, seats_count, rows_count, renovation_date, fire_safety_license_end_date)
VALUES (1, 1, 30, 3, '2019-05-05', '2025-05-05'),
       (2, 1, 40, 4, '2018-05-05', '2025-06-05'),
       (3, 1, 50, 5, '2017-05-05', '2025-07-05'),
       (4, 1, 60, 6, '2016-05-05', '2025-08-05'),
       (5, 1, 70, 7, '2015-05-05', '2025-09-05');

-- #############################################################################

INSERT INTO screening (start_time, end_time, day_off_status, price)
VALUES ('07:00:00', '09:00:00', true, 300),
       ('07:00:00', '09:00:00', false, 100),
       ('09:00:00', '11:00:00', true, 300),
       ('09:00:00', '11:00:00', false, 100),
       ('11:00:00', '13:00:00', true, 400),
       ('11:00:00', '13:00:00', false, 200),
       ('13:00:00', '15:00:00', true, 400),
       ('13:00:00', '15:00:00', false, 200),
       ('15:00:00', '17:00:00', true, 450),
       ('15:00:00', '17:00:00', false, 250),
       ('17:00:00', '19:00:00', true, 450),
       ('17:00:00', '19:00:00', false, 250),
       ('19:00:00', '21:00:00', true, 600),
       ('19:00:00', '21:00:00', false, 300),
       ('21:00:00', '23:00:00', true, 600),
       ('21:00:00', '23:00:00', false, 300),
       ('23:00:00', '01:00:00', true, 400),
       ('23:00:00', '01:00:00', false, 200);

-- #############################################################################

INSERT INTO movie (title)
VALUES ('Marvel 5'),
       ('Marvel 4'),
       ('Marvel 3'),
       ('Marvel 2'),
       ('Marvel 1');

-- #############################################################################

INSERT INTO movie_attr_type (name, comment)
VALUES ('date', null),
       ('integer', null),
       ('bool', null),
       ('text', null);

-- #############################################################################

INSERT INTO movie_attr (movie_attr_type_id, name)
VALUES (1, 'world_show_start_date'),
       (1, 'russia_show_start_date'),
       (2, 'likes_counts'),
       (4, 'first_night_press'),
       (3, 'oskar'),
       (3, 'nika'),
       (1, 'sale_start_tickets_date'),
       (1, 'advertising_start_date'),
       (1, 'russia_show_end_date');

-- #############################################################################

INSERT INTO movie_attr_value (movie_id, movie_attr_id, val_date, val_text, val_num, val_bool)
VALUES (1, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (2, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (3, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (4, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (5, 4, null,
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
        null, null),
       (1, 3, null, null, 1000, null),
       (2, 3, null, null, 800, null),
       (3, 3, null, null, 300, null),
       (4, 3, null, null, 600, null),
       (5, 3, null, null, 500, null),
       (1, 1, '2023-09-10', null, null, null),
       (1, 2, '2023-10-10', null, null, null),
       (1, 9, '2023-11-10', null, null, null),
       (2, 1, '2023-08-10', null, null, null),
       (2, 2, '2023-09-10', null, null, null),
       (2, 9, '2023-10-10', null, null, null),
       (3, 1, '2023-07-10', null, null, null),
       (3, 2, '2023-08-10', null, null, null),
       (3, 9, '2023-09-10', null, null, null),
       (4, 1, '2023-06-10', null, null, null),
       (4, 2, '2023-07-10', null, null, null),
       (4, 9, '2023-08-10', null, null, null),
       (5, 1, '2023-05-10', null, null, null),
       (5, 2, '2023-06-10', null, null, null),
       (5, 9, '2023-07-10', null, null, null),
       (1, 5, null, null, null, true),
       (2, 5, null, null, null, false),
       (3, 5, null, null, null, true),
       (4, 5, null, null, null, false),
       (5, 5, null, null, null, true),
       (1, 6, null, null, null, false),
       (2, 6, null, null, null, true),
       (3, 6, null, null, null, false),
       (4, 6, null, null, null, true),
       (5, 6, null, null, null, false),
       (1, 7, '2023-09-21', null, null, null),
       (2, 7, '2023-09-23', null, null, null),
       (3, 7, '2023-09-24', null, null, null),
       (4, 7, '2023-09-25', null, null, null),
       (5, 7, '2023-09-26', null, null, null),
       (1, 8, '2023-10-10', null, null, null),
       (2, 8, '2023-10-11', null, null, null),
       (3, 8, '2023-10-12', null, null, null),
       (4, 8, '2023-10-13', null, null, null),
       (5, 8, '2023-10-15', null, null, null);

-- #############################################################################

--  generator unique tickets
WITH movie_show_start_date AS (SELECT m.id         AS movie_id,
                                      mav.val_date AS russia_show_start_date
                               FROM movie m
                                        INNER JOIN movie_attr_value mav ON m.id = mav.movie_id
                                        INNER JOIN movie_attr ma
                                                   ON mav.movie_attr_id = ma.id AND ma.name = 'russia_show_start_date'
                                        INNER JOIN movie_attr_type mat
                                                   ON ma.movie_attr_type_id = mat.id AND mat.name = 'date'),

     random_seat_row AS (SELECT (FLOOR(random() * (room.seats_count / room.rows_count)) + 1) AS room_seat,
                                (FLOOR(random() * room.rows_count) + 1)                      AS room_row,
                                room.id                                                      AS room_id
                         FROM room
                                  CROSS JOIN generate_series(1, 200)),

     random_date AS (SELECT mssd.russia_show_start_date + (FLOOR(random() * 30) + 1)::integer AS movie_show_date,
                            mssd.russia_show_start_date - (FLOOR(random() * 1) + 1)::integer  AS ticket_sale_date
                     FROM movie_show_start_date mssd
                              CROSS JOIN generate_series(1, 200)
                     GROUP BY mssd.russia_show_start_date)


INSERT
INTO ticket (screening_id, room_id, movie_id, seat, row, show_date, sale_date)
SELECT DISTINCT FLOOR(random() * (SELECT count(*) FROM screening)) + 1,
                random_seat_row.room_id,
                mssd.movie_id,
                random_seat_row.room_seat,
                random_seat_row.room_row,
                random_date.movie_show_date,
                random_date.ticket_sale_date
FROM movie_show_start_date mssd
         CROSS JOIN random_seat_row
         CROSS JOIN random_date
ON CONFLICT DO NOTHING;

-- #############################################################################

INSERT INTO queries_result
VALUES ('SELECT s.price
FROM ticket t
         INNER JOIN screening s on s.id = t.screening_id;',
        'Hash Join  (cost=1.41..244.05 rows=11753 width=8) (actual time=0.083..3.595 rows=11753 loops=1)
Hash Cond: (t.screening_id = s.id)
->  Seq Scan on ticket t  (cost=0.00..204.53 rows=11753 width=4) (actual time=0.009..1.125 rows=11753 loops=1)
->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.034..0.035 rows=18 loops=1)
Buckets: 1024  Batches: 1  Memory Usage: 9kB
->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.007..0.010 rows=18 loops=1)
Planning Time: 0.370 ms
Execution Time: 4.158 ms',
        'Hash Join  (cost=1.41..23960.25 rows=1031548 width=8) (actual time=0.148..321.375 rows=1031548 loops=1)
Hash Cond: (t.screening_id = s.id)
->  Seq Scan on ticket t  (cost=0.00..20613.48 rows=1031548 width=4) (actual time=0.031..129.980 rows=1031548 loops=1)
->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.038..0.040 rows=18 loops=1)
Buckets: 1024  Batches: 1  Memory Usage: 9kB
->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.011..0.014 rows=18 loops=1)
Planning Time: 2.000 ms
Execution Time: 360.372 ms',
        'Hash Join  (cost=1.83..22328.42 rows=1031548 width=8) (actual time=0.077..232.660 rows=1031548 loops=1)
  Hash Cond: (t.screening_id = s.id)
  ->  Index Only Scan using idx_screening_id on ticket t  (cost=0.42..18981.65 rows=1031548 width=4) (actual time=0.028..83.175 rows=1031548 loops=1)
        Heap Fetches: 0
  ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.032..0.035 rows=18 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.011..0.014 rows=18 loops=1)
Planning Time: 0.266 ms
Execution Time: 272.105 ms', 'CREATE INDEX idx_screening_id ON ticket (screening_id);
random_page_cost = 1.0 - уменьшил стоимость случайного чтения чтобы планировщик охотнее использовал индекс + у меня быстрый SSD'),
       ('SELECT t.screening_id,
                       MAX(s.price) AS max_price,
                       MIN(s.price) AS min_price
                FROM ticket t
                         INNER JOIN screening s on s.id = t.screening_id
                GROUP BY t.screening_id;', 'HashAggregate  (cost=332.20..332.38 rows=18 width=20) (actual time=7.005..7.012 rows=18 loops=1)
  Group Key: t.screening_id
  Batches: 1  Memory Usage: 24kB
  ->  Hash Join  (cost=1.41..244.05 rows=11753 width=12) (actual time=0.047..4.287 rows=11753 loops=1)
        Hash Cond: (t.screening_id = s.id)
        ->  Seq Scan on ticket t  (cost=0.00..204.53 rows=11753 width=4) (actual time=0.009..1.219 rows=11753 loops=1)
        ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.022..0.024 rows=18 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.005..0.008 rows=18 loops=1)
Planning Time: 0.355 ms
Execution Time: 7.140 ms', 'Finalize GroupAggregate  (cost=20215.59..20220.24 rows=18 width=20) (actual time=236.640..245.451 rows=18 loops=1)
  Group Key: t.screening_id
  ->  Gather Merge  (cost=20215.59..20219.79 rows=36 width=20) (actual time=236.631..245.409 rows=54 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Sort  (cost=19215.57..19215.61 rows=18 width=20) (actual time=185.211..185.215 rows=18 loops=3)
              Sort Key: t.screening_id
              Sort Method: quicksort  Memory: 26kB
              Worker 0:  Sort Method: quicksort  Memory: 26kB
              Worker 1:  Sort Method: quicksort  Memory: 26kB
              ->  Partial HashAggregate  (cost=19215.01..19215.19 rows=18 width=20) (actual time=185.125..185.131 rows=18 loops=3)
                    Group Key: t.screening_id
                    Batches: 1  Memory Usage: 24kB
                    Worker 0:  Batches: 1  Memory Usage: 24kB
                    Worker 1:  Batches: 1  Memory Usage: 24kB
                    ->  Hash Join  (cost=1.41..15991.42 rows=429812 width=12) (actual time=0.889..124.828 rows=343849 loops=3)
                          Hash Cond: (t.screening_id = s.id)
                          ->  Parallel Seq Scan on ticket t  (cost=0.00..14596.12 rows=429812 width=4) (actual time=0.041..47.909 rows=343849 loops=3)
                          ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.778..0.779 rows=18 loops=3)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.733..0.736 rows=18 loops=3)
Planning Time: 0.405 ms
Execution Time: 245.641 ms', 'Finalize GroupAggregate  (cost=13939.56..13946.54 rows=18 width=20) (actual time=139.582..144.226 rows=18 loops=1)
  Group Key: t.screening_id
  ->  Gather Merge  (cost=13939.56..13945.95 rows=54 width=20) (actual time=139.576..144.212 rows=66 loops=1)
        Workers Planned: 3
        Workers Launched: 3
        ->  Sort  (cost=12939.52..12939.57 rows=18 width=20) (actual time=97.323..97.326 rows=16 loops=4)
              Sort Key: t.screening_id
              Sort Method: quicksort  Memory: 26kB
              Worker 0:  Sort Method: quicksort  Memory: 26kB
              Worker 1:  Sort Method: quicksort  Memory: 26kB
              Worker 2:  Sort Method: quicksort  Memory: 26kB
              ->  Partial HashAggregate  (cost=12938.97..12939.15 rows=18 width=20) (actual time=97.283..97.286 rows=16 loops=4)
                    Group Key: t.screening_id
                    Batches: 1  Memory Usage: 24kB
                    Worker 0:  Batches: 1  Memory Usage: 24kB
                    Worker 1:  Batches: 1  Memory Usage: 24kB
                    Worker 2:  Batches: 1  Memory Usage: 24kB
                    ->  Hash Join  (cost=1.83..10443.29 rows=332757 width=12) (actual time=1.660..63.984 rows=257887 loops=4)
                          Hash Cond: (t.screening_id = s.id)
                          ->  Parallel Index Only Scan using idx_screening_id on ticket t  (cost=0.42..9362.74 rows=332757 width=4) (actual time=0.751..24.576 rows=257887 loops=4)
                                Heap Fetches: 0
                          ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.871..0.872 rows=18 loops=4)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.832..0.835 rows=18 loops=4)
Planning Time: 0.661 ms
Execution Time: 144.533 ms', 'CREATE INDEX idx_screening_id ON ticket (screening_id);
max_parallel_workers_per_gather = 4  - улучшил асинхронную обработку операции Hash Join'),
       ('SELECT t.screening_id,
       MAX(s.price) AS max_price,
       MIN(s.price) AS min_price
FROM ticket t
         INNER JOIN screening s on s.id = t.screening_id
WHERE screening_id = 1 -- test value
  AND room_id = 5      -- test value
  AND t.movie_id = 2   -- test value
  AND t.show_date = ''2023-06-11''
GROUP BY t.screening_id;', 'GroupAggregate  (cost=0.15..347.50 rows=1 width=20) (actual time=2.901..2.902 rows=0 loops=1)
  Group Key: t.screening_id
  ->  Nested Loop  (cost=0.15..347.48 rows=1 width=12) (actual time=2.900..2.901 rows=0 loops=1)
        ->  Seq Scan on ticket t  (cost=0.00..339.30 rows=1 width=4) (actual time=2.899..2.899 rows=0 loops=1)
              Filter: ((screening_id = 1) AND (room_id = 5) AND (movie_id = 2) AND (show_date = ''2023-06-11''::date))
              Rows Removed by Filter: 11754
        ->  Index Scan using screening_pkey on screening s  (cost=0.15..8.17 rows=1 width=12) (never executed)
              Index Cond: (id = 1)
Planning Time: 1.007 ms
Execution Time: 3.094 ms', 'GroupAggregate  (cost=1000.15..9144.79 rows=1 width=20) (actual time=107.418..113.938 rows=0 loops=1)
  Group Key: t.screening_id
  ->  Nested Loop  (cost=1000.15..9144.77 rows=1 width=12) (actual time=107.416..113.936 rows=0 loops=1)
        ->  Gather  (cost=1000.00..9136.59 rows=1 width=4) (actual time=107.415..113.934 rows=0 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Parallel Seq Scan on ticket t  (cost=0.00..8136.49 rows=1 width=4) (actual time=36.318..36.318 rows=0 loops=3)
                    Filter: ((screening_id = 1) AND (room_id = 5) AND (movie_id = 2) AND (show_date = ''2023-06-11''::date))
                    Rows Removed by Filter: 172900
        ->  Index Scan using screening_pkey on screening s  (cost=0.15..8.17 rows=1 width=12) (never executed)
              Index Cond: (id = 1)
Planning Time: 3.746 ms
Execution Time: 114.056 ms', 'GroupAggregate  (cost=0.58..4.70 rows=13 width=20) (actual time=0.992..0.993 rows=1 loops=1)
  Group Key: t.screening_id
  ->  Nested Loop  (cost=0.58..4.40 rows=23 width=12) (actual time=0.926..0.935 rows=20 loops=1)
        ->  Index Scan using screening_pkey on screening s  (cost=0.15..2.17 rows=1 width=12) (actual time=0.017..0.018 rows=1 loops=1)
              Index Cond: (id = 1)
        ->  Index Only Scan using idx_screening_movie on ticket t  (cost=0.42..2.00 rows=23 width=4) (actual time=0.904..0.909 rows=20 loops=1)
              Index Cond: ((show_date = ''2023-06-11''::date) AND (movie_id = 2) AND (screening_id = 1) AND (room_id = 5))
              Heap Fetches: 0
Planning Time: 3.378 ms
Execution Time: 1.065 ms', 'CREATE UNIQUE INDEX idx_screening_movie ON ticket (show_date, movie_id, screening_id, room_id, seat, row);
random_page_cost = 1.0  - уменьшил стоимость случайного чтения чтобы планировщик охотнее использовал индекс + у меня быстрый SSD');





