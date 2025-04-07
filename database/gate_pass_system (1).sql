-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 07, 2025 at 07:23 PM
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
-- Database: `gate_pass_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `gatekeepers`
--

CREATE TABLE `gatekeepers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL
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
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL
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
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `request_date` datetime DEFAULT current_timestamp(),
  `exit_time` datetime DEFAULT NULL,
  `attendance_percentage` decimal(5,2) DEFAULT NULL,
  `parent_phone` varchar(15) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `notification_status` enum('pending','sent','failed') DEFAULT 'pending',
  `verification_status` enum('verified') DEFAULT NULL,
  `gatekeeper_decision` enum('allowed','not_allowed','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `attendance_percentage` decimal(5,2) DEFAULT NULL,
  `parent_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `email`, `password`, `name`, `class`, `branch`, `attendance_percentage`, `parent_phone`) VALUES
(11, '23E51A6664@hitam.org', '$2y$10$qb2Fw/hfB/IWrtof2bByr.JjUDwuHr4.GZtDsxj7bgnvsokRCJppO', 'Sai Kumar', NULL, 'CSM', 0.00, ''),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hod`
--
ALTER TABLE `hod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `passes`
--
ALTER TABLE `passes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
