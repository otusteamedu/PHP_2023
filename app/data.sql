INSERT INTO "attributes" ("id", "name", "attribute_type_id") VALUES
(1,	'рецензии критиков',	2),
(2,	'отзыв кинопоиск',	2),
(3,	'отзыв IMDb',	2),
(4,	'рейтинг кинопоиск',	8),
(5,	'рейтинг IMDb',	8),
(6,	'премия оскар',	4),
(7,	'премия ника',	4),
(8,	'мировая премьера',	6),
(9,	'премьера в РФ',	6),
(10,	'начала продажи билетов',	6),
(11,	'запуск рекламы на TВ',	5),
(12,	'cлоган',	1),
(13,	'бюджет',	8),
(14,	'возраст',	7);

INSERT INTO "attributes_type" ("id", "name") VALUES
(1,	'string'),
(2,	'text'),
(3,	'image'),
(4,	'boolean'),
(5,	'datetime'),
(6,	'date'),
(7,	'integer'),
(8,	'float');

INSERT INTO "attributes_values" ("id", "film_id", "attribute_id", "value") VALUES
(1,	1,	4,	'9.1'),
(2,	1,	5,	'8.6'),
(3,	8,	4,	'9.0'),
(4,	8,	5,	'9.3'),
(5,	7,	12,	'Твой разум - место преступления'),
(6,	4,	12,	'ТИнтриги. Хаос. Мыло'),
(7,	3,	13,	'165000000'),
(8,	6,	13,	'19000000');

INSERT INTO "films" ("id", "name", "genre", "year_of_release", "duration") VALUES
(1,	'The Green Mile',	'drama',	1999,	189),
(2,	'Forrest Gump',	'melodrama',	1994,	142),
(3,	'Interstellar',	'fantastic',	2014,	169),
(4,	'Fight Club',	'thriller',	1999,	139),
(5,	'Pulp Fiction',	'criminal',	1994,	154),
(6,	'Back to the Future',	'comedy',	1985,	116),
(7,	'Inception',	'fantastic',	2010,	148),
(8,	'The Shawshank Redemption',	'drama',	1994,	142);

INSERT INTO "halls" ("id", "name", "rows_number", "seats_number") VALUES
(1,	'2D',	20,	30),
(2,	'3D',	15,	20);

INSERT INTO "prices" ("id", "session_id", "seat_category_id", "price") VALUES
(1,	1,	1,	'$400.00'),
(2,	1,	2,	'$500.00'),
(3,	1,	3,	'$600.00'),
(4,	2,	1,	'$500.00'),
(5,	2,	2,	'$600.00'),
(6,	2,	3,	'$700.00'),
(7,	3,	1,	'$400.00'),
(8,	3,	2,	'$500.00'),
(9,	3,	3,	'$600.00'),
(10,	4,	1,	'$500.00'),
(11,	4,	2,	'$600.00'),
(12,	4,	3,	'$700.00'),
(13,	5,	1,	'$400.00'),
(14,	5,	2,	'$500.00'),
(15,	5,	3,	'$600.00'),
(16,	6,	1,	'$500.00'),
(17,	6,	2,	'$600.00'),
(18,	6,	3,	'$700.00'),
(19,	7,	1,	'$600.00'),
(20,	7,	2,	'$700.00'),
(21,	7,	3,	'$800.00'),
(22,	8,	1,	'$600.00'),
(23,	8,	2,	'$700.00'),
(24,	8,	3,	'$800.00');

INSERT INTO "rows_seats_categories" ("id", "row", "seat", "hall_id", "seat_category_id") VALUES
(1,	1,	1,	1,	1),
(2,	1,	2,	1,	2),
(3,	1,	3,	1,	3),
(4,	1,	4,	1,	1),
(5,	1,	5,	1,	2),
(6,	2,	1,	1,	3),
(7,	2,	2,	1,	1),
(8,	2,	3,	1,	2),
(9,	2,	4,	1,	3),
(10,	2,	5,	1,	1),
(11,	1,	1,	2,	2),
(12,	1,	2,	2,	3),
(13,	1,	3,	2,	1),
(14,	1,	4,	2,	2),
(15,	1,	5,	2,	3),
(16,	2,	1,	2,	1),
(17,	2,	2,	2,	2),
(18,	2,	3,	2,	3),
(19,	2,	4,	2,	1),
(20,	2,	5,	2,	2);

INSERT INTO "sessions" ("id", "datetime", "hall_id", "film_id") VALUES
(3,	'2023-09-03 11:00:00',	1,	4),
(4,	'2023-09-04 15:30:00',	2,	4),
(5,	'2023-09-05 13:00:00',	1,	2),
(6,	'2023-09-06 18:30:00',	2,	4),
(7,	'2023-09-07 10:00:00',	1,	5),
(8,	'2023-09-08 11:30:00',	2,	4),
(2,	'2023-10-22 11:30:00',	2,	3),
(1,	'2023-10-22 10:00:00',	1,	1),
(9,	'2023-10-23 09:00:00',	2,	3),
(10,	'2023-10-23 09:00:00',	1,	1);

INSERT INTO "tickets" ("id", "rows_seats_categories_id", "session_id", "status") VALUES
(1,	1,	1,	'booked'),
(2,	2,	2,	'free'),
(3,	3,	3,	'reserved'),
(4,	4,	4,	'free'),
(5,	5,	5,	'free'),
(6,	6,	6,	'booked'),
(7,	7,	7,	'booked'),
(8,	8,	8,	'free'),
(9,	9,	1,	'free'),
(10,	10,	2,	'booked'),
(11,	11,	3,	'booked'),
(12,	12,	4,	'booked'),
(13,	13,	1,	'booked'),
(14,	14,	2,	'free'),
(15,	15,	3,	'reserved'),
(16,	16,	4,	'free'),
(17,	17,	5,	'free'),
(18,	18,	6,	'booked'),
(19,	19,	7,	'booked'),
(20,	20,	8,	'free');

INSERT INTO "seat_categories" ("id", "name") VALUES
(1,	'discounted'),
(2,	'normal'),
(3,	'expensive');