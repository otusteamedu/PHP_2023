CREATE TABLE `order` (
  `id` int PRIMARY KEY,
  `user_id` int,
  `date_create` datetime DEFAULT (now()),
  `cost` int
);

CREATE TABLE `ticket` (
  `id` int PRIMARY KEY,
  `order_id` int,
  `seat_price_id` int
);

CREATE TABLE `session` (
  `id` int PRIMARY KEY,
  `time` datetime,
  `hall_id` int,
  `movie_id` int
);

CREATE TABLE `hall` (
  `id` int PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `seat_map` (
  `id` int PRIMARY KEY,
  `seat_id` int,
  `hall_id` int
);

CREATE TABLE `seat` (
  `id` int PRIMARY KEY,
  `row` int,
  `seat` int
);

CREATE TABLE `seat_price` (
  `id` int PRIMARY KEY,
  `price` int,
  `seat_map_id` int,
  `session_id` int
);

CREATE TABLE `movie` (
  `id` int PRIMARY KEY,
  `title` varchar(255),
  `description` varchar(255),
  `duration` time
);

CREATE TABLE `user` (
  `id` int PRIMARY KEY,
  `name` varchar(255),
  `phone` varchar(255)
);

ALTER TABLE `ticket` ADD FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);

ALTER TABLE `session` ADD FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`);

ALTER TABLE `seat_map` ADD FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`);

ALTER TABLE `seat_map` ADD FOREIGN KEY (`seat_id`) REFERENCES `seat` (`id`);

ALTER TABLE `seat_price` ADD FOREIGN KEY (`seat_map_id`) REFERENCES `seat_map` (`id`);

ALTER TABLE `ticket` ADD FOREIGN KEY (`seat_price_id`) REFERENCES `seat_price` (`id`);

ALTER TABLE `seat_price` ADD FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);

ALTER TABLE `session` ADD FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`);

ALTER TABLE `order` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
