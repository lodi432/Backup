-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 03, 2018 at 02:42 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom244`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `email` (`ime` VARCHAR(50), `prezime` VARCHAR(50)) RETURNS VARCHAR(50) CHARSET latin1 begin
return concat(left(lower(pocisti(ime)),1),lower(pocisti(prezime)),'@edunova.hr');
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `pocisti` (`tekst` VARCHAR(50)) RETURNS VARCHAR(50) CHARSET latin1 begin
return lower(
replace(
replace(
replace(
replace(
replace(replace(upper(tekst),' ',''),'Č','C')
,'Š','S')
,'Đ','D')
,'Ć','C')
,'Ž','Z'));
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(7, 'Levis'),
(2, 'Addidas'),
(9, '&lt;br&gt;Hello World&lt;/br&gt;'),
(13, 'wwww'),
(14, 'Levis2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`) VALUES
(187, '[{\"id\":\"4\",\"size\":\"Small\",\"quantity\":\"2\"}]', '2018-05-03 05:53:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Woman', 0),
(3, 'Boys', 0),
(4, 'Girls', 0),
(5, 'Shirts', 1),
(6, 'Pants', 1),
(7, 'Shoes', 1),
(8, 'Accessories', 1),
(9, 'Shirts', 2),
(10, 'Pants', 2),
(11, 'Shoes', 2),
(12, 'Dresses', 2),
(13, 'Shirts', 3),
(14, 'Pants', 3),
(15, 'Dresses', 4),
(16, 'Shoes', 4),
(31, 'Shoes', 3),
(32, 'Pants', 4);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `password` varchar(255) NOT NULL,
  `datum_prijave` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `zadnja_prijava` date NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `full_name`, `email`, `password`, `datum_prijave`, `zadnja_prijava`, `permissions`) VALUES
(7, 'ivan', 'admin@admin.com', 'f6fdffe48c908deb0f4c3bd36c032e72', '2018-03-31 01:26:05', '2018-03-29', 'admin'),
(8, 'domagoj', 'user@user.com', '5cc32e366c87c4cb49e4309b75f57d64', '2018-03-31 01:26:51', '2018-03-29', 'editor');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(1, 'Levi&#039;s Jeans', '29.99', '39.99', 7, '6', '/EcomApp/images/products/764d69b775362368848ba31df595962b.jpg', 'These Jeans are super freaky and awesome.', 1, '28:3,32:5.36:1', 0),
(2, 'Addidas Footbal', '50.99', '49.99', 2, '7', '/EcomApp/images/products/6e881251e7e05b6342ece000b0ec1af9.jpg', 'What an amazing shoes...Buy now!', 1, 'Small:3,medium:6,large:9', 0),
(4, 'Pants ', '32.99', '33.99', 7, '6', '/EcomApp/images/products/19b01438b32456444bcccda3f14c9954.jpeg', '', 1, 'Medium:2,Large:2,Small:4,Medium:3,', 0),
(8, 'Samsung', '33.99', '29.99', 7, '8', '/EcomApp/images/products/d68b6169540efdb88630a19ff5a454b4.png', 'Hellou Banjo\r\n123', 1, 'Medium:2,Large:4', 0),
(6, 'interface', '42.00', '23.00', 2, '', '/ecomdva/images/products/38ee655c6fa641d85d296c8d7ff3ee27.png', 'X123', 1, 'Large:2,Medium:3,Extra Small:2,Large:4', 0),
(7, 'Produkt 123', '31.99', '21.99', 9, '14', '/E-Shop/images/products/e101f4bee7744af2c96aad7beb7a5f59.jpeg', 'Description is important \r\nIsn&#039;t it.', 1, '', 0),
(9, 'Produkt 1', '31.00', '42.00', 2, '14', '/EcomApp/images/products/586d8bd2dba262ef482359514f8f5de5.png', 'This is my new product,enyoj', 1, '', 0),
(10, 'Test Product', '399.00', '299.00', 2, '15', '/EcomApp/images/products/ffec396609913dadf1137fad7bdcd020.png', '', 1, '', 0),
(11, 'Iphone', '311.00', '111.00', 7, '16', '/E-Shop/images/products/192639178baf251577c0a60f56093c88.png', '', 1, '', 0),
(12, 'Produkt 9', '388.00', '913.00', 7, '14', '/EcomApp/images/products/adef0cc17325e6a29e442a4a58d2c6df.png', 'I am the best', 0, '', 0),
(13, 'Produkt X', '561.00', '751.00', 9, '9', '/EcomApp/images/products/3ad5302fb823799f1075b8384ef963de.png', 'Samsung za na&scaron;e korisnike', 0, '', 0),
(14, 'dada', '2.00', '111.00', 9, '3', '/EcomApp/images/products/b91808c69af903b1bc474fde766b8254.png', 'gtc', 0, '', 0),
(26, 'Produkt 123', '31.00', '7.00', 14, '15', '/E-Shop/images/products/9efe6a0f26c9310724b04c57120cb853.jpg', '', 0, '', 0),
(15, '6t5', '751.00', '561.00', 9, '31', '/EcomApp/images/products/2f477a2d009cca1b62967186094f66a8.jpg', '', 0, '', 1),
(16, 'test2', '2.00', '751.00', 2, '2', '/EcomApp/images/products/32231f1700c0eff844197d14921aa7f0.png', '', 0, '', 1),
(17, 'test2', '222.00', '111.00', 9, '2', '/EcomApp/images/products/d103e79935b7b0b98c634a78f97e6322.png', '', 0, '', 1),
(18, 'produkt anton', '31.00', '32.00', 13, '1', '/EcomApp/images/products/2561f88810d4f70a543177eef388b9ac.jpg', '2', 0, '', 1),
(19, 'produkt anton', '31.00', '32.00', 13, '1', '/EcomApp/images/products/afcf218389fbff58a13d8db68db27609.jpg', '2', 0, '', 1),
(20, 'betmen', '123.00', '345.00', 2, '6', '/betmen/images/products/0e74b9dd887697527bc4f65fc7a05e28.jpg', '', 0, '', 1),
(21, 'Proba 123', '7777.00', '2222.00', 9, '14', '/E-Shop/images/products/9ad59b50adf17ddc1db1b8c703204c9d.png', 'DFes', 0, '', 1),
(22, 'wtf', '31.00', '666.00', 9, '14', '/E-Shop/images/products/54bda4bf38131cdce80747bb709b6fbe.png', 'aa', 0, '', 1),
(23, 'Produkt 123', '12345.00', '6789.00', 13, '8', '/E-Shop/images/products/5846addb24bfeb63262bdbc652385aac.png', 'qadad', 0, '', 1),
(24, 'Produkt 1e333', '31.00', '42.00', 2, '14', '/E-Shop/images/products/450284d3bf6f1151170f76218144317d.png', '', 0, '', 1),
(25, 'adaa2', '223.00', '442.00', 9, '14', '/E-Shop/images/products/301f13a542ceaf6b3c748830c4530cae.jpg', 'BATMAN', 0, '', 1),
(27, 'I phone 5', '222.00', '200.00', 13, '8', '/E-Shop/images/products/92310629c63034cfb2a5a66c38fe5000.png', 'Amazing mobile phone !', 1, '', 0),
(28, 'test2', '222.00', '38.00', 2, '14', '/E-Shop/images/products/14ba921907ed37a4699273d768a88ba7.jpg', '', 0, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
