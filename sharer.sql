-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: sharer
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

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
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `protected` tinyint(4) DEFAULT '0',
  `pass` varchar(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'test.txt',NULL,'tst001',0,'5fe1ad193f82d2cde58a999de08fddeb','374374637'),(2,'2016-10-02_17_01_31-VNC-ih199226_-_Pale_Moon.png',NULL,'pzmwqFDZB',0,NULL,NULL),(3,'2016-10-02_17_01_31-VNC-ih199226_-_Pale_Moon.png',NULL,'AhOfgRRjn',0,NULL,NULL),(4,'2016-10-02_17_01_31-VNC-ih199226_-_Pale_Moon.png',NULL,'ZDkSXTOeL',0,NULL,NULL),(5,'2016-10-02_17_01_31-VNC-ih199226_-_Pale_Moon.png','1234','sdfDNZCCO',0,NULL,NULL),(6,'2016-10-02_17_01_31-VNC-ih199226_-_Pale_Moon.png','image/png','7799f1f988baec52a235e081d78d254b',0,NULL,NULL),(7,'2016-10-02_17_01_31-VNC-ih199226_-_Pale_Moon.png','image/png','13df562f6f8d50a3c6e82516d25627f7',1,'ab86ed76ddd859a06643365e1370a75a','8a7c28067a0d5c58dee4a9ea45403afc'),(8,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','80fdcc69166eec7faa0ea47773daa76d',1,'790525724b7d5b0ed5e8156c9bc9d816','e3b00f03259cb62f50cbdccaea330315'),(9,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','e4a81ddcfbdd32a4eb3eb1e315e97269',1,'82999b75269bf9b24e94214e0e966124','b8234d4c0d09bbdc685fc8876f3310de'),(10,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','1fd66447bd451edb88414302b37d56de',1,'26b5dcbf4a3e79fb4884983c8a76b1f3','1c5768eddd709d5ce3d02dc68508fc72'),(11,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','a3027d92f63e1e77431930feba66f0b5',1,'d3d6c4dc7afa9bf70adbba3292d8e8b4','adbf475581d2b67daf75f50784357b19'),(12,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','b6d7ee5df0fefe0fc3c3621facf14d1a',1,'6459251f0b7d9d634b6310648a3c3276','f34b56df2bc2f531eb9cbd9d6c239dc2'),(13,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','a9400269af95e014f9db5498f407ac6a',1,'09b72a56e7df3c77ecb5f84f53d80717','3eebc7eae30d0ab3d3d813e8c5efc2c5'),(14,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','ea148e4364eec0208c6e7dc160cf343a',1,'52b9f7e4487e580deede9c75b256e768','b31253f7a94b1a63dd5c83212471d6da'),(15,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','e619307a556765a6541692ee60557a2b',1,'e4e0fb25dfb3e129637f744bc009a39a','6fc9bc71a6908dd5e1bd94a94c2ad430'),(16,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','38a750b8d61cd9eadc1a43a0165cb5b8',1,'fd77aeb8174d53d2e7f25f266286f5c1','ca0af8ba5cc47b0a2b993f9cb9cd6dc2'),(17,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','0c4f04d00049eb9ae35fe3808a228c69',1,'18420ea2a2ca71ecde6038a181d76663','065e698f7255f6af0b9f2a432445be9e'),(18,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','d11a065e60a0ec105cc83afee339c537',1,'c28646b266a976b04f9241030d625397','cf745018e3610ac0f0ba822ad12f665e'),(19,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','ececaa177e6c5d65ce899447b2cd0de7',1,'48ed7d9cd870487bc07366b61b906868','3faaf1b3565ab15d491418101e53929e'),(20,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','801fb5d611e314fe0bf55248ed0ce777',1,'d7551b3ec7f947fa937e1ed65a913f83','50080977af61823b2a35029caa5ac25a'),(21,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','d10d3ccc06333a3649cd2ae8e44fb315',1,'149dbbde9e435ff5ad92d029682ba00e','1a6219b0907dc5b098eb6cb1b155b456'),(22,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','c11a73cc2f6d3b30e1aa7a33de8c0e60',1,'92cd6dbc415d659bcebad3920ce03bc6','b92e57011648355325a0ff7c6e396a62'),(23,'rating 13.xls','application/vnd.ms-excel','b7d2107f94242a963a1e74f1e2443b53',1,'3088af147534b13b72b0861d6779e508','a31ea4ef458560d7370b61fbd864b10d'),(24,'rating 13.xls','application/vnd.ms-excel','3c72746eb9fc5c098dd252a6d11ba28d',1,'f95ebb348b467fab88656bfa30eaec4c','f6e0bec8be6c1ec28b4233599be7e1ea'),(25,'rating 13.xls','application/vnd.ms-excel','50823101932b0d4750276391270b480b',1,'9dca5b30898bf8a603414505c0067d88','b5eca3fd4e9bdbbc11e554f97e93aee3'),(26,'rating 13.xls','application/vnd.ms-excel','2b28dce8dc4a6a6dfc35d54c34bcbf25',0,NULL,NULL),(27,'2016-10-02_17_01_31-VNC-ih199226_-_Pale_Moon.png','image/png','f2bfebf6d22918738388f0948d1856ce',1,'d57a3455d73a3057162294b53f1cddaf','a107bc0089ad5931c96b245120c5bb56'),(28,'Tolkachev_A._Yekstremalnyiyi_Tayim_Men.a4.pdf','application/pdf','6cd48e4276cc250c52718628b313a8ce',0,NULL,NULL);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `disabled` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2016-12-12  9:54:49
