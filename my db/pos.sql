-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2016 at 10:00 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `category_desc`, `date`) VALUES
('KAT1', 'Kipas Angin', 'Kipas Angin', '2016-05-22 16:18:05'),
('LAMP', 'Lampu', 'Lampu', '2016-05-25 13:27:13'),
('TV', 'TV', 'TV', '2016-05-25 13:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `customer_phone`, `customer_address`, `date`) VALUES
('CUST0001', 'Erwin', '0812121212', 'Jl Raya Daan Mogot, Apartment Mediterania', '2016-05-22 08:04:24'),
('CUST0002', 'Cyntia', '081212121', 'Duren Kalibata', '2016-05-22 08:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `product_qty` int(11) NOT NULL DEFAULT '0',
  `sale_price` int(20) NOT NULL,
  `sale_price_type1` int(20) NOT NULL,
  `sale_price_type2` int(20) NOT NULL,
  `sale_price_type3` int(20) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `category_id`, `product_desc`, `product_qty`, `sale_price`, `sale_price_type1`, `sale_price_type2`, `sale_price_type3`, `date`) VALUES
('MAS10', 'Maspion', 'KAT1', 'Maspion Kipas Baru', 82, 120000, 100000, 0, 0, '2016-05-26 14:27:15'),
('PHIL001', 'Philip Lampu', 'LAMP', 'Philip 12watt', 8, 80000, 0, 0, 0, '2016-05-26 16:00:13'),
('SAM100', 'Samsung TV', 'TV', 'TV 52inc', 72, 6200000, 6100000, 6000000, 0, '2016-05-26 15:58:15'),
('SAM2100', 'Samsung 2100', 'KAT1', 'Samsung Kipas', 26, 210000, 200000, 180000, 0, '2016-05-29 14:26:41'),
('TOS10', 'Toshiba 21', 'TV', '', 91, 1600000, 1500000, 0, 0, '2016-05-26 14:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_data`
--

CREATE TABLE `purchase_data` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price_item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Purchase Transaction, 0=Purchase Retur',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_data`
--

INSERT INTO `purchase_data` (`id`, `transaction_id`, `product_id`, `category_id`, `quantity`, `price_item`, `subtotal`, `type`, `date`) VALUES
(48, 'RETP1466610553', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-22 15:58:25'),
(49, 'RETP1466610553', 'PHIL001', 'LAMP', '1', '12000', '12000', 1, '2016-06-22 15:58:25'),
(50, 'TRX001', 'MAS10', 'KAT1', '1', '100000', '100000', 1, '2016-06-26 14:26:52'),
(51, 'TRX001', 'PHIL001', 'LAMP', '1', '70000', '70000', 1, '2016-06-26 14:26:52'),
(52, 'TRX001', 'TOS10', 'TV', '4', '750000', '3000000', 1, '2016-06-26 14:26:53'),
(54, 'RETP1466951903', 'TOS10', 'TV', '1', '750000', '750000', 1, '2016-06-26 14:38:23'),
(55, 'RETP1467027787', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-27 11:43:07'),
(56, 'RETP1466951256', 'TOS10', 'TV', '1', '750000', '750000', 1, '2016-06-30 08:56:09'),
(58, 'RETP1466951903', 'TOS10', 'TV', '1', '750000', '750000', 1, '2016-06-30 08:57:36'),
(59, 'RETP1467027787', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-30 08:58:02'),
(61, 'RETP1467277500', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-30 09:05:31'),
(62, 'RETP1467277695', 'SAM100', 'TV', '1', '6200000', '6200000', 1, '2016-06-30 09:08:15'),
(63, 'RETP1467277695', 'SAM100', 'TV', '1', '6200000', '6200000', 1, '2016-06-30 09:08:52'),
(64, 'RETP1467277877', 'SAM100', 'TV', '1', '6200000', '6200000', 1, '2016-06-30 09:11:17'),
(66, 'RETP1467277877', 'SAM100', 'TV', '1', '6200000', '6200000', 1, '2016-06-30 09:18:58'),
(67, 'TRX0012', 'PHIL001', 'LAMP', '1', '120000', '120000', 1, '2016-06-30 15:40:58'),
(68, 'TRX0012', 'SAM2100', 'KAT1', '10', '320000', '3200000', 1, '2016-06-30 15:40:58'),
(69, 'TRX123', 'SAM2100', 'KAT1', '11', '23328', '256608', 1, '2016-06-30 17:26:21'),
(70, 'RETP1474810256', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-09-25 13:30:56'),
(71, 'RETP1474810256', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-09-25 13:30:56'),
(72, 'RETP1474810333', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-09-25 13:32:13'),
(73, 'RETP1474810333', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-09-25 13:32:13'),
(74, 'RETP1474810385', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-09-25 13:33:05'),
(75, 'RETP1474810385', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-09-25 13:33:05'),
(77, 'RETP1474810569', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-09-25 13:37:47'),
(78, 'RETP1474810569', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-09-25 13:37:47'),
(79, 'RETP1474810256', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-09-25 13:41:09'),
(80, 'RETP1474810256', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-09-25 13:41:09'),
(82, 'RETP1474811008', 'MAS10', 'KAT1', '1', '100000', '100000', 1, '2016-09-25 13:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_retur`
--

CREATE TABLE `purchase_retur` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sales_retur_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_return` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `return_by` enum('1','0') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Retur by 1 = barang, 0 = uang',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_retur`
--

INSERT INTO `purchase_retur` (`id`, `sales_retur_id`, `total_price`, `total_item`, `is_return`, `return_by`, `date`) VALUES
('RETP1466951256', 'TRX001', '750000', '1', '1', '', '2016-06-30 08:56:09'),
('RETP1467277500', 'RETS1467277485', '120000', '1', '1', '1', '2016-06-30 09:05:31'),
('RETP1467277695', 'RETS1467277678', '6200000', '1', '1', '1', '2016-06-30 09:08:52'),
('RETP1467277877', 'RETS1467277861', '6200000', '1', '1', '1', '2016-06-30 09:18:58'),
('RETP1474810256', 'RETS1474810050', '330000', '2', '1', '1', '2016-09-25 13:41:09'),
('RETP1474810333', 'RETS1474810015', '330000', '2', '1', '1', '2016-09-25 13:40:20'),
('RETP1474810385', 'RETS1474810346', '330000', '2', '1', '1', '2016-09-25 13:39:16'),
('RETP1474810569', 'TRX123', '330000', '2', '1', '1', '2016-09-25 13:37:47'),
('RETP1474811109', 'TRX123', '23328', '1', '0', '1', '2016-09-25 13:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_transaction`
--

CREATE TABLE `purchase_transaction` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_price` int(20) NOT NULL,
  `total_item` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `supplier_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_transaction`
--

INSERT INTO `purchase_transaction` (`id`, `total_price`, `total_item`, `date`, `supplier_id`) VALUES
('TRX001', 3170000, 6, '2016-06-26 14:26:52', 'SUP001'),
('TRX0012', 3320000, 11, '2016-06-30 15:40:58', 'SUP001'),
('TRX123', 256608, 11, '2016-06-30 17:26:21', 'SUP001');

-- --------------------------------------------------------

--
-- Table structure for table `sales_data`
--

CREATE TABLE `sales_data` (
  `id` int(11) NOT NULL,
  `sales_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price_item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Sales Transaction, 0=Sales Retur',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_data`
--

INSERT INTO `sales_data` (`id`, `sales_id`, `product_id`, `category_id`, `quantity`, `price_item`, `subtotal`, `type`, `date`) VALUES
(9, 'OUT1464796294', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-01 15:51:50'),
(10, 'OUT1464796372', 'SAM100', 'TV', '1', '6200000', '6200000', 1, '2016-06-01 15:53:02'),
(11, 'OUT1464796397', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-01 15:53:33'),
(12, 'OUT1464796397', 'PHIL001', 'LAMP', '2', '80000', '160000', 1, '2016-06-01 15:53:33'),
(13, 'OUT1464796429', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-01 15:54:44'),
(14, 'OUT1465701627', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-06-12 03:20:42'),
(15, 'OUT1465701627', 'PHIL001', 'LAMP', '2', '80000', '160000', 1, '2016-06-12 03:20:42'),
(45, 'OUT1465749752', 'MAS10', 'KAT1', '8', '120000', '960000', 1, '2016-06-12 16:42:54'),
(46, 'OUT1465749752', 'PHIL001', 'LAMP', '5', '80000', '400000', 1, '2016-06-12 16:42:54'),
(47, 'OUT1465749752', 'SAM100', 'TV', '1', '6200000', '6200000', 1, '2016-06-12 16:42:54'),
(51, 'OUT1466953910', 'PHIL001', 'LAMP', '2', '80000', '160000', 1, '2016-06-26 15:12:04'),
(54, 'OUT1467028283', 'MAS10', 'KAT1', '5', '120000', '600000', 1, '2016-06-27 11:51:44'),
(65, 'OUT1467307643', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-06-30 17:27:46'),
(66, 'OUT1467307643', 'PHIL001', 'LAMP', '15', '80000', '1200000', 1, '2016-06-30 17:27:46'),
(67, 'OUT1468549735', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-07-15 02:29:11'),
(68, 'OUT1468549735', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-07-15 02:29:11'),
(81, 'RETS1474810592', 'SAM2100', 'KAT1', '1', '210000', '210000', 1, '2016-09-25 13:36:35'),
(82, 'RETS1474810592', 'MAS10', 'KAT1', '1', '120000', '120000', 1, '2016-09-25 13:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `sales_retur`
--

CREATE TABLE `sales_retur` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sales_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_return` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_retur`
--

INSERT INTO `sales_retur` (`id`, `sales_id`, `total_price`, `total_item`, `is_return`, `date`) VALUES
('RETS1466088136', 'OUT1464796397', '320000', '3', '1', '2016-06-26 15:53:01'),
('RETS1466603970', 'OUT1464796429', '120000', '1', '1', '2016-06-22 14:00:21'),
('RETS1466951646', 'OUT1464796397', '750000', '1', '1', '2016-06-26 14:38:23'),
('RETS1467027724', 'OUT1465701627', '120000', '1', '1', '2016-06-27 11:43:07'),
('RETS1467276594', 'OUT1464796372', '6200000', '1', '1', '2016-06-30 08:57:17'),
('RETS1467277485', 'OUT1464796429', '120000', '1', '1', '2016-06-30 09:05:00'),
('RETS1467277678', 'OUT1464796372', '6200000', '1', '1', '2016-06-30 09:08:15'),
('RETS1467277861', 'OUT1464796372', '6200000', '1', '1', '2016-06-30 09:11:17'),
('RETS1467278296', 'OUT1464796372', '6200000', '1', '1', '2016-06-30 09:18:29'),
('RETS1474810015', 'OUT1468549735', '330000', '2', '1', '2016-09-25 13:32:13'),
('RETS1474810050', 'OUT1468549735', '330000', '2', '1', '2016-09-25 13:30:56'),
('RETS1474810346', 'OUT1468549735', '330000', '2', '1', '2016-09-25 13:33:05'),
('RETS1474810592', 'OUT1468549735', '330000', '2', '0', '2016-09-25 13:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `sales_transaction`
--

CREATE TABLE `sales_transaction` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_cash` tinyint(1) NOT NULL,
  `total_price` int(100) NOT NULL,
  `total_item` int(100) NOT NULL,
  `pay_deadline_date` date DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_transaction`
--

INSERT INTO `sales_transaction` (`id`, `customer_id`, `is_cash`, `total_price`, `total_item`, `pay_deadline_date`, `date`) VALUES
('OUT1464796372', 'CUST0001', 0, 6200000, 1, '2016-07-01', '2016-06-27 16:34:42'),
('OUT1464796397', 'CUST0002', 1, 280000, 3, '2016-07-01', '2016-06-07 15:35:49'),
('OUT1464796429', 'CUST0001', 1, 120000, 1, '2016-06-01', '2016-06-01 15:54:43'),
('OUT1465701627', 'CUST0001', 1, 280000, 3, '2016-06-12', '2016-06-12 03:20:42'),
('OUT1465749752', 'CUST0002', 1, 7560000, 14, '2016-06-12', '2016-06-12 16:42:54'),
('OUT1466953910', 'CUST0001', 1, 160000, 2, '2016-07-26', '2016-06-27 11:50:43'),
('OUT1467028283', 'CUST0002', 0, 600000, 5, '2016-07-27', '2016-06-27 11:51:44'),
('OUT1467307643', 'CUST0001', 1, 1410000, 16, '2016-07-01', '2016-06-30 17:27:46'),
('OUT1468549735', 'CUST0001', 1, 330000, 2, '2016-07-15', '2016-07-15 02:29:11');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_address` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_name`, `supplier_phone`, `supplier_address`, `date`) VALUES
('SUP001', 'Alan New', '081751261251', 'Kalibata City', '2016-05-20 17:00:00'),
('SUP002', 'Made', '', 'Made', '2016-05-25 14:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo_profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `photo_profile`, `password`) VALUES
(1, 'alan', 'admin@admin.com', 'http://localhost/ci/uploads/chalange_accepeted.png', 'e6c029df19a4f2b09de95b39c0ef61db');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `purchase_data`
--
ALTER TABLE `purchase_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_retur`
--
ALTER TABLE `purchase_retur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `purchase_transaction`
--
ALTER TABLE `purchase_transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `sales_data`
--
ALTER TABLE `sales_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_retur`
--
ALTER TABLE `sales_retur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `sales_transaction`
--
ALTER TABLE `sales_transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_data`
--
ALTER TABLE `purchase_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `sales_data`
--
ALTER TABLE `sales_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
