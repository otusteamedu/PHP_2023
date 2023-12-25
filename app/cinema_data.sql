-- Заполняем таблицу залов
INSERT INTO halls (name) VALUES ('Зал1'), ('Зал2'), ('Зал3');     

-- Заполняем таблицу c Типами Мест
INSERT INTO TypesRows (name) VALUES ('vip'), ('стандартное');


-- Заполняем таблицу с информацией о рядах
DO
$$
DECLARE
    halls integer:=3;
BEGIN
    FOR i IN 1..halls LOOP
        INSERT INTO 
        Rows (type_id, title, hall_id, position)
        SELECT
            (SELECT id FROM TypesRows ORDER BY random()+_g*0 LIMIT 1),
            substr(md5(random()::text), 1, 8),
            i,
            _g
        FROM
        generate_series(1, 20) as _g
        ON CONFLICT DO NOTHING;
    END LOOP;
END; 
$$ language plpgsql;


-- Заполняем таблицу с информацией о местах
do
$$
declare
  length integer:= 60;
begin
   for i in 1..length loop
        INSERT INTO 
                Places (row_id, number, active)
        SELECT
                i,
                _g,
                1
        FROM
            generate_series(1, 40) as _g;
   end loop;
end;
$$ language plpgsql;

