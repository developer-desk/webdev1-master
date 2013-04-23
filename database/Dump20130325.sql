CREATE DATABASE  IF NOT EXISTS `devsite` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `devsite`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: devsite
-- ------------------------------------------------------
-- Server version	5.1.41-community

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
-- Table structure for table `shop_email_sent`
--

DROP TABLE IF EXISTS `shop_email_sent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_email_sent` (
  `SHOP_EMAIL_SENT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CLIENT_ID` int(10) unsigned DEFAULT NULL,
  `EMAIL_TYPE_UID` varchar(45) DEFAULT NULL,
  `ORDER_NUMBER` varchar(128) DEFAULT NULL,
  `CB` int(10) unsigned DEFAULT NULL,
  `DC` datetime DEFAULT NULL,
  `MB` int(10) unsigned DEFAULT NULL,
  `DM` datetime DEFAULT NULL,
  `SHOP_EMAL_SENT_STATUS_ID` int(11) DEFAULT NULL,
  `EMAIL_ADDRESS` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`SHOP_EMAIL_SENT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_email_sent`
--

LOCK TABLES `shop_email_sent` WRITE;
/*!40000 ALTER TABLE `shop_email_sent` DISABLE KEYS */;
INSERT INTO `shop_email_sent` VALUES (82,107,'PASSWORD_RESET_REQUESTED','',1,'2013-03-14 01:31:51',NULL,NULL,1,'afamdient@yahoo.ca'),(83,107,'PASSWORD_RESET_REQUESTED','',1,'2013-03-14 02:33:56',NULL,NULL,1,'afamdient@yahoo.ca'),(84,107,'PASSWORD_RESET_REQUESTED','',1,'2013-03-14 03:54:20',NULL,NULL,1,'afamdient@yahoo.ca');
/*!40000 ALTER TABLE `shop_email_sent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `CLIENT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FULL_NAME` varchar(128) DEFAULT NULL,
  `EMAIL_ADDRESS` varchar(128) NOT NULL,
  `PASSWORD` varchar(128) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `CONTACT_ID` int(10) unsigned DEFAULT NULL,
  `CLIENT_TYPE_ID` int(10) unsigned DEFAULT '1',
  `CB` int(10) unsigned DEFAULT NULL,
  `DC` datetime DEFAULT NULL,
  `MB` int(10) unsigned DEFAULT NULL,
  `DM` datetime DEFAULT NULL,
  `TOKEN` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`CLIENT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (107,'Paul Okeke','afamdient123@yahoo.ca','1234pass',NULL,NULL,199,'2013-03-12 00:00:00',NULL,'2013-03-14 03:55:36','899db0a450c6a034e9ff7df4ee9f24f7'),(108,'Paul Okeke','baba2@baba.com','1qaz2wsx',NULL,NULL,199,'2013-03-12 00:00:00',NULL,NULL,NULL),(109,'Paul Okeke','baba3@baba.com','1qaz2wsx',NULL,NULL,199,'2013-03-12 00:00:00',NULL,NULL,NULL),(110,'Paul Okeke','baba4@baba.com','1qaz2wsx',NULL,NULL,199,'2013-03-12 00:00:00',NULL,NULL,NULL),(111,'test test','afamsss@baba.com','1234pass',NULL,NULL,199,'2013-03-14 00:00:00',NULL,NULL,NULL),(112,'testt test','teet@teet.com','1234pass',NULL,NULL,199,'2013-03-15 00:00:00',NULL,NULL,NULL),(113,'Paul Okeke','afamdient232323@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-25 00:00:00',NULL,NULL,NULL),(114,'Paul Okeke','afamdient1464@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-25 00:00:00',NULL,NULL,NULL),(115,'Paul Okeke','afamdient78486@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-25 00:00:00',NULL,NULL,NULL),(116,'Paul Okeke','afamdient56215@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-25 00:00:00',NULL,NULL,NULL),(117,'Paul Okeke','afamdient@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-25 00:00:00',NULL,NULL,NULL),(118,'Test TESAT','afamdient999@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-26 00:00:00',NULL,NULL,NULL),(119,'test test','afamdient8888@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-26 00:00:00',NULL,NULL,NULL),(120,'test test','afamdient7777@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-26 00:00:00',NULL,NULL,NULL),(121,'test test','afamdient444@yahoo.ca','1q2w3e4r',NULL,NULL,199,'2013-03-26 00:00:00',NULL,NULL,NULL);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_address`
--

DROP TABLE IF EXISTS `client_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_address` (
  `CLIENT_ADDRESS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CLIENT_ADDRESS_TYPE_ID` int(10) unsigned NOT NULL,
  `CLIENT_ID` int(10) unsigned NOT NULL,
  `ATTENTION_TO` varchar(128) NOT NULL,
  `ADDRESS_LINE_1` varchar(256) NOT NULL,
  `ADDRESS_LINE_2` varchar(256) DEFAULT NULL,
  `CITY` varchar(128) NOT NULL,
  `ADDR_PROVINCE_ID` varchar(5) NOT NULL,
  `POSTAL_CODE` varchar(45) NOT NULL,
  `TELEPHONE_NUMBER` varchar(45) DEFAULT NULL,
  `CB` int(10) unsigned DEFAULT '1',
  `DC` datetime DEFAULT NULL,
  `MB` int(10) unsigned DEFAULT '1',
  `DM` datetime DEFAULT NULL,
  PRIMARY KEY (`CLIENT_ADDRESS_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_address`
--

LOCK TABLES `client_address` WRITE;
/*!40000 ALTER TABLE `client_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_security_pwd_reset`
--

DROP TABLE IF EXISTS `shop_security_pwd_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_security_pwd_reset` (
  `SHOP_SECURITY_PWD_RESET_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TOKEN` varchar(128) NOT NULL,
  `EMAIL_ADDRESS` varchar(128) NOT NULL,
  `ACTION_UID` varchar(45) NOT NULL,
  `CB` int(10) unsigned DEFAULT NULL,
  `DC` datetime DEFAULT NULL,
  `MB` int(10) unsigned DEFAULT NULL,
  `DM` datetime DEFAULT NULL,
  `TS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CLIENT_ID` int(10) unsigned DEFAULT NULL,
  `RESET_STATUS` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`SHOP_SECURITY_PWD_RESET_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_security_pwd_reset`
--

LOCK TABLES `shop_security_pwd_reset` WRITE;
/*!40000 ALTER TABLE `shop_security_pwd_reset` DISABLE KEYS */;
INSERT INTO `shop_security_pwd_reset` VALUES (23,'66506c749102d8c5ab99c06cde678b44','afamdient@yahoo.ca','RESETREQUEST',1,'2013-03-13 03:11:05',NULL,NULL,'2013-03-13 03:11:14',NULL,1),(24,'9c61ba42832c76404272562ddfd87db9','afamdient@yahoo.ca','RESETREQUEST',1,'2013-03-14 01:31:51',NULL,NULL,'2013-03-14 01:31:51',NULL,1),(25,'7497b45162c721dbb6e9539e3266ed1c','afamdient@yahoo.ca','RESETREQUEST',1,'2013-03-14 02:33:56',NULL,NULL,'2013-03-14 02:35:17',NULL,2),(26,'899db0a450c6a034e9ff7df4ee9f24f7','afamdient@yahoo.ca','RESETREQUEST',1,'2013-03-14 03:54:19',NULL,NULL,'2013-03-14 03:55:36',NULL,2);
/*!40000 ALTER TABLE `shop_security_pwd_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'devsite'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-26  1:07:17
CREATE DATABASE  IF NOT EXISTS `devsite_wpi` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `devsite_wpi`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: devsite_wpi
-- ------------------------------------------------------
-- Server version	5.1.41-community

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
-- Dumping routines for database 'devsite_wpi'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-26  1:07:17
