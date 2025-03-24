-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 01:52 AM
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
-- Database: `vc1_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `has_stock`
--

CREATE TABLE `has_stock` (
  `has_stock_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `available_quantity` int(11) NOT NULL DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `no_stock`
--

CREATE TABLE `no_stock` (
  `no_stock_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `image`, `name`, `description`, `price`, `unit`, `supplier_id`, `quantity`) VALUES
(22, 'uploads/default.png', 'Asher Cooley', 'Ipsum ad cupidatat e', 10.00, 'carton', NULL, 1),
(30, 'uploads/default.png', 'Quinlan Donaldson', 'Consequatur a tempo', 9.04, 'pcs', NULL, 20),
(31, 'uploads/default.png', 'Edward Davis', 'Rem deserunt quo mol', 11.00, 'pack', NULL, 29),
(32, 'uploads/default.png', 'Orli Jordan', 'Rerum molestiae cons', 7.00, 'kg', NULL, 50),
(33, 'uploads/default.png', 'Quincy Bender', 'In est molestias por', 30.00, 'carton', NULL, 71);

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `product_list_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `available_quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`product_list_id`, `product_id`, `image`, `name`, `available_quantity`, `price`) VALUES
(2, NULL, 'uploads/13a6e7c7214158c4f676084788520266.jpg', 'car', 1, 12.00),
(4, NULL, 'uploads/coffee.jpg', 'coffee ', 1, 748.00),
(5, NULL, 'uploads/photo_2025-01-02_22-40-05.jpg', 'moto ', 471, 66.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock_management`
--

CREATE TABLE `stock_management` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `stock_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `stock_type` enum('IN','OUT') NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `email`, `phone`, `address`, `created_at`) VALUES
(2, 'Global Distributors', 'globaldist@example.com', '098765432', '456 Global Ave', '2025-03-10 03:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_provide_product`
--

CREATE TABLE `supplier_provide_product` (
  `supplier_product_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(60) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1,
  `last_activity` datetime DEFAULT NULL,
  `locked` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `image`, `first_name`, `last_name`, `email`, `password`, `role`, `phone`, `created_at`, `status`, `last_activity`, `locked`) VALUES
(2, '', 'Alice', 'Smith', 'alice@example.com', 'password456', 'manager', '987654321', '2025-03-10 03:33:45', 1, NULL, 0),
(7, '67dfb841e767f_download.jpg', 'chor ', 'bunnysd', 'bunny.chor@gmail.com', '$2y$10$NKso6fndNaMvq8ItZRK9Ge9LWqJiQv/HChGZ5nneiGIqsZYG2q58q', 'editor', '83974689', '2025-03-16 08:23:08', 1, NULL, 0),
(10, '', 'fdw', 'fd', 'fd@gmail.com', '123', 'user', '1242435', '2025-03-19 11:58:37', 1, NULL, 0),
(11, '67dac4afcf374_WIN_20250224_20_39_59_Pro.jpg', 'Leader', 'PP', 'p@gmail.com', '$2y$10$ZdSlIJxOEBJ9dwjZCZk9T.LlmWbe7P9RDnZM6vfDR4yYygBe4gqYC', 'admin', '0886062006', '2025-03-19 13:20:47', 1, NULL, 0),
(12, NULL, 'bn', 'bn', 'bn@gmail.com', '$2y$10$IoOSA382EJ80FRh3XByuZuRkX4v48ygAG3v9fq1RDW1rM4NG7R4mq', 'admin', '1234', '2025-03-20 13:36:50', 1, NULL, 0),
(13, NULL, 'Din', 'dy', 'dy@gmail.com', '$2y$10$NGGSYdgVho1.cF1mDf/EOuH5vYzwscYBkSrCG8WH.fBMui2RHDI.m', 'user', '1345678', '2025-03-20 13:49:51', 1, NULL, 0),
(14, NULL, 'b', 'bb', 'bb@gmail.com', '$2y$10$P1JLQKoxLRNw4ikJETWFjewjz8dfheubYLkAtMRmm15bFa0HW2Hai', 'admin', '3432545', '2025-03-20 17:13:48', 1, NULL, 0),
(15, NULL, 'Thai', 'Si', 'thai@gmail.com', '$2y$10$N8oasyO8cu3kP1W6gAJj5.TaVQKB1CfRL8rU9s5VPW9xjUUMeIcWK', 'user', '0886062006', '2025-03-21 18:19:33', 1, NULL, 0),
(24, NULL, 'Sreynit', 'Din', 'sreynit@gmail.com', '$2y$10$CU1cvf8orWoZXiOa6HmZKeyUFUM.2/3P9qtRLJpWjs6HxtjDCOYN.', 'user', '0886062006', '2025-03-23 15:11:41', 1, '2025-03-23 23:27:33', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `has_stock`
--
ALTER TABLE `has_stock`
  ADD PRIMARY KEY (`has_stock_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `no_stock`
--
ALTER TABLE `no_stock`
  ADD PRIMARY KEY (`no_stock_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`product_list_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_management`
--
ALTER TABLE `stock_management`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `supplier_provide_product`
--
ALTER TABLE `supplier_provide_product`
  ADD PRIMARY KEY (`supplier_product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `has_stock`
--
ALTER TABLE `has_stock`
  MODIFY `has_stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `no_stock`
--
ALTER TABLE `no_stock`
  MODIFY `no_stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `product_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_management`
--
ALTER TABLE `stock_management`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier_provide_product`
--
ALTER TABLE `supplier_provide_product`
  MODIFY `supplier_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `has_stock`
--
ALTER TABLE `has_stock`
  ADD CONSTRAINT `has_stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `no_stock`
--
ALTER TABLE `no_stock`
  ADD CONSTRAINT `no_stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL;

--
-- Constraints for table `product_list`
--
ALTER TABLE `product_list`
  ADD CONSTRAINT `product_list_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_management`
--
ALTER TABLE `stock_management`
  ADD CONSTRAINT `stock_management_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_management_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `supplier_provide_product`
--
ALTER TABLE `supplier_provide_product`
  ADD CONSTRAINT `supplier_provide_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_provide_product_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
