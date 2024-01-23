INSERT INTO films (name, film_description, duration, price, age_rating)
VALUES
    ('Под сенью тайны', 'Загадочная история, полная сюрпризов и неожиданных поворотов', 115, '$200.00', 16),
    ('Секреты темноты', 'Таинственный триллер о раскрытии мрачных секретов', 120, '$220.00', 14),
    ('Тайны прошлого', 'Раскрытие тайн прошлого и справедливость для жертв преступлений', 100, '$200.00', 16),
    ('Погоня за судьбой', 'Напряженный экшн о герое, борющемся за свою судьбу и свободу', 140, '$240.00', 16),
    ('Потерянные во времени', 'Группа путешественников попадает в параллельную реальность и ищет способ вернуться домой', 180, '$280.00', 16),
    ('Неизведанные горизонты', 'Путешествие героев в неизведанные миры и открытие новых горизонтов', 125, '$220.00', 12),
    ('Затерянные в пустыне', 'Выживание героев в опасной и неприветливой пустыне', 130, '$220.00', 12),
    ('Король лев', 'После убийства своего отца молодой принц-лев бежит из своего королевства только для того, чтобы познать истинное значение ответственности и храбрости.', 118, '$200.00', 0),
    ('Тень прошлого', 'Таинственная история о прошлых событиях, которые охватывают настоящее', 90, '$200.00', 16),
    ('Пленительная иллюзия', 'Фильм о захватывающих иллюзиях и искусстве магии', 135, '$140.00', 12),
    ('В поисках сокровищ', 'Увлекательное приключение о поиске древних сокровищ и решении головоломок', 155, '$260.00', 14),
    ('Раскрытая тайна', 'Детективный триллер о расследовании загадочного преступления', 110, '$200.00', 14),
    ('Лабиринт страстей', 'Сложная история любви и предательства, разворачивающаяся в мире интриг и загадок', 120, '$280.00', 18),
    ('Магия момента', 'Удивительная история о магическом моменте, изменяющем жизни главных героев', 105, '$220.00', 18),
    ('Джокер', 'В Готэм-сити психически больной комик Артур Флек вступает в нисходящую спираль социальной революции и кровавых преступлений. Этот путь приводит его лицом к лицу со своим альтер-эго: Джокером.', 122, '$180.00', 16),
    ('Сердце в огне', 'Романтическая история о страстной любви и сложных испытаниях', 150, '$260.00', 16),
    ('Мстители: конец', 'После разрушительных событий «Мстителей: Война бесконечности» вселенная лежит в руинах. С помощью оставшихся союзников Мстители снова собираются, чтобы обратить вспять действия Таноса и восстановить баланс во вселенной.', 181, '$220.00', 12),
    ('Зов приключений', 'История о герое, отправляющемся в опасное путешествие', 120, '$220.00', 12);


INSERT INTO zones (name, coefficient)
VALUES
    ('В середине', 1.00),
    ('VIP', 2.00),
    ('У экрана', 0.90),
    ('У выходов', 0.80),
    ('Последние ряды', 1.20);

INSERT INTO session_types (name, coefficient)
VALUES
    ('2D', 1.00),
    ('3D', 1.50);

INSERT INTO hall_types (name, coefficient)
VALUES
    ('Обычный', 1.00),
    ('IMAX', 2.00),
    ('VIP', 2.00);

INSERT INTO public.halls (name, coefficient)
VALUES
    ('Зал 2', 1.00),
    ('Зал 1', 1.00),
    ('Зал 3', 1.00),
    ('Большой зал', 1.20),
    ('Малый зал', 1.15);

INSERT INTO hall_types_halls (hall_id, hall_type_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 1),
    (4, 2),
    (5, 1),
    (5, 3);

-- Залы будем по одному включать, 6 штучек, одинаковые
INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES
    (1, 1, 4, 1),   (1, 2, 4, 1),   (1, 3, 4, 1),   (1, 4, 4, 1),   (1, 5, 5, 1),   (1, 6, 5, 1),
    (2, 1, 4, 1),   (2, 2, 4, 1),   (2, 3, 4, 1),   (2, 4, 4, 1),   (2, 5, 5, 1),   (2, 6, 5, 1),
    (3, 1, 4, 1),   (3, 2, 4, 1),   (3, 3, 4, 1),   (3, 4, 4, 1),   (3, 5, 5, 1),   (3, 6, 5, 1),
    (4, 1, 3, 1),   (4, 2, 3, 1),   (4, 3, 1, 1),   (4, 4, 1, 1),   (4, 5, 5, 1),   (4, 6, 5, 1),
    (5, 1, 3, 1),   (5, 2, 3, 1),   (5, 3, 1, 1),   (5, 4, 1, 1),   (5, 5, 5, 1),   (5, 6, 5, 1),
    (6, 1, 3, 1),   (6, 2, 3, 1),   (6, 3, 1, 1),   (6, 4, 2, 1),   (6, 5, 5, 1),   (6, 6, 5, 1),
    (7, 1, 3, 1),   (7, 2, 3, 1),   (7, 3, 1, 1),   (7, 4, 2, 1),   (7, 5, 5, 1),   (7, 6, 5, 1),
    (8, 1, 3, 1),   (8, 2, 3, 1),   (8, 3, 1, 1),   (8, 4, 2, 1),   (8, 5, 5, 1),   (8, 6, 5, 1),
    (9, 1, 3, 1),   (9, 2, 3, 1),   (9, 3, 1, 1),   (9, 4, 2, 1),   (9, 5, 5, 1),   (9, 6, 5, 1),
    (10, 1, 3, 1),  (10, 2, 3, 1),  (10, 3, 1, 1),  (10, 4, 1, 1),  (10, 5, 5, 1),  (10, 6, 5, 1),
    (11, 1, 3, 1),  (11, 2, 3, 1),  (11, 3, 1, 1),  (11, 4, 1, 1),  (11, 5, 5, 1),  (11, 6, 5, 1),
    (12, 1, 4, 1),  (12, 2, 4, 1),  (12, 3, 4, 1),  (12, 4, 4, 1),  (12, 5, 5, 1),  (12, 6, 5, 1),
    (13, 1, 4, 1),  (13, 2, 4, 1),  (13, 3, 4, 1),  (13, 4, 4, 1),  (13, 5, 5, 1),  (13, 6, 5, 1),
    (14, 1, 4, 1),  (14, 2, 4, 1),  (14, 3, 4, 1),  (14, 4, 4, 1),  (14, 5, 5, 1),  (14, 6, 5, 1);

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES
    (1, 1, 4, 2),   (1, 2, 4, 2),   (1, 3, 4, 2),   (1, 4, 4, 2),   (1, 5, 5, 2),   (1, 6, 5, 2),
    (2, 1, 4, 2),   (2, 2, 4, 2),   (2, 3, 4, 2),   (2, 4, 4, 2),   (2, 5, 5, 2),   (2, 6, 5, 2),
    (3, 1, 4, 2),   (3, 2, 4, 2),   (3, 3, 4, 2),   (3, 4, 4, 2),   (3, 5, 5, 2),   (3, 6, 5, 2),
    (4, 1, 3, 2),   (4, 2, 3, 2),   (4, 3, 1, 2),   (4, 4, 1, 2),   (4, 5, 5, 2),   (4, 6, 5, 2),
    (5, 1, 3, 2),   (5, 2, 3, 2),   (5, 3, 1, 2),   (5, 4, 1, 2),   (5, 5, 5, 2),   (5, 6, 5, 2),
    (6, 1, 3, 2),   (6, 2, 3, 2),   (6, 3, 1, 2),   (6, 4, 2, 2),   (6, 5, 5, 2),   (6, 6, 5, 2),
    (7, 1, 3, 2),   (7, 2, 3, 2),   (7, 3, 1, 2),   (7, 4, 2, 2),   (7, 5, 5, 2),   (7, 6, 5, 2),
    (8, 1, 3, 2),   (8, 2, 3, 2),   (8, 3, 1, 2),   (8, 4, 2, 2),   (8, 5, 5, 2),   (8, 6, 5, 2),
    (9, 1, 3, 2),   (9, 2, 3, 2),   (9, 3, 1, 2),   (9, 4, 2, 2),   (9, 5, 5, 2),   (9, 6, 5, 2),
    (10, 1, 3, 2),  (10, 2, 3, 2),  (10, 3, 1, 2),  (10, 4, 1, 2),  (10, 5, 5, 2),  (10, 6, 5, 2),
    (11, 1, 3, 2),  (11, 2, 3, 2),  (11, 3, 1, 2),  (11, 4, 1, 2),  (11, 5, 5, 2),  (11, 6, 5, 2),
    (12, 1, 4, 2),  (12, 2, 4, 2),  (12, 3, 4, 2),  (12, 4, 4, 2),  (12, 5, 5, 2),  (12, 6, 5, 2),
    (13, 1, 4, 2),  (13, 2, 4, 2),  (13, 3, 4, 2),  (13, 4, 4, 2),  (13, 5, 5, 2),  (13, 6, 5, 2),
    (14, 1, 4, 2),  (14, 2, 4, 2),  (14, 3, 4, 2),  (14, 4, 4, 2),  (14, 5, 5, 2),  (14, 6, 5, 2);

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES
    (1, 1, 4, 3),   (1, 2, 4, 3),   (1, 3, 4, 3),   (1, 4, 4, 3),   (1, 5, 5, 3),   (1, 6, 5, 3),
    (2, 1, 4, 3),   (2, 2, 4, 3),   (2, 3, 4, 3),   (2, 4, 4, 3),   (2, 5, 5, 3),   (2, 6, 5, 3),
    (3, 1, 4, 3),   (3, 2, 4, 3),   (3, 3, 4, 3),   (3, 4, 4, 3),   (3, 5, 5, 3),   (3, 6, 5, 3),
    (4, 1, 3, 3),   (4, 2, 3, 3),   (4, 3, 1, 3),   (4, 4, 1, 3),   (4, 5, 5, 3),   (4, 6, 5, 3),
    (5, 1, 3, 3),   (5, 2, 3, 3),   (5, 3, 1, 3),   (5, 4, 1, 3),   (5, 5, 5, 3),   (5, 6, 5, 3),
    (6, 1, 3, 3),   (6, 2, 3, 3),   (6, 3, 1, 3),   (6, 4, 2, 3),   (6, 5, 5, 3),   (6, 6, 5, 3),
    (7, 1, 3, 3),   (7, 2, 3, 3),   (7, 3, 1, 3),   (7, 4, 2, 3),   (7, 5, 5, 3),   (7, 6, 5, 3),
    (8, 1, 3, 3),   (8, 2, 3, 3),   (8, 3, 1, 3),   (8, 4, 2, 3),   (8, 5, 5, 3),   (8, 6, 5, 3),
    (9, 1, 3, 3),   (9, 2, 3, 3),   (9, 3, 1, 3),   (9, 4, 2, 3),   (9, 5, 5, 3),   (9, 6, 5, 3),
    (10, 1, 3, 3),  (10, 2, 3, 3),  (10, 3, 1, 3),  (10, 4, 1, 3),  (10, 5, 5, 3),  (10, 6, 5, 3),
    (11, 1, 3, 3),  (11, 2, 3, 3),  (11, 3, 1, 3),  (11, 4, 1, 3),  (11, 5, 5, 3),  (11, 6, 5, 3),
    (12, 1, 4, 3),  (12, 2, 4, 3),  (12, 3, 4, 3),  (12, 4, 4, 3),  (12, 5, 5, 3),  (12, 6, 5, 3),
    (13, 1, 4, 3),  (13, 2, 4, 3),  (13, 3, 4, 3),  (13, 4, 4, 3),  (13, 5, 5, 3),  (13, 6, 5, 3),
    (14, 1, 4, 3),  (14, 2, 4, 3),  (14, 3, 4, 3),  (14, 4, 4, 3),  (14, 5, 5, 3),  (14, 6, 5, 3);

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES
    (1, 1, 4, 4),   (1, 2, 4, 4),   (1, 3, 4, 4),   (1, 4, 4, 4),   (1, 5, 5, 4),   (1, 6, 5, 4),
    (2, 1, 4, 4),   (2, 2, 4, 4),   (2, 3, 4, 4),   (2, 4, 4, 4),   (2, 5, 5, 4),   (2, 6, 5, 4),
    (3, 1, 4, 4),   (3, 2, 4, 4),   (3, 3, 4, 4),   (3, 4, 4, 4),   (3, 5, 5, 4),   (3, 6, 5, 4),
    (4, 1, 3, 4),   (4, 2, 3, 4),   (4, 3, 1, 4),   (4, 4, 1, 4),   (4, 5, 5, 4),   (4, 6, 5, 4),
    (5, 1, 3, 4),   (5, 2, 3, 4),   (5, 3, 1, 4),   (5, 4, 1, 4),   (5, 5, 5, 4),   (5, 6, 5, 4),
    (6, 1, 3, 4),   (6, 2, 3, 4),   (6, 3, 1, 4),   (6, 4, 2, 4),   (6, 5, 5, 4),   (6, 6, 5, 4),
    (7, 1, 3, 4),   (7, 2, 3, 4),   (7, 3, 1, 4),   (7, 4, 2, 4),   (7, 5, 5, 4),   (7, 6, 5, 4),
    (8, 1, 3, 4),   (8, 2, 3, 4),   (8, 3, 1, 4),   (8, 4, 2, 4),   (8, 5, 5, 4),   (8, 6, 5, 4),
    (9, 1, 3, 4),   (9, 2, 3, 4),   (9, 3, 1, 4),   (9, 4, 2, 4),   (9, 5, 5, 4),   (9, 6, 5, 4),
    (10, 1, 3, 4),  (10, 2, 3, 4),  (10, 3, 1, 4),  (10, 4, 1, 4),  (10, 5, 5, 4),  (10, 6, 5, 4),
    (11, 1, 3, 4),  (11, 2, 3, 4),  (11, 3, 1, 4),  (11, 4, 1, 4),  (11, 5, 5, 4),  (11, 6, 5, 4),
    (12, 1, 4, 4),  (12, 2, 4, 4),  (12, 3, 4, 4),  (12, 4, 4, 4),  (12, 5, 5, 4),  (12, 6, 5, 4),
    (13, 1, 4, 4),  (13, 2, 4, 4),  (13, 3, 4, 4),  (13, 4, 4, 4),  (13, 5, 5, 4),  (13, 6, 5, 4),
    (14, 1, 4, 4),  (14, 2, 4, 4),  (14, 3, 4, 4),  (14, 4, 4, 4),  (14, 5, 5, 4),  (14, 6, 5, 4);

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES
    (1, 1, 4, 5),   (1, 2, 4, 5),   (1, 3, 4, 5),   (1, 4, 4, 5),   (1, 5, 5, 5),   (1, 6, 5, 5),
    (2, 1, 4, 5),   (2, 2, 4, 5),   (2, 3, 4, 5),   (2, 4, 4, 5),   (2, 5, 5, 5),   (2, 6, 5, 5),
    (3, 1, 4, 5),   (3, 2, 4, 5),   (3, 3, 4, 5),   (3, 4, 4, 5),   (3, 5, 5, 5),   (3, 6, 5, 5),
    (4, 1, 3, 5),   (4, 2, 3, 5),   (4, 3, 1, 5),   (4, 4, 1, 5),   (4, 5, 5, 5),   (4, 6, 5, 5),
    (5, 1, 3, 5),   (5, 2, 3, 5),   (5, 3, 1, 5),   (5, 4, 1, 5),   (5, 5, 5, 5),   (5, 6, 5, 5),
    (6, 1, 3, 5),   (6, 2, 3, 5),   (6, 3, 1, 5),   (6, 4, 2, 5),   (6, 5, 5, 5),   (6, 6, 5, 5),
    (7, 1, 3, 5),   (7, 2, 3, 5),   (7, 3, 1, 5),   (7, 4, 2, 5),   (7, 5, 5, 5),   (7, 6, 5, 5),
    (8, 1, 3, 5),   (8, 2, 3, 5),   (8, 3, 1, 5),   (8, 4, 2, 5),   (8, 5, 5, 5),   (8, 6, 5, 5),
    (9, 1, 3, 5),   (9, 2, 3, 5),   (9, 3, 1, 5),   (9, 4, 2, 5),   (9, 5, 5, 5),   (9, 6, 5, 5),
    (10, 1, 3, 5),  (10, 2, 3, 5),  (10, 3, 1, 5),  (10, 4, 1, 5),  (10, 5, 5, 5),  (10, 6, 5, 5),
    (11, 1, 3, 5),  (11, 2, 3, 5),  (11, 3, 1, 5),  (11, 4, 1, 5),  (11, 5, 5, 5),  (11, 6, 5, 5),
    (12, 1, 4, 5),  (12, 2, 4, 5),  (12, 3, 4, 5),  (12, 4, 4, 5),  (12, 5, 5, 5),  (12, 6, 5, 5),
    (13, 1, 4, 5),  (13, 2, 4, 5),  (13, 3, 4, 5),  (13, 4, 4, 5),  (13, 5, 5, 5),  (13, 6, 5, 5),
    (14, 1, 4, 5),  (14, 2, 4, 5),  (14, 3, 4, 5),  (14, 4, 4, 5),  (14, 5, 5, 5),  (14, 6, 5, 5);

INSERT INTO viewers (full_name, age)
VALUES
    ('John Doe', 25),
    ('Jane Smith', 30),
    ('John Smith', 26),
    ('Emily Johnson', 33),
    ('Michael Williams', 42),
    ('Sophia Jones', 20),
    ('William Brown', 37),
    ('Olivia Davis', 29),
    ('Jacob Miller', 24),
    ('Ava Anderson', 38),
    ('James Taylor', 43),
    ('Isabella Clark', 30),
    ('Ethan Thomas', 32),
    ('Mia Lee', 27),
    ('Benjamin Harris', 39),
    ('Charlotte Martin', 34),
    ('Daniel Thompson', 25),
    ('Amelia Garcia', 36),
    ('Alexander Martinez', 28),
    ('Harper Robinson', 31),
    ('Matthew Hall', 41),
    ('Evelyn Allen', 21),
    ('Joseph Young', 23),
    ('Abigail King', 40),
    ('David Wright', 35),
    ('Sophie Lopez', 44),
    ('Andrew Hill', 22),
    ('Grace Scott', 45),
    ('Oliver Green', 46),
    ('Chloe Adams', 19),
    ('Jack Baker', 47),
    ('Lily Gonzalez', 48),
    ('Henry Nelson', 49),
    ('Zoe Carter', 18),
    ('Samuel Mitchell', 50),
    ('Madison Perez', 51),
    ('Sebastian Roberts', 52),
    ('Ellie Turner', 17),
    ('Gabriel Phillips', 53),
    ('Scarlett Campbell', 54),
    ('Ryan Parker', 55),
    ('Hannah Evans', 16),
    ('Nathan Collins', 56),
    ('Avery Stewart', 57),
    ('Christian Sanchez', 58),
    ('Sofia Morris', 15),
    ('Caleb Rogers', 59),
    ('Ella Reed', 60),
    ('Owen Cook', 61),
    ('Aria Morgan', 14),
    ('Liam Bell', 62),
    ('Layla Murphy', 63),
    ('Wyatt Bailey', 64),
    ('Nora Rivera', 13),
    ('Hunter Cooper', 65),
    ('Victoria Richardson', 66),
    ('Isaac Cox', 67),
    ('Riley Howard', 12),
    ('Levi Ward', 68),
    ('Zara Torres', 69),
    ('Elijah Peterson', 70),
    ('Penelope Gray', 11),
    ('Grayson Ramirez', 71),
    ('Aurora James', 72),
    ('Carter Watson', 73),
    ('Stella Brooks', 10),
    ('Julian Kelly', 74),
    ('Hazel Sanders', 75),
    ('Luke Price', 76),
    ('Mila Bennett', 9),
    ('Anthony Wood', 77),
    ('Luna Barnes', 78),
    ('Dylan Ross', 79),
    ('Elizabeth Hill', 8),
    ('Christopher Jenkins', 80),
    ('Lillian Perry', 81),
    ('Josiah Powell', 82),
    ('Natalie Long', 7),
    ('Asher Butler', 83),
    ('Addison Reynolds', 84),
    ('Isaiah Fisher', 85),
    ('Eva Patterson', 6),
    ('Joshua Coleman', 86),
    ('Lucy Morales', 87),
    ('Adrian Wagner', 88),
    ('Clara Banks', 5),
    ('Max Hogan', 89),
    ('Audrey Hart', 90),
    ('Leo Simpson', 91),
    ('Brooklyn Reeves', 14),
    ('Charles Mendoza', 92),
    ('Bella Williamson', 93),
    ('Eli Black', 94),
    ('Zoey Sullivan', 13),
    ('Adam Wallace', 95),
    ('Nevaeh Ware', 96),
    ('Ian Ferguson', 97),
    ('Skylar Vasquez', 2),
    ('Xavier Hicks', 98),
    ('Paisley Sims', 99),
    ('Johnathan Ortiz', 10),
    ('Genesis Elliott', 11);

INSERT INTO sessions (session_type, hall_id, film_id, time_start, time_end)
VALUES
    (1, 1, 1, '2021-01-01 18:00:00', '2021-01-01 20:00:00'),
    (2, 2, 2, '2021-01-01 20:30:00', '2021-01-01 22:30:00')
ON CONFLICT ON CONSTRAINT session_no_overlap DO NOTHING;

WITH recursive session_data AS (
    SELECT 1 AS session_count,
           (SELECT id FROM films ORDER BY random() limit 1) AS film_id,
           (SELECT id FROM halls ORDER BY random() limit 1) AS hall_id,
           (SELECT id FROM session_types ORDER BY random() limit 1) AS session_type_id
    UNION ALL
    SELECT session_count + 1,
           (SELECT id FROM films ORDER BY random()+session_count limit 1) AS film_id,
           (SELECT id FROM halls ORDER BY random()+session_count limit 1) AS hall_id,
           (SELECT id FROM session_types ORDER BY random()+session_count limit 1) AS session_type_id
    FROM session_data
    WHERE session_count < 5000000
),
    start_time AS (SELECT TO_TIMESTAMP('2024-01-01 9:00:00', 'YYYY-MM-DD HH:MI:SS') as time)
INSERT INTO sessions (session_type, hall_id, film_id, time_start, time_end)
    SELECT
        session_data.session_type_id,
        session_data.hall_id,
        session_data.film_id,
        (SELECT time FROM start_time) + (session_data.session_count * INTERVAL '30 minutes'),
        (SELECT time FROM start_time) + ((session_data.session_count * INTERVAL '30 minutes') + INTERVAL '2 hours')
    FROM session_data
ON CONFLICT ON CONSTRAINT session_no_overlap DO NOTHING;


INSERT INTO tickets (seat_id, viewer_id, session_id)
VALUES
    (1, 1, 1),
    (2, 2, 2);

WITH recursive tickets_data AS (
    SELECT 1 AS tickets_count,
           (SELECT id FROM viewers ORDER BY random() limit 1) AS viewer_id,
           (SELECT id FROM sessions ORDER BY random() limit 1) AS session_id
    UNION ALL
    SELECT tickets_count + 1,
           (SELECT id FROM viewers ORDER BY random()+tickets_count limit 1) AS viewer_id,
           (SELECT id FROM sessions ORDER BY random()+tickets_count limit 1) AS session_id
    FROM tickets_data
    WHERE tickets_count < 500000
)
INSERT INTO tickets (seat_id, viewer_id, session_id)
SELECT
    (select seats.id from sessions
          join halls ON sessions.hall_id = halls.id AND sessions.id = 4010
          join seats on seats.hall_id = halls.id ORDER BY random() limit 1) AS seat_id,
    tickets_data.viewer_id,
    tickets_data.session_id
FROM tickets_data
         LEFT JOIN sessions ON tickets_data.session_id = sessions.id
;

select seats.id from sessions
join halls ON sessions.hall_id = halls.id AND sessions.id = 4010
join seats on seats.hall_id = halls.id ORDER BY random() limit 1;
-- SELECT seats.id FROM seats WHERE seats.hall_id = sessions.hall_id ORDER BY random() limit 1

INSERT INTO attribute_types (name)
VALUES
    ('Рецензия'),
    ('Обзор'),
    ('Комментарий для сотрудников'),
    ('Рейтинг'),
    ('Возрастной ценз'),
    ('Бюджет'),
    ('Сборы'),
    ('Спеццена'),
    ('Служебные даты'),
    ('Важные даты'),
    ('Премия');

INSERT INTO attributes (name, attribute_type_id)
VALUES
    ('Рецензия журнала Миллениум', 1),
    ('Обзор от Баженова', 2),
    ('Премьера в РФ', 10),
    ('Премия ника', 11),
    ('Золотой глобус', 11),
    ('Мировые сборы', 7),
    ('Сборы в США', 7),
    ('Новогодняя цена', 8),
    ('Цена в честь важного инфоповода', 8),
    ('Начало новогодних показов', 9),
    ('Важный инфоповод', 9),
    ('Завершение новогодних показов', 9),
    ('Возрастной рейтинг для особого региона', 5),
    ('Премия оскар', 11);

INSERT INTO attribute_values (film_id, attribute_id, text_val, bool_val, datetime_val, int_val, numeric_val, money_val)
VALUES
    (1, 1, 'Great movie, must see!', NULL, NULL, NULL, NULL, NULL),
    (2, 2, 'One of the best performances I have ever seen', NULL, NULL, NULL, NULL, NULL),
    (1, 3, NULL, NULL, '2021-01-01 00:00:00', NULL, NULL, NULL),
    (1, 4, NULL, TRUE, NULL, NULL, NULL, NULL),
    (2, 5, NULL, FALSE, NULL, NULL, NULL, NULL),
    (1, 6, NULL, NULL, NULL, NULL, 2797800564, NULL),
    (1, 7, NULL, NULL, NULL, NULL, 858373000, NULL),
    (1, 8, NULL, NULL, NULL, NULL, NULL, 1000.00),
    (2, 9, NULL, NULL, NULL, NULL, NULL, 800.00),
    (1, 10, NULL, NULL, '2023-12-31 00:00:00', NULL, NULL, NULL),
    (1, 11, NULL, NULL, '2023-12-31 00:00:00', NULL, NULL, NULL),
    (3, 12, NULL, NULL, '2024-01-31 00:00:00', NULL, NULL, NULL),
    (3, 13, NULL, NULL, NULL, 16, NULL, NULL);


-- Добавим бессмысленных данных для испытаний запросов

-- INSERT INTO films (name, film_description, duration, price, age_rating)
-- SELECT
--     CONCAT(LEFT(md5(random()::text), 5), ' ', LEFT(md5(random()::text), 5), ' ', LEFT(md5(random()::text), 5)) AS name,
--     CONCAT(LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ',
--            LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ',
--            LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ',
--            LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ',
--            LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ',
--            LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10), ' ', LEFT(md5(random()::text), 10))
--         AS film_description,
--     FLOOR(RANDOM() * (200 - 90 + 1) + 90)::int AS duration,
--     FLOOR(RANDOM() * (500 - 200 + 1) + 200)::int AS price,
--     FLOOR(RANDOM() * (21 - 0 + 1))::int AS age_rating
-- FROM
--     generate_series(1, 100);