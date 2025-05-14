-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 14 mei 2025 om 11:05
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
-- Database: `csv_db 5`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten_db`
--

DROP TABLE IF EXISTS `klanten_db`;
CREATE TABLE IF NOT EXISTS `klanten_db` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Bedrijfsnaam` varchar(24) DEFAULT NULL,
  `Voornaam` varchar(6) DEFAULT NULL,
  `Tussenvoegsel` varchar(3) DEFAULT NULL,
  `Achternaam` varchar(5) DEFAULT NULL,
  `Functie` varchar(21) DEFAULT NULL,
  `Email` varchar(40) DEFAULT NULL,
  `Telefoonnummer` varchar(11) DEFAULT NULL,
  `Adres` varchar(43) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `klanten_db`
--

INSERT INTO `klanten_db` (`ID`, `Bedrijfsnaam`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Functie`, `Email`, `Telefoonnummer`, `Adres`) VALUES
(1, 'Tech Innovations', 'Jan', 'de', 'Vries', 'Software Developer', 'jan.devries@techinnovations.com', '06 12345678', 'Laan van de Innovatie 10, 1234 AB Amsterdam'),
(2, 'Green Solutions', 'Maria', 'van', 'Dijk', 'Marketing Manager', 'maria.vandijk@greensolutions.nl', '06 23456789', 'Groenstraat 20, 5678 CD Rotterdam'),
(3, 'Bright Future Consulting', 'Tom', 'van', 'Berg', 'Projectleider', 'tom.vandenberg@brightfutureconsulting.nl', '06 34567890', 'ilgenlaan 5, 1122 EF Utrecht'),
(4, 'Creative Design Studio', 'Sophie', 'de', 'Jong', 'Grafisch Ontwerper', 'sophie.dejong@creativedesignstudio.com', '06 45678901', 'Designstraat 15, 3344 GH Den Haag'),
(5, 'Smart Logistics', 'David', 'van', 'Laar', 'Logistiek Coördinator', 'david.vanlaar@smartlogistics.nl', '06 56789012', 'Transportweg 25, 4433 IJ Zwolle');

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `opdrachten`
--

INSERT INTO `opdrachten` (`id`, `titel`, `omschrijving`, `aanvraagdatum`, `benodigdekennis`) VALUES
(1, 'Webservers', 'Als directie van Gilde DevOps Solutions,\r\nwil ik webhostingdiensten verlenen aan klanten,\r\nzodat meerdere klanten binnen Gilde DevOps hun website kunnen uploaden en hosten in een professionele omgeving.', '2025-01-29', '-Kennis over webservers\r\n-Kennis over Software Development\r\n-Kennis over Acces Points'),
(2, 'Urenregistratiesysteem', 'Als verkoopmanager van Gilde DevOps Solutions, wil ik een applicatie om opdrachten te beheren en gewerkte uren van medewerkers te krijgen, zodat ik gemakkelijker de gewerkte uren kan factureren naar klanten.', '2025-01-29', '-kennis over webserververs\r\n-kennis over software development'),
(3, 'Groepssamenstelling', 'De afgelopen weken zijn er diverse verschuivingen geweest binnen de afdelingen Operations en Development.​\r\nAls gevolg daarvan zijn er nieuwe groepen gevormd.​\r\nBinnen deze groepen moeten er afspraken worden gemaakt over de werkverdeling;​\r\nverantwoordelijkheden; taken en plichten.​', '2025-01-29', '-kennis over Word\r\n-Kennis over een samenwerkingscontracten'),
(4, 'Database voor een UrenRegistratieSysteem', 'Als administratief medewerker van Gilde DevOps Solutions, wil ik een database ontworpen en gebouwd hebben, zodat deze kan worden gebruikt voor het urenregistratiesysteem.', '2025-01-29', '-Kennis over sql taal\r\n-kennis over databases'),
(5, 'Beheerprocedure Datacenter opstellen', 'Als een hoofd-ICT van Gilde DevOps Solutions,\r\n\r\nwil ik dat er regels en procedures worden opgesteld en gerealiseerd voor het gebruik van de ICT-infrastructuur,\r\n\r\nZodat iedereen weet welke taken er dienen te gebeuren en ook hoe deze bijgedragen aan een veilige omgeving zonder te veel repeterende taken.', '2025-01-29', '-Kennis over webservers\r\n-kennis over infrastructuur\r\n-kennis over domain controllers');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werknemers_db`
--

DROP TABLE IF EXISTS `werknemers_db`;
CREATE TABLE IF NOT EXISTS `werknemers_db` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Voornaam` varchar(8) DEFAULT NULL,
  `Tussenvoegsels` varchar(1) DEFAULT NULL,
  `Achternaam` varchar(11) DEFAULT NULL,
  `GeboorteDatum` varchar(10) DEFAULT NULL,
  `Functie` varchar(4) DEFAULT NULL,
  `Werkmail` varchar(48) DEFAULT NULL,
  `KantoorRuimte` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `werknemers_db`
--

INSERT INTO `werknemers_db` (`ID`, `Voornaam`, `Tussenvoegsels`, `Achternaam`, `GeboorteDatum`, `Functie`, `Werkmail`, `KantoorRuimte`) VALUES
(1, 'Colin', '-', 'Stepprath', '22-5-2008', 'SD', 'Colin.Stepprath@Student.GildeOpleidingen.nl', 'B109'),
(2, 'Jan', '-', 'Brouwerss', '29-11-2006', 'ITSD', 'jan.brouwers@student.gildeopleidingen.nl', 'B109'),
(3, 'Asherah', '-', 'Braun', '2-8-2004', 'ITSD', 'Asherah.Braun@student.gildeopleidingen.nl', 'B109'),
(4, 'Kayra', '-', 'Ozdemir', '12-9-2007', 'ITSD', 'kayra.ozdemir@student.gildeopleidingen.nl', 'B109'),
(5, 'Sharuyan', '-', 'Sinnathurai', '5-5-2007', 'SD', 'Sharuyan.sinnathurai@student.gildeopleidingen.nl', 'B109');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkzaamheden`
--

DROP TABLE IF EXISTS `werkzaamheden`;
CREATE TABLE IF NOT EXISTS `werkzaamheden` (
  `ID` int DEFAULT NULL,
  `Week` int DEFAULT NULL,
  `VoornaamMedewerker` varchar(8) DEFAULT NULL,
  `TussenVoegselMedewerker` varchar(1) DEFAULT NULL,
  `AchternaamMedewerker` varchar(11) DEFAULT NULL,
  `Omschrijvingwerkzaamheden` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Projectnaam` varchar(21) DEFAULT NULL,
  `Aantaluren` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `werkzaamheden`
--

INSERT INTO `werkzaamheden` (`ID`, `Week`, `VoornaamMedewerker`, `TussenVoegselMedewerker`, `AchternaamMedewerker`, `Omschrijvingwerkzaamheden`, `Projectnaam`, `Aantaluren`) VALUES
(1, 9, 'Jan', '-', 'Brouwers', 'US2', 'Ubuntu', '02:45'),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'BeheerProcedure', '03:40'),
(1, 9, 'Jan', '-', 'Brouwers', 'US4', 'Backup IIS', '02:30'),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'Backup IIS', '02:30'),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'BeheerProcedure', '03:40'),
(1, 9, 'Jan', '-', 'Brouwers', 'US5', 'DC 2 Uit', '01:20'),
(2, 9, 'Colin', '-', 'Stepprath', 'US4', 'DataBase', '02:50'),
(2, 9, 'Colin', '-', 'Stepprath', 'US4', 'ZoekOptie', '03:30'),
(2, 9, 'Colin', '-', 'Stepprath', 'Training', 'SD Opdracht', '01:35'),
(2, 9, 'Colin', '-', 'Stepprath', 'US4', 'ZoekOptie', '03:30'),
(3, 9, 'Asherah', '-', 'Braun', 'US4', 'UrenRegistratie', '02:10'),
(3, 9, 'Asherah', '-', 'Braun', 'ZIW', 'Exel', '02:05'),
(3, 9, 'Asherah', '-', 'Braun', 'US4', 'UrenRegistratie', '02:10'),
(4, 9, 'Kayra', '-', 'Ozdemir', 'Training', 'PHP Opdracht', '01:25'),
(4, 9, 'Kayra', '-', 'Ozdemir', 'US4', 'UrenRegistratie', '00:35'),
(4, 9, 'Kayra', '-', 'Ozdemir', 'ZIW', 'Exel', '02:10'),
(4, 9, 'Kayra', '-', 'Ozdemir', '-', '-', '-'),
(5, 9, 'Sharuyan', '-', 'Sinnathurai', 'Training', 'Ubuntu/PHP Downloaden', '01:30'),
(5, 9, 'Sharuyan', '-', 'Sinnathurai', '-', '-', '-'),
(45, 45, 'JOHN', '-', 'DOE', 'ESD', 'US10', '00:00'),
(12, 12, 'Bart', 'V', 'Heik', 'Formulie', 'US7', '00:45'),
(3, 4, 'T', 'T', 'T', 'T', 'US9', '00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
