-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 12:17 PM
-- Server version: 8.0.38
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gate_pass_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `gatekeepers`
--

CREATE TABLE `gatekeepers` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gatekeepers`
--

INSERT INTO `gatekeepers` (`id`, `email`, `password`, `name`) VALUES
(1, 'gatekeeper@example.com', '$2y$10$b1QRrrOkmje3e2kbF4CGoOs4TjBehTM9bPOuNbIv4zwAQzC84whum', 'Mr. Jones');

-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

CREATE TABLE `hod` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hod`
--

INSERT INTO `hod` (`id`, `email`, `password`, `name`) VALUES
(1, 'hod@example.com', '$2y$10$b1QRrrOkmje3e2kbF4CGoOs4TjBehTM9bPOuNbIv4zwAQzC84whum', 'Dr. Smith');

-- --------------------------------------------------------

--
-- Table structure for table `passes`
--

CREATE TABLE `passes` (
  `id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `request_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `exit_time` datetime DEFAULT NULL,
  `attendance_percentage` decimal(5,2) DEFAULT NULL,
  `parent_phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_general_ci,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `notification_status` enum('pending','sent','failed') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `verification_status` enum('verified') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gatekeeper_decision` enum('allowed','not_allowed','pending') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `is_emergency` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passes`
--

INSERT INTO `passes` (`id`, `student_id`, `request_date`, `exit_time`, `attendance_percentage`, `parent_phone`, `reason`, `status`, `notification_status`, `verification_status`, `gatekeeper_decision`, `is_emergency`) VALUES
(14, 11, '2025-04-13 14:37:01', '2025-04-13 14:36:00', 66.00, '1234567890', 'fever', 'approved', 'sent', 'verified', 'allowed', 0),
(15, 11, '2025-04-14 12:42:46', '2025-04-14 12:42:00', 91.00, '458454', 'fever', 'approved', 'sent', 'verified', 'not_allowed', 0),
(16, 11, '2025-04-14 12:46:30', '2025-04-14 12:45:00', 91.00, '95945184534', 'fever', 'approved', 'sent', 'verified', 'allowed', 0),
(17, 11, '2025-04-14 13:21:01', '2025-04-14 13:20:00', 91.00, '9959450821', 'fever', 'rejected', 'sent', NULL, 'pending', 0),
(19, 11, '2025-04-18 15:32:43', '2025-04-18 15:32:00', 75.00, '9959450821', 'fever', 'pending', 'sent', NULL, 'pending', 0),
(20, 11, '2025-04-18 15:35:46', '2025-04-18 15:35:00', 60.00, '9959450821', 'need to leave to village', 'pending', 'sent', NULL, 'pending', 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `branch` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `attendance_percentage` decimal(5,2) DEFAULT NULL,
  `parent_phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `email`, `password`, `name`, `class`, `branch`, `attendance_percentage`, `parent_phone`) VALUES
(11, '23E51A6664@hitam.org', '$2y$10$qb2Fw/hfB/IWrtof2bByr.JjUDwuHr4.GZtDsxj7bgnvsokRCJppO', 'Sai Kumar', NULL, 'CSM', 0.00, '9959450821'),
(12, '23E51A6650@hitam.org', '$2y$10$qb2Fw/hfB/IWrtof2bByr.JjUDwuHr4.GZtDsxj7bgnvsokRCJppO', 'K. Vennela', NULL, 'CSM', 0.00, ''),
(13, '23E51A6651@hitam.org', '$2y$10$qb2Fw/hfB/IWrtof2bByr.JjUDwuHr4.GZtDsxj7bgnvsokRCJppO', 'Kashinathan', NULL, 'CSM', 0.00, ''),
(14, '23E51A6619@hitam.org', '$2y$10$qb2Fw/hfB/IWrtof2bByr.JjUDwuHr4.GZtDsxj7bgnvsokRCJppO', 'B Vishnu', NULL, 'CSM', 0.00, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gatekeepers`
--
ALTER TABLE `gatekeepers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hod`
--
ALTER TABLE `hod`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `passes`
--
ALTER TABLE `passes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gatekeepers`
--
ALTER TABLE `gatekeepers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hod`
--
ALTER TABLE `hod`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `passes`
--
ALTER TABLE `passes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `passes`
--
ALTER TABLE `passes`
  ADD CONSTRAINT `passes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
