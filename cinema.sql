/*
Navicat MySQL Data Transfer

Source Server         : dev.filkos.com
Source Server Version : 50505
Source Host           : localhost:3312
Source Database       : cinema

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-09-05 10:14:35
*/

SET FOREIGN_KEY_CHECKS=0;

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
