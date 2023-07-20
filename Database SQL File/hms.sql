-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2023 at 09:28 PM
-- Server version: 10.4.18-MariaDB


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `hms_appointments`
--

CREATE TABLE `hms_appointments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `specialization_id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `consultancy_fee` int(11) NOT NULL,
  `appointment_date` varchar(255) NOT NULL,
  `appointment_time` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Cancelled','Completed','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_appointments`
--

INSERT INTO `hms_appointments` (`id`, `client_id`, `specialization_id`, `consultant_id`, `consultancy_fee`, `appointment_date`, `appointment_time`, `created`, `status`) VALUES
(16, 3, 1, 14, 800, '2022-06-28', '5', '2022-06-27 21:43:08', 'Active'),
(17, 4, 1, 14, 800, '2022-06-29', '5', '2022-06-30 00:04:04', 'Active'),
(18, 37, 1, 14, 1000, '2022-06-29', '2', '2022-06-30 00:04:30', 'Active'),
(19, 5, 1, 14, 0, '2023-06-29', '2', '2023-07-17 23:29:19', 'Active'),
(20, 4, 1, 16, 200, '2023-07-24', '2', '2023-07-20 19:23:36', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `hms_clients`
--

CREATE TABLE `hms_clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_clients`
--

INSERT INTO `hms_clients` (`id`, `name`, `email`, `gender`, `mobile`, `address`, `age`) VALUES
(3, 'Popescu', 'popescu@yahoo.com', 'Male', '1234567890', 'Pipariya', 20),
(4, 'Ionescu', 'ionescu@gmail.com', 'Male', '12345678900', 'dsdgsd', 35),
(5, 'Maria', '', 'Male', '1234567890', 'tut', 33),
(37, 'Greg', 'greg@phpzag.com', 'Male', '1234567890', 'Pipariya', 20);

-- --------------------------------------------------------

--
-- Table structure for table `hms_consultant`
--

CREATE TABLE `hms_consultant` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  `specialization` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_consultant`
--

INSERT INTO `hms_consultant` (`id`, `name`, `email`, `address`, `mobile`, `fee`, `specialization`) VALUES
(14, 'Satish ', 'satis@phpzag.com', 'Pipariya', '1234567890', 45000, 1),
(15, 'Any Flower', 'andy@phpzag.com', 'sfasfasfasfas', '123456789', 1000, 2),
(16, 'Smith', 'smith@phpzag.com', 'dsfdsgd', '1234567890', 1200, 5),
(17, 'Tim', 'tim@phpzag.com', 'fdhfhdf', '1234567890', 700, 3),
(18, 'Chris', '', '', '123456789', 1100, 6);

-- --------------------------------------------------------

--
-- Table structure for table `hms_slots`
--

CREATE TABLE `hms_slots` (
  `id` int(11) NOT NULL,
  `slots` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_slots`
--

INSERT INTO `hms_slots` (`id`, `slots`) VALUES
(2, '09:00 AM'),
(5, '10:30 AM'),
(8, '12:00 PM'),
(11, '13:00 PM'),
(12, '15:30 PM'),
(14, '17:00 PM'),
(17, '18:30 PM'),
(20, '20:00 PM'),
(22, '21:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `hms_specialization`
--

CREATE TABLE `hms_specialization` (
  `id` int(11) NOT NULL,
  `specialization` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hms_specialization`
--

INSERT INTO `hms_specialization` (`id`, `specialization`) VALUES
(1, 'Psychology'),
(2, 'Fitness'),
(3, 'Finance'),
(4, 'Nutrition'),
(5, 'Lifestyle'),
(6, 'Educational');

-- --------------------------------------------------------

--
-- Table structure for table `hms_users`
--

CREATE TABLE `hms_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hms_users`
--

INSERT INTO `hms_users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(2, 'Any', 'Marks', 'admin@yahoo.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(3, 'William', 'Robert', 'robert@yahoo.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(4, 'SSSS', 'OOO', 'SSSSSin@yahoo.com', 'f542e296af9bd593c4e06b5a31a6eab4', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hms_appointments`
--
ALTER TABLE `hms_appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_clients`
--
ALTER TABLE `hms_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_consultant`
--
ALTER TABLE `hms_consultant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_slots`
--
ALTER TABLE `hms_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_specialization`
--
ALTER TABLE `hms_specialization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hms_users`
--
ALTER TABLE `hms_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hms_appointments`
--
ALTER TABLE `hms_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hms_clients`
--
ALTER TABLE `hms_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `hms_consultant`
--
ALTER TABLE `hms_consultant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hms_slots`
--
ALTER TABLE `hms_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `hms_specialization`
--
ALTER TABLE `hms_specialization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hms_users`
--
ALTER TABLE `hms_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
