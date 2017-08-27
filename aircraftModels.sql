-- MySQL dump 10.15  Distrib 10.0.26-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: simdeliveries
-- ------------------------------------------------------
-- Server version	10.0.26-MariaDB

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
-- Table structure for table `aircraftModels`
--

DROP TABLE IF EXISTS `aircraftModels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aircraftModels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subModel` varchar(255) NOT NULL,
  `engine` int(11) NOT NULL,
  `numEngines` int(11) NOT NULL,
  `defaultRadios` tinyint(1) NOT NULL,
  `defaultAutopilot` tinyint(1) NOT NULL,
  `defaultGps` tinyint(1) NOT NULL,
  `fuelCapacity` int(11) NOT NULL,
  `flightRange` int(11) NOT NULL,
  `basePrice` decimal(20,2) NOT NULL,
  `numSeats` int(11) NOT NULL,
  `cargoCapacity` int(11) NOT NULL,
  `type` enum('l','s','h') NOT NULL COMMENT 'l=land, s=sea, h=heli',
  `amphibianAvailable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `manufacturer` (`manufacturer`),
  KEY `name` (`name`),
  KEY `subModel` (`subModel`),
  KEY `engine` (`engine`),
  KEY `numEngines` (`numEngines`),
  KEY `defaultRadios` (`defaultRadios`),
  KEY `defaultAutopilot` (`defaultAutopilot`),
  KEY `defaultGps` (`defaultGps`),
  KEY `basePrice` (`basePrice`),
  KEY `flightRange` (`flightRange`),
  KEY `fuelCapacity` (`fuelCapacity`),
  CONSTRAINT `aircraftModels_ibfk_1` FOREIGN KEY (`manufacturer`) REFERENCES `aircraftManufacturers` (`id`),
  CONSTRAINT `aircraftModels_ibfk_2` FOREIGN KEY (`engine`) REFERENCES `engineModels` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-27 14:03:38
