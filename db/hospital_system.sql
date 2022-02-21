-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 05, 2021 at 05:48 PM
-- Server version: 5.6.37
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` text NOT NULL,
  `surname` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `national_id` varchar(100) DEFAULT NULL,
  `next_of_kin_name` varchar(100) NOT NULL,
  `next_of_kin_address` varchar(100) NOT NULL,
  `next_of_kin_phone_number` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `allergies` text,
  `reason` text NOT NULL,
  `admission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discharge_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_id`, `first_name`, `middle_name`, `surname`, `gender`, `national_id`, `next_of_kin_name`, `next_of_kin_address`, `next_of_kin_phone_number`, `address`, `phone_number`, `allergies`, `reason`, `admission_date`, `discharge_date`, `status`, `dob`) VALUES
(4, 'UBHP210', 'SIYABONGA', 'A', 'NCUBE', 'Male', '56-129555K58', 'Nigel Bongani Zulu', '4130 COWDRY PARK', '0779544754', '3813 COWDRY PARK', '0773618643', 'sdfs', 'sdfsfds', '2021-06-12 14:12:28', '2021-06-26', 0, '2021-06-12'),
(5, 'UBHG211', 'Louis', 'Arthur', 'Msindo', 'Female', '56-129555K58234', '234', '234', '234', '123 Lobengula West', '+263779525756', '234', '24', '2021-06-13 16:30:17', '2021-06-26', 0, '2021-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `patient_payments`
--

CREATE TABLE IF NOT EXISTS `patient_payments` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_payments`
--

INSERT INTO `patient_payments` (`id`, `patient_id`, `phone_number`, `amount`) VALUES
(1, 'UBHP210', '+263779525756', '50'),
(2, 'UBHP210', '+263779525756', '500'),
(3, 'UBHP210', '0773618643', '50'),
(4, 'UBHP210', '0779525756', '10');

-- --------------------------------------------------------

--
-- Table structure for table `patient_ward`
--

CREATE TABLE IF NOT EXISTS `patient_ward` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(100) NOT NULL,
  `ward_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_ward`
--

INSERT INTO `patient_ward` (`id`, `patient_id`, `ward_id`, `date_created`) VALUES
(4, 'UBHG211', 1, '2021-06-13 18:28:00'),
(5, 'UBHG211', 0, '2021-07-04 15:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`first_name`, `last_name`, `email_address`, `password`, `id`, `role`) VALUES
('Nigel', 'Zulu', 'admin@gmail.com', '$2y$10$Si342Sf72.Dv4Z6Gt7ZhV.3D4yMJ.tvZafEJ5Vm62Ylyk6lgdMF8e', 1, 'admin'),
('Doctor', 'Doctor', 'doctor@gmail.com', '$2y$10$Jsde3FKXH5Ik7bNg1oipeOKZsfGO2VHHaCLOT1dE0uuIJ2Mc3.YRG', 3, 'doctor'),
('nurse', 'nurse', 'nurse@gmail.com', '$2y$10$KmwS5qpmq6yXsgFbkBRJc.Ovp9GmVNmrHvzq9pkNOllK2qpIfek/.', 4, 'nurse');

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE IF NOT EXISTS `wards` (
  `id` int(11) NOT NULL,
  `ward_number` int(11) NOT NULL,
  `ward_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wards`
--

INSERT INTO `wards` (`id`, `ward_number`, `ward_name`, `status`) VALUES
(1, 45, 'Ward 1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_payments`
--
ALTER TABLE `patient_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_ward`
--
ALTER TABLE `patient_ward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `patient_payments`
--
ALTER TABLE `patient_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `patient_ward`
--
ALTER TABLE `patient_ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wards`
--
ALTER TABLE `wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
