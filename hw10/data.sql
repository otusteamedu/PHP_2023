INSERT INTO halls(name)
VALUES ('Основной зал'),
       ('VIP зал');

DO $$
    BEGIN
        FOR i IN 1..2 LOOP
            FOR j IN 1..5 LOOP
                INSERT INTO seats(number, row, hall_id, koef)
                SELECT
                    number,
                    j,
                    i,
                    CASE WHEN number BETWEEN 4 AND 6 AND j BETWEEN 2 AND 3
                        THEN 1.5
                        ELSE 1
                    END
                FROM generate_series(1, 10) as number;
            END LOOP;
        END LOOP;
    END $$;

INSERT INTO movies(name, duration)
VALUES
    ('По щучьему велению', 120),
    ('Социальная сеть', 150),
    ('Бременские музыканты', 180),
    ('Три богатыря и Пуп Земли', 135),
    ('Игры разума', 90);

INSERT INTO sessions(movie_id, hall_id, price, start_time)
SELECT
    floor(random() * 5) + 1,
    floor(random() * 2) + 1,
    floor(random() * 200) + 100,
    CURRENT_TIMESTAMP + (i * INTERVAL '1 hour')
FROM generate_series(1, 10000) as i;

INSERT INTO tickets(session_id, seat_id, price)
SELECT S.id, ST.id, floor(S.price * ST.koef)
FROM sessions S
INNER JOIN (SELECT id, hall_id, koef FROM seats ORDER BY RANDOM() LIMIT 10) ST ON ST.hall_id = S.hall_id
