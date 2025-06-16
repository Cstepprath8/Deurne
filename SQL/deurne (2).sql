-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 13 jun 2025 om 08:03
-- Serverversie: 9.1.0
-- PHP-versie: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deurne`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `facturen`
--

DROP TABLE IF EXISTS `facturen`;
CREATE TABLE IF NOT EXISTS `facturen` (
  `factuur_id` int NOT NULL AUTO_INCREMENT,
  `klant_id` int DEFAULT NULL,
  `opdracht_id` int DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `totaalbedrag` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`factuur_id`),
  KEY `klant_id` (`klant_id`),
  KEY `opdracht_id` (`opdracht_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `facturen`
--

INSERT INTO `facturen` (`factuur_id`, `klant_id`, `opdracht_id`, `datum`, `totaalbedrag`) VALUES
(1, 1, 1, '2025-05-15', 250.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `factuurregels`
--

DROP TABLE IF EXISTS `factuurregels`;
CREATE TABLE IF NOT EXISTS `factuurregels` (
  `regel_id` int NOT NULL AUTO_INCREMENT,
  `factuur_id` int DEFAULT NULL,
  `medewerker_id` int DEFAULT NULL,
  `aantal_uren` decimal(5,2) DEFAULT NULL,
  `uurtarief` decimal(10,2) DEFAULT NULL,
  `totaal_regelbedrag` decimal(10,2) DEFAULT NULL,
  `omschrijving` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`regel_id`),
  KEY `factuur_id` (`factuur_id`),
  KEY `medewerker_id` (`medewerker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten_db`
--

DROP TABLE IF EXISTS `klanten_db`;
CREATE TABLE IF NOT EXISTS `klanten_db` (
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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `klanten_db`
--

INSERT INTO `klanten_db` (`ID`, `Bedrijfsnaam`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Functie`, `Email`, `Telefoonnummer`, `Adres`) VALUES
(1, 'Tech Innovations', 'Jan', 'de', 'Vries', 'Software Developer', 'jan.devries@techinnovations.com', '06 12345678', 'Laan van de Innovatie 10, 1234 AB Amsterdam'),
(2, 'Green Solutions', 'Maria', 'van', 'Dijk', 'Marketing Manager', 'maria.vandijk@greensolutions.nl', '06 23456789', 'Groenstraat 20, 5678 CD Rotterdam'),
(3, 'Bright Future Consulting', 'Tom', 'van', 'Berg', 'Projectleider', 'tom.vandenberg@brightfutureconsulting.nl', '06 34567890', 'ilgenlaan 5, 1122 EF Utrecht'),
(4, 'Creative Design Studio', 'Sophie', 'de', 'Jong', 'Grafisch Ontwerper', 'sophie.dejong@creativedesignstudio.com', '06 45678901', 'Designstraat 15, 3344 GH Den Haag'),
(5, 'Smart Logistics', 'David', 'van', 'Laar', 'Logistiek Coördinator', 'david.vanlaar@smartlogistics.nl', '06 56789012', 'Transportweg 25, 4433 IJ Zwolle'),
(50, 'PixelFusion B.V.', 'Laura', 'De', 'Vries', 'Projectmanager', 'laura.devries@pixelfusion.test', '06 53263615', 'Kanaalstraat 12, 5751BC Deurne');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opdrachten`
--

DROP TABLE IF EXISTS `opdrachten`;
CREATE TABLE IF NOT EXISTS `opdrachten` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titel` varchar(100) NOT NULL,
  `omschrijving` varchar(1000) NOT NULL,
  `aanvraagdatum` date NOT NULL,
  `benodigdekennis` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `klant_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `klant_id` (`klant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `opdrachten`
--

INSERT INTO `opdrachten` (`id`, `titel`, `omschrijving`, `aanvraagdatum`, `benodigdekennis`, `klant_id`) VALUES
(1, 'Webservers', 'Als directie van Gilde DevOps Solutions,\r\nwil ik webhostingdiensten verlenen aan klanten,\r\nzodat meerdere klanten binnen Gilde DevOps hun website kunnen uploaden en hosten in een professionele omgeving.', '2025-01-29', '-Kennis over webservers\r\n-Kennis over Software Development\r\n-Kennis over Acces Points', 1),
(2, 'Urenregistratiesysteem', 'Als verkoopmanager van Gilde DevOps Solutions, wil ik een applicatie om opdrachten te beheren en gewerkte uren van medewerkers te krijgen, zodat ik gemakkelijker de gewerkte uren kan factureren naar klanten.', '2025-01-29', '-kennis over webserververs\r\n-kennis over software development', 2),
(3, 'Groepssamenstelling', 'De afgelopen weken zijn er diverse verschuivingen geweest binnen de afdelingen Operations en Development.​\r\nAls gevolg daarvan zijn er nieuwe groepen gevormd.​\r\nBinnen deze groepen moeten er afspraken worden gemaakt over de werkverdeling;​\r\nverantwoordelijkheden; taken en plichten.​', '2025-01-29', '-kennis over Word\r\n-Kennis over een samenwerkingscontracten', 3),
(4, 'Database voor een UrenRegistratieSysteem', 'Als administratief medewerker van Gilde DevOps Solutions, wil ik een database ontworpen en gebouwd hebben, zodat deze kan worden gebruikt voor het urenregistratiesysteem.', '2025-01-29', '-Kennis over sql taal\r\n-kennis over databases', 4),
(5, 'Beheerprocedure Datacenter opstellen', 'Als een hoofd-ICT van Gilde DevOps Solutions,\r\n\r\nwil ik dat er regels en procedures worden opgesteld en gerealiseerd voor het gebruik van de ICT-infrastructuur,\r\n\r\nZodat iedereen weet welke taken er dienen te gebeuren en ook hoe deze bijgedragen aan een veilige omgeving zonder te veel repeterende taken.', '2025-01-29', '-Kennis over webservers\r\n-kennis over infrastructuur\r\n-kennis over domain controllers', 5),
(44, 'Website Redesign', 'Vernieuwing van de bedrijfswebsite met modern design, responsive layout en optimalisatie voor snelheid.', '2025-05-22', '- weten hoe je een website maakt\r\n- code kunnen snappen', 50),
(45, 'Formulier aanmaken', 'er moet een Formulier gemaakt worden.', '2025-05-12', '- je moet een website kunnen maken\r\n- je moet code kunnen schrijven', 1),
(46, 'Grafiek maken', 'er moet een grafiek worden gemaakt die op een website moet komen.', '2025-04-28', '- weten hoe je een grafiek maakt\r\n- je moet code kunnen schijven', 1),
(47, 'Website responsive maken', 'je moet een website responsive maken van een bestaande website', '2024-09-18', '- je kan een website responsive maken\r\n- je moet code kunnen schrijven', 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werknemers_db`
--

DROP TABLE IF EXISTS `werknemers_db`;
CREATE TABLE IF NOT EXISTS `werknemers_db` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Voornaam` varchar(255) DEFAULT NULL,
  `Tussenvoegsels` varchar(50) DEFAULT NULL,
  `Achternaam` varchar(255) DEFAULT NULL,
  `GeboorteDatum` varchar(50) DEFAULT NULL,
  `Functie` varchar(100) DEFAULT NULL,
  `Werkmail` varchar(60) DEFAULT NULL,
  `KantoorRuimte` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `werknemers_db`
--

INSERT INTO `werknemers_db` (`ID`, `Voornaam`, `Tussenvoegsels`, `Achternaam`, `GeboorteDatum`, `Functie`, `Werkmail`, `KantoorRuimte`) VALUES
(1, 'Colin', '', 'Stepprath', '22-5-2008', 'SD', 'Colin.Stepprath@Student.GildeOpleidingen.nl', 'B309'),
(2, 'Jan', '', 'Brouwers', '29-11-2006', 'ITSD', 'jan.brouwers@student.gildeopleidingen.nl', 'B309'),
(3, 'Asherah', '', 'Braun', '2-8-2004', 'ITSD', 'Asherah.Braun@student.gildeopleidingen.nl', 'B309'),
(5, 'Sharuyan', '', 'Sinnathurai', '5-5-2007', 'SD', 'Sharuyan.sinnathurai@student.gildeopleidingen.nl', 'B309'),
(24, 'Daria', '', 'hryn', '2008-03-26', 'SD', 'Daria.hryn@student.gildeopleidingen.nl', 'B309');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkzaamheden`
--

DROP TABLE IF EXISTS `werkzaamheden`;
CREATE TABLE IF NOT EXISTS `werkzaamheden` (
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
  `Jaar` int NOT NULL,
  `record_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`record_id`),
  KEY `opdracht_id` (`opdracht_id`),
  KEY `medewerker_id` (`medewerker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `werkzaamheden`
--

INSERT INTO `werkzaamheden` (`ID`, `Week`, `VoornaamMedewerker`, `TussenVoegselMedewerker`, `AchternaamMedewerker`, `Omschrijvingwerkzaamheden`, `Projectnaam`, `Aantaluren`, `opdracht_id`, `medewerker_id`, `Jaar`, `record_id`) VALUES
(1, 9, 'Jan', '-', 'Brouwers', 'US2', 'Ubuntu', '02:45', NULL, NULL, 2022, 1),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'BeheerProcedure', '03:40', NULL, NULL, 2022, 2),
(1, 9, 'Jan', '-', 'Brouwers', 'US4', 'Backup IIS', '02:30', NULL, NULL, 2023, 3),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'Backup IIS', '02:30', NULL, NULL, 2024, 4),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'BeheerProcedure', '03:40', NULL, NULL, 2024, 5),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'DC 2 Uit', '01:20', NULL, NULL, 2023, 6),
(2, 9, 'Colin', '-', 'Stepprath', 'US4', 'DataBase', '02:50', NULL, NULL, 2022, 7),
(2, 9, 'Colin', '-', 'Stepprath', 'US4', 'ZoekOptie', '03:30', NULL, NULL, 2023, 8),
(2, 9, 'Colin', '-', 'Stepprath', 'Training', 'SD Opdracht', '01:35', NULL, NULL, 2024, 9),
(2, 9, 'Colin', '-', 'Stepprath', 'US4', 'ZoekOptie', '03:30', NULL, NULL, 2024, 10),
(3, 9, 'Asherah', '-', 'Braun', 'US4', 'UrenRegistratie', '02:10', NULL, NULL, 2022, 11),
(3, 9, 'Asherah', '-', 'Braun', 'ZIW', 'Exel', '02:05', NULL, NULL, 2024, 12),
(3, 9, 'Asherah', '-', 'Braun', 'US4', 'UrenRegistratie', '02:10', NULL, NULL, 2023, 13),
(5, 9, 'Sharuyan', '-', 'Sinnathurai', 'Training', 'Ubuntu/PHP Downloaden', '01:30', NULL, NULL, 2022, 18),
(5, 9, 'Sharuyan', '-', 'Sinnathurai', '-', 'Grafiek maken', '03:00', NULL, NULL, 2023, 19),
(NULL, 21, 'Colin', '', 'Stepprath', 'Website Redesign', 'US2', '03:45', 44, NULL, 2024, 20),
(NULL, 21, 'Sharuyan', '', 'Sinnathurai', 'formulier aangemaakt', 'US2', '05:00', 45, NULL, 2025, 21),
(NULL, 22, 'Colin', '', 'Stepprath', 'Grafiek gemaakt', 'US2', '09:15', 46, NULL, 2022, 22),
(NULL, 22, 'Colin', '', 'Stepprath', 'website responsive gemaakt', 'US2', '04:00', 47, NULL, 2025, 23),
(NULL, 22, 'Colin', '', 'Stepprath', 'Website gemaakt voor de Groepsamenstelling', 'US2', '09:45', 3, NULL, 2025, 24),
(NULL, 23, 'Daria', '', 'hryn', 'Formulier maken', 'US2', '05:00', 45, 24, 2025, 53),
(NULL, 22, 'Jan', '', 'Brouwers', 'redesign', 'US2', '01:00', 44, 2, 2025, 54),
(NULL, 23, 'Colin', '', 'Stepprath', 'website responsive gemaakt', 'US1', '01:00', 1, 1, 2025, 55);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `facturen`
--
ALTER TABLE `facturen`
  ADD CONSTRAINT `facturen_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `klanten_db` (`ID`),
  ADD CONSTRAINT `facturen_ibfk_2` FOREIGN KEY (`opdracht_id`) REFERENCES `opdrachten` (`id`);

--
-- Beperkingen voor tabel `factuurregels`
--
ALTER TABLE `factuurregels`
  ADD CONSTRAINT `factuurregels_ibfk_1` FOREIGN KEY (`factuur_id`) REFERENCES `facturen` (`factuur_id`),
  ADD CONSTRAINT `factuurregels_ibfk_2` FOREIGN KEY (`medewerker_id`) REFERENCES `werknemers_db` (`ID`);

--
-- Beperkingen voor tabel `opdrachten`
--
ALTER TABLE `opdrachten`
  ADD CONSTRAINT `opdrachten_ibfk_1` FOREIGN KEY (`klant_id`) REFERENCES `klanten_db` (`ID`);

--
-- Beperkingen voor tabel `werkzaamheden`
--
ALTER TABLE `werkzaamheden`
  ADD CONSTRAINT `werkzaamheden_ibfk_1` FOREIGN KEY (`opdracht_id`) REFERENCES `opdrachten` (`id`),
  ADD CONSTRAINT `werkzaamheden_ibfk_2` FOREIGN KEY (`medewerker_id`) REFERENCES `werknemers_db` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
