-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2019 at 02:52 PM
-- Server version: 10.0.38-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hudr7718_regisapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `hr_departments`
--

CREATE TABLE `hr_departments` (
  `DEPT_ID` int(11) NOT NULL,
  `NAME` varchar(15) NOT NULL,
  `DESCRIPTION` varchar(100) DEFAULT NULL,
  `CREATION_DATE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hr_departments`
--

INSERT INTO `hr_departments` (`DEPT_ID`, `NAME`, `DESCRIPTION`, `CREATION_DATE`) VALUES
(35543, 'DACC', 'DEPT ACCOUNTING', '2016-07-11 10:54:46'),
(35544, 'DBO', 'DEPT BACK OFFICE', '2016-07-11 10:54:46'),
(35545, 'DEDP', 'DEPT EDP', '2016-07-11 10:54:46'),
(35546, 'DFIN', 'DEPT FINANCE', '2016-07-11 10:54:46'),
(35547, 'DFREN', 'DEPT FRONT END', '2016-07-11 10:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `hr_employees`
--

CREATE TABLE `hr_employees` (
  `EMP_ID` int(15) NOT NULL,
  `EMP_NUM` varchar(10) NOT NULL,
  `NAME` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(70) DEFAULT NULL,
  `ACTIVE_FLAG` int(2) NOT NULL,
  `MAX_CREATE_PUM` int(10) NOT NULL DEFAULT '4',
  `CREATION_DATE` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hr_employees`
--

INSERT INTO `hr_employees` (`EMP_ID`, `EMP_NUM`, `NAME`, `EMAIL`, `ACTIVE_FLAG`, `MAX_CREATE_PUM`, `CREATION_DATE`) VALUES
(33335, '1992000044', 'SAMUEL NUGROHO', 'christian.primadana@indomaret.co.id', 0, 5, '2016-06-01 00:00:00'),
(33336, '1990000103', 'SUYONO', 'christian.primadana@indomaret.co.id', 1, 5, '2016-06-01 00:00:01'),
(33337, '1988000321', 'ANTON PRASETIO', 'christian.primadana@indomaret.co.id', 1, 5, '2016-06-01 00:00:02'),
(33338, '1994000477', 'SUGIANTO', 'christian.primadana@indomaret.co.id', 0, 5, '2016-06-01 00:00:03'),
(33339, '2004004093', 'HASSAN WIDJAJA SOENDJAJA', 'christian.primadana@indomaret.co.id', 1, 5, '2016-06-01 00:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_07_11_060614_create_departments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0d65dbb69023892cbfda2a4e87325eedfaf8892fc78449a4545d3ccb5b0b5b0a05903512f7d2aef8', 4, 1, 'nApp', '[]', 0, '2019-07-11 00:28:16', '2019-07-11 00:28:16', '2020-07-11 07:28:16'),
('16ab05b668369cfbad992a4c18452d1771106b21478f4853faeea213eb7e6c5f0a61cfd643137a98', 4, 1, 'nApp', '[]', 0, '2019-07-11 00:30:25', '2019-07-11 00:30:25', '2020-07-11 07:30:25'),
('1935e34813c2b329f4a88d6967238b6e0c3b5d7b1891cc6d94f568b8b0773fca219caaa7559947ee', NULL, 1, 'nApp', '[]', 0, '2019-07-15 18:21:41', '2019-07-15 18:21:41', '2020-07-16 01:21:41'),
('318a9e82d067ca610f49a11a64ca622aa9740cc8483c0123b96e67df827008610d5acd89de9039e7', 8, 1, NULL, '[]', 0, '2019-07-11 00:43:54', '2019-07-11 00:43:54', '2020-07-11 07:43:54'),
('3b39d4aba740c3e00d8e71d25a961a11e24d9db52c84724ebbcb59eb1c56cc5b07290e1f550797bc', 13, 1, 'nApp', '[]', 0, '2019-07-14 18:26:40', '2019-07-14 18:26:40', '2020-07-15 01:26:40'),
('4042743783ff312951cf76767dfb68c1c1d1b4288076ff9ec78117bd35c496f5bd7eb2cd77d6242f', 3, 1, 'nApp', '[]', 0, '2019-07-11 00:05:37', '2019-07-11 00:05:37', '2020-07-11 07:05:37'),
('53864aa4336fbc23e6b43b7192c67a3a0bbc7ffa388f450485d786aaf235ba53a8534444ca055a58', 11, 1, 'nApp', '[]', 0, '2019-07-11 01:00:55', '2019-07-11 01:00:55', '2020-07-11 08:00:55'),
('6fe331c3637e0d7b41090d1def960f132acc0b8e4acf45588a0ad9c727be3135c7ac6ce092a2037d', 11, 1, 'nApp', '[]', 0, '2019-07-11 01:09:25', '2019-07-11 01:09:25', '2020-07-11 08:09:25'),
('7de3cdc88bada6f9abace044dcd681197ac7b7e5264c3e2437c8d88bf23e6ad8e0004e4a3cb25674', 11, 1, 'nApp', '[]', 0, '2019-07-11 01:02:29', '2019-07-11 01:02:29', '2020-07-11 08:02:29'),
('7e1ef7bff6bd72d8f3352d88bef7f56bcfefdc8e429c432f44f6739cf86999d6ad9e3a377d4470ae', 3, 1, 'nApp', '[]', 0, '2019-07-11 00:04:19', '2019-07-11 00:04:19', '2020-07-11 07:04:19'),
('834a867811c0160c248bd73dbe6b68c525f97a91320bc97c258755a3252750d3ff9ee376a18a2bbf', 10, 1, 'nApp', '[]', 0, '2019-07-11 00:44:38', '2019-07-11 00:44:38', '2020-07-11 07:44:38'),
('85a92f75100c5984c75b2f0534ab8c9132016aa8975b8d6159106e71754d01f3bb57ceaecd635626', 3, 1, 'nApp', '[]', 0, '2019-07-10 23:44:46', '2019-07-10 23:44:46', '2020-07-11 06:44:46'),
('8806b6bd76dfe62520c57593091f759f359eb5e30a27bbde34ba682c6d90b6b872f5b7ee618aa36d', 11, 1, 'nApp', '[]', 0, '2019-07-11 01:07:03', '2019-07-11 01:07:03', '2020-07-11 08:07:03'),
('929c70a680fe6fa0e087808145bf696c54fca6e9fb04e3eb3122bbfeaa8875eddc7985ead082fd64', 11, 1, 'nApp', '[]', 0, '2019-07-11 01:07:44', '2019-07-11 01:07:44', '2020-07-11 08:07:44'),
('a0dd52224084252d41d5cae5267fc2ed1ab7288fd562689b133151666ea452632ec6b6c0471e58bd', 3, 1, 'nApp', '[]', 0, '2019-07-11 00:05:32', '2019-07-11 00:05:32', '2020-07-11 07:05:32'),
('a2ba27ba86c236d2356ab88953696dfb977fa7bf43220dc8bb69f9c22862769b1951ee22501f8e54', 3, 1, 'nApp', '[]', 0, '2019-07-11 00:04:53', '2019-07-11 00:04:53', '2020-07-11 07:04:53'),
('a4b7c4cb1383d9ef4c6f3a0e4e8d9bd36721992f69b2f7e60b81e4d2450c6998ebdd7a81d41ee10e', 5, 1, NULL, '[]', 0, '2019-07-11 00:38:53', '2019-07-11 00:38:53', '2020-07-11 07:38:53'),
('b33247a4eaa0c68020535307bc0621b238ee06157d43982e8c2c96fe7c055014752c716404fa6b69', 12, 1, 'nApp', '[]', 0, '2019-07-11 02:44:27', '2019-07-11 02:44:27', '2020-07-11 09:44:27'),
('ce487be0577db99a091377b1db10fd7a5a84fb0aa3ddf7dab1f1054a98d012093909bef5dfb6bb0c', 11, 1, 'nApp', '[]', 0, '2019-07-11 01:07:15', '2019-07-11 01:07:15', '2020-07-11 08:07:15'),
('dbb1115214cc06c11acdb58fb5c3606a924e4505be6527f3a6ae9b5f6238e4834f20d58878f38bee', 12, 1, 'nApp', '[]', 0, '2019-07-11 02:43:04', '2019-07-11 02:43:04', '2020-07-11 09:43:04'),
('f4e8a3fd0b9981add6abfb2bf384e8bebaa125d27fcf5e11d8ad41ff42104b745a45bd766ca83aa8', 10, 1, 'nApp', '[]', 0, '2019-07-11 00:49:02', '2019-07-11 00:49:02', '2020-07-11 07:49:02'),
('f84203649f01a6352e8d64c7dd7ca38bb2bdc8bd93b7bd5c2d1b754a5ff3f06b234c9a4de5020719', 13, 1, 'nApp', '[]', 0, '2019-07-14 18:31:41', '2019-07-14 18:31:41', '2020-07-15 01:31:41'),
('f8c6d19edbd8fef462c7dc5b61765ef72ab21eb8171cfa2c73f7edf308926fd327ed68037873096d', 11, 1, 'nApp', '[]', 0, '2019-07-11 00:59:43', '2019-07-11 00:59:43', '2020-07-11 07:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'YhJGaCvCDdZ0HEEDfC8rVHyIIKjYc7SV20eKlKXf', 'http://localhost', 1, 0, 0, '2019-07-10 23:44:08', '2019-07-10 23:44:08'),
(2, NULL, 'Laravel Password Grant Client', 'SOtnRbCHFkrfn8Q4otU7v42kJ03OpVtbR8CzDTtC', 'http://localhost', 0, 1, 0, '2019-07-10 23:44:08', '2019-07-10 23:44:08');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-07-10 23:44:08', '2019-07-10 23:44:08');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_user`
--

CREATE TABLE `sys_user` (
  `USER_ID` int(15) NOT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  `PASSWORD` varchar(32) NOT NULL,
  `PIN` varchar(50) NOT NULL,
  `EMP_ID` int(15) DEFAULT NULL,
  `DEPT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(10) UNSIGNED NOT NULL,
  `EMP_NUM` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PASSWORD` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DEPT_ID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `REMEMBER_TOKEN` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CREATED_AT` timestamp NULL DEFAULT NULL,
  `UPDATED_AT` timestamp NULL DEFAULT NULL,
  `EMP_ID` int(11) NOT NULL,
  `PIN` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `EMP_NUM`, `PASSWORD`, `DEPT_ID`, `REMEMBER_TOKEN`, `CREATED_AT`, `UPDATED_AT`, `EMP_ID`, `PIN`) VALUES
(1, '1992000044', '$2y$10$/pUSEnsCR0RNR98UpWzOwO8V3AYANJfYWszCh3m8Gu7C7CJRBtjfq', '35543', NULL, '2019-07-15 18:16:41', '2019-07-15 18:16:41', 33335, 123456),
(2, '1990000103', '$2y$10$/C5NXfM8TcKNaxZCUKvZQ.txOzT6FTm4t2Vn.J73B7pHBX8z9/Xte', '35547', NULL, '2019-07-15 18:23:51', '2019-07-15 18:23:51', 33338, 123456),
(3, '1988000321', '$2y$10$zkudwZgBnYTdf91SQCid9u0rBaU5N6vUo5KUiuWuD2MrAiwzs7N2S', '35547', NULL, '2019-07-15 19:20:28', '2019-07-15 19:20:28', 11111, 123456),
(4, '9999999', '$2y$10$ZlZJ.bVFE72NcCgKeAb.9uwqKjO9MFWJlXev6TmmxPtd4YGzFtDCC', '35547', NULL, '2019-07-15 19:45:03', '2019-07-15 19:45:03', 33338, 123456),
(5, '123456789', '$2y$10$tOEw4J06JUVQx5Jz4/X.nOf5gB7oiUj2KpvGfIKEqF0KcyaP7vQtS', '35547', NULL, '2019-07-15 19:46:19', '2019-07-15 19:46:19', 33336, 123456),
(6, '1988000321', '$2y$10$QpQuWnmEjIZTo1xCDJ9ujO8VA6pDC7XMcZBiM29gSEqPiZytSq5nW', '35547', NULL, '2019-07-15 19:50:24', '2019-07-15 19:50:24', 33338, 123456),
(7, '1988000321', '$2y$10$fwg/S3ev.xWwkTfbgh9kOOiMnsHZEkJqVJOrDfDC.Vc2Lr9HmNuIa', '35547', NULL, '2019-07-15 19:51:06', '2019-07-15 19:51:06', 33338, 555666),
(8, '1988000321', '$2y$10$DQZy35SsvbleiH0i1a6EE.MZRfdRp.jRIB9G6FqtM6gEBXLXTSJPu', '35547', NULL, '2019-07-15 23:21:17', '2019-07-15 23:21:17', 33338, 111);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hr_departments`
--
ALTER TABLE `hr_departments`
  ADD PRIMARY KEY (`DEPT_ID`),
  ADD KEY `DEPT_NAME` (`NAME`);

--
-- Indexes for table `hr_employees`
--
ALTER TABLE `hr_employees`
  ADD PRIMARY KEY (`EMP_ID`),
  ADD UNIQUE KEY `EMP_ID_UNIQUE` (`EMP_ID`),
  ADD KEY `EMP_NAME` (`NAME`),
  ADD KEY `EMP_NUM` (`EMP_NUM`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sys_user`
--
ALTER TABLE `sys_user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD KEY `DEPT_ID` (`DEPT_ID`),
  ADD KEY `EMP_ID` (`EMP_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hr_departments`
--
ALTER TABLE `hr_departments`
  MODIFY `DEPT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35965;

--
-- AUTO_INCREMENT for table `hr_employees`
--
ALTER TABLE `hr_employees`
  MODIFY `EMP_ID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99249;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sys_user`
--
ALTER TABLE `sys_user`
  MODIFY `USER_ID` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
