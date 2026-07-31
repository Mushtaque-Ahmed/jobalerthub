-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2026 at 04:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobalert`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `status`, `created_at`) VALUES
(1, 'Job', 'job', '', 1, '2026-07-27 17:25:57'),
(2, 'Result', 'result', '', 1, '2026-07-27 17:26:13'),
(3, 'Admit Card', 'admit-card', '', 1, '2026-07-27 17:26:26'),
(4, 'eBook', 'ebook', '', 1, '2026-07-27 17:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pdf_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pdf_products`
--

CREATE TABLE `pdf_products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `file_size` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT 1,
  `external_download_link` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `author` varchar(150) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pdf_products`
--

INSERT INTO `pdf_products` (`id`, `title`, `slug`, `short_description`, `description`, `featured_image`, `pdf_file`, `file_size`, `price`, `is_free`, `external_download_link`, `seo_title`, `seo_description`, `seo_keywords`, `pages`, `language`, `author`, `category_id`, `status`, `downloads`, `created_at`, `updated_at`) VALUES
(4, 'Enim id id atque l', 'Soluta veniam cumqu', 'Nemo rerum sapiente', 'Rerum accusamus dolo.', '1785248155_6a68b99bda9fc.webp', '1785248155_6a68b99bdaf70.pdf', '0.1 MB', 336.00, 0, 'https://www.tyxigelucepyqit.me.uk', 'Dolores est perspici', 'Nisi doloremque volu', 'Iusto placeat cumqu', 27, 'Dolores est fugit l', 'Debitis perferendis', 3, 1, 0, '2026-07-28 14:15:55', '2026-07-28 14:33:49'),
(6, 'Et velit dicta est', 'Nostrud voluptatem', 'Esse Nam blanditiis', 'Velit in id, sint ap.', '1785248795_6a68bc1b51ab5.webp', '1785248795_6a68bc1b51f89.pdf', '0.1 MB', 589.00, 1, 'https://www.vubyze.me', 'Ut natus deserunt se', 'Distinctio Lorem ad', 'Voluptatum minus nos', 59, 'Quia alias ipsam qui', 'Nulla minus tempor q', 4, 1, 0, '2026-07-28 14:26:35', '2026-07-28 15:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `post_type` enum('job','result','admit_card','answer_key','syllabus','current_affairs','article') NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `organization` varchar(150) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `total_posts` varchar(100) DEFAULT NULL,
  `age_limit` varchar(100) DEFAULT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `application_fee` varchar(255) DEFAULT NULL,
  `apply_start` date DEFAULT NULL,
  `apply_last` date DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `result_date` date DEFAULT NULL,
  `official_website` varchar(255) DEFAULT NULL,
  `apply_link` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `post_type`, `title`, `slug`, `short_description`, `description`, `featured_image`, `organization`, `qualification`, `total_posts`, `age_limit`, `salary`, `application_fee`, `apply_start`, `apply_last`, `exam_date`, `result_date`, `official_website`, `apply_link`, `seo_title`, `seo_description`, `seo_keywords`, `status`, `views`, `created_at`, `updated_at`) VALUES
(1, 1, 'admit_card', 'this is updated title', 'this-is-updated-title', 'Cumque occaecat aut I\'m almost certain the problem is there (wrong include path, database connection, or PHP output before JSON). Once I see it, I can give you the exact fix.', 'Aliqua. Illum, incid.I\'m almost certain the problem is there (wrong include path, database connection, or PHP output before JSON). Once I see it, I can give you the exact fix.', '1785175966_6a679f9eb8209.webp', 'Herring and Hensley LLC', 'Sunt maxime quis sim', 'Suscipit asperiores', 'Irure minima sunt o', 'Error cillum tenetur', 'Nobis rem est persp', '2024-09-06', '1981-02-21', '1998-12-13', '1993-02-18', 'https://www.how.co', 'https://www.how.co', 'Aperiam aut aliquid', 'Eiusmod doloribus in', 'Nostrud numquam sit', 'published', 0, '2026-07-27 17:29:06', '2026-07-28 05:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_favicon` varchar(255) DEFAULT NULL,
  `site_email` varchar(150) DEFAULT NULL,
  `site_phone` varchar(50) DEFAULT NULL,
  `site_address` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `google_verification` text DEFAULT NULL,
  `google_analytics` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_logo`, `site_favicon`, `site_email`, `site_phone`, `site_address`, `footer_text`, `facebook`, `twitter`, `instagram`, `youtube`, `linkedin`, `meta_title`, `meta_description`, `meta_keywords`, `google_verification`, `google_analytics`, `created_at`, `updated_at`) VALUES
(1, 'gobalert', 'logo_1785261304.webp', NULL, 'abc@gmail.com', '08474099294', 'Bijoypur Bongaon', 'all right reserved', '', '', '', '', '', '', '', '', '', '', '2026-07-28 17:53:48', '2026-07-28 17:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Administrator', 'waiz12345@gmail.com', '8472083737', '$2y$10$2fSDWw9/82cWjrqDp.twhe7oF5HLrJyJgpMtdLsaVvyeM0yvNvMzK', 'admin', 1, '2026-07-27 17:21:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_products`
--
ALTER TABLE `pdf_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pdf_products`
--
ALTER TABLE `pdf_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
