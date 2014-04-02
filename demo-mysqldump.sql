-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: demo
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `thread_id` int(10) unsigned NOT NULL,
  `post_index` int(11) NOT NULL,
  `content` varchar(4095) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9474526CE29040191768EBEE` (`thread_id`,`post_index`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526CE2904019` (`thread_id`),
  CONSTRAINT `FK_9474526CE2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`),
  CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,2,1,1,'content12346',1396447145,1396447145,1),(2,2,1,2,'re1111111111',1396447171,1396447171,0),(3,2,2,1,'2222222222222222',1396447223,1396447223,0),(4,1,1,3,'TTTTTTTTTTTTTTTTTTTTTTTTTT',1396447329,1396447329,0),(5,1,3,1,'22222222222222222',1396447345,1396447345,0),(6,1,4,1,'44444444444444444',1396447403,1396447403,1),(7,3,5,1,'444444444444444444444444444',1396448632,1396448632,0),(8,3,6,1,'55555555555555555',1396448641,1396448641,0),(9,3,7,1,'66666666666666666666666666666666',1396448646,1396448646,0),(10,3,8,1,'66666666666666666',1396448654,1396448654,0),(11,3,9,1,'6666666666666666666',1396448659,1396448659,0),(12,3,10,1,'66666666666666666666666',1396448690,1396448690,0),(13,3,11,1,'5555555555555555555555',1396449297,1396449297,0),(14,3,12,1,'2222222222222222',1396449304,1396449304,0),(15,3,13,1,'5555555555555555555555',1396449310,1396449310,0),(16,3,14,1,'33333333333333',1396449317,1396449317,0),(17,3,15,1,'55555555555555555555',1396449322,1396449322,0),(18,3,16,1,'6666666666666666666666666',1396449330,1396449330,0),(19,3,17,1,'22222222222222222222222222',1396449335,1396449335,0),(20,3,18,1,'2222222222222222222222',1396449340,1396449340,0),(21,3,19,1,'5555555555555555555555555555',1396449346,1396449346,0),(22,3,20,1,'222222222222222222222',1396449354,1396449354,1);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_track`
--

DROP TABLE IF EXISTS `comment_track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment_track` (
  `user_id` int(10) unsigned NOT NULL,
  `comment_id` int(10) unsigned NOT NULL,
  `thread_id` int(10) unsigned NOT NULL,
  `has_voted` tinyint(1) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`comment_id`),
  KEY `IDX_7F796057A76ED395` (`user_id`),
  KEY `IDX_7F796057F8697D13` (`comment_id`),
  KEY `IDX_7F796057E2904019` (`thread_id`),
  CONSTRAINT `FK_7F796057E2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`),
  CONSTRAINT `FK_7F796057A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7F796057F8697D13` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_track`
--

LOCK TABLES `comment_track` WRITE;
/*!40000 ALTER TABLE `comment_track` DISABLE KEYS */;
INSERT INTO `comment_track` VALUES (1,6,4,1,1396448513),(2,1,1,1,1396447166),(3,22,20,1,1396463336);
/*!40000 ALTER TABLE `comment_track` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `to_user_id` int(10) unsigned NOT NULL,
  `from_user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `has_read` tinyint(1) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `type` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307F29F6EE60` (`to_user_id`),
  KEY `IDX_B6BD307F2130303A` (`from_user_id`),
  CONSTRAINT `FK_B6BD307F2130303A` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307F29F6EE60` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (1,1,2,'111111111111','1111111111111111',1,1396447202,0),(2,1,2,'2222222222222222222','22222222222222',1,1396447819,0),(3,2,1,'12312312312','3123213123',1,1396448101,0),(4,1,3,'44444444','44444444444444444',1,1396448200,0);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enable_indexing` tinyint(1) NOT NULL,
  `num_threads` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628727ACA70` (`parent_id`),
  KEY `IDX_C24262821746551` (`enable_indexing`),
  CONSTRAINT `FK_C242628727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,NULL,'module-1','',1,0),(2,1,'submodule-1-1','description for submodule-1-1',0,19),(3,1,'submodule-1-2','description for submodule-1-2',0,0),(4,NULL,'module-2','',1,0),(5,4,'submodule-2-1','description for submodule-2-1',0,1),(6,4,'submodule-2-2','description for submodule-2-2',0,0);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57698A6A57698A6A` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'admin','ROLE_ADMIN'),(2,'user','ROLE_USER');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `last_comment_id` int(10) unsigned DEFAULT NULL,
  `first_comment_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(4095) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(5) unsigned NOT NULL,
  `type` smallint(5) unsigned NOT NULL,
  `num_replies` int(10) unsigned NOT NULL,
  `num_views` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_31204C83111D17F9` (`last_comment_id`),
  UNIQUE KEY `UNIQ_31204C8369F11C14` (`first_comment_id`),
  KEY `IDX_31204C83A76ED395` (`user_id`),
  KEY `IDX_31204C83AFC2B591` (`module_id`),
  KEY `IDX_31204C83AFC2B59143625D9F` (`module_id`,`updated_at`),
  CONSTRAINT `FK_31204C8369F11C14` FOREIGN KEY (`first_comment_id`) REFERENCES `comment` (`id`),
  CONSTRAINT `FK_31204C83111D17F9` FOREIGN KEY (`last_comment_id`) REFERENCES `comment` (`id`),
  CONSTRAINT `FK_31204C83A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_31204C83AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread`
--

LOCK TABLES `thread` WRITE;
/*!40000 ALTER TABLE `thread` DISABLE KEYS */;
INSERT INTO `thread` VALUES (1,2,2,4,1,'title13333','content12346',0,0,2,3,1396447145,1396447329),(2,2,5,3,3,'222222','2222222222222222',0,0,0,0,1396447223,1396447223),(3,1,2,5,5,'2222','22222222222222222',0,0,0,2,1396447345,1396447345),(4,1,2,6,6,'333333333333333','44444444444444444',0,0,0,2,1396447403,1396447403),(5,3,2,7,7,'44444444444444444444444444444444444','444444444444444444444444444',0,0,0,1,1396448632,1396448632),(6,3,2,8,8,'55555555555555','55555555555555555',0,0,0,1,1396448641,1396448641),(7,3,2,9,9,'66666666666666','66666666666666666666666666666666',0,0,0,1,1396448646,1396448646),(8,3,2,10,10,'6666666666666','66666666666666666',0,0,0,1,1396448654,1396448654),(9,3,2,11,11,'666666666','6666666666666666666',0,0,0,0,1396448659,1396448659),(10,3,2,12,12,'6666666644444','66666666666666666666666',0,0,0,2,1396448690,1396448690),(11,3,2,13,13,'5555555555555','5555555555555555555555',0,0,0,0,1396449297,1396449297),(12,3,2,14,14,'222222222','2222222222222222',0,0,0,0,1396449304,1396449304),(13,3,2,15,15,'555555555555555','5555555555555555555555',0,0,0,0,1396449310,1396449310),(14,3,2,16,16,'33333333333333','33333333333333',0,0,0,0,1396449317,1396449317),(15,3,2,17,17,'55555555555555','55555555555555555555',0,0,0,0,1396449322,1396449322),(16,3,2,18,18,'666666666666666','6666666666666666666666666',0,0,0,1,1396449330,1396449330),(17,3,2,19,19,'22222222222222222','22222222222222222222222222',0,0,0,0,1396449335,1396449335),(18,3,2,20,20,'22222222222222','2222222222222222222222',0,0,0,0,1396449340,1396449340),(19,3,2,21,21,'5555555555555555','5555555555555555555555555555',0,0,0,0,1396449346,1396449346),(20,3,2,22,22,'22222222222222222222','222222222222222222222',0,0,0,1,1396449354,1396449354);
/*!40000 ALTER TABLE `thread` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thread_track`
--

DROP TABLE IF EXISTS `thread_track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread_track` (
  `user_id` int(10) unsigned NOT NULL,
  `thread_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `has_viewed` tinyint(1) NOT NULL,
  `has_favored` tinyint(1) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`thread_id`),
  KEY `IDX_DC67E79DA76ED395` (`user_id`),
  KEY `IDX_DC67E79DE2904019` (`thread_id`),
  KEY `IDX_DC67E79DAFC2B591` (`module_id`),
  CONSTRAINT `FK_DC67E79DAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`),
  CONSTRAINT `FK_DC67E79DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_DC67E79DE2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread_track`
--

LOCK TABLES `thread_track` WRITE;
/*!40000 ALTER TABLE `thread_track` DISABLE KEYS */;
INSERT INTO `thread_track` VALUES (1,1,2,1,0,1396447329),(1,3,2,1,0,1396447348),(1,4,2,1,0,1396448511),(1,7,2,1,0,1396449235),(1,10,2,1,0,1396449231),(2,1,2,1,0,1396447156),(3,1,2,1,0,1396449077),(3,3,2,1,0,1396448584),(3,4,2,1,0,1396448562),(3,5,2,1,0,1396448837),(3,6,2,1,0,1396449087),(3,8,2,1,0,1396449246),(3,10,2,1,0,1396449133),(3,16,2,1,0,1396463166),(3,20,2,1,0,1396449370);
/*!40000 ALTER TABLE `thread_track` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `unread_msg` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'testuser','$2y$13$x2oKzvQNA1T9kWm7X7TJROB21gSLgZEB8lbQvJfmSKHL34udwiTni','test@email.com',1,0),(2,'admin1','$2y$13$wQpiTHQOhrs1ZsM5BfXQMOmQaNr/Q9F4iiCtbnhczZEcRcYFZ0CTi','admin1@qq.com',1,0),(3,'myuser','$2y$13$Z5sEFbJJvz77sw0YjFnk7OmsLr.Yj39qIXtiDnhwg2K0UJyGLhhnG','myuser@em.com',1,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`),
  CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,2),(2,2),(3,2);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-02 11:58:57
