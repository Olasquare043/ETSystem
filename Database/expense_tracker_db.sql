-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 04:07 AM
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
-- Database: `expense_tracker_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `user_id` int(11) NOT NULL,
  `balance_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`user_id`, `balance_amount`, `updated_at`) VALUES
(2, 125584.00, '2024-10-31 02:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `user_id`, `category_name`, `created_at`) VALUES
(6, 2, 'Food & Dining', '2024-10-30 13:53:02'),
(7, 2, 'Transportation', '2024-10-30 13:53:02'),
(8, 2, 'Utilities', '2024-10-30 13:53:02'),
(9, 2, 'Entertainment', '2024-10-30 13:53:02'),
(10, 2, 'Healthcare', '2024-10-30 13:53:02'),
(11, 2, 'Savings', '2024-10-30 13:58:01'),
(12, 2, 'Groceries', '2024-10-30 21:41:13'),
(14, 2, 'Restaurant', '2024-10-30 21:46:23');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL CHECK (`amount` > 0),
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `user_id`, `expense_date`, `amount`, `category_id`, `description`) VALUES
(1, 2, '2024-10-30', 1200.00, 9, 'savings from my allawe'),
(2, 2, '2024-10-30', 50000.00, 6, 'we must eat nah'),
(147, 2, '2022-01-15', 45.00, 6, 'Lunch at cafe'),
(148, 2, '2022-02-03', 120.00, 7, 'Monthly bus pass'),
(149, 2, '2022-02-20', 65.00, 8, 'Electricity bill'),
(150, 2, '2022-03-11', 80.00, 9, 'Concert tickets'),
(151, 2, '2022-04-07', 55.00, 10, 'Prescription refill'),
(152, 2, '2022-04-14', 200.00, 11, 'Savings deposit'),
(153, 2, '2022-05-05', 45.50, 12, 'Weekly groceries'),
(154, 2, '2022-06-02', 75.00, 14, 'Dinner out'),
(155, 2, '2022-06-25', 30.00, 6, 'Fast food'),
(156, 2, '2022-07-10', 40.00, 7, 'Fuel for car'),
(157, 2, '2022-07-28', 90.00, 8, 'Water bill'),
(158, 2, '2022-08-15', 150.00, 9, 'Movie night with family'),
(159, 2, '2022-09-01', 100.00, 10, 'Doctor’s visit'),
(160, 2, '2022-10-15', 300.00, 11, 'Monthly savings'),
(161, 2, '2022-10-20', 65.00, 12, 'Organic groceries'),
(162, 2, '2022-11-05', 125.00, 14, 'Dinner with friends'),
(163, 2, '2022-12-08', 45.00, 6, 'Brunch'),
(164, 2, '2022-12-15', 110.00, 7, 'Train ticket'),
(165, 2, '2023-01-02', 100.00, 8, 'Gas bill'),
(166, 2, '2023-02-10', 45.00, 9, 'Comedy show tickets'),
(167, 2, '2023-03-15', 50.00, 10, 'Over-the-counter medicine'),
(168, 2, '2023-03-25', 250.00, 11, 'Monthly savings'),
(169, 2, '2023-04-05', 80.00, 12, 'Grocery run'),
(170, 2, '2023-05-15', 55.00, 14, 'Local diner'),
(171, 2, '2023-06-12', 60.00, 6, 'Quick lunch'),
(172, 2, '2023-07-02', 130.00, 7, 'Taxi rides'),
(173, 2, '2023-07-25', 75.00, 8, 'Heating bill'),
(174, 2, '2023-08-05', 120.00, 9, 'Amusement park tickets'),
(175, 2, '2023-09-01', 75.00, 10, 'Physical check-up'),
(176, 2, '2023-09-20', 270.00, 11, 'Savings deposit'),
(177, 2, '2023-10-15', 100.00, 12, 'Holiday groceries'),
(178, 2, '2023-11-03', 140.00, 14, 'Fine dining'),
(179, 2, '2023-11-22', 25.00, 6, 'Quick bite'),
(180, 2, '2024-01-18', 80.00, 7, 'Weekly gas expenses'),
(181, 2, '2024-02-10', 90.00, 8, 'Electricity charges'),
(182, 2, '2024-03-07', 50.00, 9, 'Play tickets'),
(183, 2, '2024-03-15', 45.00, 10, 'Pharmacy items'),
(184, 2, '2024-04-20', 180.00, 11, 'Savings for a trip'),
(185, 2, '2024-05-25', 40.00, 12, 'Weekly market'),
(186, 2, '2024-06-05', 115.00, 14, 'Night out dining'),
(187, 2, '2024-06-25', 25.00, 6, 'Street food'),
(188, 2, '2024-07-10', 75.00, 7, 'Subway rides'),
(189, 2, '2024-08-08', 95.00, 8, 'Gas and utilities'),
(190, 2, '2024-09-01', 110.00, 9, 'Event tickets'),
(191, 2, '2024-09-14', 55.00, 10, 'Vaccinations'),
(192, 2, '2024-10-20', 200.00, 11, 'Emergency savings'),
(195, 2, '2024-08-14', 500.00, 9, 'enjoyment'),
(196, 2, '2024-10-15', 500.00, 9, 'enjoyment'),
(197, 2, '2024-10-30', 500.00, 8, 'enjoyment'),
(198, 2, '2024-10-31', 500.00, 9, 'enjoyment galo'),
(199, 2, '2024-10-30', 504.00, 9, 'Still enjoyment galo'),
(200, 2, '2024-10-30', 504.00, 9, 'Still enjoyment galo'),
(201, 2, '2024-10-31', 504.00, 9, 'Still enjoyment galo'),
(202, 2, '2024-10-31', 504.00, 9, 'Still enjoyment galo'),
(203, 2, '2024-10-31', 504.00, 10, 'Still enjoyment galo'),
(204, 2, '2024-10-31', 534.00, 9, 'Still enjoyment galo'),
(205, 2, '2024-10-31', 534.00, 9, 'Still enjoyment galo');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `income_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `user_id`, `income_date`, `amount`, `source`, `description`) VALUES
(1, 2, '2024-10-30', 5000.00, 'Salary', 'my salary'),
(2, 2, '2024-10-30', 6000.00, 'Salary', 'same salary'),
(3, 2, '2024-10-30', 1200.00, 'Salary', 'Salary with deduction'),
(4, 2, '2024-08-30', 120000.00, 'Salary and Bonuses', 'Salary and Bonuses was paid'),
(5, 2, '2024-02-12', 900.00, 'gift', ''),
(6, 2, '2024-10-30', 50.00, 'Dash', ''),
(7, 2, '2024-10-25', 50.00, 'Dash', ''),
(9, 2, '2024-10-31', 209.00, 'Dash', ''),
(10, 2, '2024-10-31', 209.00, 'Dash', '');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_generated` timestamp NOT NULL DEFAULT current_timestamp(),
  `report_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`report_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pswd` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `email`, `pswd`, `created_at`) VALUES
(2, 'Mr. Oni Mathew Taiwo', 'Matty Pretty', 'mat@gmail.com', '$2y$10$8i.P/7QB8ICmoVx44D98cuoRfoxl8bl/8XAj2qUmD6NQqrK7iR3be', '2024-10-30 11:01:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`category_name`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
