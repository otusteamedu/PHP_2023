-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: db
-- Время создания: Сен 22 2023 г., 10:23
-- Версия сервера: 8.1.0
-- Версия PHP: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cinema`
--

-- --------------------------------------------------------

--
-- Структура таблицы `films`
--

CREATE TABLE `films` (
     `id` bigint NOT NULL,
     `name` text NOT NULL,
     `genre` text NOT NULL,
     `year_of_release` int NOT NULL,
     `duration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `films`
--

INSERT INTO `films` (`id`, `name`, `genre`, `year_of_release`, `duration`) VALUES
(1, 'The Green Mile', 'drama', 1999, 189),
(2, 'Forrest Gump', 'melodrama', 1994, 142),
(3, 'Interstellar', 'fantastic', 2014, 169),
(4, 'Fight Club', 'thriller', 1999, 139),
(5, 'Pulp Fiction', 'criminal', 1994, 154),
(6, 'Back to the Future', 'comedy', 1985, 116);

-- --------------------------------------------------------

--
-- Структура таблицы `halls`
--

CREATE TABLE `halls` (
     `id` bigint NOT NULL,
     `name` text NOT NULL,
     `rows_number` int NOT NULL,
     `seats_number` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `halls`
--

INSERT INTO `halls` (`id`, `name`, `rows_number`, `seats_number`) VALUES
  (1, '2D', 20, 30),
  (2, '3D', 15, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `prices`
--

CREATE TABLE `prices` (
  `id` int NOT NULL,
  `session_id` bigint NOT NULL,
  `seat_category_id` bigint NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `prices`
--

INSERT INTO `prices` (`id`, `session_id`, `seat_category_id`, `price`) VALUES
   (1, 1, 1, 400),
   (2, 1, 2, 500),
   (3, 1, 3, 600),
   (4, 2, 1, 500),
   (5, 2, 2, 600),
   (6, 2, 3, 700),
   (7, 3, 1, 400),
   (8, 3, 2, 500),
   (9, 3, 3, 600),
   (10, 4, 1, 500),
   (11, 4, 2, 600),
   (12, 4, 3, 700),
   (13, 5, 1, 400),
   (14, 5, 2, 500),
   (15, 5, 3, 600),
   (16, 6, 1, 500),
   (17, 6, 2, 600),
   (18, 6, 3, 700),
   (19, 7, 1, 600),
   (20, 7, 2, 700),
   (21, 7, 3, 800),
   (22, 8, 1, 600),
   (23, 8, 2, 700),
   (24, 8, 3, 800);

-- --------------------------------------------------------

--
-- Структура таблицы `rows_seats_categories`
--

CREATE TABLE `rows_seats_categories` (
 `id` bigint NOT NULL,
 `row` int NOT NULL,
 `seat` int NOT NULL,
 `hall_id` bigint NOT NULL,
 `seat_category_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `rows_seats_categories`
--

INSERT INTO `rows_seats_categories` (`id`, `row`, `seat`, `hall_id`, `seat_category_id`) VALUES
 (1, 1, 1, 1, 1),
 (2, 1, 2, 1, 2),
 (3, 1, 3, 1, 3),
 (4, 1, 4, 1, 1),
 (5, 1, 5, 1, 2),
 (6, 2, 1, 1, 3),
 (7, 2, 2, 1, 1),
 (8, 2, 3, 1, 2),
 (9, 2, 4, 1, 3),
 (10, 2, 5, 1, 1),
 (11, 1, 1, 2, 2),
 (12, 1, 2, 2, 3),
 (13, 1, 3, 2, 1),
 (14, 1, 4, 2, 2),
 (15, 1, 5, 2, 3),
 (16, 2, 1, 2, 1),
 (17, 2, 2, 2, 2),
 (18, 2, 3, 2, 3),
 (19, 2, 4, 2, 1),
 (20, 2, 5, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `seat_categories`
--

CREATE TABLE `seat_categories` (
                                   `id` bigint NOT NULL,
                                   `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `seat_categories`
--

INSERT INTO `seat_categories` (`id`, `name`) VALUES
 (1, 'discounted'),
 (2, 'normal'),
 (3, 'expensive');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
`id` bigint NOT NULL,
`datetime` datetime NOT NULL,
`hall_id` bigint NOT NULL,
`film_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `datetime`, `hall_id`, `film_id`) VALUES
(1, '2023-09-01 10:00:00', 1, 1),
(2, '2023-09-02 11:30:00', 2, 3),
(3, '2023-09-03 11:00:00', 1, 4),
(4, '2023-09-04 15:30:00', 2, 4),
(5, '2023-09-05 13:00:00', 1, 2),
(6, '2023-09-06 18:30:00', 2, 4),
(7, '2023-09-07 10:00:00', 1, 5),
(8, '2023-09-08 11:30:00', 2, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
`id` bigint NOT NULL,
`rows_seats_categories_id` bigint NOT NULL,
`session_id` bigint NOT NULL,
`status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`id`, `rows_seats_categories_id`, `session_id`, `status`) VALUES
 (1, 1, 1, 'booked'),
 (2, 2, 2, 'free'),
 (3, 3, 3, 'reserved'),
 (4, 4, 4, 'free'),
 (5, 5, 5, 'free'),
 (6, 6, 6, 'booked'),
 (7, 7, 7, 'booked'),
 (8, 8, 8, 'free'),
 (9, 9, 1, 'free'),
 (10, 10, 2, 'booked'),
 (11, 11, 3, 'booked'),
 (12, 12, 4, 'booked'),
 (13, 13, 1, 'booked'),
 (14, 14, 2, 'free'),
 (15, 15, 3, 'reserved'),
 (16, 16, 4, 'free'),
 (17, 17, 5, 'free'),
 (18, 18, 6, 'booked'),
 (19, 19, 7, 'booked'),
 (20, 20, 8, 'free');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `films`
--
ALTER TABLE `films`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `halls`
--
ALTER TABLE `halls`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prices`
--
ALTER TABLE `prices`
    ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`seat_category_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Индексы таблицы `rows_seats_categories`
--
ALTER TABLE `rows_seats_categories`
    ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`seat_category_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Индексы таблицы `seat_categories`
--
ALTER TABLE `seat_categories`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
    ADD PRIMARY KEY (`id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
    ADD PRIMARY KEY (`id`),
  ADD KEY `rows_seats_categories_id` (`rows_seats_categories_id`),
  ADD KEY `session_id` (`session_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `halls`
--
ALTER TABLE `halls`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `prices`
--
ALTER TABLE `prices`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `rows_seats_categories`
--
ALTER TABLE `rows_seats_categories`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `seat_categories`
--
ALTER TABLE `seat_categories`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
    MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `prices`
--
ALTER TABLE `prices`
    ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`seat_category_id`) REFERENCES `seat_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prices_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `rows_seats_categories`
--
ALTER TABLE `rows_seats_categories`
    ADD CONSTRAINT `rows_seats_categories_ibfk_1` FOREIGN KEY (`seat_category_id`) REFERENCES `seat_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `rows_seats_categories_ibfk_2` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
    ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
    ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`rows_seats_categories_id`) REFERENCES `rows_seats_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
