-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2022 at 05:52 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_buku_uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `book_description` text DEFAULT NULL,
  `book_author` varchar(255) DEFAULT NULL,
  `book_price` int(11) DEFAULT NULL,
  `book_picture` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `book_name`, `book_description`, `book_author`, `book_price`, `book_picture`, `user_id`) VALUES
(17, 'Pemrograman PHP', 'buku belajar pemrograman dengan menggunakan bahasa PHP 8 dari pemula hingga mahir serta real word project', 'Eko Khannedy', 85900, '643-phphp.png', 8),
(18, 'Pemrograman C++', 'Buku Belajar programan dengan Bahasa C++ dari pemula hingga advance berfokus di studi kasus competitive programming', 'Pikatan Arya B.', 112000, '643-cppp.jpg', 8),
(20, 'Pulang Pergi', 'buku \"Pulang Pergi\" merupakan buku terakhir dari trilogi pulang dan pergi buku ini akan mengisahkan peperangan terakhir antara sibabi hutan.', 'Tere Liye', 88000, '769-pulangpergi.jpg', 9),
(21, 'Pemrograman JavaScript updated', 'belajar pemrograman javascript dari awal sampai mahir disertai dengan real word project updated', 'Eko updated', 90000, '141-webpro.jpg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `create_datetime`) VALUES
(8, 'admin', 'admin@mail.com', '21232f297a57a5a743894a0e4a801fc3', '2022-06-24 09:26:00'),
(9, 'admin2', 'admin2@mail.com', 'c84258e9c39059a89ab77d846ddab909', '2022-06-24 09:35:31'),
(13, 'admin3', 'admin3@mail.com', '32cacb2f994f6b42183a1300d9a3e8d6', '2022-06-24 15:11:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
