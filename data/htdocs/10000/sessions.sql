TRUNCATE TABLE tickets, sessions;
INSERT INTO sessions (id, film_id, hall_id, date, during_time) VALUES 
 (1, 61, 1, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (2, 52, 1, '2024-01-01', '[2024-01-01 06:00:00,2024-01-01 08:59:59)'),
 (3, 44, 1, '2024-01-01', '[2024-01-01 09:00:00,2024-01-01 11:59:59)'),
 (4, 89, 1, '2024-01-01', '[2024-01-01 12:00:00,2024-01-01 14:59:59)'),
 (5, 44, 1, '2024-01-01', '[2024-01-01 15:00:00,2024-01-01 17:59:59)'),
 (6, 26, 1, '2024-01-01', '[2024-01-01 18:00:00,2024-01-01 20:59:59)'),
 (7, 92, 1, '2024-01-01', '[2024-01-01 21:00:00,2024-01-01 23:59:59)'),
 (8, 60, 1, '2024-01-02', '[2024-01-02 00:00:00,2024-01-02 02:59:59)'),
 (9, 43, 1, '2024-01-02', '[2024-01-02 03:00:00,2024-01-02 05:59:59)'),
 (10, 85, 1, '2024-01-02', '[2024-01-02 06:00:00,2024-01-02 08:59:59)'),
 (11, 63, 1, '2024-01-02', '[2024-01-02 09:00:00,2024-01-02 11:59:59)'),
 (12, 7, 1, '2024-01-02', '[2024-01-02 12:00:00,2024-01-02 14:59:59)'),
 (13, 41, 1, '2024-01-02', '[2024-01-02 15:00:00,2024-01-02 17:59:59)'),
 (14, 62, 1, '2024-01-02', '[2024-01-02 18:00:00,2024-01-02 20:59:59)'),
 (15, 77, 1, '2024-01-02', '[2024-01-02 21:00:00,2024-01-02 23:59:59)'),
 (16, 43, 1, '2024-01-03', '[2024-01-03 00:00:00,2024-01-03 02:59:59)'),
 (17, 64, 1, '2024-01-03', '[2024-01-03 03:00:00,2024-01-03 05:59:59)'),
 (18, 57, 1, '2024-01-03', '[2024-01-03 06:00:00,2024-01-03 08:59:59)'),
 (19, 16, 1, '2024-01-03', '[2024-01-03 09:00:00,2024-01-03 11:59:59)'),
 (20, 51, 1, '2024-01-03', '[2024-01-03 12:00:00,2024-01-03 14:59:59)'),
 (21, 64, 1, '2024-01-03', '[2024-01-03 15:00:00,2024-01-03 17:59:59)'),
 (22, 1, 1, '2024-01-03', '[2024-01-03 18:00:00,2024-01-03 20:59:59)'),
 (23, 20, 1, '2024-01-03', '[2024-01-03 21:00:00,2024-01-03 23:59:59)'),
 (24, 71, 1, '2024-01-04', '[2024-01-04 00:00:00,2024-01-04 02:59:59)'),
 (25, 58, 1, '2024-01-04', '[2024-01-04 03:00:00,2024-01-04 05:59:59)'),
 (26, 55, 1, '2024-01-04', '[2024-01-04 06:00:00,2024-01-04 08:59:59)'),
 (27, 25, 1, '2024-01-04', '[2024-01-04 09:00:00,2024-01-04 11:59:59)'),
 (28, 21, 1, '2024-01-04', '[2024-01-04 12:00:00,2024-01-04 14:59:59)'),
 (29, 15, 1, '2024-01-04', '[2024-01-04 15:00:00,2024-01-04 17:59:59)'),
 (30, 61, 1, '2024-01-04', '[2024-01-04 18:00:00,2024-01-04 20:59:59)'),
 (31, 57, 1, '2024-01-04', '[2024-01-04 21:00:00,2024-01-04 23:59:59)'),
 (32, 99, 1, '2024-01-05', '[2024-01-05 00:00:00,2024-01-05 02:59:59)'),
 (33, 47, 1, '2024-01-05', '[2024-01-05 03:00:00,2024-01-05 05:59:59)'),
 (34, 73, 1, '2024-01-05', '[2024-01-05 06:00:00,2024-01-05 08:59:59)'),
 (35, 42, 1, '2024-01-05', '[2024-01-05 09:00:00,2024-01-05 11:59:59)'),
 (36, 34, 1, '2024-01-05', '[2024-01-05 12:00:00,2024-01-05 14:59:59)'),
 (37, 80, 1, '2024-01-05', '[2024-01-05 15:00:00,2024-01-05 17:59:59)'),
 (38, 60, 1, '2024-01-05', '[2024-01-05 18:00:00,2024-01-05 20:59:59)'),
 (39, 89, 1, '2024-01-05', '[2024-01-05 21:00:00,2024-01-05 23:59:59)'),
 (40, 3, 1, '2024-01-06', '[2024-01-06 00:00:00,2024-01-06 02:59:59)'),
 (41, 57, 1, '2024-01-06', '[2024-01-06 03:00:00,2024-01-06 05:59:59)'),
 (42, 62, 1, '2024-01-06', '[2024-01-06 06:00:00,2024-01-06 08:59:59)'),
 (43, 35, 1, '2024-01-06', '[2024-01-06 09:00:00,2024-01-06 11:59:59)'),
 (44, 33, 1, '2024-01-06', '[2024-01-06 12:00:00,2024-01-06 14:59:59)'),
 (45, 2, 1, '2024-01-06', '[2024-01-06 15:00:00,2024-01-06 17:59:59)'),
 (46, 66, 1, '2024-01-06', '[2024-01-06 18:00:00,2024-01-06 20:59:59)'),
 (47, 72, 1, '2024-01-06', '[2024-01-06 21:00:00,2024-01-06 23:59:59)'),
 (48, 59, 1, '2024-01-07', '[2024-01-07 00:00:00,2024-01-07 02:59:59)'),
 (49, 22, 1, '2024-01-07', '[2024-01-07 03:00:00,2024-01-07 05:59:59)'),
 (50, 41, 1, '2024-01-07', '[2024-01-07 06:00:00,2024-01-07 08:59:59)'),
 (51, 96, 1, '2024-01-07', '[2024-01-07 09:00:00,2024-01-07 11:59:59)'),
 (52, 80, 1, '2024-01-07', '[2024-01-07 12:00:00,2024-01-07 14:59:59)'),
 (53, 33, 1, '2024-01-07', '[2024-01-07 15:00:00,2024-01-07 17:59:59)'),
 (54, 38, 1, '2024-01-07', '[2024-01-07 18:00:00,2024-01-07 20:59:59)'),
 (55, 53, 1, '2024-01-07', '[2024-01-07 21:00:00,2024-01-07 23:59:59)'),
 (56, 91, 1, '2024-01-08', '[2024-01-08 00:00:00,2024-01-08 02:59:59)'),
 (57, 23, 1, '2024-01-08', '[2024-01-08 03:00:00,2024-01-08 05:59:59)'),
 (58, 100, 1, '2024-01-08', '[2024-01-08 06:00:00,2024-01-08 08:59:59)'),
 (59, 58, 1, '2024-01-08', '[2024-01-08 09:00:00,2024-01-08 11:59:59)'),
 (60, 38, 1, '2024-01-08', '[2024-01-08 12:00:00,2024-01-08 14:59:59)'),
 (61, 76, 1, '2024-01-08', '[2024-01-08 15:00:00,2024-01-08 17:59:59)'),
 (62, 80, 1, '2024-01-08', '[2024-01-08 18:00:00,2024-01-08 20:59:59)'),
 (63, 99, 1, '2024-01-08', '[2024-01-08 21:00:00,2024-01-08 23:59:59)'),
 (64, 49, 1, '2024-01-09', '[2024-01-09 00:00:00,2024-01-09 02:59:59)'),
 (65, 99, 1, '2024-01-09', '[2024-01-09 03:00:00,2024-01-09 05:59:59)'),
 (66, 44, 1, '2024-01-09', '[2024-01-09 06:00:00,2024-01-09 08:59:59)'),
 (67, 65, 1, '2024-01-09', '[2024-01-09 09:00:00,2024-01-09 11:59:59)'),
 (68, 8, 1, '2024-01-09', '[2024-01-09 12:00:00,2024-01-09 14:59:59)'),
 (69, 5, 1, '2024-01-09', '[2024-01-09 15:00:00,2024-01-09 17:59:59)'),
 (70, 9, 1, '2024-01-09', '[2024-01-09 18:00:00,2024-01-09 20:59:59)'),
 (71, 72, 1, '2024-01-09', '[2024-01-09 21:00:00,2024-01-09 23:59:59)'),
 (72, 82, 1, '2024-01-10', '[2024-01-10 00:00:00,2024-01-10 02:59:59)'),
 (73, 93, 1, '2024-01-10', '[2024-01-10 03:00:00,2024-01-10 05:59:59)'),
 (74, 53, 1, '2024-01-10', '[2024-01-10 06:00:00,2024-01-10 08:59:59)'),
 (75, 75, 1, '2024-01-10', '[2024-01-10 09:00:00,2024-01-10 11:59:59)'),
 (76, 14, 1, '2024-01-10', '[2024-01-10 12:00:00,2024-01-10 14:59:59)'),
 (77, 2, 1, '2024-01-10', '[2024-01-10 15:00:00,2024-01-10 17:59:59)'),
 (78, 23, 1, '2024-01-10', '[2024-01-10 18:00:00,2024-01-10 20:59:59)'),
 (79, 65, 1, '2024-01-10', '[2024-01-10 21:00:00,2024-01-10 23:59:59)'),
 (80, 25, 1, '2024-01-11', '[2024-01-11 00:00:00,2024-01-11 02:59:59)'),
 (81, 22, 1, '2024-01-11', '[2024-01-11 03:00:00,2024-01-11 05:59:59)'),
 (82, 22, 1, '2024-01-11', '[2024-01-11 06:00:00,2024-01-11 08:59:59)'),
 (83, 34, 1, '2024-01-11', '[2024-01-11 09:00:00,2024-01-11 11:59:59)'),
 (84, 32, 1, '2024-01-11', '[2024-01-11 12:00:00,2024-01-11 14:59:59)'),
 (85, 58, 1, '2024-01-11', '[2024-01-11 15:00:00,2024-01-11 17:59:59)'),
 (86, 59, 1, '2024-01-11', '[2024-01-11 18:00:00,2024-01-11 20:59:59)'),
 (87, 33, 1, '2024-01-11', '[2024-01-11 21:00:00,2024-01-11 23:59:59)'),
 (88, 16, 1, '2024-01-12', '[2024-01-12 00:00:00,2024-01-12 02:59:59)'),
 (89, 94, 1, '2024-01-12', '[2024-01-12 03:00:00,2024-01-12 05:59:59)'),
 (90, 93, 1, '2024-01-12', '[2024-01-12 06:00:00,2024-01-12 08:59:59)'),
 (91, 75, 1, '2024-01-12', '[2024-01-12 09:00:00,2024-01-12 11:59:59)'),
 (92, 45, 1, '2024-01-12', '[2024-01-12 12:00:00,2024-01-12 14:59:59)'),
 (93, 41, 1, '2024-01-12', '[2024-01-12 15:00:00,2024-01-12 17:59:59)'),
 (94, 90, 1, '2024-01-12', '[2024-01-12 18:00:00,2024-01-12 20:59:59)'),
 (95, 25, 1, '2024-01-12', '[2024-01-12 21:00:00,2024-01-12 23:59:59)'),
 (96, 70, 1, '2024-01-13', '[2024-01-13 00:00:00,2024-01-13 02:59:59)'),
 (97, 61, 1, '2024-01-13', '[2024-01-13 03:00:00,2024-01-13 05:59:59)'),
 (98, 99, 1, '2024-01-13', '[2024-01-13 06:00:00,2024-01-13 08:59:59)'),
 (99, 36, 1, '2024-01-13', '[2024-01-13 09:00:00,2024-01-13 11:59:59)'),
 (100, 46, 1, '2024-01-13', '[2024-01-13 12:00:00,2024-01-13 14:59:59)'),
 (101, 44, 2, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (102, 86, 3, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (103, 40, 4, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (104, 1, 5, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (105, 34, 6, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (106, 80, 7, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (107, 92, 8, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (108, 71, 9, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)'),
 (109, 57, 10, '2024-01-01', '[2024-01-01 03:00:00,2024-01-01 05:59:59)');