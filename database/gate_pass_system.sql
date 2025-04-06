-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 06, 2025 at 12:29 PM
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
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `notification_status` enum('pending','sent','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passes`
--

INSERT INTO `passes` (`id`, `student_id`, `request_date`, `exit_time`, `attendance_percentage`, `parent_phone`, `status`, `notification_status`) VALUES
(1, 1, '2025-04-05 20:03:06', '2025-04-06 14:00:00', NULL, NULL, 'approved', 'sent'),
(2, 1, '2025-04-05 20:15:10', '2025-04-07 14:00:00', NULL, NULL, 'pending', 'pending'),
(3, 1, '2025-04-05 22:30:14', '2025-04-09 16:04:00', 52.00, '1234567890', 'pending', 'pending'),
(4, 1, '2025-04-06 00:05:32', '2025-04-09 17:00:00', 82.00, '95945184534', 'pending', 'pending'),
(5, 1, '2025-04-06 00:12:50', '2025-04-09 17:00:00', 82.00, '95945184534', 'rejected', 'sent');

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
(1, 'student@example.com', '$2y$10$b1QRrrOkmje3e2kbF4CGoOs4TjBehTM9bPOuNbIv4zwAQzC84whum', 'John Doe', '12A', 'CSE', 85.50, '1234567890');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
