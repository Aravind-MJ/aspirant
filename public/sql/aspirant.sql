-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2016 at 07:33 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `student_zone`
--

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE IF NOT EXISTS `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rejpq9q6NDB1NmIpoWpM08FXKyYf0RT6', 1, '2016-08-21 22:53:11', '2016-08-21 22:53:11', '2016-08-21 22:53:11'),
(2, 2, 'JoeXuH26uymNKEe0itQSEReLHIa1Qa4L', 1, '2016-08-21 22:53:11', '2016-08-21 22:53:11', '2016-08-21 22:53:11'),
(3, 3, 'pHkYZj1B2mc3LEJRWFYyPCGvlYniDNhI', 1, '2016-08-21 22:53:12', '2016-08-21 22:53:12', '2016-08-21 22:53:12'),
(4, 4, 'ZdMH03QvKgKYdTdrC8ny2ON9C3aQrsBV', 1, '2016-08-21 22:53:12', '2016-08-21 22:53:12', '2016-08-21 22:53:12'),
(5, 5, 'eQmR03K74hhUocE4U2u3kdEyC2SnOIXH', 1, '2016-08-23 00:19:49', '2016-08-23 00:19:49', '2016-08-23 00:19:49'),
(6, 6, 'WvPz4gRwsv9TqIBIhBJyEit9VTVHtFjq', 1, '2016-08-23 00:36:30', '2016-08-23 00:36:30', '2016-08-23 00:36:30'),
(7, 7, 'zNHtJaiKXd7ObVYhX0I03ywFpLUmyl8y', 1, '2016-08-23 00:38:11', '2016-08-23 00:38:11', '2016-08-23 00:38:11'),
(8, 8, 'Qmf0LPZhWsM4l5BP59wLZAvZq749YENp', 1, '2016-08-23 00:39:49', '2016-08-23 00:39:49', '2016-08-23 00:39:49'),
(9, 9, 'whvoOotbe5IiGg63Kh1d1onqsDTlDVdu', 1, '2016-08-23 00:41:56', '2016-08-23 00:41:56', '2016-08-23 00:41:56'),
(10, 10, 'siBbPoxOax0IReoxmh5eaw0X7aTfyp5g', 1, '2016-08-23 00:45:38', '2016-08-23 00:45:38', '2016-08-23 00:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_id` int(11) NOT NULL,
  `attendance` varchar(255) NOT NULL,
  `present_count` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `batch_id`, `attendance`, `present_count`, `created_at`, `updated_at`) VALUES
(11, 1, '[1,3]', 2, '2016-09-13 04:12:18', '2016-09-13 04:12:18'),
(12, 2, '[2]', 3, '2016-09-13 04:12:22', '2016-09-13 04:40:32'),
(13, 1, '[]', 0, '2016-09-11 18:30:00', '2016-09-11 18:30:00'),
(14, 2, '[2]', 1, '2016-09-11 18:30:00', '2016-09-11 18:30:00'),
(15, 1, '[1,3]', 2, '2016-09-08 18:30:00', '2016-09-08 18:30:00'),
(16, 2, '[2]', 5, '2016-09-08 18:30:00', '2016-09-13 04:40:38'),
(17, 2, '[2]', 1, '2016-09-19 04:52:18', '2016-09-19 04:52:18'),
(18, 1, '[1]', 1, '2016-09-19 06:56:03', '2016-09-19 06:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `batch_details`
--

CREATE TABLE IF NOT EXISTS `batch_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch` varchar(255) NOT NULL,
  `time_shift` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `in_charge` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `batch_details`
--

INSERT INTO `batch_details` (`id`, `batch`, `time_shift`, `year`, `in_charge`, `created_at`, `updated_at`) VALUES
(1, 'Batch 1', '1', 2016, 1, '2016-08-22 08:27:30', '2016-08-30 04:02:29'),
(2, 'Batch 2', '2', 2016, 4, '2016-08-24 09:45:46', '2016-08-29 10:23:27'),
(3, 'Batch 3', '1', 2016, 4, '2016-08-24 10:57:08', '2016-08-29 10:23:30'),
(4, 'Batch 4', '3', 2016, 4, '2016-08-24 10:57:08', '2016-08-29 10:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `exam_details`
--

CREATE TABLE IF NOT EXISTS `exam_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `exam_details`
--

INSERT INTO `exam_details` (`id`, `name`, `type_id`, `exam_date`, `created_at`, `updated_at`) VALUES
(1, 'First Exam', 1, '2016-09-13', '2016-09-01 09:32:11', '2016-09-05 04:04:27'),
(2, 'Second Exam', 2, '2016-09-02', '2016-09-01 10:46:28', '2016-09-05 04:04:34'),
(3, 'Third Exam', 3, '2016-09-20', '2016-09-19 10:18:02', '2016-09-19 10:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_details`
--

CREATE TABLE IF NOT EXISTS `faculty_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qualification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `del_status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mark_details`
--

CREATE TABLE IF NOT EXISTS `mark_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `mark_details`
--

INSERT INTO `mark_details` (`id`, `user_id`, `exam_id`, `mark`, `created_at`, `updated_at`) VALUES
(7, 2, 1, 100, '2016-09-05 03:58:27', '2016-09-05 03:58:27'),
(8, 2, 1, 2, '2016-09-05 09:49:56', '2016-09-05 09:49:56'),
(9, 1, 1, 10, '2016-09-05 09:51:19', '2016-09-20 23:32:28'),
(10, 3, 1, 10, '2016-09-05 09:51:19', '2016-09-20 23:32:28'),
(11, 1, 2, 5, '2016-09-19 09:39:27', '2016-09-19 09:39:27'),
(12, 3, 2, 6, '2016-09-19 09:39:27', '2016-09-19 09:39:27'),
(13, 1, 3, 23, '2016-09-19 10:22:48', '2016-09-19 10:22:48'),
(14, 3, 3, 32, '2016-09-19 10:22:48', '2016-09-19 10:22:48'),
(15, 2, 2, 100, '2016-09-19 11:01:47', '2016-09-20 23:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_07_02_230147_migration_cartalyst_sentinel', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persistences`
--

CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=72 ;

--
-- Dumping data for table `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(5, 4, 'liD82GW00QoyzG52T9ympyM93rbEqQTj', '2016-08-22 04:40:19', '2016-08-22 04:40:19'),
(10, 3, 'HmgD3EVVJuDRAtvPs7sIMl0zcSSiKKm9', '2016-08-23 05:18:41', '2016-08-23 05:18:41'),
(13, 4, 'XgU9qyJDONnvWIe94yjRA9ZXEa0qSJn0', '2016-08-24 01:32:18', '2016-08-24 01:32:18'),
(16, 4, 'FuiWnioVOYfel1FwCuBYOsBZOzYhJbYm', '2016-08-24 06:25:50', '2016-08-24 06:25:50'),
(17, 4, 'c8YrBjxMLFELycT98dS9lb6dinefvup3', '2016-08-26 00:53:40', '2016-08-26 00:53:40'),
(18, 4, 'Xal48soLCofsBmNIYfd80AJRpyzOvX5M', '2016-08-28 22:30:46', '2016-08-28 22:30:46'),
(29, 3, 'XbdADbH2rWptJ7q7ohP26jQpj9dryHWm', '2016-08-30 05:01:46', '2016-08-30 05:01:46'),
(30, 4, 'Cy873WbZz3pS86iuGhTtxMlIMrGxCzNr', '2016-08-30 21:51:57', '2016-08-30 21:51:57'),
(33, 4, 'WajfgFjqJ3ccnyZQtD1CsKaWwpAQGTxv', '2016-09-01 06:10:17', '2016-09-01 06:10:17'),
(34, 4, 'Wp8y6EMOYS7vCEv6nKenmhFgwZi5h2Yw', '2016-09-04 22:02:48', '2016-09-04 22:02:48'),
(36, 2, 'I5crtdLDuh6nssrD03cKcNuIFN9IvZU9', '2016-09-05 00:30:59', '2016-09-05 00:30:59'),
(37, 4, 'FECU7PMGvynMHbo7ypqDAHWpWwemYtM2', '2016-09-05 03:52:12', '2016-09-05 03:52:12'),
(38, 2, 'M6dAgl5BUbnDEYRom0FuGtmK1NhRDROP', '2016-09-05 22:17:41', '2016-09-05 22:17:41'),
(43, 4, 'kALIK50YBF41D4ZpNYIkZnrubMKu5f10', '2016-09-06 05:59:47', '2016-09-06 05:59:47'),
(45, 2, 'HukP9fZ4grGinEH17YIJASF4gWKUUiy3', '2016-09-07 00:02:48', '2016-09-07 00:02:48'),
(46, 4, 'lZZ7x3VsKatwsmPrWnQHlUxDAoMhGIKP', '2016-09-07 05:42:28', '2016-09-07 05:42:28'),
(48, 2, 'Vxi0ZOWwgvqzQyqDzodrWHimeOvrRYUd', '2016-09-09 01:10:29', '2016-09-09 01:10:29'),
(51, 2, 'PwofkfyIP3YNK9aTHKZr6IiosFwd9ZAz', '2016-09-11 23:52:27', '2016-09-11 23:52:27'),
(52, 2, 'O9M037wNsXwgElmxQwb3c7sJcTglQMib', '2016-09-12 22:37:03', '2016-09-12 22:37:03'),
(57, 4, '7D5Ej93UpYfqFmMB2DbdMjOZZ2NmOBoT', '2016-09-19 01:26:12', '2016-09-19 01:26:12'),
(62, 4, 'vFF3HoNG6lOkmJxwx0fosQm5nLqW6shL', '2016-09-19 04:48:16', '2016-09-19 04:48:16'),
(63, 4, 'XGAVLaitj7HTrZ3nGZX7hbww76pYNM6Z', '2016-09-20 01:34:15', '2016-09-20 01:34:15'),
(71, 2, 'odxQuRXAUz0E5AYxXLwIzSVFVOiwy5I2', '2016-09-20 23:38:53', '2016-09-20 23:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'users', 'Users', NULL, '2016-08-21 22:53:11', '2016-08-21 22:53:11'),
(2, 'admins', 'Admins', NULL, '2016-08-21 22:53:11', '2016-08-21 22:53:11'),
(3, 'superadmin', 'SuperAdmin', NULL, '2016-08-21 22:53:11', '2016-08-21 22:53:11'),
(4, 'faculty', 'Faculty', NULL, '2016-08-21 22:53:11', '2016-08-21 22:53:11');

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE IF NOT EXISTS `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2016-08-21 22:53:12', '2016-08-21 22:53:12'),
(2, 2, '2016-08-21 22:53:12', '2016-08-21 22:53:12'),
(3, 3, '2016-08-21 22:53:12', '2016-08-21 22:53:12'),
(4, 4, '2016-08-21 22:53:12', '2016-08-21 22:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE IF NOT EXISTS `student_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `guardian` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `school` varchar(255) NOT NULL,
  `cee_rank` varchar(10) NOT NULL,
  `percentage` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `del_status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`id`, `user_id`, `batch_id`, `gender`, `dob`, `guardian`, `address`, `phone`, `school`, `cee_rank`, `percentage`, `photo`, `del_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'male', '2016-08-18', 'sadasd', 'asdadsasd', '12323123', 'adsxczxc', '12', 12, 'adscasdasd ', 0, '2016-08-29 05:08:21', '2016-08-29 05:08:21'),
(2, 2, 2, 'sad', '2016-08-25', 'asdasd', 'asdasd', '123123', 'asdasd', '12', 12, 'asdasdasd', 0, '2016-08-29 05:23:35', '2016-08-29 05:23:35'),
(3, 3, 1, 'xczc', '2016-08-11', 'zxczxc', 'zxczcx', '123123', 'azxdasdads', '12', 12, 'sadasdasdasd', 0, '2016-08-29 06:51:30', '2016-08-29 06:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2016-08-24 06:25:41', '2016-08-24 06:25:41'),
(2, NULL, 'ip', '::1', '2016-08-24 06:25:41', '2016-08-24 06:25:41'),
(3, 4, 'user', NULL, '2016-08-24 06:25:41', '2016-08-24 06:25:41'),
(4, NULL, 'global', NULL, '2016-08-26 00:53:32', '2016-08-26 00:53:32'),
(5, NULL, 'ip', '::1', '2016-08-26 00:53:32', '2016-08-26 00:53:32'),
(6, 4, 'user', NULL, '2016-08-26 00:53:32', '2016-08-26 00:53:32'),
(7, NULL, 'global', NULL, '2016-08-29 22:33:46', '2016-08-29 22:33:46'),
(8, NULL, 'ip', '::1', '2016-08-29 22:33:46', '2016-08-29 22:33:46'),
(9, NULL, 'global', NULL, '2016-08-29 22:33:57', '2016-08-29 22:33:57'),
(10, NULL, 'ip', '::1', '2016-08-29 22:33:57', '2016-08-29 22:33:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'user@user.com', '$2y$10$Jh8MG/C2mfkBn/R/Nr7cqOFnrb0AJfcMDHspKsv6HSqVe5CaAlKGS', NULL, '2016-08-29 23:33:43', 'UserFirstName', 'UserLastName', '2016-08-21 22:53:11', '2016-08-29 23:33:43'),
(2, 'admin@admin.com', '$2y$10$WTx/bnGquLGuDUyXS5PWaebLRJZA82y5Z3uPIbVNIcIK2FX1AXB56', NULL, '2016-09-20 23:38:53', 'Aravind', 'M J', '2016-08-21 22:53:11', '2016-09-20 23:38:53'),
(3, 'superadmin@superadmin.com', '$2y$10$GEHNUcOZtWEjvwN0gwwuOOSm41YwdF3UDARVybO5IFX9Kl04ENfYe', NULL, '2016-09-06 05:58:11', 'SuperAdminFirstName', 'SuperAdminLastName', '2016-08-21 22:53:12', '2016-09-06 05:58:11'),
(4, 'faculty@faculty.com', '$2y$10$6YLc6QXf/2QLj9lZ3PHo/uRpcn.3ANpYFN9/h08vYmT7HuQzbO/D6', NULL, '2016-09-20 23:35:31', 'FacultyFirstName', 'FacultyLastName', '2016-08-21 22:53:12', '2016-09-20 23:35:31');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
