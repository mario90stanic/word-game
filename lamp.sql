-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Feb 28, 2022 at 10:08 PM
-- Server version: 5.7.29
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lamp`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(18, 'Mario', 'Stanic', 'mario90stanic@gmail.com', '$2y$10$HXsib62OcaHXl7RdD1QS2u6rnHMXoMg7LLT9bdIFPUkQ9hcp1AlIm', '2022-02-25 22:23:59'),
(19, 'teri', 'Stanic', 'mario990stanic@gmail.com', '$2y$10$LGSPXdLfK902baFfESc5Hut.jQHEBIUUj9..TTTtSOJfMlHsqVPDC', '2022-02-28 22:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(10) UNSIGNED NOT NULL,
  `word` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `is_palindrome` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-false; 1-true; 2-almost',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `words`
--

INSERT INTO `words` (`id`, `word`, `user_id`, `points`, `is_palindrome`, `created_at`) VALUES
(33, 'coin', 18, 4, 0, '2022-02-25 19:15:11'),
(34, 'wow', 18, 5, 1, '2022-02-25 20:35:29'),
(35, 'coin', 18, 4, 0, '2022-02-25 20:56:44'),
(36, 'chair', 1, 5, 0, '2022-02-27 12:51:28'),
(37, 'glass', 1, 4, 0, '2022-02-28 11:51:22'),
(38, 'book', 1, 3, 0, '2022-02-28 13:14:32'),
(39, 'watch', 1, 5, 0, '2022-02-28 13:14:51'),
(40, 'test', 1, 5, 2, '2022-02-28 13:21:37'),
(41, 'tennis', 1, 5, 0, '2022-02-28 15:04:38'),
(42, 'bottle', 1, 5, 0, '2022-02-28 16:24:26'),
(43, 'bottle', 1, 5, 0, '2022-02-28 16:27:45'),
(44, 'bottle', 18, 5, 0, '2022-02-28 16:28:00'),
(45, 'house', 18, 5, 0, '2022-02-28 20:57:15'),
(46, 'wow', 19, 5, 1, '2022-02-28 22:03:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
