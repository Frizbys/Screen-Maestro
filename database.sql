SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `media_share_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `media_id` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `media_id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `screen_contents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `screen_id` int NOT NULL,
  `html_content` text,
  `sort_order` int DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `screen_id` (`screen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `screen_content_blocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `screen_id` int NOT NULL,
  `content_html` text NOT NULL,
  `block_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `screen_id` (`screen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `screen_share_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `screen_id` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `screen_id` (`screen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `signage_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `screen_id` int NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `file_type` enum('image','video') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `screen_id` (`screen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `signage_screens` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `layout_mode` enum('media','content','mix') DEFAULT 'media',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Foreign Keys

ALTER TABLE `media_share_links`
  ADD CONSTRAINT `media_share_links_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `signage_images` (`id`) ON DELETE CASCADE;

ALTER TABLE `screen_contents`
  ADD CONSTRAINT `screen_contents_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;

ALTER TABLE `screen_content_blocks`
  ADD CONSTRAINT `screen_content_blocks_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;

ALTER TABLE `screen_share_links`
  ADD CONSTRAINT `screen_share_links_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;

ALTER TABLE `signage_images`
  ADD CONSTRAINT `signage_images_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `signage_screens` (`id`) ON DELETE CASCADE;

COMMIT;
