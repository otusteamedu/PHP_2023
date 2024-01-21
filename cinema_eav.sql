/*
Navicat MySQL Data Transfer

Source Server         : dev.filkos.com
Source Server Version : 50505
Source Host           : localhost:3312
Source Database       : cinema

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2024-01-21 11:52:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for attribute_types
-- ----------------------------
DROP TABLE IF EXISTS `attribute_types`;
CREATE TABLE `attribute_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `field_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attribute_types
-- ----------------------------
INSERT INTO `attribute_types` VALUES ('1', 'Текст', 'text');
INSERT INTO `attribute_types` VALUES ('2', 'Целое число', 'int');
INSERT INTO `attribute_types` VALUES ('3', 'Дробное число', 'decimal');
INSERT INTO `attribute_types` VALUES ('4', 'Дата', 'date');
INSERT INTO `attribute_types` VALUES ('5', 'Да/Нет', 'bool');

-- ----------------------------
-- Table structure for attribute_values
-- ----------------------------
DROP TABLE IF EXISTS `attribute_values`;
CREATE TABLE `attribute_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) DEFAULT NULL,
  `moovie_id` int(11) DEFAULT NULL,
  `text` text,
  `bool` tinyint(4) DEFAULT NULL,
  `int` int(11) DEFAULT NULL,
  `decimal` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vattribute` (`attribute_id`),
  KEY `vmoovie` (`moovie_id`),
  CONSTRAINT `vattribute` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `vmoovie` FOREIGN KEY (`moovie_id`) REFERENCES `moovies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attribute_values
-- ----------------------------
INSERT INTO `attribute_values` VALUES ('1', '1', '1', 'Рецензия сугубо отрицательная', null, null, null, null);
INSERT INTO `attribute_values` VALUES ('2', '2', '1', 'А вот отзыв киноакадемии - наоборот, положительный', null, null, null, null);
INSERT INTO `attribute_values` VALUES ('3', '3', '1', null, '0', null, null, null);
INSERT INTO `attribute_values` VALUES ('4', '4', '1', null, '0', null, null, null);
INSERT INTO `attribute_values` VALUES ('5', '5', '1', null, null, null, null, '2024-01-10');
INSERT INTO `attribute_values` VALUES ('6', '6', '1', null, null, null, null, '2024-01-10');
INSERT INTO `attribute_values` VALUES ('7', '7', '1', null, null, null, null, '2024-01-01');
INSERT INTO `attribute_values` VALUES ('8', '8', '1', null, null, null, null, '2023-12-01');
INSERT INTO `attribute_values` VALUES ('9', '9', '1', null, null, null, '300.00', null);
INSERT INTO `attribute_values` VALUES ('10', '10', '1', null, null, '16', null, null);
INSERT INTO `attribute_values` VALUES ('11', '1', '2', 'Рецензия ни рыба ни мясо', null, null, null, null);
INSERT INTO `attribute_values` VALUES ('12', '2', '2', 'Страшно, жуть', null, null, null, null);
INSERT INTO `attribute_values` VALUES ('13', '3', '2', null, '1', null, null, null);
INSERT INTO `attribute_values` VALUES ('14', '4', '2', null, '0', null, null, null);
INSERT INTO `attribute_values` VALUES ('15', '5', '2', null, null, null, null, '2024-02-10');
INSERT INTO `attribute_values` VALUES ('16', '6', '2', null, null, null, null, '2024-02-10');
INSERT INTO `attribute_values` VALUES ('17', '7', '2', null, null, null, null, '2024-02-01');
INSERT INTO `attribute_values` VALUES ('18', '8', '2', null, null, null, null, '2024-01-01');
INSERT INTO `attribute_values` VALUES ('19', '9', '2', null, null, null, '200.00', null);
INSERT INTO `attribute_values` VALUES ('20', '10', '2', null, null, '18', null, null);
INSERT INTO `attribute_values` VALUES ('21', '1', '3', 'Восторг!', null, null, null, null);
INSERT INTO `attribute_values` VALUES ('22', '2', '3', 'Это того стоило!', null, null, null, null);
INSERT INTO `attribute_values` VALUES ('23', '3', '3', null, '1', null, null, null);
INSERT INTO `attribute_values` VALUES ('24', '4', '3', null, '1', null, null, null);
INSERT INTO `attribute_values` VALUES ('25', '5', '3', null, null, null, null, '2024-03-10');
INSERT INTO `attribute_values` VALUES ('26', '6', '3', null, null, null, null, '2024-03-10');
INSERT INTO `attribute_values` VALUES ('27', '7', '3', null, null, null, null, '2024-03-01');
INSERT INTO `attribute_values` VALUES ('28', '8', '3', null, null, null, null, '2024-02-01');
INSERT INTO `attribute_values` VALUES ('29', '9', '3', null, null, null, '900.00', null);
INSERT INTO `attribute_values` VALUES ('30', '10', '3', null, null, '45', null, null);

-- ----------------------------
-- Table structure for attributes
-- ----------------------------
DROP TABLE IF EXISTS `attributes`;
CREATE TABLE `attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type_id`),
  CONSTRAINT `type` FOREIGN KEY (`type_id`) REFERENCES `attribute_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attributes
-- ----------------------------
INSERT INTO `attributes` VALUES ('1', 'Рецензия критиков', '1');
INSERT INTO `attributes` VALUES ('2', 'Отзыв киноакадемии', '1');
INSERT INTO `attributes` VALUES ('3', 'Премия Оскар', '5');
INSERT INTO `attributes` VALUES ('4', 'Премия Ника', '5');
INSERT INTO `attributes` VALUES ('5', 'Дата премьеры РФ', '4');
INSERT INTO `attributes` VALUES ('6', 'Дата премьеры МИР', '4');
INSERT INTO `attributes` VALUES ('7', 'Дата начала продажи билетов', '4');
INSERT INTO `attributes` VALUES ('8', 'Дата запуска рекламы', '4');
INSERT INTO `attributes` VALUES ('9', 'Базовая цена', '3');
INSERT INTO `attributes` VALUES ('10', 'Минимальный возраст', '2');

-- ----------------------------
-- Table structure for clients
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of clients
-- ----------------------------
INSERT INTO `clients` VALUES ('1', 'Иванов Акакий');
INSERT INTO `clients` VALUES ('2', 'Петров Леонардо');
INSERT INTO `clients` VALUES ('3', 'Ди Каперс');

-- ----------------------------
-- Table structure for moovies
-- ----------------------------
DROP TABLE IF EXISTS `moovies`;
CREATE TABLE `moovies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moovies
-- ----------------------------
INSERT INTO `moovies` VALUES ('1', 'Джек потрошитель');
INSERT INTO `moovies` VALUES ('2', 'Челюсти');
INSERT INTO `moovies` VALUES ('3', 'Антология курсов OTUS (18+)');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `promocode` varchar(255) DEFAULT NULL,
  `discount` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ouniq` (`schedule_id`,`client_id`,`seat_id`) USING BTREE,
  KEY `client` (`client_id`),
  KEY `seat` (`seat_id`),
  CONSTRAINT `client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `seat` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', '6', '3', '36', '1500.00', 'new_client22', '25');
INSERT INTO `orders` VALUES ('2', '2', '1', '16', '300.00', null, null);
INSERT INTO `orders` VALUES ('3', '6', '1', '37', '1500.00', 'new_client22', '25');
INSERT INTO `orders` VALUES ('4', '6', '2', '38', '1999.00', null, null);
INSERT INTO `orders` VALUES ('6', '2', '2', '17', '300.00', null, null);
INSERT INTO `orders` VALUES ('7', '2', '3', '18', '30.00', 'my_best_friend', '90');

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES ('1', 'Красный');
INSERT INTO `rooms` VALUES ('2', 'Желтый');
INSERT INTO `rooms` VALUES ('3', 'Зеленый');

-- ----------------------------
-- Table structure for schedule
-- ----------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planned_time` datetime DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `moovie_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq` (`planned_time`,`room_id`),
  KEY `room` (`room_id`),
  KEY `moovie` (`moovie_id`),
  CONSTRAINT `moovie` FOREIGN KEY (`moovie_id`) REFERENCES `moovies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of schedule
-- ----------------------------
INSERT INTO `schedule` VALUES ('1', '2023-09-25 21:00:00', '1', '1', '200.00');
INSERT INTO `schedule` VALUES ('2', '2023-09-25 21:00:00', '2', '2', '300.00');
INSERT INTO `schedule` VALUES ('3', '2023-09-25 23:00:00', '3', '3', '999.00');
INSERT INTO `schedule` VALUES ('4', '2023-09-24 21:00:00', '1', '1', '300.00');
INSERT INTO `schedule` VALUES ('5', '2023-09-24 21:00:00', '2', '2', '400.00');
INSERT INTO `schedule` VALUES ('6', '2023-09-24 23:00:00', '3', '3', '1999.00');

-- ----------------------------
-- Table structure for seats
-- ----------------------------
DROP TABLE IF EXISTS `seats`;
CREATE TABLE `seats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) DEFAULT NULL,
  `row` tinyint(4) DEFAULT NULL,
  `seat` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sroom` (`room_id`),
  CONSTRAINT `sroom` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seats
-- ----------------------------
INSERT INTO `seats` VALUES ('1', '1', '1', '1');
INSERT INTO `seats` VALUES ('2', '1', '1', '2');
INSERT INTO `seats` VALUES ('3', '1', '1', '3');
INSERT INTO `seats` VALUES ('4', '1', '1', '4');
INSERT INTO `seats` VALUES ('5', '1', '1', '5');
INSERT INTO `seats` VALUES ('6', '1', '2', '1');
INSERT INTO `seats` VALUES ('7', '1', '2', '2');
INSERT INTO `seats` VALUES ('8', '1', '2', '3');
INSERT INTO `seats` VALUES ('9', '1', '2', '4');
INSERT INTO `seats` VALUES ('10', '1', '2', '5');
INSERT INTO `seats` VALUES ('11', '1', '3', '1');
INSERT INTO `seats` VALUES ('12', '1', '3', '2');
INSERT INTO `seats` VALUES ('13', '1', '3', '3');
INSERT INTO `seats` VALUES ('14', '1', '3', '4');
INSERT INTO `seats` VALUES ('15', '1', '3', '5');
INSERT INTO `seats` VALUES ('16', '2', '1', '1');
INSERT INTO `seats` VALUES ('17', '2', '1', '2');
INSERT INTO `seats` VALUES ('18', '2', '1', '3');
INSERT INTO `seats` VALUES ('19', '2', '1', '4');
INSERT INTO `seats` VALUES ('20', '2', '1', '5');
INSERT INTO `seats` VALUES ('21', '2', '2', '1');
INSERT INTO `seats` VALUES ('22', '2', '2', '2');
INSERT INTO `seats` VALUES ('23', '2', '2', '3');
INSERT INTO `seats` VALUES ('24', '2', '2', '4');
INSERT INTO `seats` VALUES ('25', '2', '2', '5');
INSERT INTO `seats` VALUES ('26', '2', '3', '1');
INSERT INTO `seats` VALUES ('27', '2', '3', '2');
INSERT INTO `seats` VALUES ('28', '2', '3', '3');
INSERT INTO `seats` VALUES ('29', '2', '3', '4');
INSERT INTO `seats` VALUES ('30', '2', '3', '5');
INSERT INTO `seats` VALUES ('31', '3', '1', '1');
INSERT INTO `seats` VALUES ('32', '3', '1', '2');
INSERT INTO `seats` VALUES ('33', '3', '1', '3');
INSERT INTO `seats` VALUES ('34', '3', '1', '4');
INSERT INTO `seats` VALUES ('35', '3', '1', '5');
INSERT INTO `seats` VALUES ('36', '3', '2', '1');
INSERT INTO `seats` VALUES ('37', '3', '2', '2');
INSERT INTO `seats` VALUES ('38', '3', '2', '3');
INSERT INTO `seats` VALUES ('39', '3', '2', '4');
INSERT INTO `seats` VALUES ('40', '3', '2', '5');
INSERT INTO `seats` VALUES ('41', '3', '3', '1');
INSERT INTO `seats` VALUES ('42', '3', '3', '2');
INSERT INTO `seats` VALUES ('43', '3', '3', '3');
INSERT INTO `seats` VALUES ('44', '3', '3', '4');
INSERT INTO `seats` VALUES ('45', '3', '3', '5');

-- ----------------------------
-- View structure for attributes_values_view
-- ----------------------------
DROP VIEW IF EXISTS `attributes_values_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`cabinet`@`localhost` SQL SECURITY DEFINER VIEW `attributes_values_view` AS select `m`.`id` AS `moovie_id`,`m`.`title` AS `moovie_title`,`a`.`name` AS `attribute_name`,`at`.`name` AS `attribute_type`,(case when (`at`.`field_type` = 'text') then `av`.`text` when (`at`.`field_type` = 'bool') then (case when (`av`.`bool` = 1) then 'есть' when (`av`.`bool` = 0) then 'нет' end) when (`at`.`field_type` = 'date') then `av`.`date` when (`at`.`field_type` = 'decimal') then `av`.`decimal` when (`at`.`field_type` = 'int') then `av`.`int` end) AS `value` from (((`attribute_values` `av` left join `moovies` `m` on((`av`.`moovie_id` = `m`.`id`))) left join `attributes` `a` on((`av`.`attribute_id` = `a`.`id`))) left join `attribute_types` `at` on((`at`.`id` = `a`.`type_id`))) ;

-- ----------------------------
-- View structure for service_dates
-- ----------------------------
DROP VIEW IF EXISTS `service_dates`;
CREATE ALGORITHM=UNDEFINED DEFINER=`cabinet`@`localhost` SQL SECURITY DEFINER VIEW `service_dates` AS select `m`.`id` AS `moovie_id`,`m`.`title` AS `moovie_title`,`a`.`name` AS `attribute_name`,(case when (`at`.`field_type` = 'text') then `av`.`text` when (`at`.`field_type` = 'bool') then (case when (`av`.`bool` = 1) then 'есть' when (`av`.`bool` = 0) then 'нет' end) when (`at`.`field_type` = 'date') then `av`.`date` end) AS `value` from (((`attribute_values` `av` left join `moovies` `m` on((`av`.`moovie_id` = `m`.`id`))) left join `attributes` `a` on((`av`.`attribute_id` = `a`.`id`))) left join `attribute_types` `at` on((`at`.`id` = `a`.`type_id`))) where (`a`.`id` in (7,8)) ;

-- ----------------------------
-- View structure for tasks_for_20_days
-- ----------------------------
DROP VIEW IF EXISTS `tasks_for_20_days`;
CREATE ALGORITHM=UNDEFINED DEFINER=`cabinet`@`localhost` SQL SECURITY DEFINER VIEW `tasks_for_20_days` AS select `m`.`id` AS `moovie_id`,`m`.`title` AS `moovie_title`,`a`.`name` AS `attribute_name`,`at`.`name` AS `attribute_type`,(case when (`at`.`field_type` = 'text') then `av`.`text` when (`at`.`field_type` = 'bool') then (case when (`av`.`bool` = 1) then 'есть' when (`av`.`bool` = 0) then 'нет' end) when (`at`.`field_type` = 'date') then `av`.`date` end) AS `value` from (((`attribute_values` `av` left join `moovies` `m` on((`av`.`moovie_id` = `m`.`id`))) left join `attributes` `a` on((`av`.`attribute_id` = `a`.`id`))) left join `attribute_types` `at` on((`at`.`id` = `a`.`type_id`))) where ((`a`.`id` in (7,8)) and (`av`.`date` = (curdate() + interval 20 day))) ;

-- ----------------------------
-- View structure for tasks_for_today
-- ----------------------------
DROP VIEW IF EXISTS `tasks_for_today`;
CREATE ALGORITHM=UNDEFINED DEFINER=`cabinet`@`localhost` SQL SECURITY DEFINER VIEW `tasks_for_today` AS select `m`.`id` AS `moovie_id`,`m`.`title` AS `moovie_title`,`a`.`name` AS `attribute_name`,`at`.`name` AS `attribute_type`,(case when (`at`.`field_type` = 'text') then `av`.`text` when (`at`.`field_type` = 'bool') then (case when (`av`.`bool` = 1) then 'есть' when (`av`.`bool` = 0) then 'нет' end) when (`at`.`field_type` = 'date') then `av`.`date` end) AS `value` from (((`attribute_values` `av` left join `moovies` `m` on((`av`.`moovie_id` = `m`.`id`))) left join `attributes` `a` on((`av`.`attribute_id` = `a`.`id`))) left join `attribute_types` `at` on((`at`.`id` = `a`.`type_id`))) where ((`a`.`id` in (7,8)) and (`av`.`date` = curdate())) ;
