-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2025 at 09:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unity`
--

-- --------------------------------------------------------

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
  `level` int(11) NOT NULL,
  `fault` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`level`, `fault`) VALUES
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'Shift to higher gear'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'Shift to higher gear'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Out of road'),
(1, 'Out of road'),
(1, 'Out of road'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'player hit the car'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear'),
(1, 'Out of road'),
(1, 'Out of road'),
(1, 'Shift to higher gear'),
(1, 'Out of road'),
(1, 'Out of road'),
(1, 'Shift to higher gear'),
(1, 'Shift to higher gear');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
