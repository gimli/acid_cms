-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: acid_evo_cms
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.13.04.1

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifier',
  `username` varchar(32) NOT NULL DEFAULT '',
  `nick` varchar(32) NOT NULL DEFAULT '',
  `md5_encrypted_password` varchar(40) NOT NULL DEFAULT '',
  `salt` varchar(40) NOT NULL DEFAULT '',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `email` text,
  `joindate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_ip` varchar(30) NOT NULL DEFAULT '0.0.0.0',
  `lock_ip` varchar(30) NOT NULL DEFAULT '0.0.0.0',
  `failed_logins` int(11) unsigned NOT NULL DEFAULT '0',
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastActiveTime` varchar(80) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT '',
  `active` varchar(10) NOT NULL DEFAULT '0',
  `mutetime` bigint(40) unsigned NOT NULL DEFAULT '0',
  `can_receive_mail` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `vip_account` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `points` varchar(80) NOT NULL DEFAULT '0',
  `vip_points` varchar(80) NOT NULL DEFAULT '0',
  `country` varchar(30) NOT NULL DEFAULT '',
  `security` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Account System';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (5,'nickless','Nickless','6b7662428b80ceda58416616697ad1bd','r3m6j3f9m4',5,'admin@isengard.dk','2013-10-07 12:42:56','0.0.0.0','0.0.0.0',0,0,'0000-00-00 00:00:00','','1','1',0,1,1,'10000','10000','DK','3'),(16,'bjoern','','215ac15c73b62f6cf7f46ee5b637cb8d','j3v5r3m3g6',0,'admin@middleearth.dk','2013-10-13 18:18:24','0.0.0.0','0.0.0.0',0,0,'0000-00-00 00:00:00','','','0',0,1,0,'0','0','','0'),(17,'annette','','a0cd8f7c3f96dd53ed9e97488b7ac9a4','w6p2f0o0g4',0,'annette@isengard.dk','2013-10-13 20:16:57','0.0.0.0','0.0.0.0',0,0,'0000-00-00 00:00:00','','1','1',0,1,0,'0','0','','0');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_banned`
--

DROP TABLE IF EXISTS `account_banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_banned` (
  `id` int(11) NOT NULL DEFAULT '0' COMMENT 'Account id',
  `bandate` bigint(40) NOT NULL DEFAULT '0',
  `unbandate` bigint(40) NOT NULL DEFAULT '0',
  `bannedby` varchar(50) NOT NULL,
  `banreason` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`bandate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Ban List';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_banned`
--

LOCK TABLES `account_banned` WRITE;
/*!40000 ALTER TABLE `account_banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_banned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` VALUES (1,'','annette','test','2013-10-14 17:38:04',0),(2,'','annette','buhu','2013-10-14 17:42:19',0),(3,'','annette','damn it','2013-10-14 17:43:17',0),(4,'','annette','my nick','2013-10-14 17:43:25',0),(5,'','annette','ARG','2013-10-14 17:43:31',0),(6,'johndoe','annette','test','2013-10-14 17:45:13',0),(7,'johndoe','annette','bla','2013-10-14 17:45:24',0),(8,'johndoe','annette','fuck','2013-10-14 17:45:30',0),(9,'johndoe','annette','nederen','2013-10-14 17:45:33',0),(10,'johndoe','annette','bla','2013-10-14 17:46:06',0),(11,'johndoe','annette','if','2013-10-14 17:49:35',0),(12,'johndoe','annette','oighÃ¦','2013-10-14 17:49:36',0),(13,'johndoe','annette','oih\'','2013-10-14 17:49:37',0),(14,'johndoe','annette','jheragiew','2013-10-14 17:50:01',0),(15,'johndoe','annette','rgas','2013-10-14 17:50:01',0),(16,'johndoe','annette','dgÃ¥a','2013-10-14 17:50:02',0),(17,'johndoe','annette','dsfg','2013-10-14 17:50:02',0),(18,'johndoe','annette','aÃ¥sdlfgapdkf4ga','2013-10-14 17:50:03',0),(19,'johndoe','annette','sdgpaoms\'dgÃ¥a','2013-10-14 17:50:03',0),(20,'johndoe','annette','dfpakdsinga','2013-10-14 17:50:04',0),(21,'johndoe','annette','sdgÃ¥omas','2013-10-14 17:50:05',0),(22,'johndoe','annette','dg','2013-10-14 17:50:05',0),(23,'johndoe','annette','asdÃ¥gmads','2013-10-14 17:50:05',0),(24,'johndoe','annette','Ã¥gpa4sdg','2013-10-14 17:50:06',0),(25,'johndoe','annette','apsdggm','2013-10-14 17:50:06',0),(26,'johndoe','annette','asÃ¥dpg','2013-10-14 17:50:07',0),(27,'johndoe','annette','asÃ¥odnga','2013-10-14 17:50:07',0),(28,'','annette','test','2013-10-14 17:53:56',0),(29,'','nickless','test','2013-10-14 17:54:03',0),(30,'johndoe','annette','test','2013-10-14 17:54:33',0),(31,'johndoe','annette','la','2013-10-14 17:54:36',0),(32,'johndoe','nickless','test','2013-10-14 17:54:42',0),(33,'','nickless','test','2013-10-14 17:54:54',0),(34,'','annette','test','2013-10-14 17:54:57',0),(35,'johndoe','nickless','dÃ¸ rene','2013-10-14 17:55:49',0),(36,'','annette','kuvk','2013-10-14 17:57:49',0),(37,'','nickless','davs','2013-10-14 17:58:50',0),(38,'','nickless','test','2013-10-14 18:00:06',0),(39,'','nickless','bjÃ¸rn','2013-10-14 18:00:13',0),(40,'johndoe','annette','test','2013-10-14 19:20:19',0);
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_activations`
--

DROP TABLE IF EXISTS `email_activations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_activations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifier',
  `email` varchar(40) NOT NULL DEFAULT '',
  `hash` varchar(40) NOT NULL DEFAULT '',
  `time` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Email activation System';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_activations`
--

LOCK TABLES `email_activations` WRITE;
/*!40000 ALTER TABLE `email_activations` DISABLE KEYS */;
INSERT INTO `email_activations` VALUES (18,'annette@isengard.dk','7666e494ad10ea9f3925dd15248240ad','1381695417');
/*!40000 ALTER TABLE `email_activations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ip_banned`
--

DROP TABLE IF EXISTS `ip_banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_banned` (
  `ip` varchar(32) NOT NULL DEFAULT '0.0.0.0',
  `bandate` bigint(40) NOT NULL,
  `unbandate` bigint(40) NOT NULL,
  `bannedby` varchar(50) NOT NULL DEFAULT '[Console]',
  `banreason` varchar(255) NOT NULL DEFAULT 'no reason',
  PRIMARY KEY (`ip`,`bandate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Banned IPs';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_banned`
--

LOCK TABLES `ip_banned` WRITE;
/*!40000 ALTER TABLE `ip_banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `ip_banned` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-10-19 13:10:53
