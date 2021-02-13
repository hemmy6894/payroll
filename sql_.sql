-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 13, 2021 at 01:00 AM
-- Server version: 5.6.49-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rosper_payroll`
--
CREATE DATABASE IF NOT EXISTS `rosper_payroll` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rosper_payroll`;

-- --------------------------------------------------------

--
-- Table structure for table `advance_salaries`
--

CREATE TABLE `advance_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `salary_month` date NOT NULL,
  `amount` double NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci,
  `paid_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advance_salaries`
--

INSERT INTO `advance_salaries` (`id`, `user_id`, `salary_month`, `amount`, `created_by`, `comment`, `paid_date`, `created_at`, `updated_at`) VALUES
(1, 17, '2021-02-11', 50000, 8, 'ADVANCE SALARY', NULL, '2021-02-11 19:40:59', '2021-02-11 19:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `bft_loans`
--

CREATE TABLE `bft_loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `monthly_payment` double NOT NULL DEFAULT '0',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `state` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bft_loan_activities`
--

CREATE TABLE `bft_loan_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'created',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'green',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `bg_color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'green', 1, '2019-11-28 08:07:37', '2019-11-28 08:07:37'),
(2, 'Account', 'green', 1, '2019-12-28 14:32:20', '2019-12-28 14:32:20'),
(3, 'House Bill', 'green', 1, '2019-12-28 14:32:57', '2019-12-28 14:32:57'),
(4, 'Documentation', 'green', 1, '2019-12-28 14:33:10', '2019-12-28 14:33:10'),
(5, 'Transport', 'green', 1, '2019-12-28 14:33:29', '2019-12-28 14:33:29'),
(6, 'Management', 'green', 1, '2019-12-28 14:33:47', '2019-12-28 14:33:47'),
(7, 'Office attend', 'green', 1, '2019-12-28 16:14:30', '2019-12-28 16:14:30'),
(8, 'Teacher', 'green', 1, '2021-01-22 13:34:38', '2021-01-22 13:34:38'),
(9, 'Chef', 'green', 1, '2021-01-22 13:34:55', '2021-01-22 13:34:55'),
(10, 'Driver', 'green', 1, '2021-01-22 13:35:16', '2021-01-22 13:35:16');

-- --------------------------------------------------------

--
-- Table structure for table `employee_statuses`
--

CREATE TABLE `employee_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'green',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_statuses`
--

INSERT INTO `employee_statuses` (`id`, `name`, `bg_color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'On Post', 'green', 1, '2019-11-28 08:08:15', '2019-11-28 08:08:15'),
(2, 'Terminated', 'green', 1, '2019-12-05 18:42:44', '2019-12-05 18:42:44'),
(3, 'System', 'green', 1, '2019-12-11 19:28:02', '2019-12-11 19:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'green',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `bg_color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'male', 'green', 1, '2019-11-28 08:07:50', '2019-11-28 08:07:50'),
(2, 'Female', 'green', 1, '2019-11-29 21:15:05', '2019-11-29 21:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `monthly_payment` double NOT NULL DEFAULT '0',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `state` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_activities`
--

CREATE TABLE `loan_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'created',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_boards`
--

CREATE TABLE `loan_boards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `monthly_payment` double NOT NULL DEFAULT '0',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `state` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_board_activities`
--

CREATE TABLE `loan_board_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'created',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(48, '2013_11_24_221712_create_genders', 1),
(49, '2013_11_24_222040_create_roles', 1),
(50, '2013_11_24_222241_create_employee_statuses', 1),
(51, '2013_11_24_222255_create_departments', 1),
(52, '2014_10_12_000000_create_users_table', 1),
(53, '2014_10_12_100000_create_password_resets_table', 1),
(54, '2019_08_19_000000_create_failed_jobs_table', 1),
(55, '2019_11_26_125225_create_user_role_models_table', 1),
(56, '2019_11_26_125719_create_system_function_models_table', 1),
(57, '2019_11_28_102525_create_pending_mail_models_table', 1),
(58, '2019_11_28_103039_create_variable_models_table', 1),
(59, '2019_11_29_125405_create_advance_salary_models_table', 2),
(67, '2019_11_29_165656_create_loan_models_table', 3),
(68, '2019_11_29_170309_create_loan_activities_models_table', 3),
(69, '2019_11_30_092915_create_loan_board_models_table', 4),
(70, '2019_11_30_092933_create_loan_board_activities_models_table', 4);

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
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) NOT NULL,
  `month` date DEFAULT NULL,
  `basic_salary` double NOT NULL DEFAULT '0',
  `pension` double NOT NULL DEFAULT '0',
  `paye` double NOT NULL DEFAULT '0',
  `advance` double NOT NULL DEFAULT '0',
  `loan` double NOT NULL DEFAULT '0',
  `loan_board` double NOT NULL DEFAULT '0',
  `sdl` double NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pending_mails`
--

CREATE TABLE `pending_mails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` mediumtext COLLATE utf8mb4_unicode_ci,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '1',
  `from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'green',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `bg_color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'green', 1, '2019-11-28 08:05:13', '2019-11-28 08:05:13'),
(2, 'Account', 'green', 1, '2019-12-02 14:13:07', '2019-12-02 14:13:53'),
(3, 'Staff', 'green', 1, '2019-12-10 16:22:22', '2019-12-10 16:22:22'),
(4, 'Management', 'green', 1, '2019-12-10 16:47:35', '2019-12-10 16:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `system_functions`
--

CREATE TABLE `system_functions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `function_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_functions`
--

INSERT INTO `system_functions` (`id`, `function_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'roles_settings', 1, '2019-11-28 08:04:43', '2019-11-28 08:04:43'),
(2, 'function.index', 1, '2019-11-28 08:06:00', '2019-11-28 08:06:00'),
(3, 'function.create', 1, '2019-11-28 08:06:09', '2019-11-28 08:06:09'),
(4, 'function.edit', 1, '2019-11-28 08:06:22', '2019-11-28 08:06:22'),
(5, 'function.show', 1, '2019-11-28 08:06:30', '2019-11-28 08:06:30'),
(6, 'user.index', 1, '2019-11-28 08:15:35', '2019-11-28 08:15:35'),
(7, 'user.show', 1, '2019-11-28 08:15:36', '2019-11-28 08:15:36'),
(8, 'user.edit', 1, '2019-11-28 08:15:36', '2019-11-28 08:15:36'),
(9, 'user.create', 1, '2019-11-28 08:15:36', '2019-11-28 08:15:36'),
(10, 'department.index', 1, '2019-11-28 08:17:49', '2019-11-28 08:17:49'),
(11, 'department.show', 1, '2019-11-28 08:17:49', '2019-11-28 08:17:49'),
(12, 'department.create', 1, '2019-11-28 08:17:49', '2019-11-28 08:17:49'),
(13, 'department.edit', 1, '2019-11-28 08:17:50', '2019-11-28 08:17:50'),
(14, 'status.index', 1, '2019-11-28 08:18:29', '2019-11-28 08:18:29'),
(15, 'status.show', 1, '2019-11-28 08:18:29', '2019-11-28 08:18:29'),
(16, 'status.create', 1, '2019-11-28 08:18:29', '2019-11-28 08:18:29'),
(17, 'status.edit', 1, '2019-11-28 08:18:29', '2019-11-28 08:18:29'),
(18, 'gender.index', 1, '2019-11-28 08:20:24', '2019-11-28 08:20:24'),
(19, 'gender.show', 1, '2019-11-28 08:20:24', '2019-11-29 21:14:37'),
(20, 'gender.edit', 1, '2019-11-28 08:20:24', '2019-11-28 08:20:24'),
(21, 'role.index', 1, '2019-11-28 08:20:51', '2019-11-28 08:20:51'),
(22, 'role.create', 1, '2019-11-28 08:20:51', '2019-11-28 08:20:51'),
(23, 'role.edit', 1, '2019-11-28 08:20:51', '2019-11-28 08:20:51'),
(24, 'role.show', 1, '2019-11-28 08:20:51', '2019-11-28 08:20:51'),
(25, 'variable.index', 1, '2019-11-28 09:51:24', '2019-11-28 09:51:24'),
(26, 'variable.create', 1, '2019-11-28 09:51:24', '2019-11-28 09:51:24'),
(27, 'variable.edit', 1, '2019-11-28 09:51:24', '2019-11-28 09:51:24'),
(28, 'variable.show', 1, '2019-11-28 09:51:24', '2019-11-28 09:51:24'),
(29, 'loan.index', 1, '2019-11-29 21:10:25', '2019-11-29 21:10:25'),
(30, 'loan.show', 1, '2019-11-29 21:10:25', '2019-11-29 21:10:25'),
(31, 'loan.create', 1, '2019-11-29 21:10:25', '2019-11-29 21:10:25'),
(32, 'loan.edit', 1, '2019-11-29 21:10:25', '2019-11-29 21:10:25'),
(33, 'gender.create', 1, '2019-11-29 21:14:43', '2019-11-29 21:14:43'),
(34, 'advance.create', 1, '2019-12-10 18:43:26', '2019-12-10 18:43:26'),
(35, 'advance.edit', 1, '2019-12-10 18:43:26', '2019-12-10 18:43:26'),
(36, 'advance.update', 1, '2019-12-10 18:43:26', '2019-12-10 18:43:26'),
(37, 'advance.show', 1, '2019-12-10 18:43:26', '2019-12-10 18:43:26'),
(38, 'past_pspf_wcf_download', 1, '2019-12-11 15:14:59', '2019-12-11 15:14:59'),
(39, 'download_past_payslip', 1, '2019-12-11 16:29:38', '2019-12-11 16:29:38'),
(40, 'advance.index', 1, '2019-12-12 13:15:16', '2019-12-12 13:15:16'),
(41, 'system_user', 1, '2019-12-12 19:06:22', '2019-12-12 19:06:22'),
(42, 'filter_by_date', 1, '2020-05-18 06:12:21', '2020-05-18 06:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pension_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joined_date` date DEFAULT NULL,
  `national_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_address` mediumtext COLLATE utf8mb4_unicode_ci,
  `basic_salary` double NOT NULL DEFAULT '0',
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `roles` bigint(20) UNSIGNED NOT NULL,
  `employee_status` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `sname`, `employee_no`, `pension_no`, `joined_date`, `national_id`, `email`, `email_verified_at`, `password`, `dob`, `gender`, `phone`, `post_address`, `basic_salary`, `department_id`, `roles`, `employee_status`, `bank_name`, `account_name`, `account_no`, `tin_no`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hemedi', 'Mshamu', 'Manyinja', 'PRC037', '64723429', '2019-02-01', '19940809-11104-00002-21', 'hmanyinja@gmail.com', NULL, '$2y$10$8TcwY5jh9fCJmrD1lpOUjeJ9w/Bahg/8BJ1esBaSJaugWrebQ0wyq', '1994-02-01', 1, '0685639653', 'Mbagala, Dar es salaam, Tanzania', 479305.56, 1, 1, 3, 'Equity bank', 'Hemedi Manyinja', '3003111542396', '142354683', 1, '8XuuSS1s3IydWzmicvK5F1ROGTLXJi3SyDulWPy5xbqzB8FJeJWwWLc6IMOD', '2019-11-28 08:08:58', '2021-01-21 19:00:29'),
(5, 'System', '_', 'Genetator', NULL, NULL, NULL, NULL, 'system@grandtrack.com', NULL, '$2y$10$UqtCF9OBSH/T6nkZbh4DR.OVEysr2I3fsFeW2K0HKYCmX5R9BlLhS', NULL, 1, NULL, NULL, 0, 1, 1, 3, NULL, NULL, NULL, NULL, 1, NULL, '2019-12-11 19:30:10', '2019-12-11 19:30:10'),
(6, 'Amani', 'Japhet', 'Nguku', 'PRC028', '65166728', '2017-07-01', '19910118-11101-00003-27', 'amaninguku@yahoo.com', NULL, '$2y$10$JOmlHmLXSG85K8V2IkYm2OwsUaBy2pUpw9dUCln/rLRp3wUzBfe0m', '1991-01-18', 1, '0764001113', 'Goba, Dar es salaam, Tanzania', 1400158.73, 1, 1, 3, 'Equity bank', 'Amani Nguku', '3004111421608', NULL, 1, '8uJjfOWFW94Dl8ZOPysxWptHxbUUlTcWD15LnAstq6rFC1MK3dp8snOpcKIg', '2019-12-19 17:23:35', '2021-01-21 19:01:08'),
(8, 'SARAFINA', 'ELIUD', 'NGUKU', 'RS01', '45176021', '2021-01-04', '19950225-14129-00004-17', 'sarafina@grandtracks.com', NULL, '$2y$10$2EHKPxNV1uili93zlNB0/ulHYJCjCAvBuR2Lqyj8euUVjHTX2uM8y', NULL, 2, '0659416124', NULL, 590000, 6, 4, 1, NULL, NULL, NULL, '142-353-547', 1, NULL, '2021-01-22 13:31:28', '2021-01-25 12:24:30'),
(10, 'TULA', 'FABIAN', 'KIKOTI', 'RS02', '45175961', '2021-01-04', '19940628-14107-00003-16', 'tulafabian43@gmail.com', NULL, '$2y$10$yXgQMCDvHMUuNdhPPe4elurIupUt3wOI9Oiu1BjOOuamc0Cxy7GqS', NULL, 2, '0652277371', NULL, 400000, 2, 2, 1, NULL, NULL, NULL, '149-515-445', 1, NULL, '2021-01-22 15:15:28', '2021-01-22 15:30:33'),
(11, 'JANE', 'PASCAL', 'MGIMWA', 'RS03', '60980915', '2021-01-04', '19760507-63104-00001-15', 'janemgimwa@gmail.com', NULL, '$2y$10$BsuE.vERDXKS5pfdRE38oeOpYSddoKubRXd/0tVULdIPlYAIEsxOW', NULL, 2, '0759108358', NULL, 450000, 8, 3, 1, NULL, NULL, NULL, '149-541-977', 1, NULL, '2021-01-22 15:16:39', '2021-01-26 13:40:26'),
(12, 'IMAN', 'ELIOTH', 'SANGA', 'RS04', '45176168', '2021-01-04', '19900101-39423-00007-12', 'iman@gmail.com', NULL, '$2y$10$y.jcX3OuSXmiXNJKsgg4WehCZrUetZg8IVIHoF9GM0vpSwTf5X9oW', NULL, 2, '0769284546', NULL, 380000, 8, 3, 2, NULL, NULL, NULL, '149-587-071', 1, NULL, '2021-01-22 15:17:25', '2021-02-09 12:31:12'),
(13, 'ELIZABETH', 'EDSON', 'MNG\'ONG\'O', 'RS05', '45176054', '2021-01-04', '19980602-59113-00001-12', 'elizabeth@gmail.com', NULL, '$2y$10$fu4Iso7CQryjPgsUEn6O4uEQqrUa/WQzpBL0kqLLTaeEqaS10V/XC', NULL, 2, NULL, NULL, 200000, 7, 3, 1, NULL, NULL, NULL, '149-517-596', 1, NULL, '2021-01-22 15:18:14', '2021-01-26 15:01:08'),
(14, 'HIDAYA', 'BRUNO', 'MLOWE', 'RS10', '45176188', '2021-01-04', '19920202591210000810', 'hidaya@gmail.com', NULL, '$2y$10$s09YHuuUGSFrhrRj4uvl7uK256/jdiCCrjBQAi.r5YV64as9YC6Y2', NULL, 2, NULL, NULL, 200000, 7, 3, 1, NULL, NULL, NULL, '149-833-013', 1, NULL, '2021-01-22 15:18:55', '2021-01-26 15:06:25'),
(15, 'ESTER', 'ANORLD', 'RUEBEN', 'RS06', '45176003', '2021-01-04', '19970804-61305-00001-17', 'ester@gmail.com', NULL, '$2y$10$NEztyPvtxr7jaD4ewojCAeTOyFRvbRia8JVGSHt170Soq/7YvlaBq', NULL, 2, NULL, NULL, 380000, 8, 3, 1, NULL, NULL, NULL, '149-527-419', 1, NULL, '2021-01-22 15:19:39', '2021-01-25 13:26:03'),
(16, 'ALINDWE', 'LABAN', 'MWASAMBILI', 'RS07', '45176043', '2021-01-04', '19730802-59121-00001-21', 'alindwe@gmail.com', NULL, '$2y$10$aRrr5pGi3SlZrHcki/8faODZQX1ILGjp9yXee.BU2wEAz0ZExjvTm', NULL, 1, NULL, NULL, 400000, 5, 3, 1, NULL, NULL, NULL, '120-217-968', 1, NULL, '2021-01-22 15:20:26', '2021-01-26 13:41:29'),
(17, 'ASIA', 'ALLY', 'MPUNGI', 'RS08', '45176058', '2021-01-04', '19840406-59114-00004-13', 'asia@gmail.com', NULL, '$2y$10$FZbkT1/TtVoCCvAXwkl9mOdoFneLW3Sd1iQqfPMJqa9N3bMDVKJlq', NULL, 2, NULL, NULL, 250000, 9, 3, 1, NULL, NULL, NULL, '149-519-726', 1, NULL, '2021-01-22 15:21:16', '2021-01-26 15:02:08'),
(18, 'SEBASTIAN', 'TIMOTH', 'LUKOSI', 'RS09', NULL, '2021-01-04', '19851206-12106-00002-26', 'sebastian@gmail.com', NULL, '$2y$10$PjXtepFgIjfGpaUCzDoeXuC6h9tWIPRLQQfcZ09Mz95bHkyREADe2', NULL, 1, NULL, NULL, 250000, 9, 3, 1, NULL, NULL, NULL, '149-515-445', 1, NULL, '2021-01-22 15:22:14', '2021-01-23 13:32:03');

-- --------------------------------------------------------

--
-- Table structure for table `user_attachments`
--

CREATE TABLE `user_attachments` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `attachment` varchar(191) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `function_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `rid`, `role`, `function_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'roles_settings-Admin', 'Admin', 'roles_settings', '1', '2019-11-28 08:05:20', '2019-11-28 08:05:20'),
(2, 'function.index-Admin', 'Admin', 'function.index', '1', '2019-11-28 08:06:51', '2019-11-28 08:06:51'),
(3, 'function.create-Admin', 'Admin', 'function.create', '1', '2019-11-28 08:06:52', '2019-11-28 08:06:52'),
(4, 'function.edit-Admin', 'Admin', 'function.edit', '1', '2019-11-28 08:06:54', '2019-11-28 08:06:54'),
(5, 'function.show-Admin', 'Admin', 'function.show', '1', '2019-11-28 08:06:56', '2019-11-28 08:06:56'),
(6, 'user.index-Admin', 'Admin', 'user.index', '1', '2019-11-28 08:15:56', '2019-11-28 08:15:56'),
(7, 'user.show-Admin', 'Admin', 'user.show', '1', '2019-11-28 08:15:57', '2019-11-28 08:15:57'),
(8, 'user.edit-Admin', 'Admin', 'user.edit', '1', '2019-11-28 08:15:59', '2019-11-28 08:15:59'),
(9, 'user.create-Admin', 'Admin', 'user.create', '1', '2019-11-28 08:16:02', '2019-11-28 08:16:02'),
(10, 'department.edit-Admin', 'Admin', 'department.edit', '1', '2019-11-28 08:21:01', '2019-11-28 08:21:01'),
(11, 'status.edit-Admin', 'Admin', 'status.edit', '1', '2019-11-28 08:21:02', '2019-11-28 08:21:02'),
(12, 'role.index-Admin', 'Admin', 'role.index', '1', '2019-11-28 08:21:02', '2019-11-28 08:21:02'),
(13, 'department.index-Admin', 'Admin', 'department.index', '1', '2019-11-28 08:21:04', '2019-11-28 08:21:04'),
(14, 'status.index-Admin', 'Admin', 'status.index', '1', '2019-11-28 08:21:05', '2019-11-28 08:21:05'),
(15, 'gender.index-Admin', 'Admin', 'gender.index', '1', '2019-11-28 08:21:06', '2019-11-28 08:21:06'),
(16, 'role.create-Admin', 'Admin', 'role.create', '1', '2019-11-28 08:21:06', '2019-11-28 08:21:06'),
(17, 'department.show-Admin', 'Admin', 'department.show', '1', '2019-11-28 08:21:08', '2019-11-28 08:21:08'),
(18, 'status.show-Admin', 'Admin', 'status.show', '1', '2019-11-28 08:21:09', '2019-11-28 08:21:09'),
(19, 'gender.show.gender.create-Admin', 'Admin', 'gender.show.gender.create', '1', '2019-11-28 08:21:10', '2019-11-28 08:21:10'),
(20, 'role.edit-Admin', 'Admin', 'role.edit', '1', '2019-11-28 08:21:11', '2019-11-28 08:21:11'),
(21, 'role.show-Admin', 'Admin', 'role.show', '1', '2019-11-28 08:21:13', '2019-11-28 08:21:13'),
(22, 'gender.edit-Admin', 'Admin', 'gender.edit', '1', '2019-11-28 08:21:14', '2019-11-28 08:21:14'),
(23, 'status.create-Admin', 'Admin', 'status.create', '1', '2019-11-28 08:21:15', '2019-11-28 08:21:15'),
(24, 'department.create-Admin', 'Admin', 'department.create', '1', '2019-11-28 08:21:17', '2019-11-28 08:21:17'),
(25, 'variable.create-Admin', 'Admin', 'variable.create', '1', '2019-11-28 09:53:02', '2019-11-28 09:53:02'),
(26, 'variable.index-Admin', 'Admin', 'variable.index', '1', '2019-11-28 09:53:04', '2019-11-28 09:53:04'),
(27, 'variable.edit-Admin', 'Admin', 'variable.edit', '1', '2019-11-28 09:53:05', '2019-11-28 09:53:05'),
(28, 'variable.show-Admin', 'Admin', 'variable.show', '1', '2019-11-28 09:53:07', '2019-11-28 09:53:07'),
(29, 'loan.index-Admin', 'Admin', 'loan.index', '1', '2019-11-29 21:10:35', '2019-11-29 21:10:35'),
(30, 'loan.show-Admin', 'Admin', 'loan.show', '1', '2019-11-29 21:10:36', '2019-11-29 21:10:36'),
(31, 'loan.create-Admin', 'Admin', 'loan.create', '1', '2019-11-29 21:10:37', '2019-11-29 21:10:37'),
(32, 'loan.edit-Admin', 'Admin', 'loan.edit', '1', '2019-11-29 21:10:39', '2019-11-29 21:10:39'),
(33, 'gender.create-Admin', 'Admin', 'gender.create', '1', '2019-11-29 21:14:49', '2019-11-29 21:14:49'),
(34, 'gender.show-Admin', 'Admin', 'gender.show', '1', '2019-11-29 21:14:51', '2019-11-29 21:14:51'),
(35, 'function.index-Account', 'Account', 'function.index', '0', '2019-12-02 14:14:38', '2019-12-02 14:14:43'),
(36, 'roles_settings-Account', 'Account', 'roles_settings', '0', '2019-12-02 14:14:40', '2019-12-02 14:14:46'),
(37, 'user.show-Account', 'Account', 'user.show', '1', '2019-12-02 14:14:48', '2019-12-02 14:14:48'),
(38, 'advance.create-Admin', 'Admin', 'advance.create', '1', '2019-12-10 18:43:35', '2019-12-10 18:43:39'),
(39, 'advance.edit-Admin', 'Admin', 'advance.edit', '1', '2019-12-10 18:43:39', '2019-12-10 18:43:40'),
(40, 'advance.update-Admin', 'Admin', 'advance.update', '1', '2019-12-10 18:43:41', '2019-12-10 18:43:42'),
(41, 'advance.show-Admin', 'Admin', 'advance.show', '1', '2019-12-10 18:43:43', '2019-12-10 18:43:44'),
(42, 'past_pspf_wcf_download-Admin', 'Admin', 'past_pspf_wcf_download', '1', '2019-12-11 15:15:08', '2019-12-11 15:15:08'),
(43, 'download_past_payslip-Admin', 'Admin', 'download_past_payslip', '1', '2019-12-11 16:29:47', '2019-12-11 16:29:47'),
(44, 'advance.index-Admin', 'Admin', 'advance.index', '1', '2019-12-12 13:15:30', '2019-12-12 13:15:30'),
(45, 'system_user-Admin', 'Admin', 'system_user', '1', '2019-12-12 19:07:30', '2019-12-12 19:07:30'),
(46, 'user.show-Management', 'Management', 'user.show', '1', '2020-02-27 11:39:40', '2021-01-22 13:50:42'),
(47, 'download_past_payslip-Account', 'Account', 'download_past_payslip', '1', '2020-02-27 11:39:50', '2020-02-27 11:39:50'),
(48, 'past_pspf_wcf_download-Account', 'Account', 'past_pspf_wcf_download', '1', '2020-02-27 11:39:55', '2020-02-27 11:39:55'),
(49, 'advance.show-Account', 'Account', 'advance.show', '1', '2020-02-27 11:40:01', '2020-02-27 11:40:01'),
(50, 'advance.index-Account', 'Account', 'advance.index', '1', '2020-02-27 11:40:05', '2020-02-27 11:40:05'),
(51, 'loan.index-Account', 'Account', 'loan.index', '1', '2020-02-27 11:40:17', '2020-02-27 11:40:17'),
(52, 'user.index-Account', 'Account', 'user.index', '1', '2020-02-27 11:40:27', '2020-02-27 11:40:27'),
(53, 'department.index-Account', 'Account', 'department.index', '1', '2020-02-27 11:40:29', '2020-02-27 11:40:29'),
(54, 'status.index-Account', 'Account', 'status.index', '1', '2020-02-27 11:40:30', '2020-02-27 11:40:30'),
(55, 'gender.index-Account', 'Account', 'gender.index', '1', '2020-02-27 11:40:33', '2020-02-27 11:40:33'),
(56, 'loan.show-Account', 'Account', 'loan.show', '1', '2020-02-27 11:40:37', '2020-02-27 11:40:37'),
(57, 'department.show-Account', 'Account', 'department.show', '1', '2020-02-27 11:40:38', '2020-02-27 11:40:38'),
(58, 'gender.show-Account', 'Account', 'gender.show', '1', '2020-02-27 11:40:40', '2020-02-27 11:40:40'),
(59, 'status.show-Account', 'Account', 'status.show', '1', '2020-02-27 11:40:41', '2020-02-27 11:40:41'),
(60, 'role.show-Account', 'Account', 'role.show', '1', '2020-02-27 11:40:48', '2020-02-27 11:40:48'),
(61, 'role.index-Account', 'Account', 'role.index', '0', '2020-02-27 11:56:57', '2020-02-27 11:57:00'),
(62, 'filter_by_date-Admin', 'Admin', 'filter_by_date', '1', '2020-05-18 06:12:58', '2020-05-18 06:12:58'),
(63, 'user.create-Management', 'Management', 'user.create', '1', '2021-01-22 13:49:42', '2021-01-22 13:49:42'),
(64, 'department.edit-Management', 'Management', 'department.edit', '1', '2021-01-22 13:49:44', '2021-01-22 13:49:44'),
(65, 'status.edit-Management', 'Management', 'status.edit', '1', '2021-01-22 13:49:46', '2021-01-22 13:49:46'),
(66, 'role.index-Management', 'Management', 'role.index', '1', '2021-01-22 13:49:52', '2021-01-22 13:49:52'),
(67, 'variable.index-Management', 'Management', 'variable.index', '1', '2021-01-22 13:49:53', '2021-01-22 13:49:53'),
(68, 'loan.index-Management', 'Management', 'loan.index', '1', '2021-01-22 13:49:58', '2021-01-22 13:49:58'),
(69, 'gender.create-Management', 'Management', 'gender.create', '0', '2021-01-22 13:49:59', '2021-01-22 13:50:02'),
(70, 'advance.show-Management', 'Management', 'advance.show', '1', '2021-01-22 13:50:04', '2021-01-22 13:50:04'),
(71, 'function.index-Management', 'Management', 'function.index', '1', '2021-01-22 13:50:12', '2021-01-22 13:50:12'),
(72, 'user.index-Management', 'Management', 'user.index', '1', '2021-01-22 13:50:12', '2021-01-22 13:50:12'),
(73, 'department.index-Management', 'Management', 'department.index', '1', '2021-01-22 13:50:15', '2021-01-22 13:50:15'),
(74, 'status.index-Management', 'Management', 'status.index', '1', '2021-01-22 13:50:16', '2021-01-22 13:50:16'),
(75, 'gender.index-Management', 'Management', 'gender.index', '1', '2021-01-22 13:50:18', '2021-01-22 13:50:18'),
(76, 'variable.create-Management', 'Management', 'variable.create', '0', '2021-01-22 13:50:21', '2021-01-22 13:50:25'),
(77, 'loan.show-Management', 'Management', 'loan.show', '1', '2021-01-22 13:50:27', '2021-01-22 13:50:27'),
(78, 'advance.create-Management', 'Management', 'advance.create', '1', '2021-01-22 13:50:29', '2021-01-22 13:50:29'),
(79, 'past_pspf_wcf_download-Management', 'Management', 'past_pspf_wcf_download', '1', '2021-01-22 13:50:31', '2021-01-22 13:50:31'),
(80, 'filter_by_date-Management', 'Management', 'filter_by_date', '1', '2021-01-22 13:50:34', '2021-01-22 13:50:34'),
(81, 'department.show-Management', 'Management', 'department.show', '1', '2021-01-22 13:50:44', '2021-01-22 13:50:44'),
(82, 'status.show-Management', 'Management', 'status.show', '1', '2021-01-22 13:50:46', '2021-01-22 13:50:46'),
(83, 'gender.show-Management', 'Management', 'gender.show', '1', '2021-01-22 13:50:53', '2021-01-22 13:50:53'),
(84, 'role.edit-Management', 'Management', 'role.edit', '1', '2021-01-22 13:50:56', '2021-01-22 13:50:56'),
(85, 'variable.edit-Management', 'Management', 'variable.edit', '1', '2021-01-22 13:51:03', '2021-01-22 13:51:03'),
(86, 'loan.create-Management', 'Management', 'loan.create', '1', '2021-01-22 13:51:04', '2021-01-22 13:51:04'),
(87, 'advance.edit-Management', 'Management', 'advance.edit', '1', '2021-01-22 13:51:06', '2021-01-22 13:51:06'),
(88, 'download_past_payslip-Management', 'Management', 'download_past_payslip', '1', '2021-01-22 13:51:07', '2021-01-22 13:51:07'),
(89, 'user.edit-Management', 'Management', 'user.edit', '1', '2021-01-22 13:51:12', '2021-01-22 13:51:12'),
(90, 'department.create-Management', 'Management', 'department.create', '1', '2021-01-22 13:51:16', '2021-01-22 13:51:16'),
(91, 'gender.edit-Management', 'Management', 'gender.edit', '1', '2021-01-22 13:51:24', '2021-01-22 13:51:24'),
(92, 'role.show-Management', 'Management', 'role.show', '1', '2021-01-22 13:51:25', '2021-01-22 13:51:25'),
(93, 'variable.show-Management', 'Management', 'variable.show', '1', '2021-01-22 13:51:27', '2021-01-22 13:51:27'),
(94, 'loan.edit-Management', 'Management', 'loan.edit', '1', '2021-01-22 13:51:29', '2021-01-22 13:51:29'),
(95, 'advance.update-Management', 'Management', 'advance.update', '1', '2021-01-22 13:51:35', '2021-01-22 13:51:35'),
(96, 'advance.index-Management', 'Management', 'advance.index', '1', '2021-01-22 13:51:37', '2021-01-22 13:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_updates`
--

CREATE TABLE `user_updates` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` mediumtext NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_updates`
--

INSERT INTO `user_updates` (`id`, `user_id`, `body`, `created_by`, `created_at`, `updated_at`) VALUES
(14, 8, 'status From On Post to Terminated', 15, '2020-10-23 13:38:21', '2020-10-23 13:38:21'),
(13, 28, 'status From Terminated to On Post', 6, '2020-10-06 15:51:44', '2020-10-06 15:51:44'),
(12, 1, 'surname From Manyinja. to Manyinja', 6, '2020-07-14 06:59:34', '2020-07-14 06:59:34'),
(11, 1, 'surname From Manyinja to Manyinja.', 6, '2020-07-14 06:59:29', '2020-07-14 06:59:29'),
(10, 1, 'status From Terminated to On Post', 6, '2020-07-14 06:56:13', '2020-07-14 06:56:13'),
(9, 1, 'status From On Post to Terminated', 6, '2020-07-14 06:33:33', '2020-07-13 23:48:51'),
(15, 23, 'status From On Post to Terminated', 15, '2020-12-10 15:02:09', '2020-12-10 15:02:09'),
(16, 1, 'status From On Post to System', 6, '2021-01-21 19:00:29', '2021-01-21 19:00:29'),
(17, 6, 'status From On Post to System', 6, '2021-01-21 19:01:08', '2021-01-21 19:01:08'),
(18, 12, 'status From On Post to Terminated', 8, '2021-02-09 12:31:12', '2021-02-09 12:31:12');

-- --------------------------------------------------------

--
-- Table structure for table `variables`
--

CREATE TABLE `variables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variables`
--

INSERT INTO `variables` (`id`, `name`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Company Name', 'Rosper School', 1, '2019-11-28 10:00:28', '2019-12-10 18:37:37'),
(2, 'Reply E-Mail', 'hmanyinja@gmail.com', 1, '2019-11-28 10:06:39', '2019-11-28 10:06:39'),
(3, 'CC E-Mail', 'hemmy6894@gmail.com', 1, '2019-11-28 10:07:11', '2019-11-28 10:07:11'),
(4, 'Signature', 'The email signature', 1, '2019-11-28 10:31:10', '2019-11-28 10:31:10'),
(5, 'Pension Percent', '10', 1, '2019-12-10 16:15:05', '2019-12-10 16:16:11'),
(6, 'SDL Percent', '4', 1, '2019-12-10 16:15:18', '2020-07-14 07:16:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advance_salaries`
--
ALTER TABLE `advance_salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advance_salaries_user_id_foreign` (`user_id`),
  ADD KEY `advance_salaries_created_by_foreign` (`created_by`);

--
-- Indexes for table `bft_loans`
--
ALTER TABLE `bft_loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_boards_user_id_foreign` (`user_id`),
  ADD KEY `loan_boards_created_by_foreign` (`created_by`);

--
-- Indexes for table `bft_loan_activities`
--
ALTER TABLE `bft_loan_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_board_activities_user_id_foreign` (`user_id`),
  ADD KEY `loan_board_activities_loan_id_foreign` (`loan_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_statuses`
--
ALTER TABLE `employee_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_user_id_foreign` (`user_id`),
  ADD KEY `loans_created_by_foreign` (`created_by`);

--
-- Indexes for table `loan_activities`
--
ALTER TABLE `loan_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_activities_user_id_foreign` (`user_id`),
  ADD KEY `loan_activities_loan_id_foreign` (`loan_id`);

--
-- Indexes for table `loan_boards`
--
ALTER TABLE `loan_boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_boards_user_id_foreign` (`user_id`),
  ADD KEY `loan_boards_created_by_foreign` (`created_by`);

--
-- Indexes for table `loan_board_activities`
--
ALTER TABLE `loan_board_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_board_activities_user_id_foreign` (`user_id`),
  ADD KEY `loan_board_activities_loan_id_foreign` (`loan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_mails`
--
ALTER TABLE `pending_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_functions`
--
ALTER TABLE `system_functions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_gender_foreign` (`gender`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_employee_status_foreign` (`employee_status`),
  ADD KEY `users_roles_foreign` (`roles`);

--
-- Indexes for table `user_attachments`
--
ALTER TABLE `user_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_updates`
--
ALTER TABLE `user_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variables`
--
ALTER TABLE `variables`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advance_salaries`
--
ALTER TABLE `advance_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bft_loans`
--
ALTER TABLE `bft_loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bft_loan_activities`
--
ALTER TABLE `bft_loan_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee_statuses`
--
ALTER TABLE `employee_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_activities`
--
ALTER TABLE `loan_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_boards`
--
ALTER TABLE `loan_boards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_board_activities`
--
ALTER TABLE `loan_board_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_mails`
--
ALTER TABLE `pending_mails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_functions`
--
ALTER TABLE `system_functions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_attachments`
--
ALTER TABLE `user_attachments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `user_updates`
--
ALTER TABLE `user_updates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `variables`
--
ALTER TABLE `variables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advance_salaries`
--
ALTER TABLE `advance_salaries`
  ADD CONSTRAINT `advance_salaries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `advance_salaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_activities`
--
ALTER TABLE `loan_activities`
  ADD CONSTRAINT `loan_activities_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`),
  ADD CONSTRAINT `loan_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_boards`
--
ALTER TABLE `loan_boards`
  ADD CONSTRAINT `loan_boards_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_boards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_board_activities`
--
ALTER TABLE `loan_board_activities`
  ADD CONSTRAINT `loan_board_activities_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`),
  ADD CONSTRAINT `loan_board_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `users_employee_status_foreign` FOREIGN KEY (`employee_status`) REFERENCES `employee_statuses` (`id`),
  ADD CONSTRAINT `users_gender_foreign` FOREIGN KEY (`gender`) REFERENCES `genders` (`id`),
  ADD CONSTRAINT `users_roles_foreign` FOREIGN KEY (`roles`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
