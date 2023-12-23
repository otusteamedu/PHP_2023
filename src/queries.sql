/*1. Выбор всех фильмов на сегодня*/
SELECT s.id, TO_CHAR(s.start, 'HH24:MI') as "Время", m.name, h.name FROM seance AS s
JOIN movie AS m ON s.movie_id = m.id
JOIN hall AS h ON s.hall_id = h.id
WHERE DATE(start) = current_date
ORDER BY "Время";

/*2. Подсчёт проданных билетов за неделю*/
SELECT count(id) FROM "order"
WHERE
    DATE(date_pay) >= current_date - EXTRACT(dow FROM current_date)::integer + 1
  AND
    DATE(date_pay) <= current_date + (7 - EXTRACT(dow FROM current_date)::integer);

/*3. Формирование афиши (фильмы, которые показывают сегодня)*/




/*4. Поиск 3 самых прибыльных фильмов за неделю*/
SELECT SUM(o.cost) as total, m.name FROM "order" AS o
                                             JOIN movie as m ON m.id = o.movie_id
WHERE
    DATE(date_pay) >= current_date - EXTRACT(dow FROM current_date)::integer + 1
  AND
    DATE(date_pay) <= current_date + (7 - EXTRACT(dow FROM current_date)::integer)
  AND
    paid = 'true'
GROUP BY m.name
ORDER BY total DESC
LIMIT 3;