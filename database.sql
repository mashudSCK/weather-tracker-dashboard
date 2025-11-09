-- ============================================
-- Weather Tracker Database Schema
-- ============================================
-- This file creates the database and can be imported into MySQL
-- Or you can run migrations using: php spark migrate

CREATE DATABASE IF NOT EXISTS `weather_tracker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `weather_tracker`;

-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cities Table
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Weather Logs Table
CREATE TABLE IF NOT EXISTS `weather_logs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` int(11) UNSIGNED NOT NULL,
  `temperature` decimal(5,2) NOT NULL,
  `feels_like` decimal(5,2) DEFAULT NULL,
  `humidity` int(3) DEFAULT NULL,
  `condition` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `wind_speed` decimal(5,2) DEFAULT NULL,
  `fetched_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `weather_logs_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: admin123)
INSERT INTO `users` (`username`, `password`, `role`, `created_at`, `updated_at`) VALUES
('admin', '$2y$10$IeJjzMBBurXsxF1o3ToFpePJrMccTjF0n6aFUL0EwDl1RECICYS9O', 'admin', NOW(), NOW());

-- Insert default regular user (password: user123)
INSERT INTO `users` (`username`, `password`, `role`, `created_at`, `updated_at`) VALUES
('user', '$2y$10$cDc2RmAJ5CBGQPI3OH1/uefK275HNixzBnRMkVHFoxxAxsBwYD1XO', 'user', NOW(), NOW());

-- Insert Philippine cities
INSERT INTO `cities` (`city_name`, `country_code`, `created_at`, `updated_at`) VALUES
('Isulan', 'PH', NOW(), NOW()),
('Davao City', 'PH', NOW(), NOW()),
('Manila', 'PH', NOW(), NOW()),
('Cebu City', 'PH', NOW(), NOW()),
('Cotabato City', 'PH', NOW(), NOW());
