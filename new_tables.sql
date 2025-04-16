-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 11:03 PM
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
-- Database: `my_executor_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `guidances`
--

CREATE TABLE `guidances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guidances_media`
--

CREATE TABLE `guidances_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guidance_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `life_remembereds`
--

CREATE TABLE `life_remembereds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `life_remembereds`
--

INSERT INTO `life_remembereds` (`id`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'sadasdasd', 2, '2025-04-17 03:55:26', '2025-04-17 03:55:26'),
(2, '1232131', 2, '2025-04-17 03:56:17', '2025-04-17 03:56:17'),
(3, '23213123123', 2, '2025-04-17 03:56:33', '2025-04-17 03:56:33'),
(4, '23213123123', 2, '2025-04-17 03:56:36', '2025-04-17 03:56:36'),
(5, '23213123123', 2, '2025-04-17 03:57:14', '2025-04-17 03:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `life_remembered_media`
--

CREATE TABLE `life_remembered_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `life_remembered_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `life_remembered_media`
--

INSERT INTO `life_remembered_media` (`id`, `life_remembered_id`, `file_path`, `file_type`, `created_at`, `updated_at`) VALUES
(1, 5, 'Logo_1744837034.png', 'image/png', '2025-04-17 03:57:14', '2025-04-17 03:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `wishes`
--

CREATE TABLE `wishes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wish_media`
--

CREATE TABLE `wish_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wish_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guidances`
--
ALTER TABLE `guidances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guidances_created_by_foreign` (`created_by`);

--
-- Indexes for table `guidances_media`
--
ALTER TABLE `guidances_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guidances_media_guidances_id_foreign` (`guidance_id`);

--
-- Indexes for table `life_remembereds`
--
ALTER TABLE `life_remembereds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `life_remembereds_created_by_foreign` (`created_by`);

--
-- Indexes for table `life_remembered_media`
--
ALTER TABLE `life_remembered_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `life_remembered_media_life_remembered_id_foreign` (`life_remembered_id`);

--
-- Indexes for table `wishes`
--
ALTER TABLE `wishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishes_created_by_foreign` (`created_by`);

--
-- Indexes for table `wish_media`
--
ALTER TABLE `wish_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wish_media_wish_id_foreign` (`wish_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guidances`
--
ALTER TABLE `guidances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guidances_media`
--
ALTER TABLE `guidances_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `life_remembereds`
--
ALTER TABLE `life_remembereds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `life_remembered_media`
--
ALTER TABLE `life_remembered_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishes`
--
ALTER TABLE `wishes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wish_media`
--
ALTER TABLE `wish_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guidances`
--
ALTER TABLE `guidances`
  ADD CONSTRAINT `guidances_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guidances_media`
--
ALTER TABLE `guidances_media`
  ADD CONSTRAINT `guidances_media_guidances_id_foreign` FOREIGN KEY (`guidance_id`) REFERENCES `guidances` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `life_remembereds`
--
ALTER TABLE `life_remembereds`
  ADD CONSTRAINT `life_remembereds_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `life_remembered_media`
--
ALTER TABLE `life_remembered_media`
  ADD CONSTRAINT `life_remembered_media_life_remembered_id_foreign` FOREIGN KEY (`life_remembered_id`) REFERENCES `life_remembereds` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishes`
--
ALTER TABLE `wishes`
  ADD CONSTRAINT `wishes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wish_media`
--
ALTER TABLE `wish_media`
  ADD CONSTRAINT `wish_media_wish_id_foreign` FOREIGN KEY (`wish_id`) REFERENCES `wishes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
