INSERT INTO `room` (`name`) VALUES ('1');
INSERT INTO `room` (`name`) VALUES ('2');

INSERT INTO `movie` (`name`) VALUES ('Ну погоди');
INSERT INTO `movie` (`name`) VALUES ('Чебурашка');

INSERT INTO `seat_class` (`name`) VALUES ('Обычный');
INSERT INTO `seat_class` (`name`) VALUES ('Премиум');

INSERT INTO `seat` (`room_id`, `seat_class`, `row`, `num`) VALUES ('1', '1', '1', '1');
INSERT INTO `seat` (`room_id`, `seat_class`, `row`, `num`) VALUES ('1', '2', '1', '2');
INSERT INTO `seat` (`room_id`, `seat_class`, `row`, `num`) VALUES ('2', '1', '1', '1');
INSERT INTO `seat` (`room_id`, `seat_class`, `row`, `num`) VALUES ('2', '2', '1', '2');

INSERT INTO `schedule` (`room_id`, `movie_id`, `datetime`) VALUES ('1', '1', '2023-08-30 00:51:46');
INSERT INTO `schedule` (`room_id`, `movie_id`, `datetime`) VALUES ('2', '2', '2023-08-30 00:52:23');
INSERT INTO `schedule` (`room_id`, `movie_id`, `datetime`) VALUES ('2', '2', '2023-08-30 00:53:01');

INSERT INTO `seat_price` (`seat_class_id`, `schedule_id`, `price`) VALUES ('1', '1', '1');
INSERT INTO `seat_price` (`seat_class_id`, `schedule_id`, `price`) VALUES ('2', '1', '2');
INSERT INTO `seat_price` (`seat_class_id`, `schedule_id`, `price`) VALUES ('1', '2', '1');
INSERT INTO `seat_price` (`seat_class_id`, `schedule_id`, `price`) VALUES ('2', '2', '2');
INSERT INTO `seat_price` (`seat_class_id`, `schedule_id`, `price`) VALUES ('1', '3', '1');
INSERT INTO `seat_price` (`seat_class_id`, `schedule_id`, `price`) VALUES ('2', '3', '2');


INSERT INTO `sold_ticket` (`id`, `schedule_id`, `seat_id`) VALUES (1, 1, 1);
INSERT INTO `sold_ticket` (`id`, `schedule_id`, `seat_id`) VALUES (2, 1, 2);
INSERT INTO `sold_ticket` (`id`, `schedule_id`, `seat_id`) VALUES (3, 2, 3);
INSERT INTO `sold_ticket` (`id`, `schedule_id`, `seat_id`) VALUES (4, 2, 4);
INSERT INTO `sold_ticket` (`id`, `schedule_id`, `seat_id`) VALUES (5, 3, 3);
INSERT INTO `sold_ticket` (`id`, `schedule_id`, `seat_id`) VALUES (6, 3, 4);
