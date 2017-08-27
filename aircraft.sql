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
-- Table structure for table `aircraft`
--

DROP TABLE IF EXISTS `aircraft`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aircraft` (
  `id` int(11) NOT NULL,
  `modelId` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `curLocId` int(11) NOT NULL,
  `fuelLevel` int(11) NOT NULL,
  `registration` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hasRadios` tinyint(1) NOT NULL,
  `hasAutopilot` tinyint(1) NOT NULL,
  `hasGps` tinyint(1) NOT NULL,
  `totalTime` time NOT NULL,
  `timeSinceCheck` time NOT NULL,
  `timeSinceOverhaul` int(11) NOT NULL,
  `needsRepair` tinyint(1) NOT NULL,
  `homeLocId` int(11) NOT NULL,
  `rentalCost` decimal(10,2) NOT NULL,
  `distanceBonus` decimal(10,2) NOT NULL,
  `curRenterId` int(11) NOT NULL,
  `rentalExpiration` time NOT NULL,
  `isAirborne` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration` (`registration`),
  UNIQUE KEY `curRenterId` (`curRenterId`),
  KEY `modelId` (`modelId`),
  KEY `ownerId` (`ownerId`),
  KEY `curLocId` (`curLocId`),
  KEY `name` (`name`),
  KEY `homeLocId` (`homeLocId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-27 12:06:14
