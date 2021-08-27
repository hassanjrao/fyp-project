-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2021 at 08:10 PM
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
  `vendor_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `vendor_id`, `customer_id`, `total_price`, `created_at`, `updated_at`) VALUES
(3, 14, 16, 200, '2021-08-27 07:10:40', '2021-08-27 07:10:40'),
(4, 14, 16, 200, '2021-08-27 07:12:27', '2021-08-27 07:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 7, '2021-08-27 07:10:40', '2021-08-27 07:10:40'),
(2, 3, 2, 10, '2021-08-27 07:10:40', '2021-08-27 07:10:40'),
(3, 4, 3, 4, '2021-08-27 07:12:27', '2021-08-27 07:12:27'),
(4, 4, 4, 10, '2021-08-27 07:12:27', '2021-08-27 07:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
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

INSERT INTO `products` (`id`, `product_image`, `product_name`, `litre`, `price`, `vendor_id`, `created_at`, `updated_at`) VALUES
(1, '1630047484VGA Fav Icon.png', 'product 1 updated', '5', '25', 14, '2021-08-27 06:37:18', '2021-08-27 06:58:04'),
(2, '1630047680chart-patterns - Copy.PNG', 'product 2', '10', '50', 14, '2021-08-27 06:37:36', '2021-08-27 07:01:20'),
(3, '1630046916kreshul_3.png', 'Amery Hunter', '29', '507', 14, '2021-08-27 06:48:36', NULL),
(4, '16300476661627743920271.jpg', 'Rama Briggs', '41', '313', 14, '2021-08-27 07:01:06', NULL);

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
(1, 'admin upd', 'admin@m.com', '1234', 1, 'U Block Block U New Multan Colony, Multan, Pakistan', 'Multan', 'Punjab', 'Pakistan', '30.2059097', '71.51823809999999', 'hsn.jpg', 5, 'active', '2021-08-27 06:17:23', '2021-07-06 13:42:25', 0, 1),
(14, 'vendor hassan', 'h@m.com', 'password', 2, 'Sukkur Bypass, RCW Rohri, Pakistan', 'RCW Rohri', 'Sindh', 'Pakistan', '27.6575487', '68.8475141', '1630046984cover.jpg', 5, 'active', '2021-08-27 06:49:44', '2021-08-27 06:49:44', 1, 14),
(15, 'qijyhibat@mailinator.com', 'vendor@m.com', 'password', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'inactive', '2021-08-27 06:24:30', '2021-08-27 06:24:30', 1, 1),
(16, 'customer one', 'cust@m.com', 'password', 3, 'address abcdef', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'active', '2021-08-27 07:07:01', NULL, 1, 0);

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
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

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
