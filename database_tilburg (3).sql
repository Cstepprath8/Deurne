-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 27 feb 2025 om 09:45
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
-- Database: `database tilburg`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

DROP TABLE IF EXISTS `klanten`;
CREATE TABLE IF NOT EXISTS `klanten` (
  `id` int NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(20) NOT NULL,
  `tussenvoegsel` varchar(20) NOT NULL,
  `achternaam` varchar(20) NOT NULL,
  `functie` varchar(20) NOT NULL,
  `e-mail` varchar(100) NOT NULL,
  `telefoonnummer` int NOT NULL,
  `woonplaats` varchar(20) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `straatnaam` varchar(20) NOT NULL,
  `huisnummer` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opdrachten`
--

DROP TABLE IF EXISTS `opdrachten`;
CREATE TABLE IF NOT EXISTS `opdrachten` (
  `id` int NOT NULL AUTO_INCREMENT,
  `klantnaam` varchar(20) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `omschrijving` varchar(1000) NOT NULL,
  `aanvraagdatum` date NOT NULL,
  `benodigde kennis` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uren`
--

DROP TABLE IF EXISTS `uren`;
CREATE TABLE IF NOT EXISTS `uren` (
  `id` int NOT NULL,
  `dag` date NOT NULL,
  `vanaf` time NOT NULL,
  `tot` time NOT NULL,
  `pauze (minuten)` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `uren`
--

INSERT INTO `uren` (`id`, `dag`, `vanaf`, `tot`, `pauze (minuten)`) VALUES
(1, '2025-02-17', '10:00:00', '17:00:00', 30);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werknemers`
--

DROP TABLE IF EXISTS `werknemers`;
CREATE TABLE IF NOT EXISTS `werknemers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(20) NOT NULL,
  `tussenvoegsel` varchar(20) NOT NULL,
  `achternaam` varchar(20) NOT NULL,
  `geboortedatum` varchar(10) NOT NULL,
  `functie` varchar(20) NOT NULL,
  `werkmail` varchar(100) NOT NULL,
  `kantoorruimte` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkzaamheden`
--

DROP TABLE IF EXISTS `werkzaamheden`;
CREATE TABLE IF NOT EXISTS `werkzaamheden` (
  `id` int NOT NULL,
  `voornaam wn` varchar(20) NOT NULL,
  `tussenvoegsel wn` varchar(20) NOT NULL,
  `achternaam wn` varchar(20) NOT NULL,
  `aantal uren` int NOT NULL,
  `benodigde kennis` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
