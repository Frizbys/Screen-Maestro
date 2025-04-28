-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2025 at 04:25 PM
-- Server version: 8.0.41-0ubuntu0.24.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `signage2`
--
CREATE DATABASE IF NOT EXISTS `signage2` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `signage2`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_share_links`
--

CREATE TABLE `media_share_links` (
  `id` int NOT NULL,
  `media_id` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `screen_contents`
--

CREATE TABLE `screen_contents` (
  `id` int NOT NULL,
  `screen_id` int NOT NULL,
  `html_content` text,
  `sort_order` int DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `screen_content_blocks`
--

CREATE TABLE `screen_content_blocks` (
  `id` int NOT NULL,
  `screen_id` int NOT NULL,
  `content_html` text NOT NULL,
  `block_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `screen_share_links`
--

CREATE TABLE `screen_share_links` (
  `id` int NOT NULL,
  `screen_id` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signage_images`
--

CREATE TABLE `signage_images` (
  `id` int NOT NULL,
  `screen_id` int NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `file_type` enum('image','video') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signage_screens`
--

CREATE TABLE `signage_screens` (
  `id` int NOT NULL,
  `screen_number` int NOT NULL,
  `screen_name` varchar(255) NOT NULL,
  `screen_group` varchar(50) DEFAULT NULL,
  `ticker_text` text,
  `ticker_speed` enum('slow','medium','fast') DEFAULT 'medium',
  `ticker_direction` enum('left','right') DEFAULT 'left',
  `ticker_font_size` varchar(20) DEFAULT '16px',
  `ticker_font` varchar(100) DEFAULT 'Arial',
  `ticker_color` varchar(20) DEFAULT '#FFFFFF',
  `ticker_bg_color` varchar(20) DEFAULT '#000000',
  `ticker_enabled` tinyint(1) DEFAULT '1',
  `qr_link` varchar(255) DEFAULT NULL,
  `theme` varchar(50) DEFAULT 'default',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rotation_interval` int DEFAULT '8',
  `layout_mode` enum('media','content','mix') DEFAULT 'media'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `media_share_links`
--
ALTER TABLE `media_share_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `screen_contents`
--
ALTER TABLE `screen_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `screen_content_blocks`
--
ALTER TABLE `screen_content_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `screen_share_links`
--
ALTER TABLE `screen_share_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `signage_images`
--
ALTER TABLE `signage_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `signage_screens`
--
ALTER TABLE `signage_screens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_share_links`
--
ALTER TABLE `media_share_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `screen_contents`
--
ALTER TABLE `screen_contents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `screen_content_blocks`
--
ALTER TABLE `screen_content_blocks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `screen_share_links`
--
ALTER TABLE `screen_share_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `signage_images`
--
ALTER TABLE `signage_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `signage_screens`
--
ALTER TABLE `signage_screens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `media_share_links`
--
ALTER TABLE `media_share_links`
  ADD CONSTRAINT `media_share_links_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `signage_images` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `screen_contents`
--
ALTER TABLE `screen_contents`
  ADD CONSTRAINT `screen_contents_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `screen_content_blocks`
--
ALTER TABLE `screen_content_blocks`
  ADD CONSTRAINT `screen_content_blocks_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `screen_share_links`
--
ALTER TABLE `screen_share_links`
  ADD CONSTRAINT `screen_share_links_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `signage_images`
--
ALTER TABLE `signage_images`
  ADD CONSTRAINT `signage_images_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
