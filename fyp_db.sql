-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2021 at 03:50 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 9, 3, '2021-07-06 11:49:30', NULL),
(2, 9, 3, '2021-07-06 11:49:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `litre` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `litre`, `price`, `vendor_id`, `created_at`, `updated_at`) VALUES
(3, '', '8', '40', 5, '2021-04-27 00:02:06', '2021-04-27 00:02:29'),
(5, '', '10', '50', 1, '2021-07-06 13:42:36', NULL),
(6, 'abc', '1', '10', 4, '2021-07-06 18:34:39', '2021-07-06 18:37:37'),
(7, 'Fleur Graves', '4', '40', 4, '2021-07-06 18:34:54', NULL),
(8, 'Clio Mitchell', '5', '50', 4, '2021-07-06 18:35:00', NULL),
(9, 'Yvonne Hubbard', '7', '70', 4, '2021-07-06 18:35:07', NULL),
(10, 'Charissa Daugherty', '13', '130', 4, '2021-07-06 18:35:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price_per_litre` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `address`, `city`, `state`, `country`, `lat`, `lng`, `image`, `price_per_litre`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'admin upd', 'admin@mail.com', '1234', 1, 'U Block Block U New Multan Colony, Multan, Pakistan', 'Multan', 'Punjab', 'Pakistan', '30.2059097', '71.51823809999999', 'hsn.jpg', 5, 'active', '2021-07-06 18:08:49', '2021-07-06 13:42:25', 0, 1),
(4, 'sana', 'sana@m.com', '1234', 2, 'Adfa, Newtown, UK', 'Adfa', 'Wales', 'United Kingdom', '30.20432760767934', ' 71.51946045840593', 'babu bhaiya - Copy.jpg', 10, 'active', '2021-07-08 13:11:47', '2021-07-06 18:33:52', 1, 4),
(5, 'hassan', 'vendor@mail.com', '1234', 2, 'dummy', NULL, NULL, NULL, '30.2059097', '71.51823809999999', 'IMG_20191211_183419_062.jpg', 5, 'active', '2021-07-08 13:07:44', '2021-04-26 01:02:33', 1, 5),
(9, 'hassan', 'h@m.com', '1234', 3, 'abcde', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'active', '2021-03-08 20:53:27', NULL, 1, 0),
(10, 'hassan', 'hasssan@m.com', '1234', 3, 'dumy address', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'active', '2021-03-08 21:02:37', NULL, 1, 0),
(11, 'hassan', 'h@mail.com', '1234', 3, 'dumy address 12123', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'active', '2021-03-08 21:24:07', '2021-03-08 21:24:07', 1, 1),
(12, 'rao', 'rao@m.com', '1234', 3, 'asds', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'active', '2021-05-10 00:13:15', '2021-05-10 00:13:15', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role`) VALUES
(1, 'super admin'),
(2, 'vendor'),
(3, 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
