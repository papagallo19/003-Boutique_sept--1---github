-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 02, 2017 at 02:41 PM
-- Server version: 5.7.17
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'alimentaire'),
(4, 'electro-menager'),
(2, 'produits entretien'),
(3, 'vetements');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `hash` char(60) NOT NULL,
  `civility` enum('M','Mme','Mlle') NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `email`, `hash`, `civility`, `firstName`, `lastName`) VALUES
(1, 'jm@jm.com', '$2y$10$5v/uLacFT1w5i.qe5FwsHulMP3up4mi8ckT0M1ajhA.Mx0gxQ8cGq', 'M', 'jean marc', 'la rocca');

-- --------------------------------------------------------

--
-- Table structure for table `orderlines`
--

CREATE TABLE `orderlines` (
  `id` int(10) UNSIGNED NOT NULL,
  `idOrder` mediumint(5) UNSIGNED NOT NULL,
  `idProduct` smallint(8) UNSIGNED DEFAULT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL,
  `nameProduct` varchar(75) NOT NULL,
  `priceHT` decimal(5,2) UNSIGNED NOT NULL,
  `VATRate` decimal(4,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `purchaseDate` datetime NOT NULL,
  `billingCivility` enum('M','Mme','Mlle') DEFAULT NULL,
  `billingFirstName` varchar(50) NOT NULL,
  `billingLastName` varchar(50) NOT NULL,
  `billingAddress` text NOT NULL,
  `billingZipCode` varchar(20) NOT NULL,
  `billingCity` varchar(100) NOT NULL,
  `billingCountry` varchar(50) NOT NULL,
  `billingPhoneNumber` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `deliveryCivility` int(11) NOT NULL,
  `deliveryFirstName` int(11) NOT NULL,
  `deliveryLastName` int(11) NOT NULL,
  `deliveryAddress` int(11) NOT NULL,
  `deliveryZipCode` int(11) NOT NULL,
  `deliveryCity` int(11) NOT NULL,
  `deliveryCountry` int(11) NOT NULL,
  `deliveryPhoneNumber` int(11) NOT NULL,
  `idCustomer` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(75) NOT NULL,
  `description` text NOT NULL,
  `imagePath` varchar(75) DEFAULT NULL,
  `priceHT` decimal(5,2) UNSIGNED NOT NULL,
  `VATRate` decimal(4,2) NOT NULL,
  `idCategory` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `imagePath`, `priceHT`, `VATRate`, `idCategory`) VALUES
(5, 'fromage', 'assort', 'image1.jpg', '10.00', '5.00', 1),
(7, 'pack nettoyage', 'promo', 'image4.jpg', '12.00', '5.00', 2),
(8, 'brunch', 'pack', 'image3.jpg', '17.00', '5.00', 1),
(9, 'légumes frais', 'panier', 'image2.jpg', '13.50', '5.00', 1),
(10, 'veste bleue', 'fantaisie', 'images0.jpg', '25.00', '20.00', 3),
(12, 'veste orange', 'Bien chaude', 'images2.jpg', '30.00', '20.00', 3),
(13, 'ensemble femme ', 'fantaisie', 'images3.jpg', '45.00', '20.00', 3),
(14, 'salopette', 'enfant', 'images4.jpg', '18.50', '20.00', 3),
(15, 'balayette', 'super belle', 'image100.jpg', '2.50', '5.00', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orderlines`
--
ALTER TABLE `orderlines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOrder` (`idOrder`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCustomer` (`idCustomer`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `idCategory` (`idCategory`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orderlines`
--
ALTER TABLE `orderlines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderlines`
--
ALTER TABLE `orderlines`
  ADD CONSTRAINT `orderlines_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderlines_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idCustomer`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
