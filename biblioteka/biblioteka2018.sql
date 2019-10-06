-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2018 at 06:26 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE IF NOT EXISTS `biblioteka2018` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE biblioteka2018; 

--
-- Database: `biblioteka2018`
--

-- --------------------------------------------------------

--
-- Table structure for table `izdavac`
--

CREATE TABLE `izdavac` (
  `idIzdavac` bigint(20) NOT NULL,
  `nazivIzdavac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pib` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `knjiga`
--

CREATE TABLE `knjiga` (
  `idKnjiga` bigint(20) NOT NULL,
  `nazivKnjiga` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `autor` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `jezik` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `idIzdavac` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `izdavac`
--
ALTER TABLE `izdavac`
  ADD PRIMARY KEY (`idIzdavac`);

--
-- Indexes for table `knjiga`
--
ALTER TABLE `knjiga`
  ADD PRIMARY KEY (`idKnjiga`),
  ADD KEY `idIzdavac` (`idIzdavac`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `izdavac`
--
ALTER TABLE `izdavac`
  MODIFY `idIzdavac` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `knjiga`
--
ALTER TABLE `knjiga`
  MODIFY `idKnjiga` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `knjiga`
--
ALTER TABLE `knjiga`
  ADD CONSTRAINT `knjiga_ibfk_1` FOREIGN KEY (`idIzdavac`) REFERENCES `izdavac` (`idIzdavac`);
  
--
-- Dumping data for table `izdavac`
--

INSERT INTO `izdavac` (`idIzdavac`, `nazivIzdavac`, `pib`) VALUES
(1, 'Mikro knjiga', '112233445566'),
(2, 'CET', '445566332211'),
(3, 'Kompjuter biblioteka', '225533661144');

-- --------------------------------------------------------
 
--
-- Dumping data for table `knjiga`
--

INSERT INTO `knjiga` (`idKnjiga`, `nazivKnjiga`, `autor`, `jezik`, `idIzdavac`) VALUES
(1, 'Android kuvar - Probllemi i rešenja namenjeni programerima aplikacija za Android', 'Ian F. Darwin', 'Srpski - Prevod sa Engleskog.', 1),
(2, 'Android programirajne - bez oklevanja', 'Dawn Griffiths, David Griffiths', 'Srpski - Prevod sa Engleskog', 2),
(3, 'Android Studio IDE kuvar za razvoj aplikacija', 'Rick Boyer, Kyle Mew', 'Srpski - Prevod sa Engleskog', 3);
  
CREATE USER 'biblio_korisnik'@'localhost' IDENTIFIED BY 'mtip2018';
GRANT ALL PRIVILEGES ON biblioteka2018.* TO  'biblio_korisnik'@'localhost';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
