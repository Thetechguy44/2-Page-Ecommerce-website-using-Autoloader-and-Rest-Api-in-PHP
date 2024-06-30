-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2023 at 05:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scandiweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `productType` varchar(50) NOT NULL,
  `size` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `price`, `productType`, `size`, `height`, `width`, `length`, `weight`) VALUES
(1, 'BKTE88344', 'Akila', 120.00, 'book', NULL, NULL, NULL, NULL, 123),
(3, 'CHQ122777', 'Chair', 50.00, 'furniture', NULL, 10, 15, 14, NULL),
(5, 'DBOO56090', 'Ant man', 10.00, 'dvd', 180, NULL, NULL, NULL, NULL),
(6, 'DBOO56088', 'The Hunter', 20.00, 'book', NULL, NULL, NULL, NULL, 10),
(12, 'FURH96534 ', 'Table', 150.00, 'furniture', NULL, 50, 100, 80, NULL),
(19, 'DOKT88745', 'Avatar', 150.00, 'dvd', 250, NULL, NULL, NULL, NULL),
(28, 'FTRN44456', 'Dinning Table', 300.00, 'furniture', NULL, 100, 500, 200, NULL),
(39, 'DEEL55409', 'Revenge', 100.00, 'dvd', 300, NULL, NULL, NULL, NULL),
(46, 'DBOO56055', 'War and Peace', 20.00, 'book', NULL, NULL, NULL, NULL, 5),
(47, 'TRIC20555', 'Short Chair', 50.50, 'furniture', NULL, 24, 45, 15, NULL),
(48, 'GWMN43456', 'The Thinker', 40.00, 'book', NULL, NULL, NULL, NULL, 3),
(49, 'BBJD46456', 'The Track', 50.00, 'dvd', 100, NULL, NULL, NULL, NULL),
(52, 'FTNF88904', 'Turning Chair ', 300.00, 'furniture', NULL, 50, 20, 15, NULL),
(56, 'SKUTest000', 'NameTest000', 25.00, 'dvd', 200, NULL, NULL, NULL, NULL),
(57, 'SKUTest001', 'NameTest001', 25.00, 'book', NULL, NULL, NULL, NULL, 200),
(58, 'SKUTest002', 'NameTest002', 25.00, 'furniture', NULL, 200, 200, 200, NULL),
(59, 'GFSH77896', 'Thrones', 80.99, 'book', NULL, NULL, NULL, NULL, 10),
(60, 'DVJD46400', 'The Track', 30.00, 'dvd', 200, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
