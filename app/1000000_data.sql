
-- Заполняем таблицу фильмов
INSERT INTO films (
    id, name, type, description
) select
    _g.id,
    generateNameFilm(),
    generateTypeFilm(),
    random_string(250)
from
    generate_series(1, 1000000) as _g(id)
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
FROM GENERATE_SERIES(1, 1000000) _g;

-- Заполняем таблицу c заказами
INSERT INTO orders(user_id, session_id, place_id, price, status, created_at)
    SELECT
        rand_between(1, 100000),
        rand_between(1, 30000),
        rand_between(1, 3),
        (random()*1000)::numeric(10,2),
        generateTypeOrder()::status_order,
        (NOW() - INTERVAL '20 day' + INTERVAL '30 day' * RANDOM())
    FROM   
        generate_series(1, 1000000) as _g
ON CONFLICT DO NOTHING;

