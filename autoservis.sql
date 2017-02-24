-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2015 at 11:38 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autoservis`
--
CREATE DATABASE IF NOT EXISTS `autoservis` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `autoservis`;

-- --------------------------------------------------------

--
-- Table structure for table `artikli`
--

CREATE TABLE IF NOT EXISTS `artikli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tip` int(11) NOT NULL,
  `marka` int(11) NOT NULL,
  `model` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `naziv` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `opis` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `stanje` int(11) NOT NULL,
  `cena` int(11) NOT NULL,
  `dodat` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `artikli`
--

INSERT INTO `artikli` (`id`, `tip`, `marka`, `model`, `naziv`, `opis`, `stanje`, `cena`, `dodat`) VALUES
(1, 2, 1, 'Vectra', 'Far Levi', 'Levi far od plaxiglasa, garancija 12 mes, za tmodel Vectra, godiste od 1998...', 8, 4500, '2015-03-22 10:58:46'),
(2, 1, 1, 'Vectra', 'Desni Bocni', 'Desni bocni retrovizor za model Vectra sa grejacima ogledala i manuelnim podesavanjem... ', 15, 1200, '2015-03-22 10:09:08'),
(4, 4, 2, 'M3', 'OS Lezaj', 'Osovinski lezaj za BMW, godiste od 1997 do 2003, sa garancijom 18mes...', 5, 6320, '2015-03-22 11:22:31'),
(5, 5, 3, 'Megane', 'Metlice F', 'Prednje silikonske metlice sa gumenom oblogom, garancija 6mes...', 20, 1200, '2015-03-22 11:32:38');

-- --------------------------------------------------------

--
-- Table structure for table `kuponi`
--

CREATE TABLE IF NOT EXISTS `kuponi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artikl` int(11) NOT NULL,
  `ime` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `adresa` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `telefon` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `kreiran` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `marke`
--

CREATE TABLE IF NOT EXISTS `marke` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `opis` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `marke`
--

INSERT INTO `marke` (`id`, `naziv`, `opis`) VALUES
(1, 'Opel', 'Opel je nemacki proizvodjac automobila sa sedistem u Riselshajmu kojeg je osnovao Adam Opel 1862. godine.'),
(2, 'BMW', 'Kompanija je osnovana 1916. BMW takodje poseduje i proizvodi MINI brend i Rolls-Royce Motor Cars...'),
(3, 'Reno', 'Reno je naziv francuskog proizvodjaca automobila. Kompanija je osnovana 25. februara 1899. godine.');

-- --------------------------------------------------------

--
-- Table structure for table `tipovi`
--

CREATE TABLE IF NOT EXISTS `tipovi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `opis` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tipovi`
--

INSERT INTO `tipovi` (`id`, `naziv`, `opis`) VALUES
(1, 'Retrovizor', 'Levi, desni retrovizor i ogledalo...'),
(2, 'Svetlo', 'Zadnji, pednji, bocni farovi od stakla i plaxiglasa...'),
(4, 'Lezajevi', 'Prenosni, osovinski i servo lezajevi sa cepom za punjenje...'),
(5, 'Brisaci', 'Prednji i zadnji  brisaci, metlice i specijalni brisaci za farove...');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
