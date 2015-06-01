-- MySQL dump 10.13  Distrib 5.5.19, for Linux (x86_64)
--
-- Host: 166.62.8.7    Database: magnusfinanceapp
-- ------------------------------------------------------
-- Server version	5.5.43-37.2-log

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
-- Table structure for table `fn_agent`
--

DROP TABLE IF EXISTS `fn_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_agent` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `commission` varchar(5) DEFAULT NULL,
  `occupation` varchar(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_agent`
--

LOCK TABLES `fn_agent` WRITE;
/*!40000 ALTER TABLE `fn_agent` DISABLE KEYS */;
INSERT INTO `fn_agent` VALUES (1,'Aliya','','','20','Sales Agent'),(2,'Ayu Astriani','','','15','Sales Agent'),(5,'Ayu Merta','','','15','Sales Agent'),(6,'Dewa','','',NULL,'Listing Agent'),(7,'Jefrie','','',NULL,'Listing Agent'),(8,'Windra','','',NULL,'Listing Agent'),(9,'Budi','','',NULL,'Listing Agent'),(10,'Jefrie','','','10','Sales Agent'),(11,'Theo','','','','Sales Agent');
/*!40000 ALTER TABLE `fn_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_agent_commission`
--

DROP TABLE IF EXISTS `fn_agent_commission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_agent_commission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deal_id` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `pay_date` date NOT NULL,
  `payment_via` varchar(10) NOT NULL,
  `agent` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_agent_commission`
--

LOCK TABLES `fn_agent_commission` WRITE;
/*!40000 ALTER TABLE `fn_agent_commission` DISABLE KEYS */;
INSERT INTO `fn_agent_commission` VALUES (1,8,3480000,'IDR','2015-05-22','Cash',1),(2,7,0,'','2015-05-22','Cash',2),(3,7,0,'','2015-05-22','Cash',6),(4,6,0,'','2015-05-22','Cash',7),(5,5,0,'','2015-05-22','Cash',6),(6,5,0,'','2015-05-22','Cash',1),(7,9,0,'','2015-05-22','Cash',11);
/*!40000 ALTER TABLE `fn_agent_commission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_area`
--

DROP TABLE IF EXISTS `fn_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_area` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `prefix` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_area`
--

LOCK TABLES `fn_area` WRITE;
/*!40000 ALTER TABLE `fn_area` DISABLE KEYS */;
INSERT INTO `fn_area` VALUES (1,'Canggu','CA'),(3,'Seminyak','SE'),(4,'Kerobokan','KE'),(5,'North Seminyak','BA'),(6,'Umalas','UM'),(7,'Sanur','SA'),(8,'Ubud','UB'),(9,'Kuta','KU'),(10,'Legian','LE'),(11,'Jimbaran','JI'),(12,'Nusa Dua','NU'),(13,'Uluwatu','UL'),(14,'Denpasar','DE'),(15,'Tabanan','TA');
/*!40000 ALTER TABLE `fn_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_client`
--

DROP TABLE IF EXISTS `fn_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_client` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_client`
--

LOCK TABLES `fn_client` WRITE;
/*!40000 ALTER TABLE `fn_client` DISABLE KEYS */;
INSERT INTO `fn_client` VALUES (1,'John Ludlow','','blackey@live.com.au'),(2,'Max Finke & Rebecca McCarthy','',''),(3,'Andrew Ford','','andrew@mtccoffee.com'),(4,'Jay Wade','','sorinrock@yahoo.com'),(5,'Ross William Crawshaw Wilson','','ratley1@hotmail.com'),(6,'Christiana Natalis Bulu','',''),(7,'Fedy Remon Wahba','',''),(8,'Sylvie Nguyen Ngoc','',''),(9,'Jude Damian Baker','',''),(10,'Philip Andrew Heald / B. Wullur','',''),(11,'I Kadek Ariawan','','ariavan@mail.ru'),(12,'Kelly Marciano','','kelly@naturallightcandleco.com'),(13,'Rene Mayer','','Rene.Mayer@fairmont.com'),(14,'Martinez Quiles Pedro','','louliakiles@gmail.com');
/*!40000 ALTER TABLE `fn_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_deals`
--

DROP TABLE IF EXISTS `fn_deals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_deals` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `villa_code` varchar(10) NOT NULL,
  `client` mediumint(9) NOT NULL,
  `owner` mediumint(9) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `deal_date` date NOT NULL,
  `deal_price` int(12) NOT NULL,
  `deal_price_currency` varchar(3) NOT NULL,
  `consult_fee` int(11) NOT NULL,
  `consult_fee_currency` varchar(3) NOT NULL,
  `area` mediumint(9) NOT NULL,
  `payment_via` varchar(20) NOT NULL,
  `deposit` int(11) NOT NULL,
  `deposit_currency` varchar(5) NOT NULL,
  `deposit_in` date NOT NULL,
  `contract_number` varchar(100) NOT NULL,
  `sales_agent` mediumint(9) NOT NULL,
  `listing_agent` mediumint(9) NOT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` date NOT NULL,
  `sales_commission_paid` tinyint(1) NOT NULL DEFAULT '0',
  `listing_commission_paid` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_deals`
--

LOCK TABLES `fn_deals` WRITE;
/*!40000 ALTER TABLE `fn_deals` DISABLE KEYS */;
INSERT INTO `fn_deals` VALUES (5,'SA0140Y',5,3,'2015-03-02','2016-03-01','2015-03-02',135000000,'IDR',12500000,'IDR',7,'',0,'','2015-05-21','BLTR/March/2015/SA0140Y',1,6,1,'0000-00-00',1,1,''),(6,'UM0135Y',6,0,'2015-03-07','2015-03-06','2015-03-04',110000000,'IDR',10000000,'IDR',0,'',0,'IDR','2015-05-21','BLTR/March/2015/UM0135Y',0,7,1,'2015-05-21',0,1,''),(7,'UB0028Y',7,4,'2015-03-04','2015-03-03','2015-03-04',9000000,'IDR',900000,'IDR',0,'',0,'','2015-05-21','BLTR/March/2015/UB0082Y',2,6,1,'0000-00-00',1,1,''),(8,'SE0143Y',8,5,'2015-03-05','2016-03-05','2015-03-05',180000000,'IDR',17400000,'IDR',0,'',0,'','2015-05-22','BLTR/March/2015/SE0143Y',1,0,1,'2015-05-22',1,0,''),(9,'CA0321Y',9,6,'2015-04-12','2015-06-20','2015-03-17',11250,'USD',1125,'USD',0,'',0,'','2015-05-22','BLTR/March/2015/CA0321Y',11,0,1,'0000-00-00',1,0,''),(10,'NU0005Y',10,7,'2015-04-24','2016-04-24','2015-03-07',110000000,'IDR',11000000,'IDR',12,'',0,'','2015-05-22','BLTR/March/2015/NU0005Y',1,6,1,'0000-00-00',0,0,''),(11,'SA0207Y',11,8,'2015-07-01','2016-07-01','2015-05-27',165000000,'IDR',15000000,'IDR',7,'',10000000,'IDR','2015-05-04','BLTR/May/2015/SA0207Y/02',2,9,0,'2015-05-27',0,0,''),(12,'SA0155Y',12,9,'2015-06-01','2017-06-01','2015-05-27',300000000,'IDR',3000000,'IDR',7,'',0,'','2015-05-27','',1,0,0,'2015-05-27',0,0,''),(13,'SA0212Y',13,10,'2015-05-29','2016-05-28','2015-05-24',18000000,'IDR',18000000,'IDR',7,'',0,'IDR','2015-05-27','BLTR/May/2015/SA0212Y',2,9,0,'0000-00-00',0,0,'');
/*!40000 ALTER TABLE `fn_deals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_menu`
--

DROP TABLE IF EXISTS `fn_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_menu` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `text` varchar(50) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `id_tag` varchar(50) NOT NULL,
  `class_tag` varchar(50) NOT NULL,
  `parent` smallint(6) NOT NULL,
  `sort` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_menu`
--

LOCK TABLES `fn_menu` WRITE;
/*!40000 ALTER TABLE `fn_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `fn_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_owner`
--

DROP TABLE IF EXISTS `fn_owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_owner` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_owner`
--

LOCK TABLES `fn_owner` WRITE;
/*!40000 ALTER TABLE `fn_owner` DISABLE KEYS */;
INSERT INTO `fn_owner` VALUES (1,'Nyoman Alit Mahakerta','',''),(2,'Ida Ayu Ketut Linggasari','',''),(3,'I.B. Nyoman Meneh','081990879889',''),(4,'I Wayan Suartana','',''),(5,'I Wayan Sumarta','',''),(6,'John Stephen Locker Potter','',''),(7,'Dewa Putu Rai Widana','',''),(8,'I Made Artha Adnyana','',''),(9,'I Wayan Suka','',''),(10,'Suardi','',''),(11,'Julien Schneider','','schneiderjulien@hotmail.com');
/*!40000 ALTER TABLE `fn_owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_payment_plan`
--

DROP TABLE IF EXISTS `fn_payment_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_payment_plan` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(15) NOT NULL,
  `deal_id` mediumint(9) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `ref_number` char(2) NOT NULL,
  `pay_date` date NOT NULL,
  `payment_via` varchar(20) NOT NULL,
  `payment_currency` varchar(5) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_payment_plan`
--

LOCK TABLES `fn_payment_plan` WRITE;
/*!40000 ALTER TABLE `fn_payment_plan` DISABLE KEYS */;
INSERT INTO `fn_payment_plan` VALUES (33,15000000,'IDR','2015-03-02','deal',5,0,'01','0000-00-00','','',0),(34,13500000,'IDR','2015-03-05','fee',5,1,'01','2015-03-05','Cash','IDR',13500000),(35,12000000,'IDR','2015-03-05','deal',5,0,'02','0000-00-00','','',0),(36,40000000,'IDR','2015-03-03','deal',6,0,'01','0000-00-00','','',0),(37,10000000,'IDR','2015-03-11','fee',6,1,'01','2015-03-11','Cash','IDR',10000000),(38,70000000,'IDR','2015-03-10','deal',6,0,'02','0000-00-00','','',0),(41,9000000,'IDR','2015-03-04','deal',7,0,'01','0000-00-00','','',0),(42,900000,'IDR','2015-03-05','fee',7,1,'01','2015-03-11','Cash','IDR',900000),(43,180000000,'IDR','2015-03-05','deal',8,0,'01','0000-00-00','','',0),(44,17400000,'IDR','2015-03-05','fee',8,1,'01','2015-03-06','Cash','IDR',17400001),(48,2000,'USD','2015-03-17','deal',9,0,'01','0000-00-00','','',0),(49,1125,'USD','2015-03-17','fee',9,1,'01','2015-05-27','Cash','',0),(50,9250,'USD','2015-04-01','deal',9,0,'02','0000-00-00','','',0),(54,11000000,'IDR','2015-03-05','deal',10,0,'01','0000-00-00','','',0),(55,11000000,'IDR','2015-04-24','fee',10,1,'01','2015-05-27','Cash','',0),(56,99000000,'IDR','2015-04-24','deal',10,0,'02','0000-00-00','','',0),(57,155000000,'IDR','2015-07-01','deal',11,0,'01','0000-00-00','','',0),(58,15000000,'IDR','2015-07-03','fee',11,0,'01','0000-00-00','','',0),(59,15000000,'IDR','2015-05-10','deal',12,0,'01','0000-00-00','','',0),(60,10000000,'IDR','2015-06-01','fee',12,0,'01','0000-00-00','','',0),(61,60000000,'IDR','2015-06-01','deal',12,0,'02','0000-00-00','','',0),(62,5000000,'IDR','2015-12-03','fee',12,0,'02','0000-00-00','','',0),(63,75000000,'IDR','2015-12-01','deal',12,0,'03','0000-00-00','','',0),(64,7500000,'IDR','2016-07-05','fee',12,0,'03','0000-00-00','','',0),(65,75000000,'IDR','2016-12-01','deal',12,0,'04','0000-00-00','','',0),(66,7500000,'IDR','2016-12-05','fee',12,0,'04','0000-00-00','','',0),(71,5000000,'IDR','2015-05-24','deal',13,0,'01','0000-00-00','','',0),(72,18000000,'IDR','2015-06-05','fee',13,0,'01','0000-00-00','','',0),(73,45000000,'IDR','2015-05-25','deal',13,0,'02','0000-00-00','','',0),(74,130000000,'IDR','2015-06-01','deal',13,0,'03','0000-00-00','','',0);
/*!40000 ALTER TABLE `fn_payment_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_user_role`
--

DROP TABLE IF EXISTS `fn_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_user_role` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL,
  `object` smallint(6) NOT NULL,
  `capabilities` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_user_role`
--

LOCK TABLES `fn_user_role` WRITE;
/*!40000 ALTER TABLE `fn_user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `fn_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fn_users`
--

DROP TABLE IF EXISTS `fn_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fn_users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(35) NOT NULL,
  `email` varchar(50) NOT NULL,
  `display_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fn_users`
--

LOCK TABLES `fn_users` WRITE;
/*!40000 ALTER TABLE `fn_users` DISABLE KEYS */;
INSERT INTO `fn_users` VALUES (1,'admin','5f4dcc3b5aa765d61d8327deb882cf99','blaukblonk04@gmail.com','Admin');
/*!40000 ALTER TABLE `fn_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-01  1:13:41
