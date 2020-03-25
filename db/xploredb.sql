-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2020 at 07:37 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xploredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` tinyint(3) NOT NULL,
  `role_id` smallint(4) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `temp_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `otp_code` tinyint(4) DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_key` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `role_id`, `name`, `username`, `password`, `temp_password`, `otp_code`, `phone`, `status`, `ip`, `last_login`, `user_agent`, `reset_key`, `created_at`) VALUES
(1, 1, '', 'superadmin', '$2y$10$EUWe3zy4/S7YJziZFjUhn.1mQjQrP6Ok9QlTZ/GiWE/5r5ohjR.vq', '', NULL, '', 1, '::1', '2020-03-24 04:37:44', 'Chrome 80.0.3987.149Windows 10', '', '2020-01-19 03:43:11'),
(45, 4, 'Issac Sku', 'issac.sku@gmail.com', '$2y$10$U4Lih.s0s.Q4VTpw6yAXHOQCb3fNsrJqJS6ua4sVbVk6B3S84dryi', '', NULL, '(+88) 019-3073-9757', 1, '27.147.205.106', '2020-02-13 06:51:53', 'Chrome 80.0.3987.100Windows 10', NULL, '2020-02-09 02:18:03'),
(46, 5, 'Development Admin', 'devadmin@gmail.com', '$2y$10$ORaLum3dFaDpQPJ0K0wPcuUKMqclLrd28XtaWGqBBuTd.27aKHka6', '', NULL, '(+88) 018-1621-2342', 1, '27.147.205.106', '2020-02-09 20:19:55', 'Chrome 80.0.3987.87Windows 10', NULL, '2020-02-09 13:49:19'),
(47, 6, 'Wasif', 'wasif@gmpire.com', '$2y$10$38oEoaqdIQSTvuV0bC4nMevnmCz1gXyyHmi1pZYboilXvsp6ML4/y', '', NULL, '(+88) 016-8582-5919', 1, '27.147.205.106', '2020-02-13 06:50:08', 'Chrome 80.0.3987.100Windows 10', NULL, '2020-02-12 01:16:12'),
(48, 3, 'Test', 'test@gmpire.com', '$2y$10$BvJV2yKZ0mI.VcS9VdCfdeBkgYES2nvcsaEOsWmRlZcEeez3R85iy', '', NULL, '(+88) 017-1585-4874', 1, '27.147.205.106', '2020-02-13 06:59:12', 'Chrome 80.0.3987.100Windows 10', NULL, '2020-02-14 11:38:53'),
(49, 2, 'Admin Test', 'admin@gmpire.com', '$2y$10$YTqxUpWqWUzvdUaTs7gpJO48AWNma5umuAtxj6jQCa9BOIgqXGBnu', '', NULL, '(+88) 017-1585-4874', 1, '::1', '2020-02-22 09:21:41', 'Chrome 79.0.3945.130Windows 10', NULL, '2020-02-22 03:21:33'),
(50, 4, 'tests', 'content@gmail.com', '$2y$10$oG/tBArQp5TE/uNwXXrkn.9Xrrm3EIp6CjBdBLASqV75eeW6miOZy', '', NULL, '(+88) 012-4444-4444', 1, '::1', '2020-02-22 09:19:09', 'Chrome 79.0.3945.130Windows 10', NULL, '2020-02-22 03:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` tinyint(3) NOT NULL,
  `category_id` smallint(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `position` tinyint(3) NOT NULL DEFAULT 0,
  `updateby` smallint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `category_id`, `name`, `status`, `position`, `updateby`, `created_at`) VALUES
(1, 1, '১০ম বিসিএস', 1, 0, 45, '2020-02-09 13:24:41'),
(2, 1, '১১তম বিসিএস', 1, 0, 45, '2020-02-09 13:25:02'),
(3, 1, '১২তম বিসিএস (পুলিশ)', 1, 0, 45, '2020-02-09 13:27:25'),
(4, 1, '১৩তম বিসিএস', 1, 0, 45, '2020-02-09 13:25:27'),
(5, 1, '১৪তম বিসিএস (শিক্ষা)', 1, 0, 45, '2020-02-09 13:35:50'),
(6, 1, '১৫তম বিসিএস', 1, 0, 45, '2020-02-09 13:26:01'),
(7, 1, '১৬তম বিসিএস (শিক্ষা)', 1, 0, 45, '2020-02-09 13:36:25'),
(8, 1, '১৭তম বিসিএস', 1, 0, 45, '2020-02-09 13:28:10'),
(9, 1, '১৮তম বিসিএস', 1, 0, 45, '2020-02-09 13:28:24'),
(10, 1, '১৯তম বিসিএস (পশু সম্পদ)', 1, 0, 45, '2020-02-09 13:37:26'),
(11, 1, '২০তম বিসিএস', 1, 0, 45, '2020-02-09 13:28:58'),
(12, 1, '২১তম বিসিএস', 1, 0, 45, '2020-02-09 13:29:13'),
(13, 1, '২২তম বিসিএস', 1, 0, 45, '2020-02-09 13:29:25'),
(14, 1, '২৩তম বিসিএস (মুক্তিযোদ্ধা সন্তান)', 1, 0, 45, '2020-02-09 13:39:33'),
(15, 1, '২৪তম বিসিএস (বাতিল)', 1, 0, 45, '2020-02-09 13:31:09'),
(16, 1, '২৪তম বিসিএস', 1, 0, 0, '2020-02-09 13:31:28'),
(17, 1, '২৫তম বিসিএস', 1, 0, 0, '2020-02-09 13:31:47'),
(18, 1, '২৬তম বিসিএস (শিক্ষা)', 1, 0, 45, '2020-02-09 13:41:10'),
(19, 1, '২৭তম বিসিএস', 1, 0, 0, '2020-02-09 13:31:59'),
(20, 1, '২৮তম বিসিএস', 1, 0, 0, '2020-02-09 13:32:04'),
(21, 1, '২৯তম বিসিএস', 1, 0, 0, '2020-02-09 13:32:10'),
(22, 1, '৩০তম বিসিএস', 1, 0, 0, '2020-02-09 13:32:15'),
(23, 1, '৩১তম বিসিএস', 1, 0, 0, '2020-02-09 13:32:21'),
(24, 1, '৩২তম বিসিএস (বিশেষ)', 1, 0, 0, '2020-02-09 13:32:40'),
(25, 1, '৩৩তম বিসিএস', 1, 0, 0, '2020-02-09 13:32:45'),
(26, 1, '৩৪তম বিসিএস', 1, 0, 0, '2020-02-09 13:32:51'),
(27, 1, '৩৫তম বিসিএস', 1, 0, 0, '2020-02-09 13:32:56'),
(28, 1, '৩৬তম বিসিএস', 1, 0, 0, '2020-02-09 13:33:02'),
(29, 1, '৩৭তম বিসিএস', 1, 0, 0, '2020-02-09 13:33:07'),
(30, 1, '৩৮তম বিসিএস', 1, 0, 0, '2020-02-09 13:33:29'),
(31, 1, '৩৯তম বিসিএস (বিশেষ)', 1, 0, 0, '2020-02-09 13:34:36'),
(32, 1, '৪০তম বিসিএস', 1, 0, 0, '2020-02-09 13:34:44'),
(33, 1, 'স্বাস্থ্য ও পরিবার কল্যাণ মন্ত্রণালয়ের সিনিয়র স্টা', 1, 0, 0, '2020-02-09 14:17:05'),
(34, 1, 'বাংলাদেশ রেলওয়ের সহকারী কমান্ডেট', 1, 0, 0, '2020-02-09 14:17:25'),
(35, 1, 'মাদকদ্রব্য নিয়ন্ত্রণ অধিদপ্তরের সহকারী পরিচালক', 1, 0, 0, '2020-02-09 14:17:41'),
(36, 1, 'বাংলাদেশ পল্লী বিদ্যতায়ন বোর্ডের সহকারী সচিব/সহকার', 1, 0, 0, '2020-02-09 14:19:29'),
(37, 1, 'শ্রম ও কর্মসংস্থান মন্ত্রণালয়ের মেডিকেল অফিসার', 1, 0, 0, '2020-02-09 14:19:43'),
(38, 1, 'সাব রেজিস্টার', 1, 0, 0, '2020-02-09 14:19:57'),
(39, 1, 'প্রাথমিক বিদ্যালয় সহকারী শিক্ষক', 1, 0, 0, '2020-02-09 14:20:10'),
(40, 1, 'পাবলিক সার্ভিস কমিশনের সহকারী পরিচালক', 1, 0, 0, '2020-02-09 14:20:18'),
(41, 4, 'development bank', 1, 0, 0, '2020-02-12 07:18:26'),
(42, 1, 'Dip test', 1, 0, 0, '2020-02-14 18:16:11'),
(43, 1, 'test', 1, 0, 0, '2020-02-16 05:21:12'),
(44, 1, 'as', 1, 0, 0, '2020-02-16 05:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `subject_show` tinyint(1) NOT NULL DEFAULT 1,
  `position` tinyint(3) NOT NULL DEFAULT 0,
  `updateby` smallint(4) UNSIGNED NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `status`, `subject_show`, `position`, `updateby`, `updatetime`) VALUES
(1, 'বিসিএস', 1, 1, 1, 45, '2020-03-01 08:08:24'),
(2, 'University Admission', 1, 0, 2, 0, '2020-03-01 08:08:21'),
(3, 'Hsc', 1, 1, 3, 0, '2020-03-01 08:08:23'),
(4, 'Bank', 1, 0, 4, 0, '2020-03-01 08:08:24'),
(5, 'test', 1, 1, 5, 0, '2020-03-23 06:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('fgitjj24ilvnpmkbu7if1qotjncsqhbf', '::1', 1585027113, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353032373131333b69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c655f69647c733a313a2231223b726f6c655f6e616d657c733a31313a2253757065722041646d696e223b746f705f6d656e757c733a393a2264617368626f617264223b7375625f6d656e757c733a393a2264617368626f617264223b7365745f6163746976657c733a393a2264617368626f617264223b6d656e755f636f64657c733a393a2264617368626f617264223b),
('0nbgfbng251ce0k3gjlp62ug8of09mhe', '::1', 1585027660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353032373636303b69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c655f69647c733a313a2231223b726f6c655f6e616d657c733a31313a2253757065722041646d696e223b746f705f6d656e757c733a393a2264617368626f617264223b7375625f6d656e757c733a393a2264617368626f617264223b7365745f6163746976657c733a393a2264617368626f617264223b6d656e755f636f64657c733a393a2264617368626f617264223b),
('6lq8md1c695sp1htbo9uudmt6odfddpq', '::1', 1585028581, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353032383538313b69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c655f69647c733a313a2231223b726f6c655f6e616d657c733a31313a2253757065722041646d696e223b746f705f6d656e757c733a31333a2267656e6572616c5f7365747570223b7375625f6d656e757c733a353a22746f706963223b7365745f6163746976657c733a393a2264617368626f617264223b6d656e755f636f64657c733a393a2264617368626f617264223b),
('em0bhma4obhklcgp7ctutdi5grapah9j', '::1', 1585028893, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353032383839333b69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c655f69647c733a313a2231223b726f6c655f6e616d657c733a31313a2253757065722041646d696e223b746f705f6d656e757c733a31323a2267616d655f73657474696e67223b7375625f6d656e757c733a31323a2267616d655f73657474696e67223b7365745f6163746976657c733a393a2264617368626f617264223b6d656e755f636f64657c733a393a2264617368626f617264223b),
('okefe8b6jv96psafvs7aabh5vnfk3t1e', '::1', 1585030688, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353033303638383b69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c655f69647c733a313a2231223b726f6c655f6e616d657c733a31313a2253757065722041646d696e223b746f705f6d656e757c733a31323a2267616d655f73657474696e67223b7375625f6d656e757c733a31323a2267616d655f73657474696e67223b7365745f6163746976657c733a393a2264617368626f617264223b6d656e755f636f64657c733a393a2264617368626f617264223b),
('101id69bbmfinggj8gpn7odk6e3fh26b', '::1', 1585030739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353033303733393b),
('i28jotbc1am0jvde5v7fraqep0oi1vfb', '::1', 1585031030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353033313033303b69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c655f69647c733a313a2231223b726f6c655f6e616d657c733a31313a2253757065722041646d696e223b746f705f6d656e757c733a31323a2267616d655f73657474696e67223b7375625f6d656e757c733a31323a2267616d655f73657474696e67223b7365745f6163746976657c733a393a2264617368626f617264223b6d656e755f636f64657c733a393a2264617368626f617264223b),
('6n1dkeh4r6nf4iqrrfaf0npcfjd8l24g', '::1', 1585030739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353033303733393b),
('roc3psonvdr1pi3o2hrae2ef7iib63u7', '::1', 1585031054, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538353033313033303b69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c655f69647c733a313a2231223b726f6c655f6e616d657c733a31313a2253757065722041646d696e223b746f705f6d656e757c733a353a227573657273223b7375625f6d656e757c733a353a227573657273223b7365745f6163746976657c733a393a2264617368626f617264223b6d656e755f636f64657c733a393a2264617368626f617264223b);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `description` mediumtext NOT NULL,
  `slug` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `description`, `slug`, `status`) VALUES
(1, '&lt;p&gt;Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;br&gt;&lt;/p&gt;', 'play', 1),
(2, '&lt;p&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&lt;br&gt;&lt;/p&gt;', 'coin', 1),
(3, '&lt;p&gt;&lt;span style=&quot;font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 'toc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `device_info`
--

CREATE TABLE `device_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_id` int(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `manufacture` varchar(250) NOT NULL,
  `version` varchar(50) NOT NULL,
  `fcm_token` text NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `edit_history`
--

CREATE TABLE `edit_history` (
  `id` int(11) NOT NULL,
  `edit_id` int(11) DEFAULT NULL,
  `update_by` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `edit_history`
--

INSERT INTO `edit_history` (`id`, `edit_id`, `update_by`, `slug`, `created_at`) VALUES
(1, 60, 1, 'question', '2020-02-29 12:22:07'),
(2, 60, 1, 'question', '2020-02-29 12:49:11'),
(4, 59, 1, 'question', '2020-02-29 15:25:00'),
(5, 59, 1, 'question', '2020-02-29 15:26:15'),
(6, 59, 1, 'question', '2020-02-29 15:26:32'),
(7, 26, 1, 'library', '2020-02-29 15:27:02'),
(8, 26, 1, 'library', '2020-02-29 15:27:10'),
(9, 26, 1, 'library', '2020-02-29 15:27:19'),
(10, 26, 1, 'library', '2020-03-01 13:28:43'),
(11, 26, 1, 'library', '2020-03-22 13:34:09'),
(12, 26, 1, 'library', '2020-03-22 13:34:18'),
(13, 26, 1, 'library', '2020-03-22 13:34:25'),
(14, 26, 1, 'library', '2020-03-22 13:40:08'),
(15, 26, 1, 'library', '2020-03-22 13:40:14'),
(16, 26, 1, 'library', '2020-03-22 13:40:19'),
(17, 26, 1, 'library', '2020-03-22 13:40:32'),
(18, 27, 1, 'library', '2020-03-22 13:43:38'),
(19, 27, 1, 'library', '2020-03-22 13:43:55'),
(20, 27, 1, 'library', '2020-03-22 14:24:48'),
(21, 27, 1, 'library', '2020-03-22 14:24:59'),
(22, 27, 1, 'library', '2020-03-22 14:25:15'),
(23, 27, 1, 'library', '2020-03-22 14:25:23'),
(24, 27, 1, 'library', '2020-03-22 14:26:04'),
(25, 27, 1, 'library', '2020-03-22 14:26:11'),
(26, 27, 1, 'library', '2020-03-22 14:26:22'),
(27, 27, 1, 'library', '2020-03-22 14:27:31'),
(28, 27, 1, 'library', '2020-03-22 14:31:44'),
(29, 27, 1, 'library', '2020-03-22 14:31:50'),
(30, 27, 1, 'library', '2020-03-22 14:31:59'),
(31, 27, 1, 'library', '2020-03-22 14:32:07'),
(32, 27, 1, 'library', '2020-03-22 14:32:12'),
(33, 27, 1, 'library', '2020-03-22 14:32:20'),
(34, 27, 1, 'library', '2020-03-22 14:32:40'),
(35, 27, 1, 'library', '2020-03-22 14:33:00'),
(36, 27, 1, 'library', '2020-03-22 14:33:52'),
(37, 27, 1, 'library', '2020-03-22 14:34:02'),
(38, 27, 1, 'library', '2020-03-22 14:44:24'),
(39, 27, 1, 'library', '2020-03-22 14:44:33'),
(40, 27, 1, 'library', '2020-03-22 14:45:11'),
(41, 27, 1, 'library', '2020-03-22 14:46:08'),
(42, 27, 1, 'library', '2020-03-22 14:46:25'),
(43, 27, 1, 'library', '2020-03-22 14:46:55'),
(44, 27, 1, 'library', '2020-03-22 14:47:20'),
(45, 27, 1, 'library', '2020-03-22 14:47:28'),
(46, 27, 1, 'library', '2020-03-22 14:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `game_setting`
--

CREATE TABLE `game_setting` (
  `id` int(10) UNSIGNED NOT NULL,
  `game_type_id` smallint(6) NOT NULL,
  `question_number` smallint(6) NOT NULL,
  `game_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `game_setting`
--

INSERT INTO `game_setting` (`id`, `game_type_id`, `question_number`, `game_time`) VALUES
(1, 1, 10, '6'),
(2, 2, 20, '12');

-- --------------------------------------------------------

--
-- Table structure for table `game_type`
--

CREATE TABLE `game_type` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `position` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `game_type`
--

INSERT INTO `game_type` (`id`, `name`, `type`, `position`) VALUES
(1, '6 Min Challenge', 'challenge', 1),
(2, '12 Min Challenge', 'challenge', 2),
(3, 'Model Test', 'model_test', 3);

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `cover_image` varchar(100) DEFAULT NULL,
  `details` longtext NOT NULL,
  `gist` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(6) NOT NULL DEFAULT 0,
  `created_by` smallint(3) NOT NULL,
  `updateby` smallint(3) NOT NULL,
  `approved_by` smallint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `title`, `cover_image`, `details`, `gist`, `status`, `position`, `created_by`, `updateby`, `approved_by`, `created_at`) VALUES
(26, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?', 'uploads/library/coverimage/Xplore_1582001987C.jpg', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu elit at magna viverra viverra. Pellentesque posuere accumsan ornare. Phasellus fermentum risus ut est mollis vehicula. Nulla egestas lacinia elit eget suscipit. Quisque tempus blandit nibh vel tristique. Integer egestas maximus interdum. Donec ut cursus magna. Pellentesque nec nibh lacus. Duis eu ante vitae nibh lobortis pretium.&lt;/p&gt;&lt;p&gt;Ut est tellus, vehicula et suscipit at, pharetra a elit. Nullam fermentum tellus sit amet leo sagittis, quis dictum felis auctor. Vivamus et massa a turpis sollicitudin pretium. Morbi nec libero massa. Sed quis imperdiet odio. Nulla dignissim orci vel neque suscipit elementum. Nullam consectetur lacus eu nisl porta dignissim. Nullam ac imperdiet turpis. Quisque convallis ultrices est, ac laoreet magna vehicula vel. Integer aliquet nisl et hendrerit molestie. Sed et odio ac lacus lacinia posuere vel non leo.&lt;/p&gt;', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu elit at magna viverra viverra. Pellentesque posuere accumsan ornare. Phasellus fermentum risus ut est mollis vehicula. Nulla egestas lacinia elit eget suscipit. Quisque tempus blandit nibh vel tristique. Integer egestas maximus interdum. Donec ut cursus magna. Pellentesque nec nibh lacus. Duis eu ante vitae nibh lobortis pretium.&lt;/p&gt;&lt;p&gt;Ut est tellus, vehicula et suscipit at, pharetra a elit. Nullam fermentum tellus sit amet leo sagittis, quis dictum felis auctor. Vivamus et massa a turpis sollicitudin pretium. Morbi nec libero massa. Sed quis imperdiet odio. Nulla dignissim orci vel neque suscipit elementum. Nullam consectetur lacus eu nisl porta dignissim. Nullam ac imperdiet turpis. Quisque convallis ultrices est, ac laoreet magna vehicula vel. Integer aliquet nisl et hendrerit molestie. Sed et odio ac lacus lacinia posuere vel non leo.&lt;/p&gt;', 1, 1, 1, 1, 0, '2020-02-24 06:36:08'),
(27, 'asd', 'uploads/library/coverimage/Xplore_1584863009C.jpg', '&lt;p&gt;asd&lt;/p&gt;', '&lt;p&gt;asd&lt;/p&gt;', 0, 2, 1, 1, 0, '2020-03-22 07:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `library_image`
--

CREATE TABLE `library_image` (
  `id` tinyint(3) NOT NULL,
  `library_id` smallint(3) NOT NULL,
  `slide_picture_title` varchar(200) DEFAULT NULL,
  `picture` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `library_image`
--

INSERT INTO `library_image` (`id`, `library_id`, `slide_picture_title`, `picture`, `created_at`) VALUES
(13, 26, '', 'uploads/library/slideimage/Xplore_1584862449S_2.jpg', '2020-03-22 07:34:09'),
(14, 26, 'Test', 'uploads/library/slideimage/Xplore_1584862465S_1.jpg', '2020-03-22 07:34:25'),
(15, 26, '', 'uploads/library/slideimage/Xplore_1584862832S_2.jpg', '2020-03-22 07:40:32'),
(44, 27, '', 'uploads/library/slideimage/Xplore_1584866840S_1.jpg', '2020-03-22 08:47:20'),
(46, 27, '', 'uploads/library/slideimage/Xplore_1584866840S_3.jpg', '2020-03-22 08:47:20'),
(47, 27, '', 'uploads/library/slideimage/Xplore_1584866864S_1.jpg', '2020-03-22 08:47:45'),
(48, 27, '', 'uploads/library/slideimage/Xplore_1584866864S_3.png', '2020-03-22 08:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `library_video`
--

CREATE TABLE `library_video` (
  `id` tinyint(3) NOT NULL,
  `library_id` smallint(3) NOT NULL,
  `video_title` varchar(100) DEFAULT NULL,
  `video_url` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `library_video`
--

INSERT INTO `library_video` (`id`, `library_id`, `video_title`, `video_url`, `created_at`) VALUES
(65, 26, 'Test2', 'https://www.youtube.com/embed/lTxn2BuqyzU', '2020-03-22 07:40:32'),
(66, 26, 'Test', 'https://www.youtube.com/embed/HpoVwhSVI38', '2020-03-22 07:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `permission_category`
--

CREATE TABLE `permission_category` (
  `id` int(6) NOT NULL,
  `perm_group_id` smallint(3) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL,
  `link` varchar(100) NOT NULL,
  `submenu` tinyint(1) NOT NULL,
  `subparent` tinyint(1) NOT NULL DEFAULT 0,
  `icon` varchar(50) DEFAULT NULL,
  `position` tinyint(2) NOT NULL,
  `enable_view` tinyint(1) DEFAULT 0,
  `enable_add` tinyint(1) DEFAULT 0,
  `enable_edit` tinyint(1) DEFAULT 0,
  `enable_delete` tinyint(1) DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_category`
--

INSERT INTO `permission_category` (`id`, `perm_group_id`, `name`, `short_code`, `link`, `submenu`, `subparent`, `icon`, `position`, `enable_view`, `enable_add`, `enable_edit`, `enable_delete`, `status`, `created_at`) VALUES
(3, 3, 'Administrator', 'administrator', 'administrator', 0, 0, NULL, 1, 1, 0, 0, 0, 1, '2020-01-16 09:38:46'),
(4, 3, 'Role Permission', 'role_permission', 'role-permission', 1, 0, '', 1, 1, 1, 1, 0, 1, '2020-01-16 09:38:46'),
(5, 3, 'Manage User', 'manage_user', 'manage-user', 1, 0, '', 2, 1, 1, 1, 0, 1, '2020-01-16 09:38:46'),
(6, 4, 'General Setup', 'general_setup', 'general-setup', 0, 0, NULL, 3, 1, 0, 0, 0, 1, '2020-01-16 09:38:46'),
(7, 5, 'Dashboard', 'dashboard', 'dashboard', 0, 0, NULL, 1, 1, 0, 0, 0, 1, '2020-01-18 05:05:30'),
(8, 4, 'Category', 'category', 'category', 1, 0, '', 1, 1, 1, 1, 1, 1, '2020-01-16 09:38:46'),
(9, 4, 'Subject', 'subject', 'subject', 1, 0, '', 2, 1, 1, 1, 1, 1, '2020-01-18 04:55:50'),
(10, 4, 'Section', 'section', 'section', 1, 0, '', 3, 1, 1, 1, 1, 1, '2020-01-18 04:55:50'),
(11, 4, 'Topic', 'topic', 'topic', 1, 0, '', 4, 1, 1, 1, 1, 1, '2020-01-18 04:55:50'),
(12, 3, 'Assign Permission', 'assign_permission', 'assign-permission', 0, 0, '', 1, 1, 1, 1, 0, 0, '2020-01-18 05:09:10'),
(13, 6, 'Setting', 'setting', 'setting', 0, 0, NULL, 7, 1, 0, 0, 0, 0, '2020-01-19 04:42:13'),
(14, 6, 'Reset Profile', 'reset_profile', 'reset-profile', 1, 0, '', 1, 1, 0, 1, 0, 1, '2020-01-18 06:34:47'),
(15, 3, 'Backup', 'backup', 'backup', 1, 0, '', 1, 1, 1, 0, 0, 1, '2020-01-19 07:33:46'),
(16, 4, 'Subject Assign', 'subject_assign', 'subject-assign', 1, 0, '', 3, 1, 1, 1, 1, 1, '2020-01-19 04:42:04'),
(17, 4, 'Section Assign', 'section_assign', 'section-assign', 1, 0, '', 4, 1, 1, 1, 1, 1, '2020-01-19 04:42:04'),
(18, 4, 'Topic Assign', 'topic_assign', 'topic-assign', 1, 0, '', 6, 1, 1, 1, 1, 1, '2020-01-19 04:42:04'),
(19, 7, 'Question Setup', 'question_setup', 'question-setup', 0, 0, NULL, 3, 1, 0, 0, 0, 1, '2020-01-22 05:02:32'),
(20, 7, 'Question', 'question', 'question', 1, 0, '', 1, 1, 1, 1, 0, 1, '2020-01-22 05:37:15'),
(23, 4, 'Batch', 'batch', 'batch', 1, 0, '', 1, 1, 1, 1, 0, 1, '2020-01-25 06:24:21'),
(24, 4, 'Question Year', 'question_year', 'question-year', 1, 0, '', 2, 1, 1, 1, 0, 0, '2020-01-25 06:24:42'),
(25, 8, 'Library Setup', 'library_setup', 'library-setup', 0, 0, NULL, 3, 1, 0, 0, 0, 1, '2020-01-27 08:44:24'),
(26, 8, 'Library', 'library', 'library', 1, 0, '', 1, 1, 1, 1, 0, 1, '2020-01-27 08:44:38'),
(27, 5, 'Total Question', 'total_question', 'total-question', 0, 0, '', 1, 1, 0, 0, 0, 0, '2020-02-22 08:27:12'),
(28, 4, 'Subject Show', 'subject_show', 'subject-show', 1, 8, '', 1, 1, 0, 0, 0, 0, '2020-02-26 07:53:28'),
(29, 7, 'Question Edit History', 'question_edit_history', 'question-edit-history', 0, 0, '', 1, 1, 0, 0, 0, 0, '2020-02-29 06:51:54'),
(30, 8, 'Library Edit History', 'library_edit_history', 'library-edit-history', 0, 0, '', 1, 1, 0, 0, 0, 0, '2020-02-29 08:58:11'),
(31, 9, 'Game Setting', 'game_setting', 'game-setting', 0, 0, NULL, 4, 1, 1, 1, 0, 0, '2020-03-24 05:49:02'),
(32, 10, 'Users', 'users', 'users', 0, 0, NULL, 4, 1, 0, 0, 1, 0, '2020-03-24 05:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE `permission_group` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `short_code` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `position` tinyint(1) NOT NULL,
  `is_active` smallint(1) DEFAULT 1,
  `system` smallint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`, `short_code`, `link`, `position`, `is_active`, `system`, `created_at`) VALUES
(3, 'Administrator', 'administrator', 'administrator', 1, 1, 0, '2020-01-18 07:25:19'),
(4, 'General Setup', 'general_setup', 'general-setup', 3, 1, 0, '2020-01-18 07:25:16'),
(5, 'Dashboard', 'dashboard', 'dashboard', 1, 1, 0, '2020-01-18 07:25:17'),
(6, 'Setting', 'setting', 'setting', 7, 1, 0, '2020-01-19 04:42:13'),
(7, 'Question Setup', 'question_setup', 'question-setup', 3, 1, 0, '2020-01-22 05:02:31'),
(8, 'Library Setup', 'library_setup', 'library-setup', 3, 1, 0, '2020-01-27 08:44:24'),
(9, 'Game Setting', 'game_setting', 'game-setting', 4, 1, 0, '2020-03-24 05:49:01'),
(10, 'Users', 'users', 'users', 4, 1, 0, '2020-03-24 05:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(7) UNSIGNED NOT NULL,
  `difficulty` tinyint(1) NOT NULL,
  `title` text NOT NULL,
  `option_1` varchar(100) NOT NULL,
  `option_2` varchar(100) NOT NULL,
  `option_3` varchar(100) NOT NULL,
  `option_4` varchar(100) NOT NULL,
  `answer` tinyint(1) NOT NULL,
  `answer_explain` text NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `created_by_admin` smallint(3) NOT NULL,
  `created_by_user` int(7) NOT NULL,
  `approved_by` smallint(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending,1=approved',
  `position` int(6) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updateby` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `difficulty`, `title`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`, `answer_explain`, `picture`, `created_by_admin`, `created_by_user`, `approved_by`, `status`, `position`, `created_at`, `updateby`) VALUES
(1, 2, 'পূর্ববঙ্গ ও আসাম প্রদেশ গঠনকালে ব্রিটিস ভারতের গভর্নর জেনারেল ও ভাইসরয় ছিলেন-', 'লর্ড রিপন', 'লর্ড কার্জন', 'লর্ড মিন্টো', 'লর্ড হার্ডিঞ্জ', 2, '&lt;p style=&quot;text-align: justify; &quot;&gt;&lt;span id=&quot;docs-internal-guid-d6f5d4c9-7fff-337b-3513-1611943bd802&quot; style=&quot;font-size: medium;&quot;&gt;&lt;span style=&quot;font-size: 11pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;ব্রিটিস শাসনামলে বাংলা, বিহার, উড়িষ্যা, মধ্য প্রদেশ ও আসামের কিছু অংশ নিয়ে গঠিত হয়েছিল বাংলা প্রদেশ বা বাংলা প্রেসিডেন্সি। এর আয়তন বড় হওয়ায় ১৯০৩ সালে বঙ্গভঙ্গের পরিকল্পনা গৃহীত হয়। ১৯০৪ সালে ভারত সচিব এটি অনুমোদন করেন এবং ১৯০৫ সালের জুলাই মাসে বঙ্গভঙ্গের পরিকল্পনা প্রকাশিত হয়। এ পরিকল্পনায় ঢাকা, চট্টগ্রাম, রাজশাহী, আসাম, জলপাইগুড়ি, পার্বত্য ত্রিপুরা ও মালদহ নিয়ে গঠিত হয় পূর্ব বঙ্গ ও আসাম নামে নতুন প্রদেশ। এ প্রদেশ গঠনকালে ব্রিটিস ভারতের গভর্নর জেনারেল ও ভাইসরয় ছিলেন লর্ড কার্জন। বঙ্গভঙ্গ রদের সময় গভর্নর ছিলেন লর্ড হার্ডিঞ্জ। &lt;/span&gt;&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', NULL, 45, 0, 0, 0, 1, '2020-02-09 14:02:51', 0),
(3, 2, 'বাঙালি জাতির প্রধান অংশ কোন মূল জাতিগোষ্ঠীর অন্তর্ভুক্ত?', 'দ্রাবিড়', 'নেগ্রিটো', 'ভোটচীন', 'অস্ট্রিক', 4, '&lt;p style=&quot;text-align: justify; &quot;&gt;&lt;span id=&quot;docs-internal-guid-b6788ef5-7fff-328d-234a-0e04dd3e0636&quot; style=&quot;font-size: medium;&quot;&gt;&lt;span style=&quot;font-size: 11pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;প্রাচীনকালে আর্যপূর্ব জনগোষ্ঠীর যে চারটি শাখা এখানে বাস করতো তারা হলো অস্ট্রিক, দ্রাবিড়, নেগ্রিটো ও ভোটচীনীয়। উল্লিখিত চারটি জনগোষ্ঠীর মধ্যে অস্ট্রিক জনগোষ্ঠী থেকে বাঙালি জাতির প্রধান অংশ গঠিত হয়েছে। &lt;/span&gt;&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', NULL, 45, 0, 0, 0, 2, '2020-02-09 16:36:13', 1),
(4, 1, 'বাংলা আদি অধিবাসীগণ কোন ভাষাভাষী ছিলেন?', 'বাংলা', 'হিন্দি', 'অস্ট্রিক', 'সংস্কৃত', 3, '&lt;p style=&quot;text-align: justify; &quot;&gt;&lt;span id=&quot;docs-internal-guid-795bd806-7fff-537f-4e28-916d75d12c72&quot; style=&quot;font-size: medium;&quot;&gt;&lt;span style=&quot;font-size: 11pt; font-family: Arial; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;অস্ট্রিক প্রাচীন বাংলার একটি নৃ-গোষ্ঠী। প্রাচীন সাহিত্যে এরা নিষাদ নামে পরিচিত। এরা বাংলাদেশের কোল, ভীল, সাঁওতাল, ভূমিজ মুণ্ডা, বাঁশফোঁড়, মালপাহাড়ি প্রভৃতি জনগোষ্ঠীর পূর্বপুরুষ রূপে চিহ্নিত। নৃতত্ত্ববিদগণ মনে করেন যে, বাংলাদেশের আদিম অধিবাসীদের ওপর অস্ট্রিক বা অস্ট্রোলয়েডদের বেশ প্রভাব ছিল। ফলে বাংলা আদি অধিবাসীগণ অস্ট্রিক ভাষাভাষী ছিলেন।&lt;/span&gt;&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', NULL, 45, 0, 0, 0, 3, '2020-02-09 14:23:40', 0),
(5, 2, 'আর্যজাতি কোন দেশ থেকে এসেছিল?', 'বাহরাইন', 'ইরাক', 'মেক্সিকো', 'ইরান', 4, '', NULL, 45, 0, 0, 0, 4, '2020-02-09 14:28:25', 0),
(7, 1, 'আর্যদের আদি বাসস্থান কোথায় ছিল?', 'ইউরাল পর্বতের দক্ষিণে তৃণভূমি অঞ্চলে', 'হিমালয়ের পাদদেশে নেপালের দক্ষিণে', 'ভাগীরথী নদীর পশ্চিম তীরে', 'আফগানিস্তানের দক্ষিণ-পূর্ব পাহাড়ি এলাকায়', 1, '', NULL, 45, 0, 0, 0, 5, '2020-02-09 14:31:10', 0),
(8, 1, 'নৃতাত্ত্বিকভাবে বাংলাদেশের মানুষ প্রধানত কোন নরগোষ্ঠীর অন্তর্ভুক্ত?', 'অ্যালপাইন', 'আদি-অস্ট্রেলীয়', 'নার্কিড', 'মঙ্গোলীয়', 2, '', NULL, 45, 0, 0, 0, 1, '2020-02-13 07:13:58', 1),
(9, 1, 'question title', 'a', 'b', 'c', 'd', 3, '&lt;p&gt;afasjflasjfljhfkfhfkjjflkjkfjkfkfkldfkljsdflkjsaflj&lt;/p&gt;', NULL, 1, 0, 0, 0, 2, '2020-02-12 07:05:27', 1),
(10, 2, 'question 2', 'a', 'b', 'c', 'd', 2, '&lt;p&gt;&lt;a href=&quot;https://www.tutorialspoint.com/computer_programming/computer_programming_decisions.htm&quot; target=&quot;_blank&quot;&gt;to know more&lt;/a&gt;&lt;a href=&quot;https://www.tutorialspoint.com/computer_programming/computer_programming_decisions.htm&quot;&gt;&lt;/a&gt;&lt;/p&gt;&lt;p&gt;joyjslasjfoasjf&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;a href=&quot;https://www.youtube.com/watch?v=DCl0RlmNEOk&quot; target=&quot;_blank&quot;&gt;please see the video&lt;/a&gt;&lt;br&gt;&lt;/p&gt;', NULL, 1, 0, 0, 0, 3, '2020-02-15 06:34:59', 1),
(12, 2, 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয় ?', 'dsf', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;ddfgd&lt;/p&gt;', 'uploads/question/Xplore_1581833258Q.jpg', 1, 0, 0, 0, 9, '2020-02-16 06:07:38', 0),
(13, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1581833390Q.png', 1, 0, 0, 0, 10, '2020-02-16 06:09:50', 0),
(15, 3, 'গণপ্রজাতন্ত্রী বাংলাsদেশেরasd সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 4, '&lt;p&gt;asdasd&lt;/p&gt;', 'uploads/question/Xplore_1581833490Q.png', 1, 0, 0, 0, 11, '2020-02-16 06:11:30', 0),
(16, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের asdসংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;asdasd&lt;/p&gt;', 'uploads/question/Xplore_1582012671Q.jpg', 1, 0, 0, 0, 12, '2020-02-18 07:57:51', 0),
(18, 2, 'গণপ্রজাতন্ত্রীasd বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;asdasd&lt;/p&gt;', NULL, 1, 0, 0, 0, 13, '2020-02-18 08:02:32', 0),
(20, 2, 'গণপ্রজাতন্ত্রীsdf বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 4, '&lt;p&gt;sdfsdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 14, '2020-02-18 08:06:53', 0),
(21, 2, 'গণপ্রজাতন্ত্রী বাংলাsদেশের sdfsdfসংবিধান প্রবর্তিত হয় ?', 'dsf', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;asd&lt;/p&gt;', NULL, 1, 0, 0, 0, 15, '2020-02-18 08:11:51', 0),
(22, 2, 'sdfsdf', 'sdf', 'sdf', 'sdf', 'sdf', 2, '&lt;p&gt;&lt;br&gt;&lt;/p&gt;', NULL, 1, 0, 0, 0, 16, '2020-02-18 08:12:01', 0),
(23, 2, 'sdf', 'sf', 'sdf', 'sdf', 'sdf', 2, '&lt;p&gt;sdfs&lt;/p&gt;', NULL, 1, 0, 0, 0, 17, '2020-02-18 08:12:14', 0),
(24, 2, 'sdfasd', 'sdf', 'sdf', 'sdf', 'sdf', 2, '&lt;p&gt;&lt;br&gt;&lt;/p&gt;', NULL, 1, 0, 0, 0, 18, '2020-02-18 08:13:16', 0),
(25, 2, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংবিধান প্রasdasdasdaবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;&lt;br&gt;&lt;/p&gt;', NULL, 1, 0, 0, 0, 19, '2020-02-18 08:13:38', 0),
(26, 2, 'adadsasfasdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;&lt;br&gt;&lt;/p&gt;', NULL, 1, 0, 0, 0, 20, '2020-02-18 08:15:32', 0),
(27, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের cংxিvান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;adasd&lt;/p&gt;', NULL, 1, 0, 0, 0, 21, '2020-02-18 08:26:37', 0),
(28, 1, 'গণপ্রজাতন্ত্রী বাংsাdেfেsdদংসি্াফসপ্রবর্তিত হয় ?fghfgh', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;&lt;br&gt;&lt;/p&gt;', NULL, 1, 0, 0, 0, 22, '2020-02-18 08:26:56', 0),
(29, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশেfghংfিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;fghfh&lt;/p&gt;', 'uploads/question/Xplore_1582014724Q.png', 1, 0, 0, 0, 23, '2020-02-18 08:32:04', 0),
(30, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংaিaাaaa্রaa্তিaaaa়aaa', 'dsf', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;asas&lt;/p&gt;', 'uploads/question/Xplore_1582014811Q.jpg', 1, 0, 0, 0, 24, '2020-02-18 08:33:31', 0),
(32, 1, 'sdfsdf3sdf', 'sdf', 'sdf', 'sdf', 'sdf', 3, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1582014894Q.jpg', 1, 0, 0, 0, 26, '2020-02-18 08:34:54', 0),
(33, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেsেdfসংবিধান প্রবs্তিdfহয় ?sdfdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;sdfsdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 27, '2020-02-18 08:38:26', 0),
(34, 2, 'গণপ্রজাতন্ত্রী aাংsাdaেsেd সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 1, '&lt;p&gt;asda&lt;/p&gt;', NULL, 1, 0, 0, 0, 28, '2020-02-18 08:41:05', 0),
(35, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয় ?dcsd', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;sdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 29, '2020-02-18 08:42:50', 0),
(36, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয় ?f sdfsdf', '১৭ এপ্রিল, ১৯৭১', 'asdf', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;sdfsdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 30, '2020-02-18 08:43:46', 0),
(37, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশেরvnbvnbv সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;hhvv&lt;/p&gt;', NULL, 1, 0, 0, 0, 31, '2020-02-19 03:41:17', 0),
(38, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?sdhhhhhhhhhhhhhh', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;fvcdxjg v&amp;nbsp;&lt;/p&gt;', NULL, 1, 0, 0, 0, 32, '2020-02-22 08:14:24', 0),
(39, 1, 'dsfsdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', 'adsf', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1582014852Q.png', 1, 0, 0, 0, 25, '2020-02-18 08:34:12', 0),
(40, 1, 'sdfsdf3sdf', 'sdf', 'sdf', 'sdf', 'sdf', 3, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1582014894Q.jpg', 1, 0, 0, 0, 26, '2020-02-18 08:34:54', 0),
(41, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেsেdfসংবিধান প্রবs্তিdfহয় ?sdfdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;sdfsdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 27, '2020-02-18 08:38:26', 0),
(42, 2, 'গণপ্রজাতন্ত্রী aাংsাdaেsেd সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 1, '&lt;p&gt;asda&lt;/p&gt;', NULL, 1, 0, 0, 0, 28, '2020-02-18 08:41:05', 0),
(43, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয় ?dcsd', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;sdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 29, '2020-02-18 08:42:50', 0),
(44, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয় ?f sdfsdf', '১৭ এপ্রিল, ১৯৭১', 'asdf', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;sdfsdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 30, '2020-02-18 08:43:46', 0),
(45, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশেরvnbvnbv সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;hhvv&lt;/p&gt;', NULL, 1, 0, 0, 0, 31, '2020-02-19 03:41:17', 0),
(46, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?sdhhhhhhhhhhhhhh', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;fvcdxjg v&amp;nbsp;&lt;/p&gt;', NULL, 1, 0, 0, 0, 32, '2020-02-22 08:14:24', 0),
(47, 1, 'dsfsdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', 'adsf', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1582014852Q.png', 1, 0, 0, 0, 25, '2020-02-18 08:34:12', 0),
(48, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশেরvnbvnbv সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;hhvv&lt;/p&gt;', NULL, 1, 0, 0, 0, 31, '2020-02-19 03:41:17', 0),
(49, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?sdhhhhhhhhhhhhhh', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;fvcdxjg v&amp;nbsp;&lt;/p&gt;', NULL, 1, 0, 0, 0, 32, '2020-02-22 08:14:24', 0),
(50, 1, 'dsfsdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', 'adsf', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1582014852Q.png', 1, 0, 0, 0, 25, '2020-02-18 08:34:12', 0),
(51, 1, 'sdfsdf3sdf', 'sdf', 'sdf', 'sdf', 'sdf', 3, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1582014894Q.jpg', 1, 0, 0, 0, 26, '2020-02-18 08:34:54', 0),
(52, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেsেdfসংবিধান প্রবs্তিdfহয় ?sdfdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;sdfsdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 27, '2020-02-18 08:38:26', 0),
(53, 2, 'গণপ্রজাতন্ত্রী aাংsাdaেsেd সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 1, '&lt;p&gt;asda&lt;/p&gt;', NULL, 1, 0, 0, 0, 28, '2020-02-18 08:41:05', 0),
(54, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয় ?dcsd', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;sdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 29, '2020-02-18 08:42:50', 0),
(55, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয় ?f sdfsdf', '১৭ এপ্রিল, ১৯৭১', 'asdf', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;sdfsdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 30, '2020-02-18 08:43:46', 0),
(56, 1, 'গণপ্রজাতন্ত্রী বাংলাদেশেরvnbvnbv সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;hhvv&lt;/p&gt;', NULL, 1, 0, 0, 0, 31, '2020-02-19 03:41:17', 0),
(57, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেশের সংবিধান প্রবর্তিত হয় ?sdhhhhhhhhhhhhhh', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 2, '&lt;p&gt;fvcdxjg v&amp;nbsp;&lt;/p&gt;', NULL, 1, 0, 0, 0, 32, '2020-02-22 08:14:24', 0),
(58, 1, 'dsfsdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', 'adsf', '২৬ মার্চ, ১৯৭৩', 3, '&lt;p&gt;sdf&lt;/p&gt;', 'uploads/question/Xplore_1582014852Q.png', 1, 0, 0, 1, 25, '2020-02-24 06:34:04', 0),
(59, 1, 'গণপ্রজাতন্ত্রী বাংলাsদেsdfশের সংবিধান প্রবর্তিত হয় ?', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 1, '&lt;p&gt;sdf&lt;/p&gt;', NULL, 1, 0, 0, 0, 53, '2020-02-29 09:25:00', 1),
(60, 1, 'sdfdfsdf', '১৭ এপ্রিল, ১৯৭১', '১৬ ডিসেম্বর,১৯৭২', '৭ মার্চ, ১৯৭৩', '২৬ মার্চ, ১৯৭৩', 1, '&lt;p&gt;sdf&lt;/p&gt;', NULL, 1, 0, 1, 2, 54, '2020-02-29 06:22:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `question_batch_year`
--

CREATE TABLE `question_batch_year` (
  `id` int(11) NOT NULL,
  `question_id` int(7) UNSIGNED NOT NULL,
  `batch_id` smallint(3) NOT NULL,
  `question_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_batch_year`
--

INSERT INTO `question_batch_year` (`id`, `question_id`, `batch_id`, `question_year`) VALUES
(1, 1, 29, 2016),
(4, 4, 33, 2017),
(5, 4, 34, 2000),
(6, 4, 35, 2009),
(10, 5, 37, 2003),
(11, 7, 37, 2003),
(13, 3, 28, 2016),
(14, 3, 20, 2008),
(15, 3, 36, 2017),
(19, 8, 38, 2003),
(20, 9, 40, 2019),
(21, 9, 37, 2016),
(22, 9, 36, 2013),
(25, 12, 42, 2019),
(26, 13, 44, 2020),
(27, 15, 40, 2016),
(28, 16, 42, 2018),
(29, 16, 34, 2012),
(30, 18, 42, 2018),
(31, 18, 41, 2017),
(32, 20, 43, 2019),
(33, 21, 42, 2017),
(34, 21, 34, 2010),
(35, 22, 42, 2017),
(36, 22, 34, 2010),
(37, 23, 42, 2017),
(38, 23, 34, 2010),
(39, 24, 42, 2017),
(40, 24, 34, 2010),
(41, 25, 42, 2017),
(42, 25, 34, 2010),
(43, 26, 42, 2017),
(44, 26, 34, 2010),
(45, 27, 43, 2018),
(46, 28, 43, 2018),
(47, 29, 43, 2018),
(48, 30, 44, 2018),
(50, 32, 44, 2018),
(51, 33, 39, 2019),
(52, 34, 43, 2015),
(53, 35, 43, 2019),
(54, 37, 38, 2018),
(55, 37, 34, 2011),
(56, 38, 36, 2013),
(57, 38, 31, 2009),
(64, 60, 41, 2016),
(65, 60, 34, 2011),
(70, 59, 41, 2016),
(71, 59, 34, 2011);

-- --------------------------------------------------------

--
-- Table structure for table `question_bookmark`
--

CREATE TABLE `question_bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_bookmark`
--

INSERT INTO `question_bookmark` (`id`, `user_id`, `question_id`) VALUES
(1, 1, 57),
(2, 1, 7),
(3, 1, 36),
(4, 1, 16),
(5, 1, 15),
(6, 1, 1500),
(7, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `question_reports`
--

CREATE TABLE `question_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) NOT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question_year`
--

CREATE TABLE `question_year` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `updateby` smallint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_year`
--

INSERT INTO `question_year` (`id`, `name`, `status`, `updateby`, `created_at`) VALUES
(2, '2019', 1, 0, '2020-01-25 06:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `recently_learn`
--

CREATE TABLE `recently_learn` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED DEFAULT NULL,
  `category_id` smallint(5) UNSIGNED DEFAULT NULL,
  `subject_id` smallint(5) UNSIGNED DEFAULT NULL,
  `section_id` smallint(5) UNSIGNED DEFAULT NULL,
  `topic_id` smallint(5) UNSIGNED DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(3) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `type`, `created_at`) VALUES
(1, 'Super Admin', 'system', '2020-01-16 07:53:12'),
(2, 'Admin', 'system', '2020-01-16 07:53:12'),
(4, 'Content Manager', 'custom', '2020-02-24 05:29:41'),
(5, 'App Manager', 'custom', '2020-02-24 05:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(6) UNSIGNED NOT NULL,
  `role_id` smallint(4) DEFAULT NULL,
  `perm_cat_id` smallint(4) DEFAULT NULL,
  `can_view` tinyint(1) DEFAULT NULL,
  `can_add` tinyint(1) DEFAULT NULL,
  `can_edit` tinyint(1) DEFAULT NULL,
  `can_delete` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_id`, `perm_cat_id`, `can_view`, `can_add`, `can_edit`, `can_delete`, `created_at`) VALUES
(19, 2, 13, 1, 0, 0, 0, '2020-01-18 06:34:53'),
(20, 2, 14, 1, 0, 1, 0, '2020-01-18 06:34:53'),
(32, 2, 19, 1, 0, 0, 0, '2020-01-26 05:42:51'),
(33, 2, 20, 1, 1, 1, 0, '2020-02-22 08:22:08'),
(34, 2, 25, 1, 0, 0, 0, '2020-01-27 08:45:07'),
(35, 2, 26, 1, 1, 1, 0, '2020-02-22 08:22:08'),
(36, 4, 26, 1, 1, 1, 0, '2020-01-27 16:39:47'),
(37, 4, 6, 1, 0, 0, 0, '2020-02-09 07:56:07'),
(39, 4, 9, 1, 1, 1, 0, '2020-02-22 08:19:34'),
(40, 4, 10, 1, 1, 1, 0, '2020-02-22 08:19:34'),
(41, 4, 11, 1, 1, 1, 0, '2020-02-22 08:19:34'),
(42, 4, 16, 1, 1, 1, 0, '2020-02-22 08:19:34'),
(43, 4, 17, 1, 1, 1, 0, '2020-02-22 08:19:34'),
(44, 4, 18, 1, 1, 1, 0, '2020-02-22 08:19:34'),
(45, 4, 23, 1, 1, 1, 0, '2020-02-09 07:56:07'),
(46, 4, 24, 1, 1, 1, 0, '2020-02-09 07:56:07'),
(47, 4, 25, 1, 0, 0, 0, '2020-02-09 07:56:07'),
(48, 4, 19, 1, 0, 0, 0, '2020-02-09 07:56:07'),
(49, 4, 20, 1, 1, 1, 0, '2020-02-09 07:56:07'),
(50, 5, 3, 1, 0, 0, 0, '2020-02-09 08:16:22'),
(51, 5, 4, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(52, 5, 5, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(53, 5, 12, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(54, 5, 15, 1, 1, 0, 0, '2020-02-09 08:16:22'),
(55, 5, 7, 1, 0, 0, 0, '2020-02-09 08:16:22'),
(56, 5, 6, 1, 0, 0, 0, '2020-02-09 08:16:22'),
(57, 5, 8, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(58, 5, 9, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(59, 5, 10, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(60, 5, 11, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(61, 5, 16, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(62, 5, 17, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(63, 5, 18, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(64, 5, 23, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(65, 5, 24, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(66, 5, 25, 1, 0, 0, 0, '2020-02-09 08:16:22'),
(67, 5, 26, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(68, 5, 19, 1, 0, 0, 0, '2020-02-09 08:16:22'),
(69, 5, 20, 1, 1, 1, 0, '2020-02-09 08:16:22'),
(70, 5, 13, 1, 0, 0, 0, '2020-02-09 08:16:22'),
(71, 5, 14, 1, 0, 1, 0, '2020-02-09 08:16:22'),
(72, 4, 13, 1, 0, 0, 0, '2020-02-09 20:05:21'),
(73, 4, 14, 1, 0, 1, 0, '2020-02-09 20:05:21'),
(94, 4, 8, 1, 1, 1, 0, '2020-02-22 08:19:34'),
(100, 2, 7, 1, 0, 0, 0, '2020-02-22 08:22:08'),
(107, 2, 3, 1, 0, 0, 0, '2020-02-22 08:24:40'),
(108, 2, 4, 1, 1, 1, 0, '2020-02-22 08:24:40'),
(109, 2, 5, 1, 1, 1, 0, '2020-02-22 08:24:40'),
(110, 2, 12, 1, 1, 1, 0, '2020-02-22 08:24:40'),
(111, 2, 15, 1, 1, 0, 0, '2020-02-22 08:24:40'),
(112, 2, 27, 1, 0, 0, 0, '2020-03-24 05:50:00'),
(113, 2, 31, 1, 1, 1, 0, '2020-03-24 05:50:00'),
(114, 2, 6, 1, 0, 0, 0, '2020-03-24 05:50:00'),
(115, 2, 8, 1, 1, 1, 1, '2020-03-24 05:50:00'),
(116, 2, 9, 1, 1, 1, 1, '2020-03-24 05:50:00'),
(117, 2, 10, 1, 1, 1, 1, '2020-03-24 05:50:00'),
(118, 2, 11, 1, 1, 1, 1, '2020-03-24 05:50:00'),
(119, 2, 16, 1, 1, 1, 1, '2020-03-24 05:50:00'),
(120, 2, 17, 1, 1, 1, 1, '2020-03-24 05:50:00'),
(121, 2, 18, 1, 1, 1, 1, '2020-03-24 05:50:00'),
(122, 2, 23, 1, 1, 1, 0, '2020-03-24 05:50:00'),
(123, 2, 24, 1, 1, 1, 0, '2020-03-24 05:50:00'),
(124, 2, 28, 1, 0, 0, 0, '2020-03-24 05:50:00'),
(125, 2, 30, 1, 0, 0, 0, '2020-03-24 05:50:00'),
(126, 2, 29, 1, 0, 0, 0, '2020-03-24 05:50:00'),
(127, 2, 32, 1, 0, 0, 1, '2020-03-24 05:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `position` tinyint(3) NOT NULL DEFAULT 0,
  `updateby` smallint(4) UNSIGNED NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `name`, `status`, `position`, `updateby`, `updatetime`) VALUES
(1, 'grammar', 1, 1, 1, '2020-02-09 12:43:38'),
(2, 'বাংলাদেশের জাতীয় বিষয়াবলি', 1, 1, 0, '2020-02-09 13:46:38'),
(3, 'বাংলাদেশের কৃষিজ সম্পদ', 1, 2, 0, '2020-02-09 13:55:47'),
(4, 'Geometry', 1, 1, 0, '2020-02-10 16:28:24'),
(5, 'Arithmetic', 1, 1, 0, '2020-02-12 13:00:27'),
(6, 'Arithmetic hsc', 1, 1, 0, '2020-02-12 13:12:45'),
(7, 'test section', 1, 7, 0, '2020-03-23 06:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `section_assign`
--

CREATE TABLE `section_assign` (
  `id` tinyint(3) NOT NULL,
  `subject_id` smallint(3) NOT NULL,
  `section_id` smallint(3) NOT NULL,
  `updateby` smallint(3) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section_assign`
--

INSERT INTO `section_assign` (`id`, `subject_id`, `section_id`, `updateby`, `updatetime`) VALUES
(1, 2, 1, 0, '2020-02-09 12:43:17'),
(2, 3, 2, 0, '2020-02-09 13:47:02'),
(3, 4, 4, 0, '2020-02-10 16:28:39'),
(4, 5, 4, 0, '2020-02-10 16:28:39'),
(5, 4, 5, 0, '2020-02-12 13:00:50'),
(7, 5, 6, 0, '2020-02-12 13:17:48'),
(8, 7, 7, 0, '2020-03-23 06:18:38'),
(9, 8, 7, 0, '2020-03-23 06:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `position` tinyint(3) NOT NULL DEFAULT 0,
  `updateby` smallint(4) UNSIGNED NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `status`, `position`, `updateby`, `updatetime`) VALUES
(2, 'Bengali Language', 1, 1, 0, '2020-02-09 12:37:59'),
(3, 'বাংলাদেশ বিষয়াবলি', 1, 5, 0, '2020-02-09 13:45:02'),
(4, 'Math', 1, 3, 0, '2020-02-10 16:22:35'),
(5, 'Math Hsc', 1, 4, 0, '2020-02-10 16:25:25'),
(6, 'testy', 1, 5, 0, '2020-02-22 08:39:14'),
(7, 'test subject', 1, 6, 0, '2020-03-23 06:09:52'),
(8, 'test subject 2', 1, 7, 0, '2020-03-23 06:09:58'),
(9, 'shipa', 1, 8, 0, '2020-03-23 06:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `subject_assign`
--

CREATE TABLE `subject_assign` (
  `id` tinyint(3) NOT NULL,
  `category_id` smallint(3) NOT NULL,
  `subject_id` smallint(3) NOT NULL,
  `updateby` smallint(3) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_assign`
--

INSERT INTO `subject_assign` (`id`, `category_id`, `subject_id`, `updateby`, `updatetime`) VALUES
(2, 1, 2, 0, '2020-02-09 12:46:18'),
(3, 1, 3, 0, '2020-02-09 13:45:27'),
(5, 3, 5, 0, '2020-02-10 16:25:37'),
(15, 1, 4, 0, '2020-02-12 13:22:18'),
(16, 2, 4, 0, '2020-02-12 13:22:18'),
(17, 4, 4, 0, '2020-02-12 13:22:18'),
(18, 1, 6, 0, '2020-03-23 06:17:57'),
(19, 5, 7, 0, '2020-03-23 06:18:07'),
(20, 5, 8, 0, '2020-03-23 06:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `position` tinyint(3) NOT NULL DEFAULT 0,
  `updateby` smallint(4) UNSIGNED NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `name`, `status`, `position`, `updateby`, `updatetime`) VALUES
(1, 'spelling', 1, 1, 0, '2020-02-09 12:43:59'),
(2, 'প্রাচীনকাল থেকে সম-সাময়িক কালের ইতিহাস, কৃষ্টি ও সংস্কৃতি', 1, 1, 0, '2020-02-09 13:47:40'),
(3, 'বাংলাদেশের স্বাধীনতা যুদ্ধের ইতিহাসঃ ভাষা আন্দোলন', 1, 2, 0, '2020-02-09 13:48:27'),
(4, '১৯৫৪ সালের নির্বাচন', 1, 3, 0, '2020-02-09 13:48:51'),
(5, 'ছয়-দফা আন্দোলন, ১৯৬৬', 1, 4, 0, '2020-02-09 13:49:13'),
(6, 'গণ-অভ্যুত্থান ১৯৬৮ - ১৯৬৯', 1, 5, 0, '2020-02-09 13:49:32'),
(7, '১৯৭০ সালের সাধারণ নির্বাচন', 1, 6, 0, '2020-02-09 13:49:45'),
(8, 'অসহযোগ আন্দোলন', 1, 7, 0, '2020-02-09 13:49:55'),
(9, '৭ মার্চের ঐতিহাসিক ভাষণ', 1, 8, 0, '2020-02-09 13:50:06'),
(10, 'স্বাধীনতা ঘোষণা', 1, 9, 0, '2020-02-09 13:50:15'),
(11, 'মুজিবনগর সরকারের গঠন ও কার্যাবলী', 1, 10, 0, '2020-02-09 13:50:25'),
(12, 'মুক্তিযুদ্ধের রণকৌশল', 1, 11, 0, '2020-02-09 13:50:38'),
(13, 'মুক্তিযুদ্ধে বৃহৎ শক্তিবর্গের ভূমিকা', 1, 12, 0, '2020-02-09 13:50:49'),
(14, 'পাকিস্তানী বাহিনীর আত্মসমর্পণ এবং বাংলাদেশের অভ্যুদয়', 1, 13, 0, '2020-02-09 13:51:00'),
(15, 'শস্য উৎপাদন এবং এর বহুমুখীকরণ', 1, 1, 0, '2020-02-09 13:56:22'),
(16, 'খাদ্য উৎপাদন ও ব্যবস্থাপনা', 1, 2, 0, '2020-02-09 13:56:38'),
(17, 'বাংলাদেশের বনজসম্পদ', 1, 3, 0, '2020-02-09 13:56:50'),
(18, 'Triangle', 1, 3, 0, '2020-02-10 16:29:14'),
(19, 'Real number', 1, 1, 0, '2020-02-12 13:01:07'),
(20, 'test topic', 1, 20, 0, '2020-03-23 06:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `topics_questions`
--

CREATE TABLE `topics_questions` (
  `id` int(11) NOT NULL,
  `question_id` int(7) NOT NULL,
  `topic_id` smallint(4) NOT NULL,
  `category_id` smallint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics_questions`
--

INSERT INTO `topics_questions` (`id`, `question_id`, `topic_id`, `category_id`, `created_at`) VALUES
(1, 1, 2, 1, '2020-02-09 14:02:51'),
(3, 4, 2, 1, '2020-02-09 14:23:40'),
(5, 5, 2, 1, '2020-02-09 14:28:25'),
(6, 7, 2, 1, '2020-02-09 14:31:10'),
(8, 3, 2, 1, '2020-02-09 16:36:13'),
(12, 8, 2, 1, '2020-02-11 16:40:11'),
(15, 9, 18, 1, '2020-02-12 07:05:27'),
(16, 9, 18, 2, '2020-02-12 07:05:27'),
(17, 9, 18, 3, '2020-02-12 07:05:27'),
(24, 10, 18, 1, '2020-02-13 08:37:27'),
(25, 10, 18, 3, '2020-02-13 08:37:27'),
(27, 12, 19, 1, '2020-02-16 06:07:38'),
(28, 13, 3, 1, '2020-02-16 06:09:50'),
(29, 15, 4, 1, '2020-02-16 06:11:30'),
(30, 16, 15, 1, '2020-02-18 07:57:52'),
(31, 16, 8, 1, '2020-02-18 07:57:52'),
(32, 18, 6, 1, '2020-02-18 08:02:32'),
(33, 18, 3, 1, '2020-02-18 08:02:32'),
(34, 20, 4, 1, '2020-02-18 08:06:53'),
(35, 20, 6, 1, '2020-02-18 08:06:53'),
(36, 21, 16, 1, '2020-02-18 08:11:51'),
(37, 21, 9, 1, '2020-02-18 08:11:51'),
(38, 22, 16, 1, '2020-02-18 08:12:01'),
(39, 22, 9, 1, '2020-02-18 08:12:01'),
(40, 23, 16, 1, '2020-02-18 08:12:14'),
(41, 23, 9, 1, '2020-02-18 08:12:14'),
(42, 24, 16, 1, '2020-02-18 08:13:16'),
(43, 24, 9, 1, '2020-02-18 08:13:16'),
(44, 25, 16, 1, '2020-02-18 08:13:38'),
(45, 25, 9, 1, '2020-02-18 08:13:38'),
(46, 26, 16, 1, '2020-02-18 08:15:32'),
(47, 26, 9, 1, '2020-02-18 08:15:32'),
(48, 27, 16, 1, '2020-02-18 08:26:37'),
(49, 28, 16, 1, '2020-02-18 08:26:56'),
(50, 29, 16, 1, '2020-02-18 08:32:04'),
(51, 30, 2, 1, '2020-02-18 08:33:31'),
(53, 32, 2, 1, '2020-02-18 08:34:54'),
(54, 33, 2, 1, '2020-02-18 08:38:26'),
(55, 34, 16, 1, '2020-02-18 08:41:05'),
(56, 35, 16, 1, '2020-02-18 08:42:50'),
(57, 36, 16, 1, '2020-02-18 08:43:46'),
(58, 37, 3, 1, '2020-02-19 03:41:17'),
(59, 37, 8, 1, '2020-02-19 03:41:17'),
(60, 38, 5, 1, '2020-02-19 03:42:03'),
(61, 38, 6, 1, '2020-02-19 03:42:03'),
(68, 60, 17, 1, '2020-02-29 06:49:11'),
(69, 60, 9, 1, '2020-02-29 06:49:11'),
(76, 59, 17, 1, '2020-02-29 09:26:32'),
(77, 59, 9, 1, '2020-02-29 09:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `topic_assign`
--

CREATE TABLE `topic_assign` (
  `id` tinyint(3) NOT NULL,
  `section_id` smallint(3) NOT NULL,
  `topic_id` smallint(3) NOT NULL,
  `updateby` smallint(3) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic_assign`
--

INSERT INTO `topic_assign` (`id`, `section_id`, `topic_id`, `updateby`, `updatetime`) VALUES
(1, 1, 1, 0, '2020-02-09 12:44:12'),
(2, 2, 2, 0, '2020-02-09 13:47:53'),
(3, 2, 8, 0, '2020-02-09 13:51:23'),
(4, 2, 3, 0, '2020-02-09 13:51:48'),
(5, 2, 6, 0, '2020-02-09 13:52:03'),
(6, 2, 5, 0, '2020-02-09 13:52:28'),
(7, 2, 13, 0, '2020-02-09 13:52:38'),
(8, 2, 12, 0, '2020-02-09 13:52:42'),
(9, 2, 9, 0, '2020-02-09 13:53:03'),
(10, 2, 14, 0, '2020-02-09 13:53:12'),
(11, 2, 11, 0, '2020-02-09 13:53:36'),
(12, 2, 10, 0, '2020-02-09 13:53:43'),
(13, 2, 4, 0, '2020-02-09 13:53:58'),
(14, 2, 7, 0, '2020-02-09 13:54:51'),
(15, 2, 15, 0, '2020-02-09 13:58:04'),
(16, 2, 16, 0, '2020-02-09 13:58:24'),
(17, 2, 17, 0, '2020-02-09 13:58:36'),
(18, 4, 18, 0, '2020-02-10 16:29:25'),
(21, 5, 19, 0, '2020-02-12 13:33:52'),
(22, 6, 19, 0, '2020-02-12 13:33:52'),
(23, 7, 20, 0, '2020-03-23 06:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `topic_library`
--

CREATE TABLE `topic_library` (
  `id` int(11) NOT NULL,
  `library_id` smallint(3) NOT NULL,
  `topic_id` smallint(3) NOT NULL,
  `category_id` smallint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic_library`
--

INSERT INTO `topic_library` (`id`, `library_id`, `topic_id`, `category_id`, `created_at`) VALUES
(60, 26, 2, 1, '2020-03-22 07:40:32'),
(99, 27, 16, 1, '2020-03-22 08:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `display_name` varchar(200) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `cover_picture` varchar(200) DEFAULT NULL,
  `category_id` tinyint(3) DEFAULT NULL,
  `subject_id` varchar(200) DEFAULT NULL,
  `email_code` int(6) DEFAULT NULL,
  `email_time` datetime DEFAULT NULL,
  `phone_code` int(6) DEFAULT NULL,
  `phone_time` datetime DEFAULT NULL,
  `email_status` tinyint(1) DEFAULT NULL,
  `phone_status` tinyint(1) DEFAULT NULL,
  `reset_key` int(6) DEFAULT NULL,
  `reset_time` datetime DEFAULT NULL,
  `toc` tinyint(1) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `display_name`, `phone`, `gender`, `dob`, `picture`, `cover_picture`, `category_id`, `subject_id`, `email_code`, `email_time`, `phone_code`, `phone_time`, `email_status`, `phone_status`, `reset_key`, `reset_time`, `toc`, `status`, `created_at`) VALUES
(1, 'shipan@wanitbd.com', '$2y$10$KFa2A685YcowJpr5Ni5jw.6k5v.A487IhHoCaUh8HiTdfSb0CWnW.', 'Shipan Mazumder', 'shipansm', '01834741581', 0, '1997-12-31', 'uploads/users/Xplore_1583820947U.png', NULL, NULL, NULL, 700612, '2020-03-09 16:17:37', 207180, '2020-03-10 12:16:01', 1, 0, NULL, NULL, 1, 1, '2020-03-09 10:17:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_role_id` (`role_id`) USING BTREE;

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_category_updateby` (`updateby`) USING BTREE,
  ADD KEY `idx_category_status` (`status`),
  ADD KEY `subject_show` (`subject_show`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_info`
--
ALTER TABLE `device_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_model` (`model`),
  ADD KEY `idx_manufacture` (`manufacture`),
  ADD KEY `idx_version` (`version`);

--
-- Indexes for table `edit_history`
--
ALTER TABLE `edit_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_update_by` (`update_by`) USING BTREE,
  ADD KEY `slug` (`slug`),
  ADD KEY `idx_edit_id` (`edit_id`) USING BTREE;

--
-- Indexes for table `game_setting`
--
ALTER TABLE `game_setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_type_id` (`game_type_id`);

--
-- Indexes for table `game_type`
--
ALTER TABLE `game_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `library_image`
--
ALTER TABLE `library_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_library_id` (`library_id`) USING BTREE;

--
-- Indexes for table `library_video`
--
ALTER TABLE `library_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_library_id` (`library_id`) USING BTREE;

--
-- Indexes for table `permission_category`
--
ALTER TABLE `permission_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_perm_group_id` (`perm_group_id`) USING BTREE;

--
-- Indexes for table `permission_group`
--
ALTER TABLE `permission_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dificulty` (`difficulty`),
  ADD KEY `idx_create_by_user` (`created_by_user`),
  ADD KEY `idx_approved_by` (`approved_by`),
  ADD KEY `idx_created_by_admin` (`created_by_admin`);

--
-- Indexes for table `question_batch_year`
--
ALTER TABLE `question_batch_year`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_question_batch` (`batch_id`),
  ADD KEY `idx_question_year` (`question_year`),
  ADD KEY `idx_question_id` (`question_id`) USING BTREE;

--
-- Indexes for table `question_bookmark`
--
ALTER TABLE `question_bookmark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_question_id` (`question_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `question_reports`
--
ALTER TABLE `question_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_question_id` (`question_id`);

--
-- Indexes for table `question_year`
--
ALTER TABLE `question_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recently_learn`
--
ALTER TABLE `recently_learn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_role_id` (`role_id`) USING BTREE,
  ADD KEY `idx_perm_cat_id` (`perm_cat_id`) USING BTREE;

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_section_updateby` (`updateby`) USING BTREE,
  ADD KEY `idx_section_status` (`status`);

--
-- Indexes for table `section_assign`
--
ALTER TABLE `section_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_subject_id` (`subject_id`),
  ADD KEY `idx_section_id` (`section_id`),
  ADD KEY `idx_updateby` (`updateby`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_subject_updateby` (`updateby`) USING BTREE,
  ADD KEY `idx_subject_status` (`status`);

--
-- Indexes for table `subject_assign`
--
ALTER TABLE `subject_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_subject_id` (`subject_id`),
  ADD KEY `idx_updateby` (`updateby`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_topic_updateby` (`updateby`) USING BTREE,
  ADD KEY `idx_topic_status` (`status`);

--
-- Indexes for table `topics_questions`
--
ALTER TABLE `topics_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_question_id` (`question_id`),
  ADD KEY `idx_topic_id` (`topic_id`),
  ADD KEY `idx_category_id` (`category_id`) USING BTREE;

--
-- Indexes for table `topic_assign`
--
ALTER TABLE `topic_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_section_id` (`section_id`),
  ADD KEY `idx_topic_id` (`topic_id`),
  ADD KEY `idx_updateby` (`updateby`);

--
-- Indexes for table `topic_library`
--
ALTER TABLE `topic_library`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_library_id` (`library_id`),
  ADD KEY `idx_topic_id` (`topic_id`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `device_info`
--
ALTER TABLE `device_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edit_history`
--
ALTER TABLE `edit_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `game_setting`
--
ALTER TABLE `game_setting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `game_type`
--
ALTER TABLE `game_type`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `library_image`
--
ALTER TABLE `library_image`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `library_video`
--
ALTER TABLE `library_video`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `permission_category`
--
ALTER TABLE `permission_category`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `question_batch_year`
--
ALTER TABLE `question_batch_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `question_bookmark`
--
ALTER TABLE `question_bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question_reports`
--
ALTER TABLE `question_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_year`
--
ALTER TABLE `question_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recently_learn`
--
ALTER TABLE `recently_learn`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `section_assign`
--
ALTER TABLE `section_assign`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject_assign`
--
ALTER TABLE `subject_assign`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `topics_questions`
--
ALTER TABLE `topics_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `topic_assign`
--
ALTER TABLE `topic_assign`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `topic_library`
--
ALTER TABLE `topic_library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
