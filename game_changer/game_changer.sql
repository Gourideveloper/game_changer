-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 12:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game_changer`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `assessment_id` int(11) NOT NULL,
  `athlete_id` int(11) NOT NULL,
  `team_movement_id` int(11) NOT NULL,
  `assessment_date` date NOT NULL,
  `numerical_value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`assessment_id`, `athlete_id`, `team_movement_id`, `assessment_date`, `numerical_value`) VALUES
(1, 9, 34, '2023-11-09', 17.7),
(2, 5, 34, '2023-11-09', 17.2),
(3, 6, 34, '2023-11-09', 17),
(4, 7, 34, '2023-11-09', 17.5),
(5, 8, 34, '2023-11-09', 14.4),
(6, 10, 34, '2023-11-09', 17.6),
(7, 5, 35, '2023-11-09', 17.8),
(8, 6, 35, '2023-11-09', 16.3),
(9, 7, 35, '2023-11-09', 14.8),
(10, 8, 35, '2023-11-09', 15.9),
(11, 9, 35, '2023-11-09', 17.2),
(12, 10, 35, '2023-11-09', 15.9),
(13, 5, 34, '2023-11-10', 17.6),
(14, 6, 34, '2023-11-10', 17.5),
(15, 7, 34, '2023-11-10', 17.7),
(16, 8, 34, '2023-11-10', 16),
(17, 9, 34, '2023-11-10', 17.4),
(18, 10, 34, '2023-11-10', 17.5),
(19, 5, 34, '2023-11-11', 17.4),
(20, 5, 34, '2023-11-12', 17.6),
(21, 5, 34, '2023-11-13', 17.2),
(22, 5, 34, '2023-11-14', 17.6),
(23, 5, 34, '2023-11-15', 17.4);

-- --------------------------------------------------------

--
-- Table structure for table `athletes`
--

CREATE TABLE `athletes` (
  `athlete_id` int(11) NOT NULL,
  `athlete_name` varchar(250) NOT NULL,
  `athlete_SID` varchar(30) NOT NULL,
  `athlete_age` int(11) NOT NULL,
  `athlete_height` float NOT NULL,
  `athlete_weight` float NOT NULL,
  `athlete_status` varchar(100) NOT NULL,
  `athlete_team_id` int(11) NOT NULL,
  `athlete_image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `athletes`
--

INSERT INTO `athletes` (`athlete_id`, `athlete_name`, `athlete_SID`, `athlete_age`, `athlete_height`, `athlete_weight`, `athlete_status`, `athlete_team_id`, `athlete_image`) VALUES
(1, ' Virat Kohli', '919123455                     ', 39, 5.8, 198, 'Active', 3, '919123454.jpg'),
(5, '   Mahendra Singh Dhoni                        ', ' 919123459                    ', 42, 5.11, 191.8, 'Inactive', 1, '919123459.jpg'),
(6, 'Robert', '602546', 26, 6.1, 160, 'Active', 1, '602546.jpg'),
(7, 'Allyson Felix', '919123460', 38, 5.9, 68, 'Active', 1, '919123460.jpg'),
(8, 'Carl Lewis', '919123461', 47, 6, 98, 'Inactive', 1, '919123461.jpeg'),
(9, 'Torri Huske', '919123462', 26, 5.1, 70.8, 'Active', 1, '919123462.jpeg'),
(10, 'Noah Lyles', '919123467', 45, 5.11, 89.7, 'Active', 1, '919123467.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `id` int(11) NOT NULL,
  `coach_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`id`, `coach_name`, `name`, `password`) VALUES
(1, 'admin', 'Game Changer', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `movements`
--

CREATE TABLE `movements` (
  `movement_id` int(11) NOT NULL,
  `movement_name` varchar(500) NOT NULL,
  `movement_units` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movements`
--

INSERT INTO `movements` (`movement_id`, `movement_name`, `movement_units`) VALUES
(3, 'BB Split Squat', 'lbs'),
(4, 'DB Reverse Lunge', '  lbs'),
(7, 'Hex Bar Jump (1.75 m/s)', '   lbs'),
(8, 'Hex Bar Jump (2.00 m/s)', 'lbs'),
(9, 'Hex Bar Jump (2.25 m/s)', 'lbs'),
(10, 'Back Squat (0.90 m/s)', 'lbs'),
(11, 'Back Squat (0.75 m/s)', 'lbs'),
(12, 'Back Squat (0.60 m/s)', 'lbs'),
(13, 'Bench Press (0.85 m/s)', 'lbs'),
(14, 'Bench Press (0.65 m/s)', 'lbs'),
(15, 'Bench Press (0.45 m/s)', 'lbs'),
(16, '10 yard fly sprint', 's'),
(17, 'Vertical', 'in'),
(18, 'Bodyweight', 'lbs'),
(19, 'DB Split Squat', 'lbs'),
(20, 'Goblet Split Squat', 'lbs'),
(21, 'Goblet Reverse Lunge', 'lbs'),
(23, 'BB Reverse Lunge', 'lbs');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `team_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `team_image`) VALUES
(1, 'Basket Ball', 'Basket Ball.jpg'),
(2, 'Soccer', 'Soccer.jpg'),
(3, 'Cross Country', 'Cross Country.JPG'),
(4, 'Tennis', 'Tennis.jpeg'),
(6, 'Softball', 'Softball.jpg'),
(7, 'Track and Field', 'Track and Field.jpg'),
(8, 'Volleyball', 'Volleyball.jpg'),
(9, 'Baseball', 'Baseball.jpg'),
(11, 'Golf', 'Golf Game.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `team_movements`
--

CREATE TABLE `team_movements` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `movement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_movements`
--

INSERT INTO `team_movements` (`id`, `team_id`, `movement_id`) VALUES
(34, 1, 3),
(35, 1, 4),
(36, 1, 7),
(37, 1, 8),
(38, 1, 9),
(39, 1, 10),
(40, 1, 11),
(41, 1, 12),
(42, 1, 13),
(43, 1, 14),
(44, 1, 15),
(45, 1, 16),
(46, 1, 17),
(47, 1, 18),
(48, 1, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`assessment_id`);

--
-- Indexes for table `athletes`
--
ALTER TABLE `athletes`
  ADD PRIMARY KEY (`athlete_id`),
  ADD UNIQUE KEY `athlete_SID` (`athlete_SID`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`movement_id`),
  ADD UNIQUE KEY `movement_name` (`movement_name`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`),
  ADD UNIQUE KEY `team_name` (`team_name`);

--
-- Indexes for table `team_movements`
--
ALTER TABLE `team_movements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `athletes`
--
ALTER TABLE `athletes`
  MODIFY `athlete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coach`
--
ALTER TABLE `coach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movements`
--
ALTER TABLE `movements`
  MODIFY `movement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `team_movements`
--
ALTER TABLE `team_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
