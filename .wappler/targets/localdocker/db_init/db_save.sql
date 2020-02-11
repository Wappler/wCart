-- MySQL dump 10.13  Distrib 8.0.19, for Linux (x86_64)
--
-- Host: localhost    Database: wcart
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `CategoryID` int NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `CategoryURL` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CategoryMetaID` int DEFAULT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Clothing','clothing',8),(2,'Footwear','footwear',9);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `CompanyID` int NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyAddress` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyCity` varchar(90) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyState` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyZip` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyCountry` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyEmail` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyPhone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyWebsite` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyLogo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CompanyRegistrationDate` date DEFAULT NULL,
  `CompanyBusinessID` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CompanyID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'Anachronistic Fashion House','Deventerstraat 513','Apeldoorn','Gelderland','7233 RE','Nederland','info@anachronistic.com','+31 (0)555 555555','https://anachronistic.com','company_logo.png','2019-04-08','521 63158');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `CountryID` int NOT NULL AUTO_INCREMENT,
  `CountryISO` char(2) NOT NULL,
  `CountryName` varchar(80) NOT NULL,
  `CountryRegionName` char(30) DEFAULT NULL,
  `CountryRegionRequired` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CountryID`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'AF','Afghanistan','State/ Province/ Region',0),(2,'AL','Albania','State/ Province/ Region',0),(3,'DZ','Algeria','State/ Province/ Region',0),(4,'AS','American Samoa','State/ Province/ Region',0),(5,'AD','Andorra','State/ Province/ Region',0),(6,'AO','Angola','State/ Province/ Region',0),(7,'AI','Anguilla','State/ Province/ Region',0),(8,'AQ','Antarctica','State/ Province/ Region',0),(9,'AG','Antigua and Barbuda','State/ Province/ Region',0),(10,'AR','Argentina','State/ Province/ Region',0),(11,'AM','Armenia','State/ Province/ Region',0),(12,'AW','Aruba','State/ Province/ Region',0),(13,'AU','Australia','State/Territory',1),(14,'AT','Austria','State/ Province/ Region',0),(15,'AZ','Azerbaijan','State/ Province/ Region',0),(16,'BS','Bahamas','State/ Province/ Region',0),(17,'BH','Bahrain','State/ Province/ Region',0),(18,'BD','Bangladesh','State/ Province/ Region',0),(19,'BB','Barbados','State/ Province/ Region',0),(20,'BY','Belarus','State/ Province/ Region',0),(21,'BE','Belgium','Region',0),(22,'BZ','Belize','State/ Province/ Region',0),(23,'BJ','Benin','State/ Province/ Region',0),(24,'BM','Bermuda','State/ Province/ Region',0),(25,'BT','Bhutan','State/ Province/ Region',0),(26,'BO','Bolivia','State/ Province/ Region',0),(27,'BA','Bosnia and Herzegovina','State/ Province/ Region',0),(28,'BW','Botswana','State/ Province/ Region',0),(29,'BV','Bouvet Island','State/ Province/ Region',0),(30,'BR','Brazil','State/ Province/ Region',0),(31,'IO','British Indian Ocean Territory','State/ Province/ Region',0),(32,'BN','Brunei Darussalam','State/ Province/ Region',0),(33,'BG','Bulgaria','State/ Province/ Region',0),(34,'BF','Burkina Faso','State/ Province/ Region',0),(35,'BI','Burundi','State/ Province/ Region',0),(36,'KH','Cambodia','State/ Province/ Region',0),(37,'CM','Cameroon','State/ Province/ Region',0),(38,'CA','Canada','Province',1),(39,'CV','Cape Verde','State/ Province/ Region',0),(40,'KY','Cayman Islands','State/ Province/ Region',0),(41,'CF','Central African Republic','State/ Province/ Region',0),(42,'TD','Chad','State/ Province/ Region',0),(43,'CL','Chile','State/ Province/ Region',0),(44,'CN','China','Province/Region/Municipality',1),(45,'CX','Christmas Island','State/ Province/ Region',0),(46,'CC','Cocos (Keeling) Islands','State/ Province/ Region',0),(47,'CO','Colombia','State/ Province/ Region',0),(48,'KM','Comoros','State/ Province/ Region',0),(49,'CG','Congo','State/ Province/ Region',0),(50,'CD','Congo, the Democratic Republic of the','State/ Province/ Region',0),(51,'CK','Cook Islands','State/ Province/ Region',0),(52,'CR','Costa Rica','State/ Province/ Region',0),(53,'CI','Cote D\'Ivoire','State/ Province/ Region',0),(54,'HR','Croatia','State/ Province/ Region',0),(55,'CU','Cuba','State/ Province/ Region',0),(56,'CY','Cyprus','State/ Province/ Region',0),(57,'CZ','Czech Republic','State/ Province/ Region',0),(58,'DK','Denmark','State/ Province/ Region',0),(59,'DJ','Djibouti','State/ Province/ Region',0),(60,'DM','Dominica','State/ Province/ Region',0),(61,'DO','Dominican Republic','State/ Province/ Region',0),(62,'EC','Ecuador','State/ Province/ Region',0),(63,'EG','Egypt','State/ Province/ Region',0),(64,'SV','El Salvador','State/ Province/ Region',0),(65,'GQ','Equatorial Guinea','State/ Province/ Region',0),(66,'ER','Eritrea','State/ Province/ Region',0),(67,'EE','Estonia','State/ Province/ Region',0),(68,'ET','Ethiopia','State/ Province/ Region',0),(69,'FK','Falkland Islands (Malvinas)','State/ Province/ Region',0),(70,'FO','Faroe Islands','State/ Province/ Region',0),(71,'FJ','Fiji','State/ Province/ Region',0),(72,'FI','Finland','State/ Province/ Region',0),(73,'FR','France','State/ Province/ Region',0),(74,'GF','French Guiana','State/ Province/ Region',0),(75,'PF','French Polynesia','State/ Province/ Region',0),(76,'TF','French Southern Territories','State/ Province/ Region',0),(77,'GA','Gabon','State/ Province/ Region',0),(78,'GM','Gambia','State/ Province/ Region',0),(79,'GE','Georgia','State/ Province/ Region',0),(80,'DE','Germany','State/ Province/ Region',0),(81,'GH','Ghana','State/ Province/ Region',0),(82,'GI','Gibraltar','State/ Province/ Region',0),(83,'GR','Greece','State/ Province/ Region',0),(84,'GL','Greenland','State/ Province/ Region',0),(85,'GD','Grenada','State/ Province/ Region',0),(86,'GP','Guadeloupe','State/ Province/ Region',0),(87,'GU','Guam','State/ Province/ Region',0),(88,'GT','Guatemala','State/ Province/ Region',0),(89,'GN','Guinea','State/ Province/ Region',0),(90,'GW','Guinea-Bissau','State/ Province/ Region',0),(91,'GY','Guyana','State/ Province/ Region',0),(92,'HT','Haiti','State/ Province/ Region',0),(93,'HM','Heard Island and Mcdonald Islands','State/ Province/ Region',0),(94,'VA','Holy See (Vatican City State)','State/ Province/ Region',0),(95,'HN','Honduras','State/ Province/ Region',0),(96,'HK','Hong Kong','State/ Province/ Region',0),(97,'HU','Hungary','State/ Province/ Region',0),(98,'IS','Iceland','State/ Province/ Region',0),(99,'IN','India','State/ Province/ Region',0),(100,'ID','Indonesia','State/ Province/ Region',0),(101,'IR','Iran, Islamic Republic of','State/ Province/ Region',0),(102,'IQ','Iraq','State/ Province/ Region',0),(103,'IE','Ireland','State/ Province/ Region',0),(104,'IL','Israel','State/ Province/ Region',0),(105,'IT','Italy','Region',1),(106,'JM','Jamaica','State/ Province/ Region',0),(107,'JP','Japan','Prefecture',1),(108,'JO','Jordan','State/ Province/ Region',0),(109,'KZ','Kazakhstan','State/ Province/ Region',0),(110,'KE','Kenya','State/ Province/ Region',0),(111,'KI','Kiribati','State/ Province/ Region',0),(112,'KP','Korea, Democratic People\'s Republic of','State/ Province/ Region',0),(113,'KR','Korea, Republic of','State/ Province/ Region',0),(114,'KW','Kuwait','State/ Province/ Region',0),(115,'KG','Kyrgyzstan','State/ Province/ Region',0),(116,'LA','Lao People\'s Democratic Republic','State/ Province/ Region',0),(117,'LV','Latvia','State/ Province/ Region',0),(118,'LB','Lebanon','State/ Province/ Region',0),(119,'LS','Lesotho','State/ Province/ Region',0),(120,'LR','Liberia','State/ Province/ Region',0),(121,'LY','Libyan Arab Jamahiriya','State/ Province/ Region',0),(122,'LI','Liechtenstein','State/ Province/ Region',0),(123,'LT','Lithuania','State/ Province/ Region',0),(124,'LU','Luxembourg','State/ Province/ Region',0),(125,'MO','Macao','State/ Province/ Region',0),(126,'MK','Macedonia, the Former Yugoslav Republic of','State/ Province/ Region',0),(127,'MG','Madagascar','State/ Province/ Region',0),(128,'MW','Malawi','State/ Province/ Region',0),(129,'MY','Malaysia','State/ Province/ Region',0),(130,'MV','Maldives','State/ Province/ Region',0),(131,'ML','Mali','State/ Province/ Region',0),(132,'MT','Malta','State/ Province/ Region',0),(133,'MH','Marshall Islands','State/ Province/ Region',0),(134,'MQ','Martinique','State/ Province/ Region',0),(135,'MR','Mauritania','State/ Province/ Region',0),(136,'MU','Mauritius','State/ Province/ Region',0),(137,'YT','Mayotte','State/ Province/ Region',0),(138,'MX','Mexico','State/ Province/ Region',0),(139,'FM','Micronesia, Federated States of','State/ Province/ Region',0),(140,'MD','Moldova, Republic of','State/ Province/ Region',0),(141,'MC','Monaco','State/ Province/ Region',0),(142,'MN','Mongolia','State/ Province/ Region',0),(143,'MS','Montserrat','State/ Province/ Region',0),(144,'MA','Morocco','State/ Province/ Region',0),(145,'MZ','Mozambique','State/ Province/ Region',0),(146,'MM','Myanmar','State/ Province/ Region',0),(147,'NA','Namibia','State/ Province/ Region',0),(148,'NR','Nauru','State/ Province/ Region',0),(149,'NP','Nepal','State/ Province/ Region',0),(150,'NL','Netherlands','State',0),(151,'AN','Netherlands Antilles','State/ Province/ Region',0),(152,'NC','New Caledonia','State/ Province/ Region',0),(153,'NZ','New Zealand','State/ Province/ Region',0),(154,'NI','Nicaragua','State/ Province/ Region',0),(155,'NE','Niger','State/ Province/ Region',0),(156,'NG','Nigeria','State/ Province/ Region',0),(157,'NU','Niue','State/ Province/ Region',0),(158,'NF','Norfolk Island','State/ Province/ Region',0),(159,'MP','Northern Mariana Islands','State/ Province/ Region',0),(160,'NO','Norway','State/ Province/ Region',0),(161,'OM','Oman','State/ Province/ Region',0),(162,'PK','Pakistan','State/ Province/ Region',0),(163,'PW','Palau','State/ Province/ Region',0),(164,'PS','Palestinian Territory, Occupied','State/ Province/ Region',0),(165,'PA','Panama','State/ Province/ Region',0),(166,'PG','Papua New Guinea','State/ Province/ Region',0),(167,'PY','Paraguay','State/ Province/ Region',0),(168,'PE','Peru','State/ Province/ Region',0),(169,'PH','Philippines','State/ Province/ Region',0),(170,'PN','Pitcairn','State/ Province/ Region',0),(171,'PL','Poland','State/ Province/ Region',0),(172,'PT','Portugal','State/ Province/ Region',0),(173,'PR','Puerto Rico','State/ Province/ Region',0),(174,'QA','Qatar','State/ Province/ Region',0),(175,'RE','Reunion','State/ Province/ Region',0),(176,'RO','Romania','State/ Province/ Region',0),(177,'RU','Russian Federation','State/ Province/ Region',0),(178,'RW','Rwanda','State/ Province/ Region',0),(179,'SH','Saint Helena','State/ Province/ Region',0),(180,'KN','Saint Kitts and Nevis','State/ Province/ Region',0),(181,'LC','Saint Lucia','State/ Province/ Region',0),(182,'PM','Saint Pierre and Miquelon','State/ Province/ Region',0),(183,'VC','Saint Vincent and the Grenadines','State/ Province/ Region',0),(184,'WS','Samoa','State/ Province/ Region',0),(185,'SM','San Marino','State/ Province/ Region',0),(186,'ST','Sao Tome and Principe','State/ Province/ Region',0),(187,'SA','Saudi Arabia','State/ Province/ Region',0),(188,'SN','Senegal','State/ Province/ Region',0),(189,'CS','Serbia and Montenegro','State/ Province/ Region',0),(190,'SC','Seychelles','State/ Province/ Region',0),(191,'SL','Sierra Leone','State/ Province/ Region',0),(192,'SG','Singapore','State/ Province/ Region',0),(193,'SK','Slovakia','State/ Province/ Region',0),(194,'SI','Slovenia','State/ Province/ Region',0),(195,'SB','Solomon Islands','State/ Province/ Region',0),(196,'SO','Somalia','State/ Province/ Region',0),(197,'ZA','South Africa','State/ Province/ Region',0),(198,'GS','South Georgia and the South Sandwich Islands','State/ Province/ Region',0),(199,'ES','Spain','Province',1),(200,'LK','Sri Lanka','State/ Province/ Region',0),(201,'SD','Sudan','State/ Province/ Region',0),(202,'SR','Suriname','State/ Province/ Region',0),(203,'SJ','Svalbard and Jan Mayen','State/ Province/ Region',0),(204,'SZ','Swaziland','State/ Province/ Region',0),(205,'SE','Sweden','State/ Province/ Region',0),(206,'CH','Switzerland','State/ Province/ Region',0),(207,'SY','Syrian Arab Republic','State/ Province/ Region',0),(208,'TW','Taiwan, Province of China','State/ Province/ Region',0),(209,'TJ','Tajikistan','State/ Province/ Region',0),(210,'TZ','Tanzania, United Republic of','State/ Province/ Region',0),(211,'TH','Thailand','State/ Province/ Region',0),(212,'TL','Timor-Leste','State/ Province/ Region',0),(213,'TG','Togo','State/ Province/ Region',0),(214,'TK','Tokelau','State/ Province/ Region',0),(215,'TO','Tonga','State/ Province/ Region',0),(216,'TT','Trinidad and Tobago','State/ Province/ Region',0),(217,'TN','Tunisia','State/ Province/ Region',0),(218,'TR','Turkey','State/ Province/ Region',0),(219,'TM','Turkmenistan','State/ Province/ Region',0),(220,'TC','Turks and Caicos Islands','State/ Province/ Region',0),(221,'TV','Tuvalu','State/ Province/ Region',0),(222,'UG','Uganda','State/ Province/ Region',0),(223,'UA','Ukraine','State/ Province/ Region',0),(224,'AE','United Arab Emirates','State/ Province/ Region',0),(225,'GB','United Kingdom','County',1),(226,'US','United States','State',1),(227,'UM','United States Minor Outlying Islands','State/ Province/ Region',0),(228,'UY','Uruguay','State/ Province/ Region',0),(229,'UZ','Uzbekistan','State/ Province/ Region',0),(230,'VU','Vanuatu','State/ Province/ Region',0),(231,'VE','Venezuela','State/ Province/ Region',0),(232,'VN','Viet Nam','State/ Province/ Region',0),(233,'VG','Virgin Islands, British','State/ Province/ Region',0),(234,'VI','Virgin Islands, U.s.','State/ Province/ Region',0),(235,'WF','Wallis and Futuna','State/ Province/ Region',0),(236,'EH','Western Sahara','State/ Province/ Region',0),(237,'YE','Yemen','State/ Province/ Region',0),(238,'ZM','Zambia','State/ Province/ Region',0),(239,'ZW','Zimbabwe','State/ Province/ Region',0);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `CustomerID` int NOT NULL AUTO_INCREMENT,
  `CustomerEmail` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerPassword` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerFirstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerLastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerAddress` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerCity` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerState` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerZip` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerCountry` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerPhone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerEmailVerified` tinyint(1) DEFAULT '0',
  `CustomerRegistrationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CustomerVerificationCode` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CustomerIP` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metatags`
--

DROP TABLE IF EXISTS `metatags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metatags` (
  `metaID` int NOT NULL AUTO_INCREMENT,
  `metaPage` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metaURL` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metaTitle` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metaDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`metaID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metatags`
--

LOCK TABLES `metatags` WRITE;
/*!40000 ALTER TABLE `metatags` DISABLE KEYS */;
INSERT INTO `metatags` VALUES (1,'Home','/','Welcome to','Description for home page'),(2,'About','/about','About','Description for about'),(3,'Contact','/contact','Get in touch','description for contact'),(4,'Products','/products','Our products','Description for products'),(5,'User-Home','/user-home','User Home','Description for User Home'),(6,'Cart','/cart','Shopping Cart','Description for Shopping Cart'),(7,'Checkout','/checkout','Checkout','Description for Checkout'),(8,'Clothing','/products/clothing','Clothing','Description for clothing'),(9,'Footwear','/products/footwear','Footwear','Description for footwear');
/*!40000 ALTER TABLE `metatags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orderdetails` (
  `DetailID` int NOT NULL AUTO_INCREMENT,
  `DetailOrderID` int DEFAULT NULL,
  `DetailProductID` int DEFAULT NULL,
  `DetailName` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `DetailPrice` float DEFAULT NULL,
  `DetailSKU` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `DetailQuantity` int DEFAULT NULL,
  PRIMARY KEY (`DetailID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderdetails`
--

LOCK TABLES `orderdetails` WRITE;
/*!40000 ALTER TABLE `orderdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `OrderID` int NOT NULL AUTO_INCREMENT,
  `OrderCustomerID` int DEFAULT NULL,
  `OrderAmount` float DEFAULT NULL,
  `OrderShipName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderShipAddress` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderShipAddress2` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderState` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderZip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderCountry` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderPhone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderPostage` float DEFAULT NULL,
  `OrderTax` float DEFAULT NULL,
  `OrderEmail` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OrderShipped` tinyint(1) NOT NULL DEFAULT '0',
  `OrderTrackingNumber` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`OrderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `ProductID` int NOT NULL AUTO_INCREMENT,
  `ProductSKU` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductPrice` float DEFAULT NULL,
  `ProductWeight` float DEFAULT NULL,
  `ProductCartDesc` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductShortDesc` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductLongDesc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ProductThumb` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductImage` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProductCategoryID` int DEFAULT NULL,
  `ProductUpdateDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ProductStock` float DEFAULT NULL,
  `ProductLive` tinyint(1) DEFAULT '0',
  `ProductUnlimited` tinyint(1) DEFAULT '1',
  `ProductLocation` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'000-0001','Cotton T-Shirt',9.99,3,'Light Cotton T-Shirt','A light cotton T-Shirt made with 100% real cotton.','A light cotton T-Shirt made with 100% real cotton.\r\n\r\nMade right here in the USA for over 15 years, this t-shirt is lightweight and durable.','','',1,'2013-06-13 01:00:50',100,1,0,NULL),(2,'000-0004','Los Angeles',179.99,NULL,NULL,'A rugged track and trail athletic shoe','A rugged track and trail athletic shoe',NULL,NULL,2,NULL,NULL,1,NULL,NULL),(3,'000-0011','Leather Belt',101,NULL,'Australian Bush Leather Belt','Australian Bush Leather Belt','All Austrlian hand made leather belt withsilver buckle',NULL,NULL,NULL,'2020-02-01 00:55:59',NULL,0,1,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regions` (
  `RegionID` int NOT NULL AUTO_INCREMENT,
  `RegionName` char(50) NOT NULL,
  `RegionCode` char(2) DEFAULT NULL,
  `RegionCountry` char(2) NOT NULL DEFAULT 'US',
  PRIMARY KEY (`RegionID`)
) ENGINE=MyISAM AUTO_INCREMENT=530 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (1,'Alaska','AK','US'),(2,'Alabama','AL','US'),(3,'American Samoa','AS','US'),(4,'Arizona','AZ','US'),(5,'Arkansas','AR','US'),(6,'California','CA','US'),(7,'Colorado','CO','US'),(8,'Connecticut','CT','US'),(9,'Delaware','DE','US'),(10,'District of Columbia','DC','US'),(11,'Federated States of Micronesia','FM','US'),(12,'Florida','FL','US'),(13,'Georgia','GA','US'),(14,'Guam','GU','US'),(15,'Hawaii','HI','US'),(16,'Idaho','ID','US'),(17,'Illinois','IL','US'),(18,'Indiana','IN','US'),(19,'Iowa','IA','US'),(20,'Kansas','KS','US'),(21,'Kentucky','KY','US'),(22,'Louisiana','LA','US'),(23,'Maine','ME','US'),(24,'Marshall Islands','MH','US'),(25,'Maryland','MD','US'),(26,'Massachusetts','MA','US'),(27,'Michigan','MI','US'),(28,'Minnesota','MN','US'),(29,'Mississippi','MS','US'),(30,'Missouri','MO','US'),(31,'Montana','MT','US'),(32,'Nebraska','NE','US'),(33,'Nevada','NV','US'),(34,'New Hampshire','NH','US'),(35,'New Jersey','NJ','US'),(36,'New Mexico','NM','US'),(37,'New York','NY','US'),(38,'North Carolina','NC','US'),(39,'North Dakota','ND','US'),(40,'Northern Mariana Islands','MP','US'),(41,'Ohio','OH','US'),(42,'Oklahoma','OK','US'),(43,'Oregon','OR','US'),(44,'Palau','PW','US'),(45,'Pennsylvania','PA','US'),(46,'Puerto Rico','PR','US'),(47,'Rhode Island','RI','US'),(48,'South Carolina','SC','US'),(49,'South Dakota','SD','US'),(50,'Tennessee','TN','US'),(51,'Texas','TX','US'),(52,'Utah','UT','US'),(53,'Vermont','VT','US'),(54,'Virgin Islands','VI','US'),(55,'Virginia','VA','US'),(56,'Washington','WA','US'),(57,'West Virginia','WV','US'),(58,'Wisconsin','WI','US'),(59,'Wyoming','WY','US'),(60,'Armed Forces Africa','AE','US'),(61,'Armed Forces Americas (except Canada)','AA','US'),(62,'Armed Forces Canada','AE','US'),(63,'Armed Forces Europe','AE','US'),(64,'Armed Forces Middle East','AE','US'),(65,'Armed Forces Pacific','AP','US'),(66,'Alberta','AB','CA'),(67,'British Columbia','BC','CA'),(68,'Manitoba','MB','CA'),(69,'New Brunswick','NB','CA'),(70,'Newfoundland and Labrador','NL','CA'),(71,'Northwest Territories','NT','CA'),(72,'Nova Scotia','NS','CA'),(73,'Nunavut','NU','CA'),(74,'Ontario','ON','CA'),(75,'Prince Edward Island','PE','CA'),(76,'Quebec','QC','CA'),(77,'Saskatchewan','SK','CA'),(78,'Yukon','YT','CA'),(355,'Stirling',NULL,'GB'),(354,'South Lanarkshire',NULL,'GB'),(353,'South Ayrshire',NULL,'GB'),(352,'Shetland',NULL,'GB'),(351,'Roxburghshire',NULL,'GB'),(350,'Renfrewshire',NULL,'GB'),(349,'Perthshire and Kinross',NULL,'GB'),(348,'Orkney',NULL,'GB'),(347,'North Lanarkshire',NULL,'GB'),(346,'North Ayrshire',NULL,'GB'),(345,'Moray',NULL,'GB'),(344,'Midlothian',NULL,'GB'),(343,'Inverclyde',NULL,'GB'),(342,'Highland',NULL,'GB'),(341,'Glasgow (City of)',NULL,'GB'),(340,'Fife',NULL,'GB'),(339,'Falkirk',NULL,'GB'),(338,'Edinburgh City',NULL,'GB'),(337,'East Renfrewshire',NULL,'GB'),(336,'East Lothian',NULL,'GB'),(335,'East Dunbartonshire',NULL,'GB'),(334,'East Ayrshire',NULL,'GB'),(333,'Dumfries and Galloway',NULL,'GB'),(332,'Clackmannan',NULL,'GB'),(331,'Borders',NULL,'GB'),(330,'Argyll and Bute',NULL,'GB'),(329,'Angus',NULL,'GB'),(328,'Aberdeenshire',NULL,'GB'),(327,'Aberdeen City',NULL,'GB'),(326,'Tyrone',NULL,'GB'),(325,'Londonderry',NULL,'GB'),(324,'Fermanagh',NULL,'GB'),(323,'Down',NULL,'GB'),(322,'Armagh',NULL,'GB'),(321,'Antrim',NULL,'GB'),(320,'Worcestershire',NULL,'GB'),(319,'Wiltshire',NULL,'GB'),(318,'West Yorkshire',NULL,'GB'),(317,'West Sussex',NULL,'GB'),(316,'West Midlands',NULL,'GB'),(315,'Warwickshire',NULL,'GB'),(314,'Tyne and Wear',NULL,'GB'),(313,'Surrey',NULL,'GB'),(312,'Suffolk',NULL,'GB'),(311,'Staffordshire',NULL,'GB'),(310,'South Yorkshire',NULL,'GB'),(309,'Somerset',NULL,'GB'),(308,'Shropshire',NULL,'GB'),(307,'Rutland',NULL,'GB'),(306,'Oxfordshire',NULL,'GB'),(305,'Nottinghamshire',NULL,'GB'),(304,'Northumberland',NULL,'GB'),(303,'Northamptonshire',NULL,'GB'),(302,'North Yorkshire',NULL,'GB'),(301,'Norfolk',NULL,'GB'),(300,'Middlesex',NULL,'GB'),(299,'Merseyside',NULL,'GB'),(298,'London',NULL,'GB'),(297,'Lincolnshire',NULL,'GB'),(296,'Leicestershire',NULL,'GB'),(295,'Lancashire',NULL,'GB'),(294,'Kent',NULL,'GB'),(293,'Isles of Scilly',NULL,'GB'),(292,'Isle of Wight',NULL,'GB'),(291,'Humberside',NULL,'GB'),(290,'Hertfordshire',NULL,'GB'),(289,'Herefordshire',NULL,'GB'),(288,'Hampshire',NULL,'GB'),(287,'Greater Manchester',NULL,'GB'),(286,'Gloucestershire',NULL,'GB'),(285,'Essex',NULL,'GB'),(284,'East Sussex',NULL,'GB'),(283,'East Riding of Yorkshire',NULL,'GB'),(282,'Durham',NULL,'GB'),(281,'Dorset',NULL,'GB'),(280,'Devon',NULL,'GB'),(279,'Derbyshire',NULL,'GB'),(278,'Cumbria',NULL,'GB'),(277,'Cornwall',NULL,'GB'),(276,'Cleveland',NULL,'GB'),(275,'Cheshire',NULL,'GB'),(274,'Cambridgeshire',NULL,'GB'),(273,'Buckinghamshire',NULL,'GB'),(272,'Bristol',NULL,'GB'),(271,'Berkshire',NULL,'GB'),(270,'Bedfordshire',NULL,'GB'),(269,'Avon',NULL,'GB'),(499,'Anhui',NULL,'CN'),(501,'Chongqing',NULL,'CN'),(168,'Álava',NULL,'ES'),(169,'Albacete',NULL,'ES'),(170,'Alicante',NULL,'ES'),(171,'Almería',NULL,'ES'),(172,'Asturias',NULL,'ES'),(173,'Ávila',NULL,'ES'),(174,'Badajoz',NULL,'ES'),(175,'Barcelona',NULL,'ES'),(176,'Burgos',NULL,'ES'),(177,'Cáceres',NULL,'ES'),(178,'Cádiz',NULL,'ES'),(179,'Cantabria',NULL,'ES'),(180,'Castellón',NULL,'ES'),(181,'Ceuta',NULL,'ES'),(182,'Ciudad Real',NULL,'ES'),(183,'Córdoba',NULL,'ES'),(184,'Cuenca',NULL,'ES'),(185,'Guadalajara',NULL,'ES'),(186,'Girona',NULL,'ES'),(187,'Granada',NULL,'ES'),(188,'Guipúzcoa',NULL,'ES'),(189,'Huelva',NULL,'ES'),(190,'Huesca',NULL,'ES'),(191,'Islas Baleares',NULL,'ES'),(192,'Jaén',NULL,'ES'),(193,'La Coruña',NULL,'ES'),(194,'Las Palmas',NULL,'ES'),(195,'La Rioja',NULL,'ES'),(196,'León',NULL,'ES'),(197,'Lérida',NULL,'ES'),(198,'Lugo',NULL,'ES'),(199,'Madrid',NULL,'ES'),(200,'Málaga',NULL,'ES'),(201,'Melilla',NULL,'ES'),(202,'Murcia',NULL,'ES'),(203,'Navarra',NULL,'ES'),(204,'Orense',NULL,'ES'),(205,'Palencia',NULL,'ES'),(206,'Pontevedra',NULL,'ES'),(207,'Salamanca',NULL,'ES'),(208,'Santa Cruz de Tenerife',NULL,'ES'),(209,'Segovia',NULL,'ES'),(210,'Sevilla',NULL,'ES'),(211,'Soria',NULL,'ES'),(212,'Tarragona',NULL,'ES'),(213,'Teruel',NULL,'ES'),(214,'Toledo',NULL,'ES'),(215,'Valencia',NULL,'ES'),(216,'Valladolid',NULL,'ES'),(217,'Vizcaya',NULL,'ES'),(218,'Zamora',NULL,'ES'),(219,'Zaragoza',NULL,'ES'),(500,'Beijing',NULL,'CN'),(221,'Hokkaido',NULL,'JP'),(222,'Aomori',NULL,'JP'),(223,'Iwate',NULL,'JP'),(224,'Miyagi',NULL,'JP'),(225,'Akita',NULL,'JP'),(226,'Yamagata',NULL,'JP'),(227,'Fukushima',NULL,'JP'),(228,'Ibaraki',NULL,'JP'),(229,'Tochigi',NULL,'JP'),(230,'Gunma',NULL,'JP'),(231,'Saitama',NULL,'JP'),(232,'Chiba',NULL,'JP'),(233,'Tokyo',NULL,'JP'),(234,'Kanagawa',NULL,'JP'),(235,'Niigata',NULL,'JP'),(236,'Toyama',NULL,'JP'),(237,'Ishikawa',NULL,'JP'),(238,'Fukui',NULL,'JP'),(239,'Yamanashi',NULL,'JP'),(240,'Nagano',NULL,'JP'),(241,'Gifu',NULL,'JP'),(242,'Shizuoka',NULL,'JP'),(243,'Aichi',NULL,'JP'),(244,'Mie',NULL,'JP'),(245,'Shiga',NULL,'JP'),(246,'Kyoto',NULL,'JP'),(247,'Osaka',NULL,'JP'),(248,'Hyogo',NULL,'JP'),(249,'Nara',NULL,'JP'),(250,'Wakayama',NULL,'JP'),(251,'Tottori',NULL,'JP'),(252,'Shimane',NULL,'JP'),(253,'Okayama',NULL,'JP'),(254,'Hiroshima',NULL,'JP'),(255,'Yamaguchi',NULL,'JP'),(256,'Tokushima',NULL,'JP'),(257,'Kagawa',NULL,'JP'),(258,'Ehime',NULL,'JP'),(259,'Kochi',NULL,'JP'),(260,'Fukuoka',NULL,'JP'),(261,'Saga',NULL,'JP'),(262,'Nagasaki',NULL,'JP'),(263,'Kumamoto',NULL,'JP'),(264,'Oita',NULL,'JP'),(265,'Miyazaki',NULL,'JP'),(266,'Kagoshima',NULL,'JP'),(267,'Okinawa',NULL,'JP'),(356,'West Dunbartonshire',NULL,'GB'),(357,'West Lothian',NULL,'GB'),(358,'Western Isles',NULL,'GB'),(359,'Blaenau Gwent',NULL,'GB'),(360,'Bridgend',NULL,'GB'),(361,'Caerphilly',NULL,'GB'),(362,'Cardiff',NULL,'GB'),(363,'Carmarthenshire',NULL,'GB'),(364,'Ceredigion',NULL,'GB'),(365,'Conwy',NULL,'GB'),(366,'Denbighshire',NULL,'GB'),(367,'Flintshire',NULL,'GB'),(368,'Gwynedd',NULL,'GB'),(369,'Isle of Anglesey',NULL,'GB'),(370,'Merthyr Tydfil',NULL,'GB'),(371,'Monmouthshire',NULL,'GB'),(372,'Neath Port Talbot',NULL,'GB'),(373,'Newport',NULL,'GB'),(374,'Pembrokeshire',NULL,'GB'),(375,'Powys',NULL,'GB'),(376,'Rhondda Cynon Taff',NULL,'GB'),(377,'Swansea',NULL,'GB'),(378,'Torfaen',NULL,'GB'),(379,'The Vale of Glamorgan',NULL,'GB'),(380,'Wrexham',NULL,'GB'),(381,'Channel Islands',NULL,'GB'),(382,'Isle of Man',NULL,'GB'),(383,'Italian Provinces',NULL,'IT'),(384,'Agrigento',NULL,'IT'),(385,'Alessandria',NULL,'IT'),(386,'Ancona',NULL,'IT'),(387,'Aosta',NULL,'IT'),(388,'L\'Aquila',NULL,'IT'),(389,'Arezzo',NULL,'IT'),(390,'Ascoli Piceno',NULL,'IT'),(391,'Asti',NULL,'IT'),(392,'Avellino',NULL,'IT'),(393,'Bari',NULL,'IT'),(394,'Belluno',NULL,'IT'),(395,'Benevento',NULL,'IT'),(396,'Bergamo',NULL,'IT'),(397,'Biella',NULL,'IT'),(398,'Bologna',NULL,'IT'),(399,'Bolzano',NULL,'IT'),(400,'Brescia',NULL,'IT'),(401,'Brindisi',NULL,'IT'),(402,'Cagliari',NULL,'IT'),(403,'Caltanissetta',NULL,'IT'),(404,'Campobasso',NULL,'IT'),(405,'Carbonia-Iglesias',NULL,'IT'),(406,'Caserta',NULL,'IT'),(407,'Catania',NULL,'IT'),(408,'Catanzaro',NULL,'IT'),(409,'Chieti',NULL,'IT'),(410,'Como',NULL,'IT'),(411,'Cosenza',NULL,'IT'),(412,'Cremona',NULL,'IT'),(413,'Crotone',NULL,'IT'),(414,'Cuneo',NULL,'IT'),(415,'Enna',NULL,'IT'),(416,'Ferrara',NULL,'IT'),(417,'Firenze',NULL,'IT'),(418,'Foggia',NULL,'IT'),(419,'Forli',NULL,'IT'),(420,'Frosinone',NULL,'IT'),(421,'Genova',NULL,'IT'),(422,'Gorizia',NULL,'IT'),(423,'Grosseto',NULL,'IT'),(424,'Imperia',NULL,'IT'),(425,'Isernia',NULL,'IT'),(426,'Latina',NULL,'IT'),(427,'Lecce',NULL,'IT'),(428,'Lecco',NULL,'IT'),(429,'Livorno',NULL,'IT'),(430,'Lodi',NULL,'IT'),(431,'Lucca',NULL,'IT'),(432,'Macerata',NULL,'IT'),(433,'Mantova',NULL,'IT'),(434,'Massa Carrara',NULL,'IT'),(435,'Matera',NULL,'IT'),(436,'Medio Campidano',NULL,'IT'),(437,'Messina',NULL,'IT'),(438,'Milano',NULL,'IT'),(439,'Modena',NULL,'IT'),(440,'Napoli',NULL,'IT'),(441,'Novara',NULL,'IT'),(442,'Nuoro',NULL,'IT'),(443,'Ogliastra',NULL,'IT'),(444,'Olbia-Tempio',NULL,'IT'),(445,'Oristano',NULL,'IT'),(446,'Padova',NULL,'IT'),(447,'Palermo',NULL,'IT'),(448,'Parma',NULL,'IT'),(449,'Pavia',NULL,'IT'),(450,'Perugia',NULL,'IT'),(451,'Pesaro',NULL,'IT'),(452,'Pescara',NULL,'IT'),(453,'Piacenza',NULL,'IT'),(454,'Pisa',NULL,'IT'),(455,'Pistoia',NULL,'IT'),(456,'Pordenone',NULL,'IT'),(457,'Potenza',NULL,'IT'),(458,'Prato',NULL,'IT'),(459,'Ragusa',NULL,'IT'),(460,'Ravenna',NULL,'IT'),(461,'Reggio Calabria',NULL,'IT'),(462,'Reggio Emilia',NULL,'IT'),(463,'Rieti',NULL,'IT'),(464,'Rimini',NULL,'IT'),(465,'Roma',NULL,'IT'),(466,'Rovigo',NULL,'IT'),(467,'Salerno',NULL,'IT'),(468,'Sassari',NULL,'IT'),(469,'Savona',NULL,'IT'),(470,'Siena',NULL,'IT'),(471,'Siracusa',NULL,'IT'),(472,'Sondrio',NULL,'IT'),(473,'La Spezia',NULL,'IT'),(474,'Taranto',NULL,'IT'),(475,'Teramo',NULL,'IT'),(476,'Terni',NULL,'IT'),(477,'Torino',NULL,'IT'),(478,'Trapani',NULL,'IT'),(479,'Trento',NULL,'IT'),(480,'Treviso',NULL,'IT'),(481,'Trieste',NULL,'IT'),(482,'Udine',NULL,'IT'),(483,'Varese',NULL,'IT'),(484,'Venezia',NULL,'IT'),(485,'Verbania-Cusio-Ossola',NULL,'IT'),(486,'Vercelli',NULL,'IT'),(487,'Verona',NULL,'IT'),(488,'Vibo Valentia',NULL,'IT'),(489,'Vicenza',NULL,'IT'),(490,'Viterbo',NULL,'IT'),(491,'Australian Capital Territory',NULL,'AU'),(492,'New South Wales',NULL,'AU'),(493,'Northern Territory',NULL,'AU'),(494,'Queensland',NULL,'AU'),(495,'South Australia',NULL,'AU'),(496,'Tasmania',NULL,'AU'),(497,'Victoria',NULL,'AU'),(498,'Western Australia',NULL,'AU'),(502,'Fujian',NULL,'CN'),(503,'Gansu',NULL,'CN'),(504,'Guangdong',NULL,'CN'),(505,'Guangxi Zhuang',NULL,'CN'),(506,'Guizhou',NULL,'CN'),(507,'Hainan',NULL,'CN'),(508,'Hebei',NULL,'CN'),(509,'Heilongjiang',NULL,'CN'),(510,'Henan',NULL,'CN'),(511,'Hubei',NULL,'CN'),(512,'Hunan',NULL,'CN'),(513,'Jiangsu',NULL,'CN'),(514,'Jiangxi',NULL,'CN'),(515,'Jilin',NULL,'CN'),(516,'Liaoning',NULL,'CN'),(517,'Nei Mongol',NULL,'CN'),(518,'Ningxia Hui',NULL,'CN'),(519,'Qinghai',NULL,'CN'),(520,'Shaanxi',NULL,'CN'),(521,'Shandong',NULL,'CN'),(522,'Shanghai',NULL,'CN'),(523,'Shanxi',NULL,'CN'),(524,'Sichuan',NULL,'CN'),(525,'Tianjin',NULL,'CN'),(526,'Xinjiang Uygur',NULL,'CN'),(527,'Xizang',NULL,'CN'),(528,'Yunnan',NULL,'CN'),(529,'Zhejiang',NULL,'CN');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `UserPassword` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `UserLevel` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Admin','2ffda559d52f087171443389e2ff157da9b1fa5ec98abc9f8b11fdddcc245b9b','Manager');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-01  6:23:25
