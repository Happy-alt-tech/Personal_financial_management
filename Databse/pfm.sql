-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 10:09 AM
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
-- Database: `pfm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin123', '2025-06-19 07:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income_category`
--

CREATE TABLE `income_category` (
  `id` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income_category`
--

INSERT INTO `income_category` (`id`, `category`, `name`, `amount`, `date`, `payment_method`, `description`) VALUES
(1, 'salary', 'happy', 100, '2025-06-18', 'cash', 'gfv'),
(2, 'salary', 'happy', 1000, '2025-06-19', 'cash', 'jgvhj');

-- --------------------------------------------------------

--
-- Table structure for table `user_expense`
--

CREATE TABLE `user_expense` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `phone`, `password`, `status`, `image`) VALUES
(1, 'happy', 'happy@gmail.com', NULL, '1234', 'approved', 'profilepic.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_income`
--

CREATE TABLE `user_income` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_category`
--
ALTER TABLE `income_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_expense`
--
ALTER TABLE `user_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_income`
--
ALTER TABLE `user_income`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_category`
--
ALTER TABLE `income_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_expense`
--
ALTER TABLE `user_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_income`
--
ALTER TABLE `user_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_expense`
--
ALTER TABLE `user_expense`
  ADD CONSTRAINT `user_expense_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_form` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_expense_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `expense_category` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_income`
--
ALTER TABLE `user_income`
  ADD CONSTRAINT `user_income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_form` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_income_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `income_category` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
