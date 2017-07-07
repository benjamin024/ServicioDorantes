-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: taller
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `Auto`
--

DROP TABLE IF EXISTS `Auto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Auto` (
  `placas` varchar(8) NOT NULL,
  `marca` varchar(25) DEFAULT NULL,
  `submarca` varchar(25) DEFAULT NULL,
  `modelo` varchar(5) DEFAULT NULL,
  `cliente` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`placas`),
  KEY `cliente` (`cliente`),
  CONSTRAINT `Auto_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `Cliente` (`IDCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Auto`
--

LOCK TABLES `Auto` WRITE;
/*!40000 ALTER TABLE `Auto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Auto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cliente`
--

DROP TABLE IF EXISTS `Cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cliente` (
  `IDCliente` varchar(8) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido` varchar(30) DEFAULT NULL,
  `telefono` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IDCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cliente`
--

LOCK TABLES `Cliente` WRITE;
/*!40000 ALTER TABLE `Cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `Cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Orden`
--

DROP TABLE IF EXISTS `Orden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orden` (
  `folio` varchar(8) NOT NULL,
  `cliente` varchar(8) DEFAULT NULL,
  `auto` varchar(8) DEFAULT NULL,
  `kilometraje` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`folio`),
  KEY `cliente` (`cliente`),
  KEY `auto` (`auto`),
  CONSTRAINT `Orden_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `Cliente` (`IDCliente`),
  CONSTRAINT `Orden_ibfk_2` FOREIGN KEY (`auto`) REFERENCES `Auto` (`placas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Orden`
--

LOCK TABLES `Orden` WRITE;
/*!40000 ALTER TABLE `Orden` DISABLE KEYS */;
/*!40000 ALTER TABLE `Orden` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Presupuesto`
--

DROP TABLE IF EXISTS `Presupuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Presupuesto` (
  `folio` varchar(8) NOT NULL,
  `cliente` varchar(50) DEFAULT NULL,
  `auto` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`folio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Presupuesto`
--

LOCK TABLES `Presupuesto` WRITE;
/*!40000 ALTER TABLE `Presupuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Presupuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Trabajo`
--

DROP TABLE IF EXISTS `Trabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Trabajo` (
  `IDTrabajo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `manoObra` float DEFAULT NULL,
  `refacciones` float DEFAULT NULL,
  `ordenPresupuesto` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`IDTrabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Trabajo`
--

LOCK TABLES `Trabajo` WRITE;
/*!40000 ALTER TABLE `Trabajo` DISABLE KEYS */;
/*!40000 ALTER TABLE `Trabajo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuario` (
  `user` varchar(20) NOT NULL,
  `pass` varchar(20) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `direccion` text,
  `telefono` varchar(11) DEFAULT NULL,
  `celular` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES ('serviciodorantes','servicio','Ing. Benjamín Dorantes Pérez','Lago Musters No. 74 Col. Argentina Antigua, Miguel Hidalgo, Ciudad de México. C.P.: 11270','55277025','5523380682','servicio_dorantes@hotmail.com');
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-06 16:52:16
