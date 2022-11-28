-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 28, 2022 at 04:08 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `products`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `_id` int(11) NOT NULL,
  `item` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `is_active` enum('0','1') COLLATE latin1_general_ci NOT NULL DEFAULT '1' COMMENT '0->In-Active;1->Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`_id`, `item`, `is_active`) VALUES
(1, 'A', '1'),
(2, 'B', '1'),
(3, 'C', '1'),
(4, 'D', '1'),
(5, 'E', '1');

-- --------------------------------------------------------

--
-- Table structure for table `item_offers`
--

CREATE TABLE `item_offers` (
  `_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `base_units` int(11) NOT NULL,
  `units` int(11) NOT NULL,
  `link_itemId` int(11) NOT NULL,
  `link_itemUnits` int(11) NOT NULL,
  `item_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `item_offers`
--

INSERT INTO `item_offers` (`_id`, `item_id`, `base_units`, `units`, `link_itemId`, `link_itemUnits`, `item_price`) VALUES
(1, 4, 1, 1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `item_price`
--

CREATE TABLE `item_price` (
  `price_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `units` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `item_price`
--

INSERT INTO `item_price` (`price_id`, `item_id`, `units`, `price`) VALUES
(1, 1, 1, 50),
(2, 1, 3, 130),
(3, 2, 1, 30),
(4, 2, 2, 45),
(5, 3, 1, 20),
(6, 3, 2, 38),
(7, 3, 3, 50),
(8, 4, 1, 15),
(9, 5, 1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `item` (`item`);

--
-- Indexes for table `item_offers`
--
ALTER TABLE `item_offers`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `link_itemId` (`link_itemId`);

--
-- Indexes for table `item_price`
--
ALTER TABLE `item_price`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `item_offers`
--
ALTER TABLE `item_offers`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item_price`
--
ALTER TABLE `item_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `item_offers`
--
ALTER TABLE `item_offers`
  ADD CONSTRAINT `item_offers_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`_id`),
  ADD CONSTRAINT `item_offers_ibfk_2` FOREIGN KEY (`link_itemId`) REFERENCES `items` (`_id`);

--
-- Constraints for table `item_price`
--
ALTER TABLE `item_price`
  ADD CONSTRAINT `item_price_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
