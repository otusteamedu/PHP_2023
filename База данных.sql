-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               PostgreSQL 12.12, compiled by Visual C++ build 1914, 64-bit
-- Операционная система:         
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES  */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп данных таблицы public.halls: 0 rows
/*!40000 ALTER TABLE "halls" DISABLE KEYS */;
INSERT INTO "halls" ("uid", "hall_name") VALUES
	(1, 'Зал №1'),
	(3, 'Зал №2'),
	(6, 'Зал №3'),
	(10, 'Зал №4');
/*!40000 ALTER TABLE "halls" ENABLE KEYS */;

-- Дамп данных таблицы public.movies: 0 rows
/*!40000 ALTER TABLE "movies" DISABLE KEYS */;
INSERT INTO "movies" ("uid", "movie_category_id", "movie_name", "movie_duration", "date_screen_start", "date_screen_end") VALUES
	(1, 3, 'Аватар', 162, '2009-12-01', '2010-01-15'),
	(8, 3, 'Джентльмены', 113, '2021-08-28', '2021-11-01'),
	(12, 3, 'Исчезнувшая', 149, '2020-05-01', '2020-07-01');
/*!40000 ALTER TABLE "movies" ENABLE KEYS */;

-- Дамп данных таблицы public.movie_categories: 4 rows
/*!40000 ALTER TABLE "movie_categories" DISABLE KEYS */;
INSERT INTO "movie_categories" ("uid", "category_name", "date_start", "date_end") VALUES
	(2, 'Иностранные фильмы', '2000-08-28', NULL),
	(5, 'Российские фильмы', '2000-08-28', NULL),
	(3, 'Блокбастеры (Высокий рейтинг)', '2000-08-28', NULL),
	(9, 'Фильмы 18+', '2000-08-28', NULL);
/*!40000 ALTER TABLE "movie_categories" ENABLE KEYS */;

-- Дамп данных таблицы public.places: 20 rows
/*!40000 ALTER TABLE "places" DISABLE KEYS */;
INSERT INTO "places" ("uid", "hall_id", "place_number", "row") VALUES
	(1, 1, 1, 1),
	(6, 3, 1, 1),
	(7, 3, 2, 2),
	(8, 3, 3, 3),
	(9, 3, 4, 4),
	(10, 3, 5, 5),
	(11, 6, 1, 1),
	(12, 6, 2, 2),
	(13, 6, 3, 3),
	(14, 6, 4, 4),
	(16, 6, 5, 5),
	(15, 10, 1, 1),
	(17, 10, 2, 2),
	(18, 10, 3, 3),
	(19, 10, 4, 4),
	(20, 10, 5, 5),
	(2, 1, 2, 2),
	(3, 1, 3, 3),
	(4, 1, 4, 4),
	(5, 1, 5, 5);
/*!40000 ALTER TABLE "places" ENABLE KEYS */;

-- Дамп данных таблицы public.price_categories: 0 rows
/*!40000 ALTER TABLE "price_categories" DISABLE KEYS */;
INSERT INTO "price_categories" ("uid", "movie_category_id", "time_start", "time_end", "price") VALUES
	(4, 3, '09:00:00', '12:00:00', 300),
	(13, 3, '12:01:00', '16:00:00', 400),
	(20, 3, '16:01:00', '23:59:59', 500);
/*!40000 ALTER TABLE "price_categories" ENABLE KEYS */;

-- Дамп данных таблицы public.shelude_sessions: 0 rows
/*!40000 ALTER TABLE "shelude_sessions" DISABLE KEYS */;
INSERT INTO "shelude_sessions" ("uid", "movie_id", "hall_id", "screen_time_start", "screen_time_end", "screen_date") VALUES
	(6, 8, 1, '14:00:00', '16:00:00', '2021-08-28'),
	(11, 12, 1, '19:00:00', '21:00:00', '2020-07-01'),
	(4, 1, 1, '09:00:00', '11:00:00', '2009-12-01');
/*!40000 ALTER TABLE "shelude_sessions" ENABLE KEYS */;

-- Дамп данных таблицы public.tickets: 0 rows
/*!40000 ALTER TABLE "tickets" DISABLE KEYS */;
INSERT INTO "tickets" ("uid", "session_id", "place_id", "place_price", "available") VALUES
	(37, 6, 1, 400, 'false'),
	(44, 6, 2, 400, 'false'),
	(62, 6, 4, 400, 'false'),
	(74, 6, 5, 400, 'false'),
	(105, 11, 1, 500, 'false'),
	(117, 11, 2, 500, 'false'),
	(130, 11, 3, 500, 'false'),
	(144, 11, 4, 500, 'false'),
	(159, 11, 5, 500, 'false'),
	(2, 4, 1, 300, 'true'),
	(4, 4, 2, 300, 'true'),
	(7, 4, 3, 300, 'true'),
	(11, 4, 4, 300, 'true'),
	(16, 4, 5, 300, 'true'),
	(52, 6, 3, 400, 'true');
/*!40000 ALTER TABLE "tickets" ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
