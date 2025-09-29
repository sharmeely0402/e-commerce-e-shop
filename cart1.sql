-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 09:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cart1`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `password` varchar(100) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `created`, `modified`, `password`, `hash`, `active`) VALUES
(2, 'solma', 'korrma', 'admin@eshop.com', '464685899', '1234', '2025-09-17 16:47:53', '2025-09-17 16:47:53', '$2y$10$Tvh9SpbUMi/3sYGtYfZUceBs7GFB0XHZoT990AdlX/Pf0kMtPVLtW', '19b650660b253761af189682e03501dd', '1'),
(3, 'helooo', 'vello', 'Belly@gmail.com', '2345678', '3456', '2025-09-17 18:51:13', '2025-09-17 18:51:13', '$2y$10$kjvRQGU2zJhXP6kXpDj0B.XPoNLx5JsS3Gy11Adfhtbp3.7/OwG7.', '3988c7f88ebcb58c6ce932b957b6f332', '1'),
(4, 'Giyu', 'tomiyoka', 'Giyu@gmail', '1234556', 'demon slayer', '2025-09-17 20:55:47', '2025-09-17 20:55:47', '$2y$10$aP4U1e/Bk4giOSZp4STQ1OvVm8bi0M1M8nUTa6DwIZ6bZevIxsqjW', '076a0c97d09cf1a0ec3e19c7f2529f2b', '1'),
(5, 'Shinobu', 'Kocho', 'Kocho@gmail', '1223456789', 'butterfly mansion', '2025-09-17 21:19:23', '2025-09-17 21:19:23', '$2y$10$fDH9rVJoVU8eAUcwabn0HOQdqEmURimeu6XqGYS/g.iLISWPSxMsy', '7647966b7343c29048673252e490f736', '1'),
(6, 'Mitsuri', 'Obanai', 'MO@gmail', '234567890', 'ghrfnvf,', '2025-09-17 21:20:44', '2025-09-17 21:20:44', '$2y$10$.af8P6V/GP00ejJTdZILeusl6JoA8yL8kXJRxtwvvHMI773UePU4G', 'aba3b6fd5d186d28e06ff97135cade7f', '1'),
(7, 'Cheng', 'Hua', 'Crimson@gmail', '2345678', 'Paradise Manor', '2025-09-17 21:29:50', '2025-09-17 21:29:50', '$2y$10$Xqzeu2BZwZ4kzm5/Ryeol.ewgi9Xdd4F.GaiizGVnkMPzbUqGWQA6', '4e732ced3463d06de0ca9a15b6153677', '1'),
(8, 'Lian', 'Xie', 'Xie@gmail', '234567890', 'sdfghjkl;', '2025-09-17 21:36:52', '2025-09-17 21:36:52', '$2y$10$2YBSDdozmqnz3H17PkZhV.Y1gAuQN.jcqbhHXbpelSWBEShSDlpJe', 'b6a1085a27ab7bff7550f8a3bd017df8', '1'),
(9, 'Dany', 'Targereny', 'MotherOfDragons@gmail.com', '767890865', 'dragon stone of the seven kingdoms', '2025-09-27 13:26:08', '2025-09-27 13:26:08', '$2y$10$robs5ttjoxaRoIuOrlGP9O7319MlgdrDvv90xeA3PygFT5XYVzwky', '55b37c5c270e5d84c793e486d798c01d', '1'),
(10, 'admin', 'adminad', 'admin@gmail.com', '28939330330-', 'dbdhdj', '2025-09-27 16:26:33', '2025-09-27 16:26:33', '$2y$10$XL9fFihICfwSi65DSTpk1uF4cQrAEs4gaKnCM02TAXoLO90yMsWau', '58e4d44e550d0f7ee0a23d6b02d9b0db', '1'),
(11, 'fareeda', 'syed', 'fareeda@gmail.com', '90987654345890', '703 unity park', '2025-09-27 18:27:17', '2025-09-27 18:27:17', '$2y$10$g7CbhE7oKlJ1.Opq4HhZ1.7DcEGEnv/iZEmysvVhcLwaOtWBz0te2', 'e6cb2a3c14431b55aa50c06529eaa21b', '1'),
(12, 'basSHA', 'bhai', 'basha@gmail.com', '4567890-', '703', '2025-09-27 18:31:22', '2025-09-27 18:31:22', '$2y$10$.aEcUjBet9UGJ0X5EgZFIeO5ok8RP/tGzTsmwVuGCM1QTWa5Dufuu', '9766527f2b5d3e95d4a733fcfb77bd7e', '1'),
(13, 'Light ', 'Yagami', 'Light@gmail.com', '8490910402', 'nothing', '2025-09-29 14:18:24', '2025-09-29 14:18:24', '$2y$10$GjUxvk3BnWNwhfwam/OKBuTLkH8OyLol/8iv/6dVShPCSfv5VPMPi', '81e74d678581a3bb7a720b019f4f1a93', '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` float(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_price`, `created`, `modified`, `status`) VALUES
(1, 4, 5240.00, '2025-09-17 20:58:05', '2025-09-17 20:58:05', '1'),
(2, 5, 25645.00, '2025-09-17 21:19:52', '2025-09-17 21:19:52', '1'),
(3, 7, 8441.00, '2025-09-17 21:30:08', '2025-09-17 21:30:08', '1'),
(4, 9, 68050.00, '2025-09-27 16:04:06', '2025-09-27 16:04:06', '1'),
(5, 9, 5001.00, '2025-09-27 16:15:46', '2025-09-27 16:15:46', '1'),
(6, 9, 240.00, '2025-09-27 16:23:44', '2025-09-27 16:23:44', '1'),
(7, 11, 15003.00, '2025-09-27 18:28:09', '2025-09-27 18:28:09', '1'),
(8, 12, 720.00, '2025-09-27 18:32:20', '2025-09-27 18:32:20', '1'),
(9, 13, 4856.00, '2025-09-29 19:55:16', '2025-09-29 19:55:16', '1'),
(10, 13, 3000.00, '2025-09-29 19:56:53', '2025-09-29 19:56:53', '1'),
(11, 13, 240.00, '2025-09-29 19:57:13', '2025-09-29 19:57:13', '1'),
(12, 13, 5001.00, '2025-09-29 20:24:45', '2025-09-29 20:24:45', '1'),
(13, 13, 5001.00, '2025-09-29 21:26:18', '2025-09-29 21:26:18', '1'),
(14, 13, 240.00, '2025-09-29 21:32:06', '2025-09-29 21:32:06', '1');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 7, 1),
(2, 1, 3, 1),
(3, 2, 10, 2),
(4, 2, 7, 5),
(5, 2, 3, 1),
(6, 3, 10, 1),
(7, 3, 9, 1),
(8, 3, 3, 1),
(9, 3, 7, 1),
(10, 4, 10, 41),
(11, 4, 7, 10),
(12, 4, 3, 41),
(13, 5, 7, 1),
(14, 6, 3, 1),
(15, 7, 7, 3),
(16, 8, 3, 3),
(17, 9, 9, 1),
(18, 9, 3, 1),
(19, 9, 11, 8),
(20, 10, 9, 1),
(21, 11, 3, 1),
(22, 12, 7, 1),
(23, 13, 7, 1),
(24, 14, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` float(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`, `modified`, `status`, `Image`) VALUES
(3, 'Pure Serum', 'Serum Pure – Description\r\n\r\nSerum Pure is a lightweight, fast-absorbing skincare formula enriched with high-potency active ingredients that penetrate deep into the skin to deliver visible results. ', 240.00, '2025-09-17 16:51:25', '2025-09-17 16:51:25', '1', 'pure_serum.jpg\r\n'),
(7, 'Dove peach Body Wash', 'good', 5001.00, '2025-09-17 20:39:34', '2025-09-17 20:39:34', '1', 'Dove_Peach_Body_Wash.jpg'),
(9, 'dove body wash', 'good', 3000.00, '2025-09-17 21:17:58', '2025-09-17 21:17:58', '1', 'dove_body_wash.jpg'),
(10, 'gloss boss', 'good tint', 200.00, '2025-09-17 21:18:29', '2025-09-17 21:18:29', '1', 'gloss_boss.jpg'),
(11, 'douglas lip tint', 'nice', 202.00, '2025-09-29 14:08:01', '2025-09-29 14:16:56', '1', 'douglas.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `score` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `p_id`, `score`) VALUES
(1, 7, 5.0),
(2, 3, 2.0),
(3, 7, 4.0),
(4, 3, 5.0),
(5, 9, 5.0),
(6, 3, 2.0),
(7, 11, 4.0),
(8, 9, 2.0),
(9, 7, 4.0),
(10, 7, 3.0),
(11, 3, 3.0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
