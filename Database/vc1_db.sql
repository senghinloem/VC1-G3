-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 03:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
  `quantity` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `image`, `name`, `description`, `price`, `unit`, `supplier_id`, `quantity`) VALUES
(22, 'uploads/default.png', 'Asher Cooley', 'Ipsum ad cupidatat e', 10.00, 'carton', NULL, 1),
(30, 'uploads/default.png', 'Quinlan Donaldson', 'Consequatur a tempo', 9.00, 'pcs', NULL, 20),
(31, 'uploads/default.png', 'Edward Davis', 'Rem deserunt quo mol', 11.00, 'pack', NULL, 29),
(32, 'uploads/default.png', 'Orli Jordan', 'Rerum molestiae cons', 7.00, 'kg', NULL, 50),
(33, 'uploads/default.png', 'Quincy Bender', 'In est molestias por', 30.00, 'carton', NULL, 71),
(34, 'uploads/default.png', 'Trevor Jackson', 'Et esse est repreh', 9.00, 'L', NULL, 45),
(35, 'uploads/default.png', 'Dominique Pace', 'Atque ea facere dele', 11.00, 'pcs', NULL, 30),
(36, 'uploads/default.png', 'Deacon Justice', 'Dolorem optio incid', 40.00, 'm', NULL, 38),
(37, 'uploads/default.png', 'Ursula Alston', 'Quos qui enim magni', 90.00, 'carton', NULL, 4),
(38, 'uploads/default.png', 'Rana Campbell', 'Autem consequatur e', 10.00, 'carton', NULL, 8),
(39, 'uploads/default.png', 'August Mcgee', 'Quos velit deleniti', 10.00, 'pack', NULL, 20),
(40, 'uploads/default.png', 'Alfreda Waters', 'Tempore illo sint', 10.00, 'm', NULL, 46);

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
(1, 'Tech Supplies Ltd', 'techsup@example.com', '012345678', '123 Tech Street', '2025-03-10 03:33:45'),
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
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(60) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `phone`, `created_at`, `image`) VALUES
(2, 'Alice', 'Smith', 'alice@example.com', 'password456', 'manager', '987654321', '2025-03-10 03:33:45', NULL),
(7, 'chor ', 'bunny', 'bunny.chor@gmail.com', '$2y$10$NKso6fndNaMvq8ItZRK9Ge9LWqJiQv/HChGZ5nneiGIqsZYG2q58q', 'user', '83974689', '2025-03-16 08:23:08', NULL),
(8, 'er', 'er', 'er@gmail.com', '$2y$10$JEEid3hV8w1UvxJ/wMFzd.Y/emBIu.lMb3YNgTUxWScBOzCBE6blS', 'admin', '23456', '2025-03-20 05:23:06', NULL),
(9, 'rr', 'rr', 'rr@gmail.com', '$2y$10$QXd0.ow8O2pc7gX5226AWejM4HwmYlNtKY7DCL70ocz3plrf/pU2W', 'admin', '3432545', '2025-03-21 01:58:13', NULL);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

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
