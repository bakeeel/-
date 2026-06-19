-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06 يونيو 2026 الساعة 14:49
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `military_training`
--

-- --------------------------------------------------------

--
-- بنية الجدول `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `payload`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 09:23:39', '2026-06-03 09:23:39'),
(2, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-03 09:45:48', '2026-06-03 09:45:48'),
(3, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 11:27:52', '2026-06-03 11:27:52'),
(4, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-03 12:12:53', '2026-06-03 12:12:53'),
(5, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-03 16:00:45', '2026-06-03 16:00:45'),
(6, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 19:00:55', '2026-06-03 19:00:55'),
(7, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:10:29', '2026-06-03 21:10:29'),
(8, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:11:00', '2026-06-03 21:11:00'),
(9, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:11:42', '2026-06-03 21:11:42'),
(10, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:12:09', '2026-06-03 21:12:09'),
(11, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:12:34', '2026-06-03 21:12:34'),
(12, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:13:19', '2026-06-03 21:13:19'),
(13, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:13:41', '2026-06-03 21:13:41'),
(14, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:14:18', '2026-06-03 21:14:18'),
(15, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:15:02', '2026-06-03 21:15:02'),
(16, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-03 21:15:25', '2026-06-03 21:15:25'),
(17, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-04 07:42:35', '2026-06-04 07:42:35'),
(18, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-04 07:50:44', '2026-06-04 07:50:44'),
(19, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-04 08:11:35', '2026-06-04 08:11:35'),
(20, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-04 18:58:35', '2026-06-04 18:58:35'),
(21, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-05 10:31:25', '2026-06-05 10:31:25'),
(22, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 10:45:36', '2026-06-05 10:45:36'),
(23, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 10:48:50', '2026-06-05 10:48:50'),
(24, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-05 11:52:41', '2026-06-05 11:52:41'),
(25, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 11:56:02', '2026-06-05 11:56:02'),
(26, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 12:01:05', '2026-06-05 12:01:05'),
(27, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 14:00:18', '2026-06-05 14:00:18'),
(28, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-05 14:48:07', '2026-06-05 14:48:07'),
(29, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 15:06:31', '2026-06-05 15:06:31'),
(30, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 15:15:09', '2026-06-05 15:15:09'),
(31, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-05 15:18:33', '2026-06-05 15:18:33'),
(32, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 15:20:28', '2026-06-05 15:20:28'),
(33, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-05 15:26:37', '2026-06-05 15:26:37'),
(34, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-05 15:53:08', '2026-06-05 15:53:08'),
(35, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-05 16:49:40', '2026-06-05 16:49:40'),
(36, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-05 16:54:46', '2026-06-05 16:54:46'),
(37, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-06 07:18:21', '2026-06-06 07:18:21'),
(38, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-06 08:19:58', '2026-06-06 08:19:58'),
(39, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-06 08:22:18', '2026-06-06 08:22:18'),
(40, 2, 'إضافة متدرب عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-06 09:27:01', '2026-06-06 09:27:01'),
(41, 2, 'إضافة ضابط جديد', NULL, NULL, NULL, NULL, '2026-06-06 09:37:06', '2026-06-06 09:37:06'),
(42, 2, 'إضافة فرد عسكري جديد', NULL, NULL, NULL, NULL, '2026-06-06 09:39:22', '2026-06-06 09:39:22');

-- --------------------------------------------------------

--
-- بنية الجدول `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration_days` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `certificate_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `courses`
--

INSERT INTO `courses` (`id`, `name`, `type`, `start_date`, `end_date`, `duration_days`, `location`, `certificate_number`, `status`, `created_at`, `updated_at`) VALUES
(25, 'الامن السبراني', 'basic', '1447-12-01', '1447-12-30', 10, 'وزارة الدفاع', 'CERT-TAC-01', 'قيد الانتظار', '2026-06-05 15:28:11', '2026-06-06 08:55:50'),
(26, 'امن الطرق', 'advanced', '1447-01-01', '1447-01-26', 15, 'وزارة الدفاع', 'CERT-TAC-02', 'مكتملة ومؤرشفة', '2026-06-05 15:55:24', '2026-06-05 16:06:40'),
(28, 'دورة الامن 15', 'tactical', '1447-01-05', '1447-01-16', 89, '775985779577', 'CERT-TAC-04', 'مكتملة ومؤرشفة', '2026-06-05 17:03:26', '2026-06-06 08:28:06');

-- --------------------------------------------------------

--
-- بنية الجدول `course_officer`
--

CREATE TABLE `course_officer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `officer_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'مستمر في الدورة',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `course_officer`
--

INSERT INTO `course_officer` (`id`, `officer_id`, `status`, `start_date`, `end_date`, `course_id`, `location`, `created_at`, `updated_at`) VALUES
(21, 19, 'أكمل الدورة', '1447-01-24', '1447-01-27', 25, 'وزارة الدفاع', '2026-06-05 15:28:39', '2026-06-05 15:28:39'),
(22, 20, 'أكمل الدورة', '1447-01-01', '1447-01-17', 26, 'وزارة الدفاع', '2026-06-05 15:56:24', '2026-06-05 15:56:24'),
(24, 21, 'أكمل الدورة', '1447-01-03', '1447-01-27', 25, 'وزارة الدفاع', '2026-06-06 06:11:43', '2026-06-06 06:11:43'),
(25, 19, 'مستمر في الدورة', '1447-12-18', '1447-12-25', 26, 'وزارة الدفاع', '2026-06-06 06:29:53', '2026-06-06 08:40:26'),
(26, 20, 'مستمر في الدورة', '1447-01-23', '1447-01-30', 25, 'وووووو', '2026-06-06 06:30:33', '2026-06-06 06:30:33');

-- --------------------------------------------------------

--
-- بنية الجدول `course_personnel`
--

CREATE TABLE `course_personnel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `personnel_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'مستمر في الدورة',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `course_personnel`
--

INSERT INTO `course_personnel` (`id`, `personnel_id`, `status`, `start_date`, `end_date`, `course_id`, `location`, `created_at`, `updated_at`) VALUES
(13, 11, 'أكمل الدورة', '1447-01-23', '1447-01-26', 25, 'وزارة الدفاع 155', '2026-06-05 15:58:17', '2026-06-06 06:37:55');

-- --------------------------------------------------------

--
-- بنية الجدول `course_trainee`
--

CREATE TABLE `course_trainee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trainee_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'مستمر في الدورة',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `course_trainee`
--

INSERT INTO `course_trainee` (`id`, `trainee_id`, `status`, `start_date`, `end_date`, `course_id`, `created_at`, `updated_at`, `location`) VALUES
(11, 7, 'مستمر في الدورة', '1447-05-18', '1447-05-27', 26, '2026-06-06 08:24:26', '2026-06-06 09:19:35', 'خاص'),
(12, 6, 'مستمر في الدورة', '1447-01-24', '1447-01-30', 25, '2026-06-06 08:24:51', '2026-06-06 08:24:51', 'وزارة الدفاع');

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_28_180928_create_personnel_table', 1),
(5, '2026_05_28_181000_create_courses_table', 1),
(6, '2026_05_28_181010_create_promotions_and_logs_tables', 1),
(7, '2026_05_29_190340_add_details_to_course_personnel_table', 1),
(8, '2026_05_31_221407_add_phone_and_service_duration_to_personnel_table', 1),
(9, '2026_06_01_001053_create_officers_table', 1),
(10, '2026_06_01_004559_create_course_officer_table', 1),
(11, '2026_06_01_010530_add_avatar_to_officers_table', 1),
(12, '2026_06_01_010838_update_officers_table_add_missing_columns', 1),
(13, '2026_06_01_100241_add_officer_id_to_promotions_table', 1),
(14, '2026_06_02_103050_create_trainees_table', 1),
(15, '2026_06_02_103255_create_course_trainee_table', 1),
(16, '2026_06_02_124126_add_pivot_columns_to_course_trainee_table', 1),
(17, '2026_06_03_135920_add_status_and_dates_to_course_officer_table', 2),
(18, '2026_06_03_135941_add_status_and_dates_to_course_personnel_table', 2),
(19, '2026_06_03_140117_add_status_and_dates_to_course_trainee_table', 2),
(20, '2026_06_03_142415_add_status_and_dates_to_course_trainee_table', 3),
(21, '2026_06_03_214942_add_sailing_days_to_officers_table', 4),
(22, '2026_06_05_115959_create_vacancies_table', 5);

-- --------------------------------------------------------

--
-- بنية الجدول `officers`
--

CREATE TABLE `officers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `military_id` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `specialty` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `sailing_hours` int(11) NOT NULL DEFAULT 0,
  `sailing_days` int(11) NOT NULL DEFAULT 0,
  `phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'نشط',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `officers`
--

INSERT INTO `officers` (`id`, `military_id`, `full_name`, `rank`, `specialty`, `appointment_date`, `avatar`, `sailing_hours`, `sailing_days`, `phone`, `status`, `created_at`, `updated_at`, `notes`) VALUES
(19, 'O20260001', 'علي حزام', 'عقيد بحري', 'قائد عالي', '1447-01-25', 'avatars/mil_avatar_6a2312f94612d.jpeg', 1, 2, '6546556465', 'نشط', '2026-06-05 15:18:33', '2026-06-06 08:57:04', NULL),
(20, 'O20260002', 'الشيخ شرف', 'قائد', 'مدفعيه', '1447-01-18', 'avatars/mil_avatar_6a231b1458d5d.png', 3, 4, '4654655555', 'نشط', '2026-06-05 15:53:08', '2026-06-06 08:56:57', NULL),
(21, 'O20260003', 'بكيل  مرشد', 'عميد بحري ركن', 'مهندس', '1447-01-03', NULL, 11, 12, '7868667866', 'نشط', '2026-06-05 16:49:40', '2026-06-06 08:56:48', NULL),
(23, 'O20260004', 'سعيد قاسم', 'عميد بحري ركن', 'مدفعي 1', '1447-01-04', 'avatars/mil_avatar_6a23f3ed7b79c.jpeg', 3, 0, '4645654644', 'نشط', '2026-06-06 07:18:21', '2026-06-06 07:18:21', NULL),
(24, 'O20260005', 'علي بن علي', 'عميد بحري ركن', 'يلبيلبي111', '1447-01-03', NULL, 0, 1, '6556565656', 'إذن', '2026-06-06 09:37:06', '2026-06-06 09:37:06', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `personnel`
--

CREATE TABLE `personnel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `military_id` varchar(255) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `rank` varchar(255) NOT NULL,
  `primary_specialty` varchar(255) NOT NULL,
  `sub_specialty` varchar(255) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `service_years` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `service_months` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `confirmation_date` date DEFAULT NULL,
  `current_promotion_date` date NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `personnel`
--

INSERT INTO `personnel` (`id`, `full_name`, `military_id`, `phone`, `rank`, `primary_specialty`, `sub_specialty`, `appointment_date`, `service_years`, `service_months`, `confirmation_date`, `current_promotion_date`, `avatar`, `status`, `notes`, `deleted_at`, `created_at`, `updated_at`) VALUES
(11, 'مؤمن راشد', 'P20260001', '1556456666', 'رقيب', 'م11', 'م111111111111', '1447-01-02', 2, 1, '1447-01-04', '1447-01-05', 'avatars/mil_avatar_6a23136c24c12.jpeg', 'نشط', NULL, NULL, '2026-06-05 15:20:28', '2026-06-05 15:20:49'),
(12, 'gffghgfhgf', 'P20260002', NULL, 'رقيب اول', 'hjghjhgj', 'jhgjhgj', '1447-01-01', 2, 1, '1447-01-04', '1447-01-07', NULL, 'إجازة', NULL, NULL, '2026-06-06 09:39:22', '2026-06-06 09:39:22');

-- --------------------------------------------------------

--
-- بنية الجدول `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `officer_id` bigint(20) UNSIGNED NOT NULL,
  `personnel_id` bigint(20) UNSIGNED NOT NULL,
  `previous_rank` varchar(255) NOT NULL,
  `new_rank` varchar(255) NOT NULL,
  `promotion_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7OuuEBjqTbGhOXm4vnAc3RThbOGPaTZsYa0FIypL', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidzJETXBKa0FxYkczQWZGMHFZRGhocTdzWGJvVzFMZDJ5REI5eVVrcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vZmZpY2VycyI7czo1OiJyb3V0ZSI7czoxMzoib2ZmaWNlci5pbmRleCI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1780750114);

-- --------------------------------------------------------

--
-- بنية الجدول `trainees`
--

CREATE TABLE `trainees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `military_id` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `rank` varchar(255) NOT NULL,
  `primary_specialty` varchar(255) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `service_years` int(11) NOT NULL DEFAULT 0,
  `service_months` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `trainees`
--

INSERT INTO `trainees` (`id`, `military_id`, `full_name`, `phone`, `rank`, `primary_specialty`, `appointment_date`, `service_years`, `service_months`, `avatar`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(5, 'T20260001', 'علي قاسم', '6565465555', 'عريف', 'مدفعية1', '1447-01-06', 3, 2, 'avatars/mil_avatar_6a2314ddb7d59.png', 'نشط', 'لبلب', '2026-06-05 15:26:37', '2026-06-05 15:26:50'),
(6, 'T20260002', 'قاسم علي', '4654655555', 'عريف 11', 'ممم1', '1447-12-11', 3, 2, 'avatars/mil_avatar_6a24025e9a115.png', 'نشط', NULL, '2026-06-06 08:19:58', '2026-06-06 08:19:58'),
(7, 'T20260003', 'حمود', NULL, 'جندي اول', 'ننن1', '1447-02-04', 1, 1, NULL, 'نشط', NULL, '2026-06-06 08:22:18', '2026-06-06 08:22:18'),
(8, 'T20260004', 'كامل', NULL, 'رئيس رقباء', 'ك1', '1447-01-12', 4, 3, NULL, 'مسلم', NULL, '2026-06-06 09:27:01', '2026-06-06 09:27:01');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'المشرف العام', 'admin@system.local', NULL, '$2y$12$m4eOj0g7y2k/NdjYntgxXubZJKymcdoJjApqqYJ3P0vLCZPQM93qu', '0cMLKLe8KbPYbQ5C4S3XWtsxYKnYv2xyzFdjRQ4g68NopUQi5C4J1zg8XW8L', '2026-06-03 09:21:28', '2026-06-03 09:21:28'),
(3, 'مدير النظام الثاني', 'admin@admin.com', NULL, '$2y$12$nqhBUxl5psa4OVIbGTkVIeZVukqBaY6EJvZfnFA6juF.QHcfHHVNq', NULL, '2026-06-05 15:42:18', '2026-06-05 15:42:18');

-- --------------------------------------------------------

--
-- بنية الجدول `vacancies`
--

CREATE TABLE `vacancies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vacancy_number` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` enum('vacant','under_action','processing') NOT NULL DEFAULT 'vacant',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `vacancies`
--

INSERT INTO `vacancies` (`id`, `vacancy_number`, `title`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(22, '464565', 'engineer', 'processing', '', '2026-06-05 12:06:54', '2026-06-05 12:07:08'),
(23, '454645654645', 'بلابلالت', 'under_action', 'البالب', '2026-06-05 15:27:32', '2026-06-05 15:27:32'),
(25, 'لتالتالتالاتللت', '9879878979878977', 'vacant', '', '2026-06-05 17:12:14', '2026-06-05 17:12:14'),
(26, '4579788979', 'ضابط صف ادارة', 'processing', 'تم جديد', '2026-06-06 06:05:51', '2026-06-06 06:05:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_officer`
--
ALTER TABLE `course_officer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_officer_officer_id_foreign` (`officer_id`),
  ADD KEY `course_officer_course_id_foreign` (`course_id`);

--
-- Indexes for table `course_personnel`
--
ALTER TABLE `course_personnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_personnel_personnel_id_foreign` (`personnel_id`),
  ADD KEY `course_personnel_course_id_foreign` (`course_id`);

--
-- Indexes for table `course_trainee`
--
ALTER TABLE `course_trainee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_trainee_trainee_id_foreign` (`trainee_id`),
  ADD KEY `course_trainee_course_id_foreign` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `officers_military_id_unique` (`military_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personnel_military_id_unique` (`military_id`),
  ADD UNIQUE KEY `personnel_phone_unique` (`phone`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotions_personnel_id_foreign` (`personnel_id`),
  ADD KEY `promotions_officer_id_foreign` (`officer_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `trainees`
--
ALTER TABLE `trainees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trainees_military_id_unique` (`military_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vacancies_vacancy_number_unique` (`vacancy_number`),
  ADD KEY `vacancies_status_index` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `course_officer`
--
ALTER TABLE `course_officer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `course_personnel`
--
ALTER TABLE `course_personnel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `course_trainee`
--
ALTER TABLE `course_trainee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainees`
--
ALTER TABLE `trainees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- قيود الجداول `course_officer`
--
ALTER TABLE `course_officer`
  ADD CONSTRAINT `course_officer_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_officer_officer_id_foreign` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `course_personnel`
--
ALTER TABLE `course_personnel`
  ADD CONSTRAINT `course_personnel_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_personnel_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `course_trainee`
--
ALTER TABLE `course_trainee`
  ADD CONSTRAINT `course_trainee_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_trainee_trainee_id_foreign` FOREIGN KEY (`trainee_id`) REFERENCES `trainees` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_officer_id_foreign` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotions_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
