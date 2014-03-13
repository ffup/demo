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
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9474526CE29040191768EBEE` (`thread_id`,`post_index`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526CE2904019` (`thread_id`),
  CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_9474526CE2904019` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,1,1,1,'2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext, text.\r\n\r\n\r\n[Solved] No blob type available when making a doctrine 2 + symfony ...\r\n\r\n\r\n\r\nsupport.orm-designer.com/.../solved-blob-type-available-when-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n\r\n2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext, text.\r\n\r\n\r\n[Solved] No blob type available when making a doctrine 2 + symfony ...\r\n\r\n\r\n\r\nsupport.orm-designer.com/.../solved-blob-type-available-when-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n\r\n2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext, text.\r\n\r\n\r\n[Solved] No blob type available when making a doctrine 2 + symfony ...\r\n\r\n\r\n\r\nsupport.orm-designer.com/.../solved-blob-type-available-when-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n\r\n2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext,','2014-03-13 18:11:15','2014-03-13 18:11:15',0),(2,1,1,2,'+你\r\n\r\n\r\n搜索\r\n\r\n\r\n图片\r\n\r\n\r\n地图\r\n\r\n\r\nPlay\r\n\r\n\r\nYouTube\r\n\r\n\r\n新闻\r\n\r\n\r\nGmail\r\n\r\n\r\n\r\n更多\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n登录\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\nGoogle\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n \r\n\r\n \r\n\r\n\r\n  \r\n \r\n \r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n网页\r\n\r\n图片\r\n\r\n视频\r\n\r\n新闻\r\n\r\n地图\r\n更多\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n搜索工具\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n找到约 1,450,000 条结果 （用时 0.23 秒） \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n搜索结果\r\n\r\n\r\n\r\n\r\n8. Types — Doctrine DBAL 2.1.0 documentation\r\n\r\n\r\n\r\ndoctrine-dbal.readthedocs.org/en/latest/reference/types.html‎\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine 2 has a type translation system baked in that supports the conversion from and to PHP ... Types that map string data such as character and binary text.\r\n\r\n\r\nDefining Models — Doctrine 1.2.4 documentation\r\n\r\n\r\n\r\ndocs.doctrine-project.org/.../doctrine1/en/.../defining-models.ht...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nThe text data type is available with two options for the length: one that is explicitly length limited and another of undefined length that should be as large as the ...\r\n\r\n\r\n4. Basic Mapping — Doctrine 2 ORM 2.0.0 documentation\r\n\r\n\r\n\r\ndocs.doctrine-project.org/en/2.0.x/.../basic-mapping.html‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nA Doctrine Mapping Type defines the mapping between a PHP type and an SQL type. ... text: Type that maps an SQL CLOB to a PHP string. object: Type that maps a .... use Doctrine\\DBAL\\Platforms\\AbstractPlatform; /** * My custom datatype.\r\n\r\n\r\nData types in Doctrine 2.1 - Google Groups\r\n\r\n\r\n\r\nhttps://groups.google.com/d/topic/doctrine-user/08tyn5t0cZw‎\r\n\r\n\r\n\r\n翻译此页\r\nData types in Doctrine 2.1, John Elliot, 12/18/11 11:53 PM. Hi there. I\'m using Doctrine 2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext, text.\r\n\r\n\r\n[Solved] No blob type available when making a doctrine 2 + symfony ...\r\n\r\n\r\n\r\nsupport.orm-designer.com/.../solved-blob-type-available-when-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n2013年4月4日 - Doctrine supports the blob type see ... <data-type name=\"text\" unified-name=\"@TEXT\"/> <data-type name=\"object\" ...\r\n\r\n\r\nphp - Using Mysql data type Set with Doctrine 1.2 - Stack Overflow\r\n\r\n\r\n\r\nstackoverflow.com/.../using-mysql-data-type-set-with-doctrine-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n2011年8月11日 - The fields that are type Set in the database are generated as type Text in the base models. Manually changing the fields to \'set\' gives us the ...\r\n\r\n\r\nDoctrine Manual - Chapter 5 Basic schema mapping\r\n\r\n\r\n\r\nwww.growsite.com/contactoven/amfphp/doctrine/manual/?...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nThis value may be set in any character set that the DBMS supports for text fields, and any other valid data for the field\'s data type. In the above example, we have ...\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\ndoctrine text data type的相关搜索\r\n\r\n\r\n\r\ntext数据类型\r\n\r\noracle text数据类型\r\n\r\nmysql text数据类型\r\n\r\nsql text数据类型\r\n\r\ntext数据类型不能选为distinct\r\n\r\n\r\ndatatype text\r\n\r\nmysql datatype text\r\n\r\najax datatype text\r\n\r\njquery datatype text\r\n\r\njquery ajax datatype text\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n1 \r\n\r\n2 \r\n\r\n3 \r\n\r\n4 \r\n\r\n5 \r\n\r\n6 \r\n\r\n7 \r\n\r\n8 \r\n\r\n9 \r\n\r\n10 \r\n\r\n\r\n下一页 \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n帮助发送反馈隐私权和使用条款Google.com\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n  \r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n+你\r\n\r\n\r\n搜索\r\n\r\n\r\n图片\r\n\r\n\r\n地图\r\n\r\n\r\nPlay\r\n\r\n\r\nYouTube\r\n\r\n\r\n新闻\r\n\r\n\r\nGmail\r\n\r\n\r\n\r\n更多\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n登录\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\nGoogle\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n \r\n\r\n \r\n\r\n\r\n  \r\n \r\n \r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n网页\r\n\r\n图片\r\n\r\n视频\r\n\r\n新闻\r\n\r\n地图\r\n更多\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n搜索工具\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n找到约 1,450,000 条结果 （用时 0.23 秒） \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n搜索结果\r\n\r\n\r\n\r\n\r\n8. Types — Doctrine DBAL 2.1.0 documentation\r\n\r\n\r\n\r\ndoctrine-dbal.rea','2014-03-13 18:12:25','2014-03-13 18:12:25',0),(3,1,1,3,'13123123123123123','2014-03-13 18:27:44','2014-03-13 18:27:44',0),(4,1,2,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:20:51','2014-03-13 19:20:51',0),(5,1,3,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:20:54','2014-03-13 19:20:54',0),(6,1,4,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:20:58','2014-03-13 19:20:58',0),(7,1,5,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:21:00','2014-03-13 19:21:00',0),(8,1,6,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:21:02','2014-03-13 19:21:02',0),(9,1,7,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:21:04','2014-03-13 19:21:04',0),(10,1,8,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:21:09','2014-03-13 19:21:09',0),(11,1,9,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:21:12','2014-03-13 19:21:12',0),(12,1,10,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:21:15','2014-03-13 19:21:15',0),(13,1,11,1,'SSSSSDSAAAAAAAAAAAAAAAAA','2014-03-13 19:21:18','2014-03-13 19:21:18',0);
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
  `created_at` datetime NOT NULL,
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
/*!40000 ALTER TABLE `comment_track` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,NULL,'module-1','',1,0),(2,NULL,'module-2','',1,0),(3,1,'submodule-1-1','description1',0,11),(4,1,'submodule-1-2','description2',0,0),(5,2,'submodule-2-1','',0,0),(6,2,'submodule-2-2','',0,0),(7,1,'submodule-1-3','',0,0);
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
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(5) unsigned NOT NULL,
  `type` smallint(5) unsigned NOT NULL,
  `num_replies` int(10) unsigned NOT NULL,
  `num_views` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_31204C83A76ED395` (`user_id`),
  KEY `IDX_31204C83AFC2B591` (`module_id`),
  KEY `updated_at` (`updated_at`),
  CONSTRAINT `FK_31204C83A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_31204C83AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread`
--

LOCK TABLES `thread` WRITE;
/*!40000 ALTER TABLE `thread` DISABLE KEYS */;
INSERT INTO `thread` VALUES (1,1,3,'2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT    Add new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...    symfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎       翻译此页 Add new Data Type in Doctrine 2 in','2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext, text.\r\n\r\n\r\n[Solved] No blob type available when making a doctrine 2 + symfony ...\r\n\r\n\r\n\r\nsupport.orm-designer.com/.../solved-blob-type-available-when-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n\r\n2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext, text.\r\n\r\n\r\n[Solved] No blob type available when making a doctrine 2 + symfony ...\r\n\r\n\r\n\r\nsupport.orm-designer.com/.../solved-blob-type-available-when-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n\r\n2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext, text.\r\n\r\n\r\n[Solved] No blob type available when making a doctrine 2 + symfony ...\r\n\r\n\r\n\r\nsupport.orm-designer.com/.../solved-blob-type-available-when-...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\n\r\n2.1, ... @Column(type=\"string\", nullable=false, columnDefinition=\"TEXT\r\n\r\n\r\n\r\nAdd new Data Type in Doctrine 2 in Symfony 2 | Blog de l\'équipe ...\r\n\r\n\r\n\r\nsymfony2.ylly.fr/add-new-data-type-in-doctrine-2-in-symfony...‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nAdd new Data Type in Doctrine 2 in Symfony 2. Publié le 8 ... Doctrine 2 supports a list of of data types. ... text: Type that maps an SQL CLOB to a PHP string.\r\n\r\n\r\nDatabases and Doctrine (current) - Symfony\r\n\r\n\r\n\r\nsymfony.com › Documentation › The Book‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nYou can also persist data to MongoDB using Doctrine ODM library. ..... For information on the available field types, see the Doctrine Field Types Reference ...\r\n\r\n\r\nChapter 4 - Schema Files (1_2) - Symfony\r\n\r\n\r\n\r\nsymfony.com/legacy/doc/doctrine/1_2/en/04-Schema-Files‎\r\n\r\n\r\n\r\n\r\n\r\n\r\n翻译此页\r\nDoctrine offers several column data types. ... Doctrine data types are standardized and made portable across all DBMS. ... clob(16777215), mediumtext,',0,0,2,1,'2014-03-13 18:11:15','2014-03-13 18:27:44'),(2,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:20:51','2014-03-13 19:20:51'),(3,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:20:54','2014-03-13 19:20:54'),(4,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:20:58','2014-03-13 19:20:58'),(5,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:21:00','2014-03-13 19:21:00'),(6,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:21:02','2014-03-13 19:21:02'),(7,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:21:04','2014-03-13 19:21:04'),(8,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:21:09','2014-03-13 19:21:09'),(9,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:21:12','2014-03-13 19:21:12'),(10,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,0,'2014-03-13 19:21:15','2014-03-13 19:21:15'),(11,1,3,'SDASSSSSSSSSSSSSSSSSSS','SSSSSDSAAAAAAAAAAAAAAAAA',0,0,0,1,'2014-03-13 19:21:18','2014-03-13 19:21:18');
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
  `created_at` datetime NOT NULL,
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
INSERT INTO `thread_track` VALUES (1,1,3,1,'2014-03-13 18:11:59'),(1,11,3,1,'2014-03-13 23:05:16');
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'root','$2y$13$eIHffgyh/g..RnK1Rfo8LOeTZeJoTmuABaVBKY8F7O6KbS8AErD1W','emasdm@email.com',1);
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
INSERT INTO `user_role` VALUES (1,2);
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

-- Dump completed on 2014-03-13  8:16:07
