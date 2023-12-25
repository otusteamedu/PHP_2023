-- Заполняем таблицу фильмов
INSERT INTO films (
    id, name, type, description
) select
    _g.id,
    generateNameFilm(),
    generateTypeFilm(),
    random_string(250)
from
    generate_series(1, 1000) as _g(id)
ON CONFLICT DO NOTHING;

-- Заполняем таблицу сеансов
INSERT INTO 
    Sessions(film_id, hall_id, start_at) 
SELECT 
    (SELECT id FROM films ORDER BY random()+_g*0 LIMIT 1),
    (SELECT id FROM halls ORDER BY random()+_g*0 LIMIT 1),
    (NOW() - INTERVAL '20 day' + INTERVAL '40 day' * RANDOM())
FROM   
    generate_series(1, 30000) as _g
ON CONFLICT DO NOTHING;


-- Заполняем таблицу c ценнами для сеансов
INSERT INTO 
  SessionPrices (session_id, type_id, price)
SELECT
    (SELECT id FROM Sessions ORDER BY random()+_g*0 LIMIT 1),
    (SELECT id FROM TypesRows ORDER BY random()+_g*0 LIMIT 1),
    (random()*1000)::numeric(10,2)
FROM
 generate_series(1, 60000) as _g
 ON CONFLICT DO NOTHING;


-- Заполняем таблицу c пользователей
INSERT INTO users(name, email)
SELECT
  'user_' || _g,
  'user_' || _g || '@' || (
    CASE (RANDOM() * 2)::INT
      WHEN 0 THEN 'gmail'
      WHEN 1 THEN 'hotmail'
      WHEN 2 THEN 'yahoo'
    END
  ) || '.com' AS email
FROM GENERATE_SERIES(1, 10000) _g;

-- Заполняем таблицу c заказами
INSERT INTO orders(user_id, session_id, place_id, price, status, created_at)
    SELECT
        (SELECT id FROM users ORDER BY random()+_g*0 LIMIT 1),
        (SELECT id FROM Sessions ORDER BY random()+_g*0 LIMIT 1),
        (SELECT id FROM Places ORDER BY random()+_g*0 LIMIT 1),
        (random()*1000)::numeric(10,2),
        generateTypeOrder()::status_order,
        (NOW() - INTERVAL '20 day' + INTERVAL '30 day' * RANDOM())
    FROM   
        generate_series(1, 10000) as _g
ON CONFLICT DO NOTHING;

