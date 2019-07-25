-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2019 at 12:03 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `discount` int(11) NOT NULL,
  `validuntil` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount`, `validuntil`) VALUES
(1, 'GO2018', 10, '2019-10-31 00:00:00'),
(2, 'GO2019', 15, '2019-09-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `menucategories`
--

CREATE TABLE `menucategories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menucategories`
--

INSERT INTO `menucategories` (`id`, `name`) VALUES
(1, 'Burgers'),
(2, 'Beverages'),
(3, 'Combo Meals');

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE `menuitems` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `foodname` varchar(200) NOT NULL,
  `amount` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`id`, `categoryid`, `foodname`, `amount`) VALUES
(1, 1, 'Burger Hotdog', '45'),
(2, 1, 'Cheese Burger', '55'),
(3, 1, 'Burger and Fries', '66'),
(4, 2, '8oz Coke', '15'),
(5, 2, '8oz Sprite', '15'),
(6, 2, 'Ice Tea 8oz', '13'),
(7, 2, '8oz Royal', '15'),
(8, 3, 'Fried Chicken with Rice', '75'),
(9, 3, 'Pork Chop with Rice', '85'),
(10, 3, 'Fish Fillet with Rice', '65');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_07_23_222034_create_orders_table', 1),
(5, '2019_07_23_224315_create_order_details_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `discount` decimal(8,2) NOT NULL,
  `couponcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `isFinal` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userid`, `subtotal`, `discount`, `couponcode`, `total`, `isFinal`, `created_at`, `updated_at`) VALUES
(1, 1, '507.00', '50.70', '', '456.30', 1, '2019-07-23 15:20:52', '2019-07-23 15:20:52'),
(2, 1, '45.00', '0.00', '', '45.00', 0, '2019-07-23 20:37:50', '2019-07-23 20:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orderid` bigint(20) UNSIGNED NOT NULL,
  `menuitemsid` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `orderid`, `menuitemsid`, `quantity`, `amount`, `created_at`, `updated_at`) VALUES
(21, 1, 2, 3, '55.00', '2019-07-23 17:16:39', '2019-07-23 17:16:39'),
(22, 1, 2, 3, '55.00', '2019-07-23 17:16:41', '2019-07-23 17:16:41'),
(23, 1, 1, 1, '45.00', '2019-07-23 17:16:42', '2019-07-23 17:16:42'),
(24, 1, 3, 1, '66.00', '2019-07-23 17:16:44', '2019-07-23 17:16:44'),
(25, 1, 3, 1, '66.00', '2019-07-23 17:16:45', '2019-07-23 17:16:45'),
(26, 2, 1, 1, '45.00', '2019-07-23 20:37:50', '2019-07-23 20:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dave', 'test@test.com', NULL, '$2y$10$nN3CROV2C/LRkwpE5bhMEeRuRWG5m2ObPkV14ZNVTlBUVqcFmoJUO', NULL, '2019-07-23 14:35:54', '2019-07-23 14:35:54');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vwordersdetails`
-- (See below for the actual view)
--
CREATE TABLE `vwordersdetails` (
`orderid` bigint(20) unsigned
,`foodname` varchar(200)
,`menuitemsid` bigint(20) unsigned
,`quantity` decimal(32,0)
,`amount` decimal(8,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_item_details`
-- (See below for the actual view)
--
CREATE TABLE `vw_item_details` (
`orderid` bigint(20) unsigned
,`menuitemsid` bigint(20) unsigned
,`quantity` decimal(32,0)
,`amount` decimal(8,2)
);

-- --------------------------------------------------------

--
-- Structure for view `vwordersdetails`
--
DROP TABLE IF EXISTS `vwordersdetails`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwordersdetails`  AS  select `order_details`.`orderid` AS `orderid`,(select `menuitems`.`foodname` from `menuitems` where (`menuitems`.`id` = `order_details`.`menuitemsid`)) AS `foodname`,`order_details`.`menuitemsid` AS `menuitemsid`,sum(`order_details`.`quantity`) AS `quantity`,`order_details`.`amount` AS `amount` from `order_details` group by `order_details`.`menuitemsid`,`order_details`.`orderid`,`order_details`.`amount` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_item_details`
--
DROP TABLE IF EXISTS `vw_item_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_item_details`  AS  select `order_details`.`orderid` AS `orderid`,`order_details`.`menuitemsid` AS `menuitemsid`,sum(`order_details`.`quantity`) AS `quantity`,`order_details`.`amount` AS `amount` from `order_details` group by `order_details`.`menuitemsid` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menucategories`
--
ALTER TABLE `menucategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_userid_foreign` (`userid`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_orderid_foreign` (`orderid`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menucategories`
--
ALTER TABLE `menucategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menuitems`
--
ALTER TABLE `menuitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_orderid_foreign` FOREIGN KEY (`orderid`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
