-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 01:41 PM
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
-- Database: `ticket_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftarkonser`
--

CREATE TABLE `daftarkonser` (
  `id_konser` int(11) NOT NULL,
  `nama_konser` varchar(255) NOT NULL,
  `tgl_konser` date NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kota` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftarkonser`
--

INSERT INTO `daftarkonser` (`id_konser`, `nama_konser`, `tgl_konser`, `lokasi`, `kota`, `harga`, `gambar`) VALUES
(1, 'We The Fest 2024', '2024-07-19', 'GBK Sport Complex Senayan', 'Jakarta', '1.500.000 - 17.500.000', 'wethefest.webp'),
(2, 'Treasure 2024', '2024-06-29', 'GBK Sport Complex Senayan', 'Jakarta', '1.500.000 - 17.500.000', 'treasure.jpg'),
(3, 'The Sounds Project 7', '2024-08-09', 'GBK Sport Complex Senayan', 'Jakarta', '1.500.000 - 17.500.000', 'tsp7.jpg'),
(4, 'BNI Java Jazz Fest 2024', '2024-05-24', 'GBK Sport Complex Senayan', 'Jakarta', '650.000 - 2.500.000', 'javajazz.webp'),
(5, 'Lalala Fest 2024', '2024-08-23', 'GBK Sport Complex Senayan', 'Jakarta', '700.000 - 15.000.000', 'lalala.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftarkonser`
--
ALTER TABLE `daftarkonser`
  ADD PRIMARY KEY (`id_konser`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftarkonser`
--
ALTER TABLE `daftarkonser`
  MODIFY `id_konser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
