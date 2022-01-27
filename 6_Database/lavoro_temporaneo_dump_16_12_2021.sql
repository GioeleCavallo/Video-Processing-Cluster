-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: lavoro_temporaneo
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fattura`
--

DROP TABLE IF EXISTS `fattura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fattura` (
  `data` datetime NOT NULL,
  `datore_email` varchar(50) NOT NULL,
  `lavoratore_email` varchar(50) NOT NULL,
  `totale` int(11) DEFAULT NULL,
  PRIMARY KEY (`data`),
  KEY `datore_email` (`datore_email`),
  KEY `lavoratore_email` (`lavoratore_email`),
  CONSTRAINT `fattura_ibfk_1` FOREIGN KEY (`datore_email`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fattura_ibfk_2` FOREIGN KEY (`lavoratore_email`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fattura`
--

LOCK TABLES `fattura` WRITE;
/*!40000 ALTER TABLE `fattura` DISABLE KEYS */;
INSERT INTO `fattura` VALUES ('2021-12-08 17:13:53','miro.joos@samtrevano.ch','samuele.abba@samtrevano.ch',11),('2021-12-08 17:13:54','samuele.abba@samtrevano.ch','andrea.curti@samtrevano.ch',10);
/*!40000 ALTER TABLE `fattura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lavoro`
--

DROP TABLE IF EXISTS `lavoro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lavoro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datore_email` varchar(50) NOT NULL,
  `lavoratore_email` varchar(50) DEFAULT NULL,
  `titolo` varchar(25) NOT NULL,
  `descrizione` text NOT NULL,
  `tariffaOraria` int(11) NOT NULL,
  `occupato` tinyint(4) NOT NULL,
  `scaduto` tinyint(4) NOT NULL,
  `oreDiLavoro` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `archiviato` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `datore_email` (`datore_email`),
  KEY `lavoratore_email` (`lavoratore_email`),
  CONSTRAINT `lavoro_ibfk_1` FOREIGN KEY (`datore_email`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lavoro_ibfk_2` FOREIGN KEY (`lavoratore_email`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lavoro`
--

LOCK TABLES `lavoro` WRITE;
/*!40000 ALTER TABLE `lavoro` DISABLE KEYS */;
INSERT INTO `lavoro` VALUES (20,'miro.joos@samtrevano.ch','andrea.curti@samtrevano.ch','Parrucchiere','Tagliare i capelli !',10,1,0,1,'2021-12-08 16:47:29',0),(21,'miro.joos@samtrevano.ch','samuele.abba@samtrevano.ch','Giardiniere','tagliare il mio giardino',10,0,1,1,'2021-12-09 11:32:13',0);
/*!40000 ALTER TABLE `lavoro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lavoro_proposta`
--

DROP TABLE IF EXISTS `lavoro_proposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lavoro_proposta` (
  `data` datetime NOT NULL,
  `lavoro_id` int(11) NOT NULL,
  `lavoratore_email` varchar(50) NOT NULL,
  `titolo` varchar(25) NOT NULL,
  `descrizione` text NOT NULL,
  `allegati` blob NOT NULL,
  `archiviato` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`data`),
  KEY `lavoro_id` (`lavoro_id`),
  KEY `lavoratore_email` (`lavoratore_email`),
  CONSTRAINT `lavoro_proposta_ibfk_1` FOREIGN KEY (`lavoro_id`) REFERENCES `lavoro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lavoro_proposta_ibfk_2` FOREIGN KEY (`lavoratore_email`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lavoro_proposta`
--

LOCK TABLES `lavoro_proposta` WRITE;
/*!40000 ALTER TABLE `lavoro_proposta` DISABLE KEYS */;
INSERT INTO `lavoro_proposta` VALUES ('2021-12-08 16:47:29',20,'andrea.curti@samtrevano.ch','Parrucchiere','Sono un Parrucchiere !','password.txt',1),('2021-12-09 11:32:13',21,'andrea.curti@samtrevano.ch','Giardiniere','io sono un ottimo giardiniere','password.txt',0);
/*!40000 ALTER TABLE `lavoro_proposta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utente`
--

DROP TABLE IF EXISTS `utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utente` (
  `email` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `nomeRuolo` enum('amministratore','datore','lavoratore') NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utente`
--

LOCK TABLES `utente` WRITE;
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` VALUES ('andrea.curti@samtrevano.ch','033b54379f35a3a7864555e840dc4c54a59cdee842cf134f3a9e008d86265657','lavoratore'),('dilix59965@tinydef.com','6239b479b97a15a5a494351afcc22b5b85627f37250649713c0d6f4d1d10100a','datore'),('gioele.cavallo@samtrevano.ch','a5fd322d7b96dd875ed907d12c0883ace02938314dd6cd9c8eabbd0027794b8c','lavoratore'),('gioele.zanetti@samtrevano.ch','a5fd322d7b96dd875ed907d12c0883ace02938314dd6cd9c8eabbd0027794b8c','datore'),('miro.joos@samtrevano.ch','4d61fefcf6ea734eaa0de4e7c150f1d075ce9b6b6da2a3f189a51be8c240bc11','datore'),('samuele.abba@samtrevano.ch','6239b479b97a15a5a494351afcc22b5b85627f37250649713c0d6f4d1d10100a','amministratore');
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-19 16:10:31
