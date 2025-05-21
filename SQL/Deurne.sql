-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: csv_db 5
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `facturen`
--

DROP TABLE IF EXISTS `facturen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturen` (
  `factuur_id` int NOT NULL AUTO_INCREMENT,
  `klant_id` int DEFAULT NULL,
  `opdracht_id` int DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `totaalbedrag` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`factuur_id`),
  KEY `klant_id` (`klant_id`),
  KEY `opdracht_id` (`opdracht_id`),
  CONSTRAINT `facturen_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `klanten_db` (`ID`),
  CONSTRAINT `facturen_ibfk_2` FOREIGN KEY (`opdracht_id`) REFERENCES `opdrachten` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturen`
--

LOCK TABLES `facturen` WRITE;
/*!40000 ALTER TABLE `facturen` DISABLE KEYS */;
INSERT INTO `facturen` VALUES (1,1,1,'2025-05-15',250.00);
/*!40000 ALTER TABLE `facturen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factuurregels`
--

DROP TABLE IF EXISTS `factuurregels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factuurregels` (
  `regel_id` int NOT NULL AUTO_INCREMENT,
  `factuur_id` int DEFAULT NULL,
  `medewerker_id` int DEFAULT NULL,
  `aantal_uren` decimal(5,2) DEFAULT NULL,
  `uurtarief` decimal(10,2) DEFAULT NULL,
  `totaal_regelbedrag` decimal(10,2) DEFAULT NULL,
  `omschrijving` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`regel_id`),
  KEY `factuur_id` (`factuur_id`),
  KEY `medewerker_id` (`medewerker_id`),
  CONSTRAINT `factuurregels_ibfk_1` FOREIGN KEY (`factuur_id`) REFERENCES `facturen` (`factuur_id`),
  CONSTRAINT `factuurregels_ibfk_2` FOREIGN KEY (`medewerker_id`) REFERENCES `werknemers_db` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factuurregels`
--

LOCK TABLES `factuurregels` WRITE;
/*!40000 ALTER TABLE `factuurregels` DISABLE KEYS */;
/*!40000 ALTER TABLE `factuurregels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klanten_db`
--

DROP TABLE IF EXISTS `klanten_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `klanten_db` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Bedrijfsnaam` varchar(255) DEFAULT NULL,
  `Voornaam` varchar(255) DEFAULT NULL,
  `Tussenvoegsel` varchar(50) DEFAULT NULL,
  `Achternaam` varchar(255) DEFAULT NULL,
  `Functie` varchar(50) DEFAULT NULL,
  `Email` varchar(60) DEFAULT NULL,
  `Telefoonnummer` varchar(50) DEFAULT NULL,
  `Adres` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klanten_db`
--

LOCK TABLES `klanten_db` WRITE;
/*!40000 ALTER TABLE `klanten_db` DISABLE KEYS */;
INSERT INTO `klanten_db` VALUES (1,'Tech Innovations','Jan','de','Vries','Software Developer','jan.devries@techinnovations.com','06 12345678','Laan van de Innovatie 10, 1234 AB Amsterdam'),(2,'Green Solutions','Maria','van','Dijk','Marketing Manager','maria.vandijk@greensolutions.nl','06 23456789','Groenstraat 20, 5678 CD Rotterdam'),(3,'Bright Future Consulting','Tom','van','Berg','Projectleider','tom.vandenberg@brightfutureconsulting.nl','06 34567890','ilgenlaan 5, 1122 EF Utrecht'),(4,'Creative Design Studio','Sophie','de','Jong','Grafisch Ontwerper','sophie.dejong@creativedesignstudio.com','06 45678901','Designstraat 15, 3344 GH Den Haag'),(5,'Smart Logistics','David','van','Laar','Logistiek Coördinator','david.vanlaar@smartlogistics.nl','06 56789012','Transportweg 25, 4433 IJ Zwolle'),(22,'Test BV','Klaas','','Klant','Eigenaar','klaas@testbv.nl','0612345678','Straat 1, 1234 AB Plaats');
/*!40000 ALTER TABLE `klanten_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opdrachten`
--

DROP TABLE IF EXISTS `opdrachten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opdrachten` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titel` varchar(100) NOT NULL,
  `omschrijving` varchar(1000) NOT NULL,
  `aanvraagdatum` date NOT NULL,
  `benodigdekennis` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `klant_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `klant_id` (`klant_id`),
  CONSTRAINT `opdrachten_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `klanten_db` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opdrachten`
--

LOCK TABLES `opdrachten` WRITE;
/*!40000 ALTER TABLE `opdrachten` DISABLE KEYS */;
INSERT INTO `opdrachten` VALUES (1,'Webservers','Als directie van Gilde DevOps Solutions,\r\nwil ik webhostingdiensten verlenen aan klanten,\r\nzodat meerdere klanten binnen Gilde DevOps hun website kunnen uploaden en hosten in een professionele omgeving.','2025-01-29','-Kennis over webservers\r\n-Kennis over Software Development\r\n-Kennis over Acces Points',NULL),(2,'Urenregistratiesysteem','Als verkoopmanager van Gilde DevOps Solutions, wil ik een applicatie om opdrachten te beheren en gewerkte uren van medewerkers te krijgen, zodat ik gemakkelijker de gewerkte uren kan factureren naar klanten.','2025-01-29','-kennis over webserververs\r\n-kennis over software development',NULL),(3,'Groepssamenstelling','De afgelopen weken zijn er diverse verschuivingen geweest binnen de afdelingen Operations en Development.​\r\nAls gevolg daarvan zijn er nieuwe groepen gevormd.​\r\nBinnen deze groepen moeten er afspraken worden gemaakt over de werkverdeling;​\r\nverantwoordelijkheden; taken en plichten.​','2025-01-29','-kennis over Word\r\n-Kennis over een samenwerkingscontracten',NULL),(4,'Database voor een UrenRegistratieSysteem','Als administratief medewerker van Gilde DevOps Solutions, wil ik een database ontworpen en gebouwd hebben, zodat deze kan worden gebruikt voor het urenregistratiesysteem.','2025-01-29','-Kennis over sql taal\r\n-kennis over databases',NULL),(5,'Beheerprocedure Datacenter opstellen','Als een hoofd-ICT van Gilde DevOps Solutions,\r\n\r\nwil ik dat er regels en procedures worden opgesteld en gerealiseerd voor het gebruik van de ICT-infrastructuur,\r\n\r\nZodat iedereen weet welke taken er dienen te gebeuren en ook hoe deze bijgedragen aan een veilige omgeving zonder te veel repeterende taken.','2025-01-29','-Kennis over webservers\r\n-kennis over infrastructuur\r\n-kennis over domain controllers',NULL),(15,'Website bouwen','WordPress website ontwikkelen inclusief CMS en responsive design','2025-05-15','HTML, CSS, PHP, WordPress',1);
/*!40000 ALTER TABLE `opdrachten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `werknemers_db`
--

DROP TABLE IF EXISTS `werknemers_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `werknemers_db` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Voornaam` varchar(255) DEFAULT NULL,
  `Tussenvoegsels` varchar(50) DEFAULT NULL,
  `Achternaam` varchar(255) DEFAULT NULL,
  `GeboorteDatum` varchar(50) DEFAULT NULL,
  `Functie` varchar(100) DEFAULT NULL,
  `Werkmail` varchar(60) DEFAULT NULL,
  `KantoorRuimte` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `werknemers_db`
--

LOCK TABLES `werknemers_db` WRITE;
/*!40000 ALTER TABLE `werknemers_db` DISABLE KEYS */;
INSERT INTO `werknemers_db` VALUES (1,'Colin','-','Stepprath','22-5-2008','SD','Colin.Stepprath@Student.GildeOpleidingen.nl','B109'),(2,'Jan','-','Brouwerss','29-11-2006','ITSD','jan.brouwers@student.gildeopleidingen.nl','B109'),(3,'Asherah','-','Braun','2-8-2004','ITSD','Asherah.Braun@student.gildeopleidingen.nl','B109'),(4,'Kayra','-','Ozdemir','12-9-2007','ITSD','kayra.ozdemir@student.gildeopleidingen.nl','B109'),(5,'Sharuyan','-','Sinnathurai','5-5-2007','SD','Sharuyan.sinnathurai@student.gildeopleidingen.nl','B109');
/*!40000 ALTER TABLE `werknemers_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `werkzaamheden`
--

DROP TABLE IF EXISTS `werkzaamheden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `werkzaamheden` (
  `ID` int DEFAULT NULL,
  `Week` int DEFAULT NULL,
  `VoornaamMedewerker` varchar(255) DEFAULT NULL,
  `TussenVoegselMedewerker` varchar(50) DEFAULT NULL,
  `AchternaamMedewerker` varchar(255) DEFAULT NULL,
  `Omschrijvingwerkzaamheden` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Projectnaam` varchar(50) DEFAULT NULL,
  `Aantaluren` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `opdracht_id` int DEFAULT NULL,
  `medewerker_id` int DEFAULT NULL,
  KEY `opdracht_id` (`opdracht_id`),
  KEY `medewerker_id` (`medewerker_id`),
  CONSTRAINT `werkzaamheden_ibfk_1` FOREIGN KEY (`opdracht_id`) REFERENCES `opdrachten` (`id`),
  CONSTRAINT `werkzaamheden_ibfk_2` FOREIGN KEY (`medewerker_id`) REFERENCES `werknemers_db` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `werkzaamheden`
--

LOCK TABLES `werkzaamheden` WRITE;
/*!40000 ALTER TABLE `werkzaamheden` DISABLE KEYS */;
INSERT INTO `werkzaamheden` VALUES (1,9,'Jan','-','Brouwers','US2','Ubuntu','02:45',NULL,NULL),(1,9,'Jan','-','Brouwers','US5','BeheerProcedure','03:40',NULL,NULL),(1,9,'Jan','-','Brouwers','US4','Backup IIS','02:30',NULL,NULL),(1,9,'Jan','-','Brouwers','US5','Backup IIS','02:30',NULL,NULL),(1,9,'Jan','-','Brouwers','US5','BeheerProcedure','03:40',NULL,NULL),(1,9,'Jan','-','Brouwers','US5','DC 2 Uit','01:20',NULL,NULL),(2,9,'Colin','-','Stepprath','US4','DataBase','02:50',NULL,NULL),(2,9,'Colin','-','Stepprath','US4','ZoekOptie','03:30',NULL,NULL),(2,9,'Colin','-','Stepprath','Training','SD Opdracht','01:35',NULL,NULL),(2,9,'Colin','-','Stepprath','US4','ZoekOptie','03:30',NULL,NULL),(3,9,'Asherah','-','Braun','US4','UrenRegistratie','02:10',NULL,NULL),(3,9,'Asherah','-','Braun','ZIW','Exel','02:05',NULL,NULL),(3,9,'Asherah','-','Braun','US4','UrenRegistratie','02:10',NULL,NULL),(4,9,'Kayra','-','Ozdemir','Training','PHP Opdracht','01:25',NULL,NULL),(4,9,'Kayra','-','Ozdemir','US4','UrenRegistratie','00:35',NULL,NULL),(4,9,'Kayra','-','Ozdemir','ZIW','Exel','02:10',NULL,NULL),(4,9,'Kayra','-','Ozdemir','-','-','-',NULL,NULL),(5,9,'Sharuyan','-','Sinnathurai','Training','Ubuntu/PHP Downloaden','01:30',NULL,NULL),(5,9,'Sharuyan','-','Sinnathurai','-','-','-',NULL,NULL),(45,45,'JOHN','-','DOE','ESD','US10','00:00',NULL,NULL),(12,12,'Bart','V','Heik','Formulie','US7','00:45',NULL,NULL),(3,4,'T','T','T','T','US9','00:00',NULL,NULL),(1,19,'Piet','','Programmeur','Design homepage','Website bouwen','5',1,NULL);
/*!40000 ALTER TABLE `werkzaamheden` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-15 11:38:14
