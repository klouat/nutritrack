-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2025 at 03:26 PM
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
-- Database: `nutri`
--

-- --------------------------------------------------------

--
-- Table structure for table `asupan`
--

CREATE TABLE `asupan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kadar_gula` decimal(6,2) NOT NULL,
  `kadar_kalori` decimal(6,2) NOT NULL,
  `tanggal_konsumsi` date NOT NULL,
  `waktu_konsumsi` varchar(255) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asupan`
--

INSERT INTO `asupan` (`id`, `user_id`, `nama`, `kadar_gula`, `kadar_kalori`, `tanggal_konsumsi`, `waktu_konsumsi`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 4, 'Teh Manis', 15.00, 60.00, '2025-05-01', 'Pagi', 'Minum dengan sarapan', '2025-05-01 03:28:15', '2025-05-01 03:28:15'),
(2, 4, 'asdfs', 15.00, 60.00, '2025-05-01', 'Pagi', 'Minum dengan sarapan', '2025-05-01 03:56:41', '2025-05-01 03:56:41'),
(4, 9, 'Teh Manis', 15.00, 60.00, '2025-05-08', 'Pagi', 'Minum dengan sarapan', '2025-05-08 13:08:42', '2025-05-08 13:08:42'),
(5, 4, 'Teh Manis', 15.00, 60.00, '2025-05-09', 'Pagi', 'Minum dengan sarapan', '2025-05-08 23:00:12', '2025-05-08 23:00:12'),
(6, 10, 'Nasi Goreng', 100.00, 200.00, '2025-05-09', 'Pagi', 'Minum dengan sarapan', '2025-05-09 00:02:38', '2025-05-09 00:02:38'),
(7, 4, 'Teh Manis', 15.00, 60.00, '2025-05-12', 'Pagi', 'Minum dengan sarapan', '2025-05-12 04:57:54', '2025-05-12 04:57:54'),
(8, 10, 'Teh Manis', 15.00, 60.00, '2025-05-18', 'Pagi', 'Minum dengan sarapan', '2025-05-18 05:31:23', '2025-05-18 05:31:23'),
(9, 10, 'Teh Manis', 15.00, 9999.99, '2025-05-18', 'Pagi', 'Minum dengan sarapan', '2025-05-18 05:32:13', '2025-05-18 05:32:13'),
(10, 10, 'Teh Manis', 15.00, 9999.99, '2025-05-20', 'Pagi', 'Minum dengan sarapan', '2025-05-18 05:35:52', '2025-05-18 05:35:52'),
(11, 10, 'Teh Manis', 15.00, 60.00, '2025-05-18', 'Pagi', 'Minum dengan sarapan', '2025-05-18 05:48:29', '2025-05-18 05:48:29'),
(12, 10, 'Teh Manis', 9999.99, 60.00, '2025-05-10', 'Pagi', 'Minum dengan sarapan', '2025-05-18 06:08:07', '2025-05-18 06:08:07'),
(13, 10, 'Teh Manis', 5.00, 60.00, '2025-05-18', 'Pagi', 'Minum dengan sarapan', '2025-05-18 06:08:49', '2025-05-18 06:08:49'),
(14, 10, 'Teh Manis', 15.00, 60.00, '2025-05-19', 'Pagi', 'Minum dengan sarapan', '2025-05-18 23:56:13', '2025-05-18 23:56:13'),
(15, 10, 'Teh Manis', 15.00, 9999.99, '2025-05-19', 'Pagi', 'Minum dengan sarapan', '2025-05-19 00:06:44', '2025-05-19 00:06:44'),
(16, 10, 'Teh Manis', 9999.99, 60.00, '2025-05-19', 'Pagi', 'Minum dengan sarapan', '2025-05-19 00:07:05', '2025-05-19 00:07:05'),
(17, 4, 'Teh Manis', 15.00, 60.00, '2025-05-23', 'Pagi', 'Minum dengan sarapan', '2025-05-22 23:24:47', '2025-05-22 23:24:47'),
(19, 9, 'Teh Manis', 15.00, 60.00, '2025-06-04', 'Pagi', 'Minum dengan sarapan', '2025-06-04 14:01:15', '2025-06-04 14:01:15'),
(20, 9, 'Teh Manis', 5.32, 27.00, '2025-06-05', 'Pagi', 'Minum dengan sarapan', '2025-06-05 10:10:10', '2025-06-05 10:10:10'),
(21, 9, 'ICE CREAM', 21.50, 200.00, '2025-06-06', 'Pagi', 'Minum dengan sarapan', '2025-06-05 17:04:00', '2025-06-05 17:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_laporan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `judul`, `isi_laporan`, `created_at`, `updated_at`) VALUES
(1, 'test', 'sdfsdf', '2025-04-30 23:09:22', '2025-04-30 23:09:22'),
(2, 'test', '\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"', '2025-04-30 23:10:17', '2025-04-30 23:10:17'),
(3, 'egdfgd', 'fgdfdfgdfg', '2025-05-01 06:18:55', '2025-05-01 06:18:55'),
(4, 'teste', 'dsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsddsdvvvv', '2025-05-01 06:31:03', '2025-05-01 06:31:03'),
(5, 'test', 'test', '2025-05-08 13:02:16', '2025-05-08 13:02:16'),
(6, 'Tombol tidak berfungsi', 'Tombol kirim tidak berfungsi', '2025-05-09 00:05:34', '2025-05-09 00:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_id` bigint(20) UNSIGNED NOT NULL,
  `to_id` bigint(20) DEFAULT NULL,
  `to_role` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from_id`, `to_id`, `to_role`, `message`, `created_at`, `updated_at`) VALUES
(17, 4, NULL, 'dokter_pencegahan', 'test', '2025-05-01 08:27:58', '2025-05-01 08:27:58'),
(18, 4, NULL, NULL, 'TEST', '2025-05-01 08:29:03', '2025-05-01 08:29:03'),
(19, 4, NULL, NULL, 'test', '2025-05-01 08:29:11', '2025-05-01 08:29:11'),
(58, 9, NULL, 'dokter_pencegahan', 'halo dok', '2025-05-08 22:31:48', '2025-05-08 22:31:48'),
(59, 4, 9, NULL, 'iya ada apa', '2025-05-08 22:32:00', '2025-05-08 22:32:00'),
(60, 10, NULL, 'dokter_pencegahan', 'halo dok', '2025-05-09 00:04:04', '2025-05-09 00:04:04'),
(61, 4, 10, NULL, 'iya ada apa', '2025-05-09 00:04:47', '2025-05-09 00:04:47'),
(62, 10, NULL, 'dokter_pencegahan', 'saya ada keluhan', '2025-05-09 00:04:52', '2025-05-09 00:04:52'),
(64, 9, NULL, 'dokter_pencegahan', 'test', '2025-06-08 06:07:34', '2025-06-08 06:07:34'),
(65, 4, 9, NULL, 'test', '2025-06-08 06:10:03', '2025-06-08 06:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_29_221230_create_asupans_table', 2),
(5, '2025_05_01_055629_create_laporan_table', 3),
(6, '2025_05_01_141939_create_messages_table', 4),
(7, '2024_04_30_create_pilihan_sehat_table', 5),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('dewaraysa35@gmail.com', '$2y$10$989W8I5LZsuDkUnGBRI8fOnZ5kX71ePeFhuvIxqB8.127AGTRaJwK', '2025-05-12 04:25:13');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_otps`
--

CREATE TABLE `password_reset_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_otps`
--

INSERT INTO `password_reset_otps` (`id`, `email`, `otp`, `used`, `created_at`, `updated_at`, `expires_at`) VALUES
(2, 'dewaraysa35@gmail.com', '04460', 0, '2025-05-15 09:29:00', '2025-05-15 09:29:00', '2025-05-15 09:43:59'),
(12, 'crystalyt856@gmail.com', '99819', 0, '2025-06-05 23:13:18', '2025-06-05 23:13:18', '2025-06-05 23:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(4, 'App\\Models\\User', 14, 'api-token', '5ad913e61e046a0344963f35e2d1858a454d89c57b61bb3fb4663faa1e52890b', '[\"*\"]', NULL, NULL, '2025-06-05 08:40:40', '2025-06-05 08:40:40'),
(5, 'App\\Models\\User', 14, 'api-token', 'c9e7920e1be76bbb3f8e64056b9f033578b23aa657f0f7f2eefdd7072d359c2f', '[\"*\"]', NULL, NULL, '2025-06-05 08:43:20', '2025-06-05 08:43:20'),
(6, 'App\\Models\\User', 14, 'api-token', '25effc40ff3708a0b1665c884b6fa01bd0b111d74ba0a39166a59967ad60af5d', '[\"*\"]', NULL, NULL, '2025-06-05 08:43:32', '2025-06-05 08:43:32'),
(7, 'App\\Models\\User', 14, 'api-token', 'a15449aad133a1255e56eb7ea519083fae1d795b1af3f712e2795a175955ac2f', '[\"*\"]', NULL, NULL, '2025-06-05 08:43:49', '2025-06-05 08:43:49'),
(8, 'App\\Models\\User', 14, 'api-token', 'c4cf62f8829387f17162f1e5242fd96efe6a9f574c9eab1f6e335d20f5721fd7', '[\"*\"]', NULL, NULL, '2025-06-05 08:43:51', '2025-06-05 08:43:51'),
(9, 'App\\Models\\User', 14, 'api-token', '08729e9bf7bd4353835d950b1a093d4c4669ba7c36de1ebf0422298333a84b76', '[\"*\"]', NULL, NULL, '2025-06-05 08:43:55', '2025-06-05 08:43:55'),
(10, 'App\\Models\\User', 14, 'api-token', '25ab6f64cfa5992c6f2242c2007195bdec4a866fe0370314439c5d025595a799', '[\"*\"]', NULL, NULL, '2025-06-05 08:43:56', '2025-06-05 08:43:56'),
(11, 'App\\Models\\User', 9, 'api-token', '4baa728c240929b41fe09ef75763f2d8d4c3b3609bf9474ac1655eecb4b65b56', '[\"*\"]', NULL, NULL, '2025-06-05 08:44:16', '2025-06-05 08:44:16'),
(12, 'App\\Models\\User', 9, 'api-token', '84e2c58b4a626b5f5ee13e512604f065c24be56125063d44513b06c9ba17f10b', '[\"*\"]', NULL, NULL, '2025-06-05 08:44:23', '2025-06-05 08:44:23'),
(13, 'App\\Models\\User', 9, 'api-token', '28e3b5e5e36f2f05bc4f62e0d559b321a607b56bac6385ef27635a110ab581b7', '[\"*\"]', NULL, NULL, '2025-06-05 08:44:24', '2025-06-05 08:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `pilihan_sehat`
--

CREATE TABLE `pilihan_sehat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `gambar_path` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pilihan_sehat`
--

INSERT INTO `pilihan_sehat` (`id`, `judul`, `kategori`, `gambar_path`, `nama`, `deskripsi`, `urutan`, `aktif`, `created_at`, `updated_at`) VALUES
(37, 'Semangka', 'Buah', 'images/1749386430.png', 'Semangka', 'Semangka mengandung banyak air dan rendah gula. Dalam 100 gram semangka, terdapat sekitar 6 gram gula. Selain itu, semangka juga kaya akan vitamin A dan C.', 1, 1, '2025-06-08 05:40:30', '2025-06-08 05:40:30'),
(38, 'Alpukat', 'Buah', 'images/1749386456.png', 'Alpukat', 'Satu buah alpukat yang mengandung gula sebanyak 1 gram saja. Selain itu, buah berwarna hijau ini kaya akan lemak sehat yang baik untuk kesehatan.', 2, 1, '2025-06-08 05:40:56', '2025-06-08 05:40:56'),
(39, 'Lemon', 'Buah', 'images/1749386471.png', 'Lemon', 'Lemon adalah salah satu buah terbaik untuk mengatur gula dan kalori. Dalam 100 gram lemon, hanya terdapat sekitar 2,5 gram gula dan sekitar 29 kalori. Lemon juga kaya akan vitamin C, serat, dan memiliki efek menstabilkan gula darah.', 1, 1, '2025-06-08 05:41:11', '2025-06-08 05:41:11'),
(40, 'Bayam', 'Sayur', 'images/1749386529.png', 'Bayam', 'Kaya akan serat dan rendah karbohidrat, membantu menstabilkan gula darah. Hanya 23 kalori per 100 gram dan hampir tidak mengandung gula.', 1, 1, '2025-06-08 05:42:09', '2025-06-08 05:42:09'),
(41, 'Brokoli', 'Sayur', 'images/1749386550.png', 'Brokoli', 'Mengandung sulforaphane, senyawa yang dapat meningkatkan sensitivitas insulin. Hanya 35 kalori per 100 gram dan 1,7 gram gula.', 2, 1, '2025-06-08 05:42:30', '2025-06-08 05:42:30'),
(42, 'Wortel', 'Sayur', 'images/1749386569.png', 'Wortel', 'Serat dalam wortel membantu memperlambat penyerapan gula dalam darah, sehingga mencegah lonjakan gula darah yang berbahaya bagi penderita diabetes atau mereka yang ingin mengontrol kalori.', 3, 1, '2025-06-08 05:42:49', '2025-06-08 05:42:49'),
(43, 'Ikan Salmon', 'Protein', 'images/1749386633.png', 'Ikan Salmon', 'Kaya akan asam lemak omega-3, yang terbukti membantu meningkatkan sensitivitas insulin dan mengurangi peradangan pada penderita diabetes. inggi protein & rendah karbohidrat, sehingga tidak menyebabkan lonjakan gula darah.', 1, 1, '2025-06-08 05:43:53', '2025-06-08 05:43:53'),
(44, 'Tempe', 'Protein', 'images/1749386652.png', 'Tempe', 'Mengandung prebiotik alami karena hasil fermentasi, yang dapat meningkatkan kesehatan usus dan memperbaiki metabolisme glukosa.', 2, 1, '2025-06-08 05:44:12', '2025-06-08 05:44:12'),
(45, 'Telur', 'Protein', 'images/1749386665.png', 'Telur', 'Mengandung protein berkualitas tinggi, yang memperlambat penyerapan gula dalam darah. Mengandung kolin dan biotin, yang berperan dalam metabolisme lemak dan karbohidrat, membantu mengontrol gula darah (Journal of Diabetes Research, 2018).', 3, 1, '2025-06-08 05:44:25', '2025-06-08 05:44:34'),
(46, 'Air Putih', 'Minuman', 'images/1749386745.jpg', 'Air Putih', 'Tidak mengandung kalori dan gula sehingga aman bagi penderita diabetes dan untuk diet. Membantu mengeluarkan kelebihan gula darah melalui urine dan menjaga hidrasi tubuh.', 1, 1, '2025-06-08 05:45:45', '2025-06-08 05:45:45'),
(47, 'Teh Hijau', 'Minuman', 'images/1749386761.jpg', 'Teh Hijau', 'Mengandung katekin yang membantu meningkatkan sensitivitas insulin dan mengurangi kadar gula darah. Rendah kalori jika dikonsumsi tanpa gula. Dapat membantu menurunkan berat badan dan mengurangi risiko obesitas yang berhubungan dengan diabetes.', 2, 1, '2025-06-08 05:46:01', '2025-06-08 05:46:28'),
(48, 'Jus Tanpa Gula', 'Minuman', 'images/1749386777.jpg', 'Jus Tanpa Gula', 'Jus dari buah rendah gula seperti lemon, apel hijau, atau stroberi dapat menjadi pilihan sehat. Membantu memenuhi kebutuhan vitamin dan mineral tanpa meningkatkan kadar gula darah secara berlebihan.', 3, 1, '2025-06-08 05:46:17', '2025-06-08 05:46:17'),
(49, 'Nasi Merah', 'Karbohidrat', 'images/1749386954.webp', 'Nasi Merah', 'Mengandung serat tinggi yang membantu memperlambat penyerapan gula dalam darah. Indeks glikemik (GI) lebih rendah dibanding nasi putih, sehingga tidak menyebabkan lonjakan gula darah. Kaya akan vitamin B, magnesium, dan antioksidan yang mendukung metabolisme tubuh.', 1, 1, '2025-06-08 05:49:14', '2025-06-08 05:49:14'),
(50, 'Oatmeal', 'Karbohidrat', 'images/1749386973.jpeg', 'Oatmeal', 'Mengandung beta-glukan, sejenis serat larut yang membantu menurunkan kadar gula darah dan kolesterol.  Memberikan rasa kenyang lebih lama, cocok untuk mengontrol berat badan. Indeks glikemik rendah jika dikonsumsi tanpa tambahan gula.', 2, 1, '2025-06-08 05:49:33', '2025-06-08 05:49:33'),
(51, 'Ubi', 'Karbohidrat', 'images/1749386987.jpeg', 'Ubi', 'Mengandung serat tinggi dan vitamin A, baik untuk kesehatan mata dan sistem kekebalan tubuh. Indeks glikemik lebih rendah dibanding kentang biasa Membantu mengontrol gula darah dengan pelepasan energi yang lebih stabil.', 3, 1, '2025-06-08 05:49:47', '2025-06-08 05:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `umur` int(3) DEFAULT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `riwayat_kesehatan` text DEFAULT NULL,
  `alergi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `umur`, `nomor_telepon`, `pekerjaan`, `riwayat_kesehatan`, `alergi`) VALUES
(1, 'test', 'crystalyt856@gmail.com', NULL, NULL, '$2y$12$wNcrkCaf6sPjayUuPa5kVePHANgKHPELgvX81/um/7knlrBfxzFG2', 'user', 'XUdcrWEqcC', '2025-04-21 20:22:08', '2025-04-21 20:22:08', NULL, NULL, NULL, NULL, NULL),
(2, 'test', 'scfsdf@gmail.com', NULL, NULL, '$2y$12$sK/Ikjx8l.2ofc9KeJT20O8Ew7aUnpX97uHTZ6XcBzFqdBYtywMdS', 'user', 'DzBve1U5Yh', '2025-04-24 10:06:02', '2025-04-24 10:06:02', NULL, NULL, NULL, NULL, NULL),
(3, 'test', 'sdfsdf@gmail.com', NULL, NULL, '$2y$10$bIt3dLXd9YJAZ4eayrK4VeQ8TT0pqlbfgUasHK7sDLlw4mH1E5kQO', 'user', 'dhM4iFzPEt', '2025-04-29 14:55:35', '2025-04-29 14:55:35', NULL, NULL, NULL, NULL, NULL),
(4, 'raysa rafii', 'dewaraysa35@gmail.com', '101360439727054150482', NULL, '$2y$10$8fsHeuJ8RU.eLsdd0LShDecMjakV9zyC4n8MqqLOA9Ff.iXQrt2HS', 'dokter_pencegahan', 'GxWtkDeS6JhrG2JRnLiXSX8fkdKF7SVmqy0bf7LiUakswPmAOjzQja6seiko', '2025-04-29 14:58:50', '2025-05-22 23:24:40', 20, '081334536478', 'Dokter', 'test', 'testd'),
(6, 'dfdfcv', 'dfgaa@gmail.com', NULL, NULL, '$2y$10$/TPzV5N9QyzDnYsQ12/jSuiuZbEcBuFF/Ppgc7LAor7LZsjZPM0DK', 'user', '6O0Tr9SPFT', '2025-05-01 20:16:04', '2025-05-01 20:16:04', NULL, NULL, NULL, NULL, NULL),
(9, 'sdgdfgdfg', 'sdfsdf232@gmail.com', NULL, NULL, '$2y$10$4GnDyXgC2MAql19CImtd5OBGX6EzxXSZSqXUpiR9z9AworY52blqm', 'admin', '1QDz3hyK7WRvk85d2azx07SPUpBRFim4liD68gsU9F1SVttA1ebfCZqO2Nf3', '2025-05-08 12:51:40', '2025-05-08 13:09:11', 20, '0813213142342', 'Mahasiswa', '-', '-'),
(10, 'Sazkia', 'sazkia@gmail.com', NULL, NULL, '$2y$10$WJWjJ2pUkGvZrrY.T8b6MOShp3n.EGtmhOPrGhbQEA4DlJEBdwaoS', 'admin', '9bPTROxQVjyYU13ThIrXiYr1EEJfjQhWmLOa1IyGOZeunaZoJBNuCH9e9ODh', '2025-05-08 23:59:44', '2025-05-18 08:50:35', 19, '081334536478', 'Mahasiswa', '-', '-'),
(11, 'Luceeal', 'sahidkaswawii26@gmail.com', '106675211844942621617', NULL, NULL, 'user', NULL, '2025-05-15 04:25:17', '2025-05-15 04:25:17', NULL, NULL, NULL, NULL, NULL),
(12, 'muhammad raysa', 'muhammadraysa74@gmail.com', '108997982119265019484', NULL, NULL, 'admin', NULL, '2025-05-19 00:08:00', '2025-05-19 00:08:00', NULL, NULL, NULL, NULL, NULL),
(14, 'test', 'guje2341@gmail.com', NULL, NULL, '$2y$10$bXz/6ZYvQl6gS//0gK/eaewZ0zcZJe8udAxDdXEJVASkoJYRk0ibm', 'user', 'kNKbrB3GHxYVCVX7zke1zqr69WJErWu5E6SRulo9KCgWD2AQdA9kiwdBYB5h', '2025-06-05 08:29:51', '2025-06-05 08:29:51', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asupan`
--
ALTER TABLE `asupan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asupans_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_from_id_foreign` (`from_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `email` (`email`);

--
-- Indexes for table `password_reset_otps`
--
ALTER TABLE `password_reset_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pilihan_sehat`
--
ALTER TABLE `pilihan_sehat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asupan`
--
ALTER TABLE `asupan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `password_reset_otps`
--
ALTER TABLE `password_reset_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pilihan_sehat`
--
ALTER TABLE `pilihan_sehat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asupan`
--
ALTER TABLE `asupan`
  ADD CONSTRAINT `asupans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
