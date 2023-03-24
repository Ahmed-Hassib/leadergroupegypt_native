/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40101 SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `officers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officers` (
  `off_id` int(11) NOT NULL AUTO_INCREMENT,
  `off_name` varchar(50) NOT NULL,
  PRIMARY KEY (`off_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `officers` WRITE;
SET autocommit=0;
UNLOCK TABLES;
COMMIT;

DROP TABLE IF EXISTS `soldier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soldier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone1` varchar(25) NOT NULL,
  `phone2` varchar(25) NOT NULL,
  `militiry_number` varchar(25) NOT NULL,
  `national_id` varchar(25) NOT NULL,
  `basic_unit` int(11) NOT NULL,
  `current_unit` int(11) NOT NULL,
  `qualification` text NOT NULL,
  `specialization` text NOT NULL,
  `joined_date` date NOT NULL,
  `discharge_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 for single & 1 for marriage',
  `num_child` int(11) NOT NULL,
  `father_job` varchar(100) NOT NULL,
  `mother_job` varchar(100) NOT NULL,
  `religion` int(11) NOT NULL DEFAULT 0 COMMENT '0 for muslim & 1 for cristen ',
  `current_img_name` varchar(100) NOT NULL,
  `img_name` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `temp_name` text NOT NULL,
  `error` int(11) NOT NULL,
  `img_size` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `national_id` (`national_id`),
  UNIQUE KEY `militiry_number` (`militiry_number`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `soldier` WRITE;
SET autocommit=0;
INSERT INTO `soldier` VALUES (1,'كريم','الشرقية','01541324634','','54564641234165','65432146334546',1,1,'دبلوم','1','2021-12-01','2022-12-01',0,0,'لا يعمل','ربة منزل',0,'PNG_20221021_65432146334546.png','air-defence-logo-2.png','image/png','E:\\xampp\\tmp\\php6ED7.tmp',0,342285);
UNLOCK TABLES;
COMMIT;

DROP TABLE IF EXISTS `specialization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialization` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT,
  `spec_name` varchar(50) NOT NULL,
  PRIMARY KEY (`spec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `specialization` WRITE;
SET autocommit=0;
INSERT INTO `specialization` VALUES (1,'حواسب');
UNLOCK TABLES;
COMMIT;

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name_ar` varchar(50) NOT NULL,
  `unit_name_en` varchar(50) NOT NULL,
  `unit_type` int(11) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `units` WRITE;
SET autocommit=0;
INSERT INTO `units` VALUES (1,'قيا فر 8','F-8',0);
UNLOCK TABLES;
COMMIT;

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(250) NOT NULL,
  `privilidge` int(11) NOT NULL,
  `last_login_date` date NOT NULL,
  `last_login_time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
SET autocommit=0;
INSERT INTO `users` VALUES (1,'admin','55f56bb4920b92d569746a3ddac9c0130917e198',1,'2022-10-22','17:08:56'),(2,'user','dd9b52b3cb8c8c5edd6979e1392f71b11183d624',0,'2022-09-17','10:50:18');
UNLOCK TABLES;
COMMIT;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET AUTOCOMMIT=@OLD_AUTOCOMMIT */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

