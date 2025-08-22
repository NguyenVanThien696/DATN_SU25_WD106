-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2025 at 04:21 PM
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
-- Database: `datn5`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `position` enum('homepage','category','product','custom') NOT NULL DEFAULT 'homepage',
  `status` enum('hidden','visible') NOT NULL DEFAULT 'visible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `description`, `image`, `link`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Thời Trang Việt', 'Lấy cảm hứng từ những cảm xúc trong tâm hồn người phụ nữ – lúc dịu dàng như nốt trầm, khi rực rỡ như nốt cao – Charming Notes là bản hòa tấu, nơi mỗi thiết kế là một thanh âm riêng, khắc họa vẻ đẹp của từng cung bậc xúc cảm khác nhau.', 'banners/lsBu8hY6FzYXYxssdcRMUrJ5KaK1PUvf6onvKdj4.png', 'http://localhost/phpmyadmin/index.php?route=/sql&db=test1&table=banners&pos=0', 'homepage', 'visible', '2025-07-16 10:51:28', '2025-07-16 13:59:27'),
(2, 'Phong Cách Hiện Đại', 'Lấy cảm hứng từ những cảm xúc trong tâm hồn người phụ nữ – lúc dịu dàng như nốt trầm, khi rực rỡ như nốt cao – Charming Notes là bản hòa tấu, nơi mỗi thiết kế là một thanh âm riêng, khắc họa vẻ đẹp của từng cung bậc xúc cảm khác nhau.', 'banners/xwozq2zz28Yar8tfQQ6LnhvuCdlof2IdFlzWRJE8.jpg', 'http://localhost/phpmyadmin/index.php?route=/sql&db=test1&table=banners&pos=0', 'homepage', 'visible', '2025-07-16 10:58:43', '2025-08-01 15:55:29'),
(7, 'Phong Cách Hiện Đại', 'Lấy cảm hứng từ những cảm xúc trong tâm hồn người phụ nữ – lúc dịu dàng như nốt trầm, khi rực rỡ như nốt cao – Charming Notes là bản hòa tấu, nơi mỗi thiết kế là một thanh âm riêng, khắc họa vẻ đẹp của từng cung bậc xúc cảm khác nhau.', 'banners/eZx9beUYmqIn7zBj5nPiaqiCnJLJbtSLer0mPoq8.jpg', 'https://github.com/NguyenVanThien696/DATN_SU25_WD106', 'homepage', 'visible', '2025-07-16 11:51:49', '2025-08-01 15:50:42'),
(11, 'phong cách thời trang', 'hàng chính hãng', 'banners/FAE6LQxD3FHkFGaX9kKRxs9swc102DeB2VvXAILo.png', NULL, 'homepage', 'visible', '2025-08-01 15:58:22', '2025-08-01 15:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Canifa', '', NULL, NULL),
(2, 'YODY', '', NULL, NULL),
(3, 'Owen', NULL, NULL, NULL),
(4, 'IVY Moda', NULL, NULL, NULL),
(5, 'Tingoan', NULL, NULL, NULL),
(6, 'Routine', NULL, NULL, NULL);

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(16, 10, '2025-08-02 00:38:25', '2025-08-02 00:38:25'),
(27, 11, '2025-08-06 17:07:46', '2025-08-06 17:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_variant_id`, `quantity`, `created_at`, `updated_at`) VALUES
(66, 27, 473, 5, '2025-08-06 17:46:37', '2025-08-06 17:53:30'),
(70, 27, 456, 1, '2025-08-06 18:46:58', '2025-08-06 18:46:58'),
(78, 16, 473, 1, '2025-08-08 14:00:16', '2025-08-08 14:00:16'),
(90, 16, 390, 1, '2025-08-08 14:59:17', '2025-08-08 14:59:17');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Áo Nam', NULL, '2025-07-14 14:49:13'),
(2, 'Quần Nam', NULL, '2025-07-14 14:49:24'),
(3, 'Áo Nữ', NULL, '2025-07-14 14:49:32'),
(4, 'Quần Nữ', NULL, '2025-07-14 14:49:41'),
(5, 'Váy', '2025-07-14 14:49:56', '2025-07-14 14:49:56'),
(6, 'Nam', '2025-07-15 10:23:01', '2025-07-15 10:23:01'),
(7, 'Nữ', '2025-07-15 10:23:05', '2025-07-15 10:23:05'),
(8, 'Áo Phông', '2025-07-15 10:24:23', '2025-07-15 10:25:13'),
(9, 'Áo Hoodie', '2025-07-15 10:44:48', '2025-07-15 10:44:48'),
(10, 'Áo Len', '2025-07-15 10:53:22', '2025-07-15 10:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Đen', '#000000', NULL, NULL),
(2, 'Xanh', '#0000FF', NULL, NULL),
(3, 'Trắng', '#FFFFFF', NULL, NULL),
(4, 'Đỏ', '#FF0000', NULL, NULL),
(5, 'Be', '#FFCC66', NULL, NULL),
(6, 'Nâu', '#8B4513', NULL, NULL),
(7, 'Vàng', '#FFFF00', NULL, NULL),
(8, 'Xám', NULL, '2025-07-15 10:40:00', '2025-07-15 10:40:00'),
(9, 'Tím', NULL, '2025-07-15 10:53:40', '2025-07-15 10:53:40'),
(10, 'Kem', NULL, '2025-07-15 10:58:06', '2025-07-15 10:58:06'),
(11, 'Hồng', NULL, '2025-07-15 11:02:15', '2025-07-15 11:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `discount_percent` int(11) DEFAULT NULL,
  `max_discount_amount` int(11) DEFAULT NULL,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `discount_amount` int(11) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','expired','used_up') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_percent`, `max_discount_amount`, `min_order_amount`, `discount_amount`, `expires_at`, `start_at`, `end_at`, `usage_limit`, `used`, `status`, `created_at`, `updated_at`) VALUES
(21, 'THIENDEPTRAI02', 'percent', 100, 30000, 30000.00, NULL, NULL, '2025-07-15 21:12:00', '2025-08-09 21:12:00', 10, 0, 'active', '2025-07-15 14:12:28', '2025-08-02 00:55:42'),
(22, 'HAIDEPTRAI01', 'percent', 18, 30000, 400000.00, NULL, NULL, '2025-07-15 21:38:00', '2025-08-09 21:38:00', 10, 1, 'active', '2025-07-15 14:38:50', '2025-08-06 17:07:30'),
(24, 'HAIDEPTRAI011', 'amount', NULL, NULL, NULL, 1000000, NULL, '2025-07-15 22:04:00', '2025-08-09 22:04:00', 1, 1, 'used_up', '2025-07-15 15:05:03', '2025-08-02 00:51:43'),
(25, 'duong', 'amount', NULL, NULL, 500000.00, 100000, NULL, '2025-08-02 01:05:00', '2025-08-09 01:05:00', 3, 2, 'active', '2025-08-01 18:05:16', '2025-08-02 00:53:23'),
(26, 'mmm', 'percent', 100, 50000, 50000.00, NULL, NULL, '2025-08-02 08:54:00', '2025-08-09 08:54:00', 1, 0, 'active', '2025-08-02 01:54:55', '2025-08-06 17:06:26');

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
(4, '2025_06_01_092839_create_categories_table', 1),
(5, '2025_06_01_092840_create_brands_table', 1),
(6, '2025_06_01_092842_create_products', 1),
(7, '2025_06_01_093227_create_colors_table', 1),
(8, '2025_06_01_093256_create_sizes_table', 1),
(9, '2025_06_01_093346_create_product_variants_table', 1),
(10, '2025_06_01_093506_create_carts_table', 1),
(11, '2025_06_01_093525_create_cart_items_table', 1),
(12, '2025_06_01_093625_create_orders_table', 1),
(13, '2025_06_01_093640_create_order_items_table', 1),
(14, '2025_06_01_093746_create_product_reviews_table', 1),
(15, '2025_06_01_093918_create_coupons_table', 1),
(16, '2025_06_01_094037_create_user_coupons_table', 1),
(17, '2025_06_01_094439_update_users_table_add_fields', 1),
(18, '2025_06_01_113955_create_banners_table', 1),
(19, '2025_06_04_105646_add_deleted_at_to_users_table', 2),
(20, '2025_06_05_163911_add_variant_id_to_products_table', 2),
(21, '2025_06_05_165734_remove_quantity_from_products_table', 3),
(22, '2025_06_05_184624_remove_variant_id_from_products_table', 4),
(23, '2025_06_06_140040_add_image_to_product_variants_table', 5),
(24, '2025_06_06_121730_add_role_to_users_table', 6),
(25, '2025_06_04_171818_add_role_to_users_table', 7),
(26, '2025_06_08_052443_add_code_to_colors_table', 7),
(27, '2025_06_11_081403_create_tags_table', 7),
(28, '2025_06_11_081438_add_tag_id_to_products_table', 8),
(29, '2025_06_11_083833_drop_tags_and_tag_id', 8),
(30, '2025_06_11_083942_create_tags_table', 9),
(31, '2025_06_11_084112_add_tag_id_to_products', 9),
(32, '2025_06_14_141244_update_orders_add_payment_fields_and_modify_foreign_key', 9),
(33, '2025_06_14_141434_update_order_items_add_note_and_modify_foreign_key', 9),
(34, '2025_06_15_083702_create_shipping_addresses_table', 10),
(35, '2025_06_18_155834_add_shipping_address_id_to_orders_table', 11),
(36, '2025_07_01_002654_create_pending_orders_table', 12),
(37, '2025_07_01_014144_update_order_status_enum', 13),
(38, '2025_07_01_014541_update_payment_status_enum_on_orders', 14),
(39, '2025_07_01_204856_add_shipping_fee_to_orders_table', 15),
(40, '2025_07_01_215204_add_discount_to_orders_table', 15),
(41, '2025_07_02_020459_add_fields_to_coupons_table', 16),
(42, '2025_07_02_024327_update_user_coupons_foreign_keys', 17),
(43, '2025_07_03_034913_add_discount_and_shipping_fee_to_pending_orders_table', 18),
(44, '2025_07_03_042840_add_order_code_to_orders_table', 19),
(45, '2025_07_03_043730_add_order_code_to_pending_orders_table', 20),
(46, '2025_07_05_215520_add_order_item_id_to_product_reviews_table', 21),
(47, '2025_07_09_071818_alter_orders_add_enum_values', 22),
(48, '2025_07_09_082455_alter_users_role_add_staff_enum', 23),
(49, '2025_07_09_103126_update_coupons_add_more_fields', 24),
(50, '2025_07_10_222930_add_max_discount_amount_to_coupons_table', 25),
(51, '2025_07_10_225825_add_coupon_id_to_orders_table', 26),
(52, '2025_07_11_123802_update_status_enum_in_orders_table', 27),
(53, '2025_07_15_214927_add_min_order_amount_to_coupons_table', 28),
(54, '2025_07_15_223414_update_coupon_status_enum', 29),
(55, '2025_07_16_161537_add_stock_to_products_table', 30),
(56, '2025_07_16_174234_change_status_to_enum_in_banners_table', 31),
(57, '2025_07_16_184958_add_description_to_banners_table', 32),
(58, '2025_07_28_181457_add_is_seen_by_admin_to_orders_table', 33),
(59, '2025_08_02_234843_add_product_name_and_variant_name_to_order_items_table', 34),
(60, '2025_08_03_000718_add_customer_info_to_orders_table', 34),
(61, '2025_08_04_221638_create_wallets_table', 34),
(62, '2025_08_04_221715_create_wallet_transactions_table', 34),
(63, '2025_08_04_221736_create_refund_requests_table', 34),
(64, '2025_08_04_221810_create_bank_accounts_table', 34),
(65, '2025_08_04_222710_add_original_bank_fields_to_refund_requests_table', 34),
(66, '2025_08_04_233356_add_user_id_to_wallet_transactions_table', 34),
(67, '2025_08_05_015524_add_customer_info_to_pending_orders_table', 34),
(68, '2025_08_06_003551_alter_amount_column_in_wallet_transactions_table', 34),
(69, '2025_08_06_003731_alter_type_column_in_wallet_transactions_table', 34),
(70, '2025_08_17_220028_update_status_enum_in_orders_table', 35);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) NOT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_price` decimal(10,0) NOT NULL DEFAULT 0,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','confirmed','processing','shipping','delivered','completed','cancelled','cancelled_paid','refunded','delivery_failed','refund_pending','refund_rejected','refund_approved') NOT NULL,
  `payment_method` enum('cod','bank','momo','vnpay') NOT NULL DEFAULT 'cod',
  `payment_status` enum('unpaid','paid','failed','refunded') NOT NULL DEFAULT 'unpaid',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_seen_by_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `shipping_address_id`, `total_price`, `shipping_fee`, `discount`, `status`, `payment_method`, `payment_status`, `note`, `created_at`, `updated_at`, `coupon_id`, `is_seen_by_admin`) VALUES
(29, 'DH212615072025CMQK', 3, '', '', NULL, '', NULL, 1268000, 0.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-15 14:26:17', '2025-07-15 14:32:04', NULL, 0),
(30, 'DH223015072025JWUC', 3, '', '', NULL, '', NULL, 0, 0.00, 818500, 'cancelled', 'cod', 'unpaid', NULL, '2025-07-15 15:30:29', '2025-07-15 15:39:40', 24, 0),
(31, 'DH22481507202573O9', 3, '', '', NULL, '', NULL, 30000, 30000.00, 369000, 'cancelled', 'cod', 'unpaid', NULL, '2025-07-15 15:48:34', '2025-07-15 15:48:44', 24, 0),
(32, 'DH230115072025KAKN', 3, '', '', NULL, '', NULL, 399000, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-15 16:01:56', '2025-07-15 16:04:21', NULL, 0),
(33, 'DH171416072025JT3L', 1, '', '', NULL, '', NULL, 479500, 30000.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-07-16 10:14:31', '2025-08-01 15:44:28', NULL, 1),
(34, 'DH234718072025CCJK', 10, '', '', NULL, '', NULL, 30062, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-18 16:47:53', '2025-07-18 16:48:45', NULL, 0),
(35, 'DH224221072025WASB', 10, '', '', NULL, '', NULL, 2444500, 0.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-21 15:42:44', '2025-07-21 15:43:20', NULL, 0),
(36, 'DH2259210720253RMB', 10, '', '', NULL, '', NULL, 479500, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-21 15:59:06', '2025-07-21 15:59:23', NULL, 0),
(37, 'DH144526072025BXJA', 10, '', '', NULL, '', NULL, 129500, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-26 07:45:26', '2025-07-26 07:47:02', NULL, 0),
(38, 'DH010502082025QNHT', 10, '', '', NULL, '', NULL, 3793000, 0.00, 100000, 'completed', 'vnpay', 'paid', NULL, '2025-08-01 18:05:57', '2025-08-01 18:06:55', NULL, 0),
(39, 'DH021302082025AVFG', 10, '', '', NULL, '', NULL, 107000, 0.00, 1000000, 'completed', 'cod', 'paid', NULL, '2025-08-01 19:13:21', '2025-08-01 19:26:50', 24, 0),
(40, 'DH021502082025TSHR', 10, '', '', NULL, '', NULL, 428000, 30000.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-01 19:15:59', '2025-08-01 22:59:18', NULL, 1),
(41, 'DH021602082025IAYH', 10, '', '', NULL, '', NULL, 529000, 30000.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-01 19:16:48', '2025-08-01 22:59:18', NULL, 1),
(42, 'DH021902082025KDNX', 11, '', '', NULL, '', NULL, 738000, 0.00, 0, 'completed', 'cod', 'paid', NULL, '2025-08-01 19:19:18', '2025-08-01 19:20:11', NULL, 0),
(43, 'DH022202082025SDFU', 11, '', '', NULL, '', NULL, 529000, 30000.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-01 19:22:20', '2025-08-01 22:59:18', NULL, 1),
(44, 'DH022302082025FB1K', 11, '', '', NULL, '', NULL, 229000, 30000.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-01 19:23:44', '2025-08-01 22:59:18', NULL, 1),
(45, 'DH022502082025QRLM', 10, '', '', NULL, '', NULL, 428000, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-08-01 19:25:16', '2025-08-01 19:32:31', NULL, 0),
(46, 'DH023302082025QYIB', 10, '', '', NULL, '', NULL, 229500, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-08-01 19:33:36', '2025-08-01 19:34:06', NULL, 0),
(47, 'DH055502082025MZUJ', 10, '', '', NULL, '', NULL, 747000, 0.00, 0, 'completed', 'vnpay', 'paid', NULL, '2025-08-01 22:56:50', '2025-08-01 22:58:12', NULL, 0),
(48, 'DH075202082025GJGO', 11, '', '', NULL, '', NULL, 638000, 0.00, 100000, 'completed', 'vnpay', 'paid', NULL, '2025-08-02 00:53:23', '2025-08-02 00:54:16', NULL, 0),
(49, 'DH100802082025ORYE', 11, '', '', NULL, '', NULL, 1898000, 0.00, 0, 'delivered', 'cod', 'unpaid', NULL, '2025-08-02 03:08:46', '2025-08-02 03:09:04', NULL, 0),
(50, 'DH235404082025A4PE', 11, '', '', NULL, '', NULL, 2545000, 0.00, 50000, 'cancelled', 'cod', 'unpaid', NULL, '2025-08-04 16:54:00', '2025-08-06 16:44:53', 26, 1),
(55, 'DH230106082025ZOA0', 11, '', '', NULL, '', NULL, 648000, 0.00, 0, 'cancelled', 'cod', 'unpaid', NULL, '2025-08-06 16:01:38', '2025-08-06 16:44:49', NULL, 0),
(56, 'DH234906082025JJFD', 11, '', '', NULL, '', NULL, 848000, 0.00, 0, 'cancelled', 'cod', 'unpaid', NULL, '2025-08-06 16:49:14', '2025-08-06 16:52:19', NULL, 0),
(57, 'DH235606082025NVQQ', 11, '', '', NULL, '', NULL, 529000, 30000.00, 0, 'cancelled', 'cod', 'unpaid', NULL, '2025-08-06 16:56:23', '2025-08-06 16:58:44', NULL, 0),
(58, 'DH235906082025LDBR', 11, '', '', NULL, '', NULL, 998000, 0.00, 0, 'delivered', 'cod', 'unpaid', NULL, '2025-08-06 16:59:12', '2025-08-06 16:59:55', NULL, 0),
(59, 'DH000107082025LJIP', 11, '', '', NULL, '', NULL, 848000, 0.00, 0, 'pending', 'vnpay', 'paid', NULL, '2025-08-06 17:01:42', '2025-08-08 10:37:57', NULL, 1),
(60, 'DH000207082025QGGV', 11, '', '', NULL, '', NULL, 847000, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-06 17:02:47', '2025-08-08 10:37:57', NULL, 1),
(62, 'DH000707082025KD8R', 11, '', '', NULL, '', NULL, 818000, 0.00, 30000, 'pending', 'cod', 'unpaid', NULL, '2025-08-06 17:07:30', '2025-08-08 10:37:57', 22, 1),
(65, 'DH001007082025YWOK', 11, '', '', NULL, '', NULL, 428000, 30000.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-06 17:10:47', '2025-08-08 10:37:57', NULL, 1),
(66, 'DH004207082025BSC8', 11, '', '', NULL, '', NULL, 4592000, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-06 17:42:11', '2025-08-08 10:37:57', NULL, 1),
(68, 'DH191308082025XOCB', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 3140000, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-08 12:13:33', '2025-08-08 13:37:23', NULL, 1),
(69, 'DH210108082025NUUL', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 648000, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-08 14:01:00', '2025-08-19 13:17:15', NULL, 1),
(70, 'DH211408082025CFZN', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 648000, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-08 14:14:06', '2025-08-19 13:17:15', NULL, 1),
(71, 'DH211508082025GBV8', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 648000, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-08 14:15:21', '2025-08-19 13:17:15', NULL, 1),
(72, 'DH211908082025Q5Y1', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 898000, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-08 14:19:32', '2025-08-19 13:17:15', NULL, 1),
(73, 'DH211908082025WNH4', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 379500, 30000.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-08 14:19:59', '2025-08-19 13:17:15', NULL, 1),
(76, 'DH215808082025JI5A', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 1897500, 0.00, 0, 'pending', 'cod', 'unpaid', NULL, '2025-08-08 14:58:48', '2025-08-19 13:17:15', NULL, 1),
(83, 'DH010009082025SUXH', 10, 'duong', '0349043276', 'ht232425duong@gmail.com', '29 abc', NULL, 278500, 30000.00, 0, 'pending', 'vnpay', 'paid', NULL, '2025-08-08 18:01:14', '2025-08-19 13:17:15', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `variant_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_variant_id`, `product_name`, `variant_name`, `quantity`, `price`, `note`, `created_at`, `updated_at`) VALUES
(37, 29, 195, NULL, NULL, 2, 449500.00, NULL, '2025-07-15 14:26:17', '2025-07-15 14:26:17'),
(38, 29, 187, NULL, NULL, 1, 369000.00, NULL, '2025-07-15 14:26:17', '2025-07-15 14:26:17'),
(39, 30, 186, NULL, NULL, 1, 369000.00, NULL, '2025-07-15 15:30:29', '2025-07-15 15:30:29'),
(40, 30, 198, NULL, NULL, 1, 449500.00, NULL, '2025-07-15 15:30:29', '2025-07-15 15:30:29'),
(41, 31, 191, NULL, NULL, 1, 369000.00, NULL, '2025-07-15 15:48:34', '2025-07-15 15:48:34'),
(42, 32, 183, NULL, NULL, 1, 369000.00, NULL, '2025-07-15 16:01:56', '2025-07-15 16:01:56'),
(43, 33, 195, NULL, NULL, 1, 449500.00, NULL, '2025-07-16 10:14:31', '2025-07-16 10:14:31'),
(44, 34, 204, NULL, NULL, 2, 31.00, NULL, '2025-07-18 16:47:53', '2025-07-18 16:47:53'),
(45, 35, 182, NULL, NULL, 5, 399000.00, NULL, '2025-07-21 15:42:44', '2025-07-21 15:42:44'),
(46, 35, 199, NULL, NULL, 1, 449500.00, NULL, '2025-07-21 15:42:44', '2025-07-21 15:42:44'),
(47, 36, 199, NULL, NULL, 1, 449500.00, NULL, '2025-07-21 15:59:06', '2025-07-21 15:59:06'),
(48, 37, 302, NULL, NULL, 1, 99500.00, NULL, '2025-07-26 07:45:26', '2025-07-26 07:45:26'),
(49, 38, 492, NULL, NULL, 2, 199000.00, NULL, '2025-08-01 18:05:57', '2025-08-01 18:05:57'),
(50, 38, 484, NULL, NULL, 5, 699000.00, NULL, '2025-08-01 18:05:57', '2025-08-01 18:05:57'),
(51, 39, 496, NULL, NULL, 3, 369000.00, NULL, '2025-08-01 19:13:21', '2025-08-01 19:13:21'),
(52, 40, 492, NULL, NULL, 2, 199000.00, NULL, '2025-08-01 19:15:59', '2025-08-01 19:15:59'),
(53, 41, 477, NULL, NULL, 1, 499000.00, NULL, '2025-08-01 19:16:48', '2025-08-01 19:16:48'),
(54, 42, 494, NULL, NULL, 2, 369000.00, NULL, '2025-08-01 19:19:18', '2025-08-01 19:19:18'),
(55, 43, 465, NULL, NULL, 1, 499000.00, NULL, '2025-08-01 19:22:20', '2025-08-01 19:22:20'),
(56, 44, 490, NULL, NULL, 1, 199000.00, NULL, '2025-08-01 19:23:44', '2025-08-01 19:23:44'),
(57, 45, 473, NULL, NULL, 1, 149000.00, NULL, '2025-08-01 19:25:16', '2025-08-01 19:25:16'),
(58, 45, 452, NULL, NULL, 1, 249000.00, NULL, '2025-08-01 19:25:16', '2025-08-01 19:25:16'),
(59, 46, 479, NULL, NULL, 1, 199500.00, NULL, '2025-08-01 19:33:36', '2025-08-01 19:33:36'),
(60, 47, 310, NULL, NULL, 3, 249000.00, NULL, '2025-08-01 22:56:50', '2025-08-01 22:56:50'),
(61, 48, 269, NULL, NULL, 4, 184500.00, NULL, '2025-08-02 00:53:23', '2025-08-02 00:53:23'),
(62, 49, 141, NULL, NULL, 1, 499000.00, NULL, '2025-08-02 03:08:46', '2025-08-02 03:08:46'),
(63, 49, 485, NULL, NULL, 1, 1399000.00, NULL, '2025-08-02 03:08:46', '2025-08-02 03:08:46'),
(64, 50, 482, NULL, NULL, 2, 699000.00, NULL, '2025-08-04 16:54:00', '2025-08-04 16:54:00'),
(65, 50, 352, NULL, NULL, 3, 399000.00, NULL, '2025-08-04 16:54:00', '2025-08-04 16:54:00'),
(70, 55, 472, NULL, NULL, 1, 149000.00, NULL, '2025-08-06 16:01:38', '2025-08-06 16:01:38'),
(71, 55, 477, NULL, NULL, 1, 499000.00, NULL, '2025-08-06 16:01:38', '2025-08-06 16:01:38'),
(72, 56, 483, NULL, NULL, 1, 699000.00, NULL, '2025-08-06 16:49:14', '2025-08-06 16:49:14'),
(73, 56, 470, NULL, NULL, 1, 149000.00, NULL, '2025-08-06 16:49:14', '2025-08-06 16:49:14'),
(74, 57, 465, NULL, NULL, 1, 499000.00, NULL, '2025-08-06 16:56:23', '2025-08-06 16:56:23'),
(75, 57, 471, NULL, NULL, 1, 149000.00, NULL, '2025-08-06 16:56:23', '2025-08-06 16:56:23'),
(76, 58, 465, NULL, NULL, 2, 499000.00, NULL, '2025-08-06 16:59:12', '2025-08-06 16:59:12'),
(77, 59, 473, NULL, NULL, 1, 149000.00, NULL, '2025-08-06 17:01:42', '2025-08-06 17:01:42'),
(78, 59, 484, NULL, NULL, 1, 699000.00, NULL, '2025-08-06 17:01:42', '2025-08-06 17:01:42'),
(79, 60, 469, NULL, NULL, 1, 499000.00, NULL, '2025-08-06 17:02:47', '2025-08-06 17:02:47'),
(80, 60, 472, NULL, NULL, 1, 149000.00, NULL, '2025-08-06 17:02:47', '2025-08-06 17:02:47'),
(81, 60, 459, NULL, NULL, 1, 199000.00, NULL, '2025-08-06 17:02:47', '2025-08-06 17:02:47'),
(84, 62, 484, NULL, NULL, 1, 699000.00, NULL, '2025-08-06 17:07:30', '2025-08-06 17:07:30'),
(85, 62, 472, NULL, NULL, 1, 149000.00, NULL, '2025-08-06 17:07:30', '2025-08-06 17:07:30'),
(90, 65, 470, NULL, NULL, 1, 149000.00, NULL, '2025-08-06 17:10:47', '2025-08-06 17:10:47'),
(91, 65, 450, NULL, NULL, 1, 249000.00, NULL, '2025-08-06 17:10:47', '2025-08-06 17:10:47'),
(92, 66, 482, NULL, NULL, 3, 699000.00, NULL, '2025-08-06 17:42:11', '2025-08-06 17:42:11'),
(93, 66, 477, NULL, NULL, 5, 499000.00, NULL, '2025-08-06 17:42:11', '2025-08-06 17:42:11'),
(96, 68, 280, 'Quần Nỉ Nữ Dáng Suông', 'Xanh / M', 7, 299000.00, NULL, '2025-08-08 12:13:33', '2025-08-08 12:13:33'),
(97, 69, 141, 'Áo Sơ Mi Nam Cộc Tay Knit Phối Nẹp', 'Trắng / Xl', 1, 499000.00, NULL, '2025-08-08 14:01:00', '2025-08-08 14:01:00'),
(98, 70, 477, 'Quần Jean Nữ Ống Suông Nhuộm Màu Túi Ốp', 'Trắng / M', 1, 499000.00, NULL, '2025-08-08 14:14:06', '2025-08-08 14:14:06'),
(99, 71, 477, 'Quần Jean Nữ Ống Suông Nhuộm Màu Túi Ốp', 'Trắng / M', 1, 499000.00, NULL, '2025-08-08 14:15:21', '2025-08-08 14:15:21'),
(100, 72, 483, 'Áo Phao Nam Trần Trám Nẹp Giấu Khoá', 'Nâu / L', 1, 699000.00, NULL, '2025-08-08 14:19:32', '2025-08-08 14:19:32'),
(101, 72, 460, 'Áo Sơ Mi Dài Tay Nam Siêu Co Giãn', 'Hồng / Xl', 1, 199000.00, NULL, '2025-08-08 14:19:32', '2025-08-08 14:19:32'),
(102, 73, 234, 'Váy Maxi Đan Hỗn Hợp', 'Đen / M', 1, 349500.00, NULL, '2025-08-08 14:19:59', '2025-08-08 14:19:59'),
(105, 76, 443, 'Áo Phông Nữ Thun Rib Cổ Tim', 'Trắng / S', 1, 149000.00, NULL, '2025-08-08 14:58:48', '2025-08-08 14:58:48'),
(106, 76, 233, 'Váy Maxi Đan Hỗn Hợp', 'Be / S', 1, 349500.00, NULL, '2025-08-08 14:58:48', '2025-08-08 14:58:48'),
(107, 76, 238, 'Áo Khoác Nam Túi Hộp Da', 'Đen / L', 1, 1399000.00, NULL, '2025-08-08 14:58:48', '2025-08-08 14:58:48'),
(114, 83, 472, 'Áo Phông In Hình', 'Trắng / M', 1, 149000.00, NULL, '2025-08-08 18:01:14', '2025-08-08 18:01:14'),
(115, 83, 302, 'Áo Phông Dáng Croptop In Ngực Áo', 'Đen / M', 1, 99500.00, NULL, '2025-08-08 18:01:14', '2025-08-08 18:01:14');

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
-- Table structure for table `pending_orders`
--

CREATE TABLE `pending_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `txn_ref` varchar(255) NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `note` text DEFAULT NULL,
  `user_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `cart_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `total_price` int(11) NOT NULL,
  `discount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `shipping_fee` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pending_orders`
--

INSERT INTO `pending_orders` (`id`, `txn_ref`, `order_code`, `user_id`, `note`, `user_info`, `cart_items`, `total_price`, `discount`, `shipping_fee`, `created_at`, `updated_at`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`) VALUES
(1, '3_6870d7412db2c', 'DH162011072025VKYJ', 3, NULL, '{\"name\":\"Nguyen Than Thien\",\"email\":\"viettel555111@gmail.com\",\"phone\":\"0987654321\",\"address\":\"L\\u1ee5c Ng\\u1ea1n - B\\u1eafc Giang\"}', '[{\"product_variant_id\":100,\"quantity\":2,\"price\":\"669000.00\"},{\"product_variant_id\":103,\"quantity\":1,\"price\":\"380000.00\"}]', 1678000, 40000, 0, '2025-07-11 09:20:01', '2025-07-11 09:20:01', NULL, NULL, NULL, NULL),
(3, '3_6870d7c885566', 'DH1622110720251Z3A', 3, NULL, '{\"name\":\"Nguyen Than Thien\",\"email\":\"viettel555111@gmail.com\",\"phone\":\"0987654321\",\"address\":\"L\\u1ee5c Ng\\u1ea1n - B\\u1eafc Giang\"}', '[{\"product_variant_id\":99,\"quantity\":1,\"price\":\"399000.00\"}]', 399000, 30000, 30000, '2025-07-11 09:22:16', '2025-07-11 09:22:16', NULL, NULL, NULL, NULL),
(4, '10_6884876b0ed77', 'DH144426072025OZJ7', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"}]', 129500, 0, 30000, '2025-07-26 07:44:43', '2025-07-26 07:44:43', NULL, NULL, NULL, NULL),
(5, '10_68878669be413', 'DH211728072025NZFN', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":492,\"quantity\":1,\"price\":\"199000.00\"}]', 229000, 0, 30000, '2025-07-28 14:17:13', '2025-07-28 14:17:13', NULL, NULL, NULL, NULL),
(10, '10_6896091dc9e36', 'DH21260808202560VT', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":443,\"quantity\":1,\"price\":\"149000.00\"}]', 179000, 0, 30000, '2025-08-08 14:26:37', '2025-08-08 14:26:37', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(11, '10_68960c8ba101c', 'DH2141080820254XSS', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":443,\"quantity\":1,\"price\":\"149000.00\"}]', 179000, 0, 30000, '2025-08-08 14:41:15', '2025-08-08 14:41:15', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(12, '10_689610d5620a0', 'DH21590808202503TO', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 493000, 0, 30000, '2025-08-08 14:59:33', '2025-08-08 14:59:33', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(13, '10_689610eaea70d', 'DH215908082025J71M', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 493000, 0, 30000, '2025-08-08 14:59:54', '2025-08-08 14:59:54', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(14, '10_68962b8c23bb3', 'DH235308082025FB5E', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 493000, 0, 30000, '2025-08-08 16:53:32', '2025-08-08 16:53:32', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(15, '10_68962c08f079a', 'DH2355080820251SOK', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 278500, 0, 30000, '2025-08-08 16:55:36', '2025-08-08 16:55:36', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(16, '10_68962e3f36986', 'DH000509082025NXYH', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 493000, 0, 30000, '2025-08-08 17:05:03', '2025-08-08 17:05:03', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(17, '10_68962f1856acf', 'DH0008090820254HMG', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 278500, 0, 30000, '2025-08-08 17:08:40', '2025-08-08 17:08:40', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(18, '10_689631c5bc330', 'DH0020090820251ONW', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 278500, 0, 30000, '2025-08-08 17:20:05', '2025-08-08 17:20:05', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(19, '10_68963253c1eac', 'DH002209082025TTNA', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 278500, 0, 30000, '2025-08-08 17:22:27', '2025-08-08 17:22:27', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(20, '10_689632926e41e', 'DH0023090820258V8Z', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 278500, 0, 30000, '2025-08-08 17:23:30', '2025-08-08 17:23:30', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc'),
(21, '10_68963487578ec', 'DH003109082025NGH6', 10, NULL, '{\"name\":\"duong\",\"email\":\"ht232425duong@gmail.com\",\"phone\":\"0349043276\",\"address\":\"29 abc\"}', '[{\"product_variant_id\":473,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":472,\"quantity\":1,\"price\":\"149000.00\"},{\"product_variant_id\":302,\"quantity\":1,\"price\":\"99500.00\"},{\"product_variant_id\":390,\"quantity\":1,\"price\":\"214500.00\"}]', 278500, 0, 30000, '2025-08-08 17:31:51', '2025-08-08 17:31:51', 'duong', 'ht232425duong@gmail.com', '0349043276', '29 abc');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tag_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `category_id`, `brand_id`, `created_at`, `updated_at`, `tag_id`) VALUES
(26, 'Áo Phông Yoguu Oversize Mickey Shreddin', 'CHẤT LIỆU:\r\n\r\n  Cotton BH-S008 : Đứng form, thấm hút\r\n\r\nFORM DÁNG :\r\n\r\n Oversize rộng rãi, độ dài vừa phải, cá tính, phù hợp cho cả nam và nữ\r\n\r\nĐIỂM NHẤN SẢN PHẨM \r\n\r\n  Phần hình in Mickey Mouse bắt mắt, cá tính, trẻ trung.\r\n\r\nKẾT HỢP VỚI:\r\n\r\n  Dễ dàng phối đồ, phù hợp với hầu hết các loại form quần từ short đến quần dài : Baggy, Straight, Wide leg, Skinny, chân váy mini skirt, midi skirt... Với đa dạng chất liệu như Jeans, gió, kaki...  Giày sneaker, casual, boots cùng với tất cao cổ.', 399000.00, NULL, 'products/owD09iN1AKgIdvCuCMvsb60qdalq5rBbC4iUoRAX.png', 8, 2, '2025-07-15 10:15:48', '2025-07-15 10:24:43', 1),
(27, 'Áo Phông Yoguu Mickey Oh Boy Boards', 'Vải chính 100% Cotton: Mang lại cảm giác mềm mại, thoáng mát, phù hợp với mọi loại da, giúp người mặc cảm thấy thoải mái suốt cả ngày.\r\n\r\nThấm hút mồ hôi: Chất liệu cotton giúp thấm hút mồ hôi hiệu quả, giữ cơ thể khô thoáng trong mọi điều kiện thời tiết.', 399000.00, NULL, 'products/dyKoXknrvtblTClj5d6RCxyVvWjYjlt0C37et3HT.png', 8, 2, '2025-07-15 10:21:37', '2025-07-15 10:24:36', 1),
(28, 'Áo Sơ Mi Nam Cộc Tay Túi 3M', 'Siêu mướt và thoáng khí : Vải lụa nến mang đến cảm giác mềm mại, nhẹ nhàng và thông thoáng khi mặc.\r\n\r\nThấm hút tốt : Hỗ trợ hút ẩm nhanh, giúp da luôn khô ráo và thoải mái.\r\n\r\nBắt nhiệt lạnh nhanh, tạo cảm giác mát mẻ: Giúp cơ thể luôn dễ chịu, phù hợp với thời tiết nóng.', 299000.00, NULL, 'products/qj6rv2n8NG4OEV3RHnNC8UdLCCv1lVx3bEgOGvvI.png', 1, 2, '2025-07-15 10:29:46', '2025-07-15 10:29:46', 1),
(29, 'Áo Sơ Mi Nam Cộc Tay Knit Phối Nẹp', 'Áo sơ mi nam cộc tay Knit\r\n\r\nThiết kế cơ bản nẹp giấu cúc có đường phối lé tinh tế, trẻ trung\r\n\r\nPhom dáng hơi ôm phù hợp với khách hàng trẻ tuổ từ 25-35 mặc đi làm, đi chơi', 499000.00, NULL, 'products/hMbZa8UOg3y3HsBsq30iovsmoLpv46vzgf1syNic.png', 1, 2, '2025-07-15 10:34:07', '2025-07-15 10:34:07', 1),
(30, 'Áo Sơ Mi Nam Cộc Tay Nẹp Kiểu Họa Tiết Kẻ Sọc', 'Áo sơ mi nam dài tay Knit\r\n\r\nThiết kế nẹp kiểu mới lạ\r\n\r\nPhom dáng suông dễ mặc\r\n\r\nChất liệu Knit họa tiết kẻ sọc nhỏ sang trọng\r\n\r\nSản phẩm phù hợp với khách hàng trung tuổi từ 35-45 mặc đi làm, đi chơi', 499000.00, NULL, 'products/058aYVq37xArecdxuyHVPmNYET1LnkJzG5g96Vsg.png', 1, 2, '2025-07-15 10:37:39', '2025-07-15 10:37:39', 2),
(31, 'Áo Hoodie Yoguu Tay Tháo Rời', 'Một sản phẩm phá cách mới ra mắt: Áo hoodie unisex có tay tháo rời. Thiết kế trẻ trung, linh hoạt, đa dạng cách sử dụng vô cùng thú vị. Chất vải dày dặn, đanh chắc, không bai dão và ít xù đem lại độ bền bỉ, ấm áp cho chiếc áo này.', 699000.00, NULL, 'products/BPc5tgfLYgiben8xCKBRqgOllc7sSHHFIIHkYnFE.png', 9, 2, '2025-07-15 10:44:28', '2025-07-15 10:44:57', 2),
(32, 'Áo Yoguu Sweater In Chữ', 'Áo sweater ấm áp, thoải mái cho mùa đông lạnh giá này. Sản phẩm có kiểu dệt frency terry hay còn gọi là da cá giúp mặt phải mềm mịn, đanh chắc, mặt trái là những mắt dệt xếp chồng lên nhau đều đặn. Trên nền vải nỉ chất lượng, chiếc áo này giúp bạn giữ ấm tốt, thoải mái nhờ form rộng và định hình tốt, hạn chế nhăn nhàu/ xù lông.', 249500.00, NULL, 'products/Fp1uvsQRTTwr19ceuf5UIyqpEhfzPQcMdxBxTata.png', 9, 2, '2025-07-15 10:49:04', '2025-07-15 10:49:04', 1),
(33, 'Áo Sơ Mi Dài Tay Nữ Ren Thêu Dáng Rộng', 'Bộ sưu tập Peaceful Summer 2025 - YODY mang đến vẻ đẹp thanh lịch, sự thoải mái và phong cách tinh tế. Với gam màu dịu nhẹ và chất liệu cao cấp, bộ sưu tập gợi lên cảm giác bình yên, tươi mới, như một sự kết nối hài hòa với thiên nhiên.\r\n\r\nƯu điểm chất liệu:\r\n\r\nChất liệu tự nhiên: 100% Cotton, an toàn và thân thiện với làn da.\r\n\r\nThoáng mát & thấm hút: Hấp thụ mồ hôi tốt, mang lại cảm giác khô ráo, dễ chịu.\r\n\r\nPhom dáng năng động: Giữ form khỏe khoắn, phù hợp với phong cách trẻ trung.\r\n\r\nĐặc điểm thiết kế:\r\n\r\nPhom Loose Fit: Bồng bềnh, thoải mái, tạo cảm giác nhẹ nhàng.\r\n\r\nĐiểm nhấn tinh tế: Tay áo phồng và xếp ly sau áo giúp tôn vẻ nữ tính, thanh lịch, tăng độ uyển chuyển cho trang phục.', 224500.00, NULL, 'products/B3uOpD5hpUzeAznQQYeYRXhxvt9i9XGg9W7j0KL7.png', 3, 2, '2025-07-15 10:52:42', '2025-07-15 10:52:42', 2),
(34, 'Áo Len Polo Dệt Vặn Thừng', 'Bộ sưu tập Peaceful Summer 2025 - YODY mang đến vẻ đẹp thanh lịch, sự thoải mái và phong cách tinh tế. Với gam màu dịu nhẹ và chất liệu cao cấp, bộ sưu tập gợi lên cảm giác bình yên, tươi mới, như một sự kết nối hài hòa với thiên nhiên.', 399000.00, NULL, 'products/I601Z9UwXEdWOlKEKE4CgCpbNeWpqJ8FEgz2tGCW.png', 10, 2, '2025-07-15 10:56:49', '2025-07-15 10:56:49', 1),
(35, 'Áo Len Nữ Cổ Cao', 'Chất liệu viscose mềm mịn thoải mái pha thêm polyester tăng độ bền, giữ form dáng hoàn hảo, không bị bai dão sau nhiều lần giặt. Thiết kế đơn giản với cổ cao giữ ấm và thanh lịch. Sản phẩm phù hợp nhiều phong cách từ đi làm đến dạo phố.', 369000.00, NULL, 'products/TKvdNTAKbidPwV6xOSNeRMxUqF77NbVnjzTvLgpu.png', 10, 2, '2025-07-15 11:00:53', '2025-07-15 11:00:53', 2),
(36, 'Váy Liền Cổ Đức Đai Eo Xòe Tầng', 'Thoải mái & thanh lịch: Đầm sơ mi dáng rộng, phù hợp cho nhiều phong cách.\r\n\r\nThiết kế tay phồng: Tạo điểm nhấn thời trang, mang lại vẻ nữ tính.\r\n\r\nĐai eo linh hoạt: Dễ dàng điều chỉnh để tôn dáng hoặc tạo sự thoải mái khi mặc.', 449500.00, NULL, 'products/mVxplKidIZndPwqt9uM3YhnEPPRJ4Emw4rqg3hyQ.png', 5, 2, '2025-07-15 11:04:31', '2025-07-16 10:03:19', 2),
(39, 'Áo Polo nam Premium Cotton', 'Áo polo bằng thun cá sấu nhẹ làm từ cotton pha, có cổ, nẹp khuy và tay ngắn. Dáng ôm gọn các đường cong trên cơ thể tạo dáng vừa vặn. Áo kết hợp vải sợi polyester độc đáo, mềm mại, thoải mái và nhanh khô giúp hút ẩm và điều chỉnh nhiệt độ hiệu quả.', 399000.00, NULL, 'products/kenDeaYn6cwKFyTN7O75yWrGjKSECRkxLBB9vfX3.png', 1, 2, '2025-07-18 16:46:09', '2025-07-25 10:09:27', 1),
(40, 'Áo Ba Lỗ Rib Cổ Tròn', 'Dành cho tủ đồ hàng ngày của bất cứ chàng trai nào. Áo ba lỗ trơn màu cơ bản. Thiết kế cổ tròn basic, dễ phối đồ phù hợp mọi hoạt động. Chất liệu siêu co giãn, đàn hồi mang đến cảm giác thoải mái tối đa khi vận động. Thông thoáng, thoát mồ hôi nhanh. Đây là lựa chọn hoàn hảo cho item mặc trong hoặc mang đi tập gym, thể thao... đều được', 74500.00, NULL, 'products/olUD8VvEi0ujnPOIP4YSZN17Wa8ZpixmXGkvnf6c.png', 6, 1, '2025-07-25 09:55:44', '2025-07-25 10:09:18', 1),
(41, 'Quần Jeans Nam Slim Fit Rayon Rách Gối', 'Quần jeans mang phong cách trẻ trung, cá tính với thiết kế rách gối dễ dàng phối đồ. Kiểu slim fit ôm sát, tôn dáng. Chất liệu mềm mại, thông thoáng mang lại cảm giác thoải mái khi mặc. Khả năng co giãn tốt, dễ dàng vận động. Độ bền cao, giữ form lâu dài, thấm hút mồ hôi tốt và an toàn cho da.', 219000.00, NULL, 'products/uaGdvZlHTdgmjaIXfjfG4I9YuoyAu9CLbkfi0wll.png', 2, 2, '2025-07-25 10:14:27', '2025-07-25 10:14:27', 2),
(42, 'Sơ Mi Dài Tay Nữ Dáng Suông Vải Tơ', NULL, 249000.00, NULL, 'products/RNN61TLhdwZyhyTtyBVAWcZ9D0k8RnRqkGTWUAPs.png', 3, 2, '2025-07-25 10:18:57', '2025-07-25 10:18:57', 2),
(43, 'Quần Âu Nữ Dáng Suông Họa Tiêt Kẻ', 'Quần âu nữ dáng suông họa tiết kẻ caro thanh lịch. Chất liệu cao cấp, mềm mại, co giãn. Lớp cào lông bên trong giữ ấm hiệu quả. Thiết kế đơn giản, thoải mái, dễ phối đồ, phù hợp phong cách công sở và dạo phố.', 349000.00, NULL, 'products/sUDPN8TXIhucztFSbXFSvbKRK8rvl2n1qobeusiK.png', 4, 2, '2025-07-25 10:23:53', '2025-07-25 10:23:53', 1),
(44, 'Váy Maxi Đan Hỗn Hợp', 'Bộ sưu tập Peaceful Summer 2025 - YODY mang đến vẻ đẹp thanh lịch, sự thoải mái và phong cách tinh tế. Với gam màu dịu nhẹ và chất liệu cao cấp, bộ sưu tập gợi lên cảm giác bình yên, tươi mới, như một sự kết nối hài hòa với thiên nhiên.', 349500.00, NULL, 'products/Fiqy3yXCNfvzqB7gH2AZ0HxHrrBIIjSp4s9t3EJq.png', 5, 2, '2025-07-25 10:28:06', '2025-07-25 10:28:06', 2),
(45, 'Áo Khoác Nam Túi Hộp Da', NULL, 1399000.00, NULL, 'products/wKdPjVjKFOjkVnaxKG3eovmSRaERiLDI8Tkiwhmt.png', 6, 2, '2025-07-25 10:35:00', '2025-07-25 10:35:00', 2),
(46, 'Áo Khoác Thể Thao Nữ Siêu Nhẹ Siêu Co Giãn Chống Tia Uv', NULL, 599000.00, NULL, 'products/YCWo5q2jPS67g2RT49sKB3bltGiPQX6BGky8KqMb.png', 7, 2, '2025-07-25 10:39:16', '2025-07-25 10:39:16', 1),
(47, 'Áo Phông In Chữ', 'Bộ sưu tập Peaceful Summer 2025 - YODY mang đến vẻ đẹp thanh lịch, sự thoải mái và phong cách tinh tế. Với gam màu dịu nhẹ và chất liệu cao cấp, bộ sưu tập gợi lên cảm giác bình yên, tươi mới, như một sự kết nối hài hòa với thiên nhiên.', 149000.00, NULL, 'products/2xnzSlbdC5kHcaJtvE430p6HryEmmxuwI1XTe3zs.png', 8, 2, '2025-07-25 10:43:40', '2025-07-25 10:43:40', 1),
(48, 'Áo Hoodie Yoguu Bổ Thân', NULL, 599000.00, NULL, 'products/EraUlrkfjnmcwMEbBt5uhMyCEzJFT6Kz6uuPVlFJ.png', 9, 2, '2025-07-25 10:48:59', '2025-07-25 10:48:59', 1),
(49, 'Áo Len Polo Dệt Họa Tiết Kẻ', NULL, 199500.00, NULL, 'products/fIJZIE1nFm7ZV8CmidfJNDXdbh1M19PSdFXo5BNN.png', 10, 2, '2025-07-25 10:53:51', '2025-07-25 10:53:51', 2),
(50, 'Sơ Mi Dài Tay Nam Oxford Túi Ngực', 'Áo sơ mi nam sử dụng sợi 100% cotton oxford cổ điển luôn là item không thể thiếu trong tủ đồ của nam giới. Áo có khả năng co giãn tự nhiên, mềm mại, thoải mái, cho cảm giác mặc thông thoáng. Sản phẩm oxford 100% cotton có thể bị nhăn nhàu nên giũ phẳng mạnh trước khi phơi để sản phẩm phẳng nhất có thể.', 499000.00, NULL, 'products/DrM6j1CmBMU2OdHQTX5P6CnlmJuo7Nm6Bi49pbE5.png', 1, 1, '2025-07-25 11:02:12', '2025-07-25 11:02:12', 1),
(51, 'Quần Shorts Nam Basic', NULL, 184500.00, NULL, 'products/z6ekb3GpFe9WV5cibsNAmiUFZ9RruzUV2tnVEPwd.png', 2, 1, '2025-07-25 11:05:40', '2025-07-25 11:05:40', 2),
(52, 'Sơ Mi Dài Tay Nữ Tay Bồng Lá Cổ Nhọn Cá Tính', NULL, 469000.00, NULL, 'products/du41ErIpH5080J8HJN41TMSUvh8g40hsjbjCzbpm.png', 3, 1, '2025-07-25 11:09:24', '2025-07-25 11:09:24', 2),
(53, 'Quần Nỉ Nữ Dáng Suông', NULL, 299000.00, NULL, 'products/Py392ded4pbEMmE0h5Z85OIOwTv6QgtEg4LVdqJr.png', 4, 1, '2025-07-25 11:13:53', '2025-07-25 11:13:53', 1),
(54, 'Chân Váy Túi Hộp Xỏa Viền Yoguu', 'Sản phẩm dễ dàng mix&match với áo t-shirt, babytee, sơ mi.... phù hợp với nhiều hoàn cảnh đi học, đi chơi, đi làm...', 199500.00, NULL, 'products/inSFdHE7Xkw2ib9izIlqKmX3jQj3VoDvH6vALX6i.png', 5, 1, '2025-07-25 11:18:03', '2025-07-25 11:18:03', 1),
(55, 'Bộ Đồ Thể Thao Nam Nỉ Phối Sườn Dây Lé', NULL, 999000.00, NULL, 'products/TayMEVQ67g03lsckEdWqMlgLPmL5IDtjU5wbTUxP.png', 6, 3, '2025-07-25 11:25:16', '2025-07-25 11:43:00', 2),
(56, 'Áo Phông Dáng Croptop In Ngực Áo', 'Mềm mại, co giãn tốt – Chất vải 100% Cotton Interlock có bề mặt mịn màng, co giãn linh hoạt, mang lại cảm giác thoải mái khi mặc.', 99500.00, NULL, 'products/yTv9IDkOVMAjcO4nRXoUMwW1zTonPCn7MzxHaN3I.png', 7, 1, '2025-07-25 11:29:50', '2025-07-25 11:29:50', 2),
(57, 'Áo Phông Nam Cổ Nẹp Cúc', 'Mềm mại, co giãn tốt – Chất vải 100% Cotton Interlock có bề mặt mịn màng, co giãn linh hoạt, mang lại cảm giác thoải mái khi mặc.', 299000.00, NULL, 'products/TKYdtVFjZR6IvdwgOYEzETcT1OgqyDCIDlQZWpVu.png', 8, 1, '2025-07-25 11:34:17', '2025-07-25 11:34:17', 2),
(58, 'Sweater In Tràn', 'Mùa đông sẽ thật ấm áp mà vẫn lên đồ cá tính với chiếc áo sweater này. Thiết kế hình in trẻ trung, có phần bụi bặm trên nền vải dày dặn. Áo có kiểu dệt da cá giúp mặt vải mềm mịn, đanh chắc. Bên trong là một lớp bông mềm mại giúp tăng cường khả năng giữ ấm hiệu quả.', 249000.00, NULL, 'products/0qZEGsKZourgVUE3o9AkAQICcHpelHuOdeJjRfeH.png', 9, 1, '2025-07-25 11:38:18', '2025-07-25 11:38:18', 1),
(59, 'Áo len nam cổ polo cơ bản', 'Mềm mại, êm ái: Thành phần rayon chiếm 65% cho vải mềm mịn, mát tay, tạo cảm giác mặc như được nâng niu.', 499000.00, NULL, 'products/8IcWaXfH2zDD3bKEmG6yK6Xyz2dSHrxlg9Ftfs3a.png', 10, 1, '2025-07-25 11:41:35', '2025-07-25 11:41:35', 1),
(60, 'Sơ mi cộc tay nam polyester nano caro', 'Vải được dệt bởi các sợi Polyester với đường kính nhỏ hơn sợi tóc thông thường, các sợi này được gọi là sợi polyester công nghệ nano. Các sợi mảnh này được xoắn vào nhau tạo lên một sợi lớn, sau đó dệt thành vải. Sợi lớn này bao gồm các sợi polyester công nghệ nano do đó tạo nên một bề mặt vải mềm mịn, sạch.', 499000.00, NULL, 'products/3z3djELBM7KRhGPxkx6BX7LS4BXME36W5s0bsKdc.png', 1, 3, '2025-07-25 11:47:01', '2025-07-25 11:47:01', 1),
(61, 'Quần Kaki Nam Phối Lé Túi', NULL, 499000.00, NULL, 'products/KPnJ4jzXWDkDSD5XGMvYnnNX6YAODKzcPAOUGqbP.png', 2, 3, '2025-07-25 11:50:02', '2025-07-25 11:50:02', 2),
(62, 'Vest Nữ Gile Vạt Lệch Cá tính', NULL, 429000.00, NULL, 'products/pAErJQeFsY1HBYZyhioUpOvk2QUJsQHUBlWokOvR.png', 3, 3, '2025-07-25 11:52:25', '2025-07-25 11:52:25', 2),
(63, 'Quần Âu Nữ Loe Cúc Bọc Cạp Chun Đáp', 'Quần âu nữ dáng loe chất liệu knit crepe co giãn 4 chiều, thoải mái vận động. Bề mặt vải crepe cao cấp, không nhăn, dễ dàng chăm sóc. Cạp chun ôm vừa vặn, tôn dáng. Thiết kế loe nhẹ nhàng, phong cách thời trang hiện đại và phù hợp nhiều hoàn cảnh.', 249000.00, NULL, 'products/aPrHDBKUwZBWKI7UQmOFpwaU71eko7cTRabC7g8c.png', 4, 3, '2025-07-25 11:54:38', '2025-07-25 11:54:38', 1),
(64, 'Chân Váy Da Nữ Dáng A 8 Mảnh', 'Chiếc váy da cá tính với 2 lớp dày dặn giúp chị em lên đồ thoải mái, tự tin mỗi ngày. Đây là thiết kế trẻ trung, cá tính lại dễ dàng vệ sinh, bảo quản. Bổ sung ngay vào tủ đồ hàng ngày nhé!', 249000.00, NULL, 'products/ZGBxayNSOGPGBomYrkMfgRA0vKnP5vydOXaMPnHV.png', 5, 3, '2025-07-25 11:57:40', '2025-07-25 11:57:40', 2),
(65, 'Vest polyester nano waffle một lớp', 'Chất liệu vải Waffle được tạo nên từ công nghệ dệt hiện đại, sử dụng các sợi polyester siêu mảnh, nhỏ hơn nhiều lần so với đường kính sợi tóc. Những sợi siêu nhỏ này được xoắn chặt lại thành một sợi lớn, sau đó dệt thành vải, tạo ra bề mặt vải dạng waffle (ô nổi nhẹ) với kết cấu rõ nét.', 1499000.00, NULL, 'products/mhaIXlyFuZu3MVJhbMuwJOmoDC0tdCrOaJuPYjHx.png', 6, 3, '2025-07-25 11:59:56', '2025-07-25 11:59:56', 2),
(66, 'Set Nữ Lá Cổ Đức Cúc Bọc Chân A', NULL, 399000.00, NULL, 'products/H9fNYlC9ihAjyNZDeHGF46vbwGFXEKVD1hdYayb8.png', 7, 3, '2025-07-25 12:02:01', '2025-07-25 12:02:01', 1),
(67, 'Áo thun Nam Basic Slimfit Thun Rib Cotton Mềm', 'Thành phần cotton cao (90%) giúp vải mềm, dễ chịu, ít gây kích ứng – lý tưởng cho sản phẩm mặc sát như áo ôm, tanktop, đầm body.', 149000.00, NULL, 'products/d1K5gfW6vjLRSAYEBAegNplnoJHxgGWdNtK9fvsj.png', 8, 3, '2025-07-25 12:05:41', '2025-07-25 12:05:41', 1),
(68, 'Áo Nỉ Nam Relax Có Cổ Cơ Bản', NULL, 469000.00, NULL, 'products/E1IrZxzCZnvvAFfwHWqyfx2FuQcySKk2Q3iL4iim.png', 9, 3, '2025-07-25 12:08:14', '2025-07-25 12:08:14', 2),
(69, 'Áo Len Nữ Cổ Cao', 'Chất liệu viscose mềm mịn thoải mái pha thêm polyester tăng độ bền, giữ form dáng hoàn hảo, không bị bai dão sau nhiều lần giặt. Thiết kế đơn giản với cổ cao giữ ấm và thanh lịch. Sản phẩm phù hợp nhiều phong cách từ đi làm đến dạo phố.', 369000.00, NULL, 'products/ILfLsPERr3fGq2ZjUtsyXIS4tH47s5ZuuMR11dKD.png', 10, 3, '2025-07-25 12:10:46', '2025-07-25 12:10:46', 2),
(70, 'Sơ Mi Tay Dài Nam Nano Kẻ', NULL, 219000.00, NULL, 'products/tBsljmH7tXbwlcuMBaQB9V5ZgqYDFXaZGkEm0Bzq.png', 1, 4, '2025-07-25 12:57:04', '2025-07-25 12:57:04', 1),
(71, 'Quần âu nam polyester nano classic cạp di động', 'Chất liệu vải Waffle được tạo nên từ công nghệ dệt hiện đại, sử dụng các sợi polyester siêu mảnh, nhỏ hơn nhiều lần so với đường kính sợi tóc. Những sợi siêu nhỏ này được xoắn chặt lại thành một sợi lớn, sau đó dệt thành vải, tạo ra bề mặt vải dạng waffle (ô nổi nhẹ) với kết cấu rõ nét.', 599000.00, NULL, 'products/SkxDjq1iyBasA1a4MU5uhBloBo0rOZD321K46SP7.png', 2, 4, '2025-07-25 12:58:54', '2025-07-25 12:58:54', 2),
(72, 'Áo Sơ Mi Vai Chờm Cổ Đức', 'Chất liệu tự nhiên: Thành phần 100% Lyocell, an toàn và thân thiện với làn da.\r\n\r\nMềm mại & êm ái: Bề mặt vải mịn màng, mang lại cảm giác nhẹ nhàng, thoải mái.\r\n\r\nĐộ rủ tinh tế: Tạo hiệu ứng bay bổng, tôn lên vẻ nữ tính và duyên dáng.', 249500.00, NULL, 'products/c9uXjPF6mNNgKaaRHwgbpwdt3aMGZikIRgBUHwc1.png', 3, 4, '2025-07-25 13:00:39', '2025-07-25 13:00:39', 2),
(73, 'Quần Shorts Dáng Lửng', 'Quần short nữ basic với thiết kế đơn giản nhưng không kém phần thời trang, được làm từ 100% sợi Nylon cao cấp, mang lại độ bền vượt trội và khả năng giữ form tuyệt đối. Sản phẩm tôn dáng, tạo nên phong cách cá tính và năng động cho người mặc. Ưu điểm nổi bật là dễ dàng chăm sóc, giặt nhanh khô và không bị biến dạng sau nhiều lần sử dụng, phù hợp cho mọi hoạt động hàng ngày.', 114500.00, NULL, 'products/pdnodDRoSJ9NmFnDdL2OSO7A6r75wqu7oxMv9vhG.png', 4, 4, '2025-07-25 13:04:26', '2025-07-25 13:04:26', 1),
(74, 'Chân Váy Nữ Ngắn Dập Ly', 'Chân váy nữ ngắn dập ly với chất liệu cao cấp tạo form dáng chuẩn mang đến vẻ ngoài thời thượng và trẻ trung. Vải mềm mại, co giãn 4 chiều, thoải mái tối đa. Thiết kế trẻ trung, năng động và tôn dáng phù hợp với nhiều phong cách.', 214500.00, NULL, 'products/YXe8KnfjTlCb4x0aIEQc2dWzl20bAVacHzaGuXVu.png', 5, 4, '2025-07-25 13:06:15', '2025-07-25 13:06:15', 2),
(75, 'Áo Khoác Chống Nắng Thoáng Khí', 'hạn chế tia UV lên đến UPF 50+: Sợi cấu trúc đám mây giúp tối ưu độ thoáng khí, khúc xạ ánh nắng, duy trì khả năng hạn chế tia UV lên đến UPF 50+', 669000.00, NULL, 'products/qkd3swA2CBQZAPS1M53GlXHas3Hj5LrOrjcVSGp2.png', 6, 4, '2025-07-25 13:08:03', '2025-07-25 13:08:03', 1),
(76, 'Áo Chống Nắng Nữ Đa Năng Anti UV - Versatile', 'Chống tia UVA, UVB hiệu quả: Chất liệu đặc biệt giúp ngăn chặn tia cực tím, bảo vệ da tối ưu.', 449000.00, NULL, 'products/qlqxpGempHhVvH8dkblBlxN3hHE9ydpBQycP5Guy.png', 7, 4, '2025-07-25 13:10:09', '2025-07-25 13:10:09', 1),
(77, 'T-shirt Thể Thao Nam In Ngực', 'Áo Thun Thể Thao Nam In Ngực có chất liệu đàn hồi nhanh chóng, thoáng mát nhờ bề mặt vải có các lỗ nhỏ hỗ trợ quá trình lưu thông thoát ẩm, thoải mái tập luyện thể thao.', 149000.00, NULL, 'products/0PjYR0WMaCIpvQecAAfBrxzDoBhAGY3cWcLfg8s1.png', 8, 4, '2025-07-25 13:12:01', '2025-07-25 13:12:01', 1),
(78, 'Áo Thể Thao Thu Đông Nam Nỉ Cơ Bản In Yody Sport', 'Thiết kế bổ can vai, thân sau ép decan phản quang logo. Form dáng cơ bản phù hợp với nhiều dáng người, màu trẻ trung khỏe khoắn. Kiểu dệt Double Face mang lại cảm giác tiếp xúc da thoải mái, tăng cường khả năng giữ ấm cơ thể.', 449000.00, NULL, 'products/eeWtHpV5QbZmECDVCe3WePOyXWQw4DZ69z2EJgLo.png', 9, 4, '2025-07-25 13:14:01', '2025-07-25 13:14:01', 2),
(79, 'Áo Len Nữ Mỏng Cổ Cao 5cm', 'Trời trở lạnh, những chiếc áo len nữ thu đông chính là lựa chọn lý tưởng để nàng bảo vệ sức khỏe của mình mà vẫn vô cùng thời trang và phong cách.', 359000.00, NULL, 'products/iYfZ2Kau7YKpJEBeyxWBHCPz39ru99xqnnPVew2p.png', 10, 4, '2025-07-25 13:16:03', '2025-07-25 13:16:03', 2),
(80, 'Sơ mi nam s.cafe melange cộc tay túi ngực', 'Thấm hút tốt, Nhanh khô: Sợi Polyester ít ngậm ẩm, mao dẫn tốt, thoát ẩm nhanh, mang lại cảm giác khô thoáng, dễ chịu, không gây nặng, bí khi ra mồ hôi.', 469000.00, NULL, 'products/38g1E1DQ33xFUzPaPPold1kwzH2K0eYUl5TiWBJL.png', 1, 5, '2025-07-25 13:18:44', '2025-07-25 13:18:44', 1),
(81, 'Quần Sooc Nam Yody Sport Cạp Di Động', 'Chất liệu vải mềm mại, co giãn tốt, giúp bạn luôn khô ráo và thoải mái trong mọi hoạt động. Thoát mồ hôi nhanh chóng, hạn chế tình trạng bí bách, khó chịu. Co giãn thoải mái dễ dàng vận động mà không lo bị gò bó. Bền màu, hạn chế phai màu sau nhiều lần giặt. Ít nhăn nhàu, giữ form lâu dài.', 199000.00, NULL, 'products/1l8L5k39NjjYnMSoOAEqtFBetv2Wk6p91yZnQWxj.png', 2, 5, '2025-07-25 13:21:09', '2025-07-25 13:21:09', 1),
(82, 'Áo Sơ Mi Cổ Đức Thân Phối Ren', 'Mang đến vẻ đẹp thanh lịch, sự thoải mái và phong cách tinh tế. Với gam màu dịu nhẹ và chất liệu cao cấp, bộ sưu tập gợi lên cảm giác bình yên, tươi mới, như một sự kết nối hài hòa với thiên nhiên.', 249500.00, NULL, 'products/ZHUh7B5sho8rlZjpm4ObrsGNuccSuqWYqPspxkaS.png', 3, 5, '2025-07-25 13:22:56', '2025-07-25 13:22:56', 2),
(83, 'Quần Jeans Baggy Cạp Liền Co Giãn', 'Thoáng mát, thấm hút tốt: Nhờ thành phần cotton tự nhiên, mang lại cảm giác dễ chịu cả ngày.', 399000.00, NULL, 'products/q45PXxatw1FpAYyMsJDXIgJH5CHeaUMV1pcjEXia.png', 4, 5, '2025-07-25 13:24:44', '2025-07-25 13:24:44', 1),
(84, 'Chân Váy Nữ Thiết Kế Maxi', NULL, 299000.00, NULL, 'products/3EcMMeQTQKMCtY1ZFyds7oTT7Q79GUpiuQY8uesX.png', 5, 5, '2025-07-25 13:26:31', '2025-07-25 13:26:31', 2),
(85, 'Áo Khoác Nam Bomber Da', 'Áo khoác bomber da nam cao cấp, chất liệu da PU bền đẹp, lót polyester ấm áp. Cản gió hiệu quả, giữ ấm cơ thể trong những ngày lạnh. Thiết kế thời trang, phù hợp nhiều phong cách.', 1199000.00, NULL, 'products/nNbWg86uqHL3S0nYFp5c4vWUVunKVlvcljEZrRZS.png', 6, 5, '2025-07-25 13:28:17', '2025-07-25 13:28:17', 2),
(86, 'Áo Khoác Thể Thao Nữ Oversize Năng Động', 'Tự tin khoác lên mình chiếc áo khoác gió hiện đại, siêu trẻ trung này. Sản phẩm sử dụng vải có hiệu ứng nhăn gợn sóng tự nhiên được tạo nên bởi kiểu dệt với độ căng trùng của hai hệ sợi khác nhau. Áo nhẹ, mặc thoải mái, độ bền cao, định hình form dáng tốt. Sản phẩm có thể giặt máy.', 799000.00, NULL, 'products/LRrWnZcNolFfdAqmuKJJoD4xoB1lwDHEGyoBDlyW.png', 7, 5, '2025-07-25 13:29:55', '2025-07-25 13:29:55', 2),
(87, 'Áo Phông Nữ Thun Rib Cổ Tim', 'Đơn giản nhưng thanh lịch cùng áo thun nữ cổ tim. Sản phẩm là một món đồ cơ bản nhưng được xử lý tỉ mỉ từ đường may đến thiết kế giúp chị em mặc đẹp - tôn dáng. Áo ôm tôn lên đường cong cơ thể cùng bảng màu cơ bản siêu dễ phối đồ.', 149000.00, NULL, 'products/INk3EVcmgVq7RWwoZmH5s3cFvuAI0jg2LIbJpVoi.png', 8, 5, '2025-07-25 13:31:37', '2025-07-25 13:31:37', 1),
(88, 'Áo Yoguu Dài Tay A Great Day', NULL, 249000.00, NULL, 'products/RjVVClocRZFo0gOxkG8IXqyk83YnwN584VZwwB0q.png', 9, 5, '2025-07-25 13:33:46', '2025-07-25 13:33:46', 2),
(89, 'Áo Len Nữ Cổ Tròn Cơ Bản', NULL, 399000.00, NULL, 'products/euIoWSKU1SdDWWjmARbZd4xEAXy0Z629eDynHdPi.png', 10, 5, '2025-07-25 13:36:42', '2025-07-25 13:36:42', 1),
(90, 'Áo Sơ Mi Dài Tay Nam Siêu Co Giãn', NULL, 199000.00, NULL, 'products/E5mJBrEfGAEExuZpgjhPkEZeb00gzRwiddgiUFSg.png', 1, 6, '2025-07-25 13:38:46', '2025-07-25 13:38:46', 1),
(91, 'Quần Nỉ Thể Thao Nam Can Thân Phối Khoá', 'Quần nỉ thể thao nam chất liệu double face pique scuba cao cấp. Vải mềm mịn, co giãn 4 chiều, thấm hút mồ hôi tốt. Thiết kế thời trang, cá tính với khóa kéo tiện lợi, phù hợp với nhiều hoạt động.', 499000.00, NULL, 'products/8tTaLSYKu6eYcvQf8GEr0v0GzrUL8Dtgo7vTQjrF.png', 2, 6, '2025-07-25 13:41:48', '2025-07-25 13:41:48', 2),
(92, 'Áo Phông In Hình', NULL, 149000.00, NULL, 'products/FxHnZB0SqeHdIn0fWKnVY0WhCzV6inaRvXJagDHz.png', 3, 6, '2025-07-25 13:43:32', '2025-07-25 13:43:32', 2),
(93, 'Quần Jean Nữ Ống Suông Nhuộm Màu Túi Ốp', 'Thành phần spandex: giúp sản phẩm có độ co giãn đàn hồi vừa phải, thoải mái khi hoạt động.', 499000.00, NULL, 'products/gO6ISrmffu49sJvakNNJMUgfXJcRITXYql1U9cu8.png', 4, 6, '2025-07-25 13:45:30', '2025-07-25 13:45:30', 2),
(94, 'Chân Váy Jean Nữ Ngắn Cơ Bản', 'Chân váy jean nữ ngắn thiết kế basic, dễ phối đồ. Chất denim sọc gân cá tính, co giãn 4 chiều, thoải mái mọi chuyển động. Thiết kế đơn giản nhưng không kém phần thời trang giúp bạn tự tin thể hiện cá tính, phù hợp với nhiều phong cách.', 199500.00, NULL, 'products/o8S5pFCupaxmImoFYKezGZAYiVsuRy7RZkxGgOLQ.png', 5, 6, '2025-07-25 13:47:20', '2025-07-25 13:47:20', 2),
(95, 'Áo Phao Nam Trần Trám Nẹp Giấu Khoá', NULL, 699000.00, NULL, 'products/mvpJjVBA3wqjquU3QjBxzeDpV9zETMcjBmh5J0D6.png', 6, 6, '2025-07-25 13:49:12', '2025-07-25 13:49:12', 1),
(96, 'Áo Phao Nữ Dáng Dài Lỡ Trần Sóng Mũ Rời', NULL, 1399000.00, NULL, 'products/tY7k8XSCkJ1NCAy4buuQOjFjT776EtaKUOfSot2G.png', 7, 6, '2025-07-25 13:50:39', '2025-07-25 13:50:39', 2),
(97, 'Áo Phông Diễu Chỉ', NULL, 199000.00, NULL, 'products/sthVBiQ2m7KwH7IWwMZLO57EABVubJKMFiBwM1Yq.png', 8, 6, '2025-07-25 13:53:29', '2025-07-25 13:53:29', 2),
(98, 'Áo Len Nữ Cổ Liền', 'Với thiết kế basic nhưng chỉnh chu trong từng đường may, sợi vải, chiếc áo này là người bạn đồng hành không thể thiếu trong tủ đồ của các chị em khi mùa thu đông về. Trải nghiệm ngay để lên đồ thật chất nhé!', 369000.00, NULL, 'products/hITv6xhL5VmhkaTdnBgBbEW101IfFtLdzl70YQZe.png', 10, 6, '2025-07-25 13:55:51', '2025-07-25 13:55:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `order_item_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(2, 10, 36, 46, 4, '1213sba', '2025-07-21 15:59:30', '2025-07-21 15:59:30'),
(3, 10, 56, 48, 4, 'đẹp quá', '2025-07-26 07:47:14', '2025-07-26 07:47:14'),
(4, 10, 98, 51, 3, 'abc', '2025-08-01 19:27:09', '2025-08-01 19:27:09'),
(5, 10, 58, 60, 4, '23sa', '2025-08-01 22:58:55', '2025-08-01 22:58:55'),
(6, 11, 51, 61, 4, '123', '2025-08-02 00:56:07', '2025-08-02 00:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size_id`, `color_id`, `stock`, `image`, `price`, `created_at`, `updated_at`) VALUES
(107, 26, 1, 1, 20, 'variant-images/3jDm6xFhApxPNSblfaH3D38xJukyfPLvccLIRqj2.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(108, 26, 2, 1, 20, 'variant-images/JJoNZI07PqK6FAVePuAF4K8ekvVK49KtgO89ZM4p.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(109, 26, 3, 1, 20, 'variant-images/bCiTEq2Ms101n1UV8KmXrWmDoJCnOblA0RkkHQHC.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(110, 26, 4, 1, 20, 'variant-images/l6NKJajgs7Usd2JDMeRpo0rGvqTmCLo8nfXk8cw8.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(111, 26, 1, 3, 20, 'variant-images/oNHY6S1V3SSNWgezg17Y03En3pByj7GrvSOdgSBo.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(112, 26, 2, 3, 20, 'variant-images/5sYZSnwKNmZnWrgmrKsQXA6v1BG1Ivb8GDfP1frC.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(113, 26, 3, 3, 20, 'variant-images/wQTqwYTS0MlOd0ptHgTJJgiluZ0OeEtWNgiPM1in.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(114, 26, 4, 3, 20, 'variant-images/lvV8MoOHyKjUzHdsU08FYqnexHvGXHO1Mb2IxmCY.png', NULL, '2025-07-15 10:15:48', '2025-07-15 10:15:48'),
(115, 27, 1, 1, 20, 'variant-images/zbeSVeinRmcry42OuEsDeAehqpvZp36KKowCAL99.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(116, 27, 2, 1, 20, 'variant-images/sl3FjSu5unPLmlRyZF0TPWKvEttFQirtPLkvIP5d.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(117, 27, 3, 1, 20, 'variant-images/6rAojoHCIcxBIDEFCfXgkUrZfypcAnIqs5bTbIHU.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(118, 27, 4, 1, 20, 'variant-images/vSXUJ6l0W5zgnegvFDowjozrUp5Kd1LDqUYBYSR9.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(119, 27, 1, 3, 20, 'variant-images/WJ6pRNlZPskWvKrZAnfmw4C82ZafcMceTgexZLb2.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(120, 27, 2, 3, 20, 'variant-images/Le5CI9tt6G99brhfA24qYIAA9ldGVwkZF0gphDks.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(121, 27, 3, 3, 20, 'variant-images/s3tODVxthkA0bGAwpHI48lYiYIyLoQcvApGvnjPy.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(122, 27, 4, 3, 20, 'variant-images/W46QFxhure1muOI2nJNM56wiBj8LZ09k38E0fRsM.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(123, 27, 1, 4, 20, 'variant-images/syEnEZsI7iqUmgX9tuDiumHLekNZ4lvw0UlSQ7ss.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(124, 27, 2, 4, 20, 'variant-images/DFu5yv4fCwoqWLdb23fegYpcPJEWIM9wd0uSyIsM.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(125, 27, 3, 4, 20, 'variant-images/JycIczKciPEWl9Wz7yF8i71B3zI8VLOjiL9rUPwn.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(126, 27, 4, 4, 20, 'variant-images/BGVTMixTw1r5Cohm1Nseo42fBmHm1cvMrjujixKr.png', NULL, '2025-07-15 10:21:37', '2025-07-15 10:21:37'),
(127, 28, 2, 1, 20, 'variant-images/w1S6yKS45j8VTzZTRgHKWaubA9ghRTK9GcxYChHy.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(128, 28, 3, 1, 20, 'variant-images/YX5BAa7XXzrsshHxIRQC0xWI62cX1338ktZq1GeL.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(129, 28, 4, 1, 20, 'variant-images/PEPnbACqtMdehP9GwYnpjqM2aQ7GXiU9qLjs7V9T.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(130, 28, 5, 1, 20, 'variant-images/fQomsE1De32rz3HJr8jMzhrArqZU3wT4MIMJrUPW.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(131, 28, 2, 2, 20, 'variant-images/YMSt2DSUYAZCjOYpk29CpPaINywhOjokYM7L0p1U.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(132, 28, 3, 2, 20, 'variant-images/PoeBJ0n8w4SK0n50Sycc99l5O67HNuKVJ0rnYAMc.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(133, 28, 4, 2, 20, 'variant-images/WZRnHejyzuZblUd0AYPzqON7bU8bqHfDZ2b1Tzak.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(134, 28, 5, 2, 20, 'variant-images/aZtGeLlrluLj3DvnnT8RJOFzMKYR8zb5dfSsAHmm.png', NULL, '2025-07-15 10:29:46', '2025-07-15 10:29:46'),
(135, 29, 2, 1, 20, 'variant-images/ixqoyPNwgIyRZX7gCMWD5icgL9h322tu6bE1uowm.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(136, 29, 3, 1, 20, 'variant-images/SgXlfY0mbApk6uHDpgZmu6xNKVnt77UhAl7hZkXX.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(137, 29, 4, 1, 20, 'variant-images/AOO7AiLkiJoeybhFDLctXkcJbnG3GBlNMiXyMeZe.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(138, 29, 5, 1, 20, 'variant-images/66cOk2NpJ8uQe7tsbHawqqmIBhTlKfeLa54nj22S.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(139, 29, 2, 3, 20, 'variant-images/cAvrnHrecyg8HHcb1GlRRVLPcdo9yxbmQcObdUNs.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(140, 29, 3, 3, 20, 'variant-images/nTr9fSiBxMkI0mn6Jj7OQRu05BMcwm29iQh3wbUd.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(141, 29, 4, 3, 18, 'variant-images/iv6x2uxUNnjYBDtnbW2JP40AirKXSIrQqpncBZOE.png', NULL, '2025-07-15 10:34:07', '2025-08-08 14:01:00'),
(142, 29, 5, 3, 20, 'variant-images/nOLT0yOA5cv2UGC1EE1JZrlL6EmZOrd3Z3m3B1rC.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(143, 29, 2, 2, 20, 'variant-images/8RoJYNCW7EemPO37LkVYQB3EwfLMPJmbJ3ICLK3F.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(144, 29, 3, 2, 20, 'variant-images/cyBmXFDaBgvUVT2ExUCSbNFIAEYEgFDn0XigzmRv.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(145, 29, 4, 2, 20, 'variant-images/ayunF67M7bxVZdXwDqGGagkVZBkcyACKPmoBTF4g.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(146, 29, 5, 2, 20, 'variant-images/aROWw0xyBE4McDWcFM0LJYRhTmiCOYaydnFgjo3f.png', NULL, '2025-07-15 10:34:07', '2025-07-15 10:34:07'),
(147, 30, 3, 8, 20, 'variant-images/hAVbGCDz6MKINxBG1dryeksEu5ZmxnlmQy2WMpmP.png', NULL, '2025-07-15 10:37:39', '2025-07-15 10:40:10'),
(148, 30, 4, 8, 20, 'variant-images/ucLqEFj8bqVx3a3N8DEZAAetYGtSU3VqxH6fAN9j.png', NULL, '2025-07-15 10:37:39', '2025-07-15 10:40:10'),
(149, 30, 3, 2, 20, 'variant-images/6Shvr39fejgkXros11U2u2M1GKhDd4G0Wmmug3aL.png', NULL, '2025-07-15 10:37:39', '2025-07-15 10:37:39'),
(150, 30, 4, 2, 20, 'variant-images/ObNgvOvjf1AKfrscmGFkc4BKreW9rI5WMGapscX5.png', NULL, '2025-07-15 10:37:39', '2025-07-15 10:37:39'),
(151, 31, 2, 1, 20, 'variant-images/0YZaUy6wsx7CXn1OsUQfd2uSO3EsurFeMyvOXfIx.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(152, 31, 3, 1, 20, 'variant-images/7b6wY1WLMFMz0aSNINPU4bY8M274e30pRH8aLcLz.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(153, 31, 4, 1, 20, 'variant-images/lIlFtcpOXpvJquvfnIzo8mgXg39nLnkp0ymIT26c.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(154, 31, 5, 1, 20, 'variant-images/VArbTLZ4E98ftpzmMVi8UOurCZqNr0FMLjuyjw9K.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(155, 31, 2, 8, 20, 'variant-images/GFiIghnKeeD3fYAXIy4cfrOgd9Lf3UO7bJ7jiiHx.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(156, 31, 3, 8, 20, 'variant-images/vpTjxygqEtHwGTUlJvVoB6XQdYo16rJOudSVxsVG.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(157, 31, 4, 8, 20, 'variant-images/hXzYznTJERLVZZycq9lK3medZlmLKEt7LtwJxikK.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(158, 31, 5, 8, 20, 'variant-images/gtQ1wjjkS53hRFogmaIPHJnfrdTobiZm47uKCsrq.png', NULL, '2025-07-15 10:44:28', '2025-07-15 10:44:28'),
(159, 32, 2, 1, 20, 'variant-images/uCwYs7bdxxKq7LX0qwyADSqo9KeDhighS9rflKl2.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(160, 32, 3, 1, 20, 'variant-images/XnhV1MC6j1gdAEaIfAkMuMmOCjKNPtgyHQJJ6qIq.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(161, 32, 4, 1, 20, 'variant-images/2eYDva7Hz5QSDoLm7iEt5WwoUYquG7X1JC45B13V.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(162, 32, 2, 6, 20, 'variant-images/5HYlTBMiZqdm7yTOOZyXY3eZ29Hr6xGowgl9lgmm.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(163, 32, 3, 6, 20, 'variant-images/qlu56pOT40Xx9ZH9jLhm7AEPL49D1gUZ698MxsXk.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(164, 32, 4, 6, 20, 'variant-images/pGwoQwYxp4RN6V4kyLWhQbNyWUBtuJjz9rTn9Uel.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(165, 32, 2, 5, 20, 'variant-images/2y6KOk46blQ6jkMO3n6S1hKFNhMZ7Y7hjArgbQF5.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(166, 32, 3, 5, 20, 'variant-images/cggMEtMIUGPyg6CQ3J9X0gh7JzutiuIta0uvjqbG.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(167, 32, 4, 5, 20, 'variant-images/s9fpGoq81cRfNZJNRO30weSHt2LxHDi0bhgoz9ZO.png', NULL, '2025-07-15 10:49:04', '2025-07-15 10:49:04'),
(168, 33, 1, 3, 20, 'variant-images/lrlnhnDBNez5QHKrp7WyFSF43KwtY2AgSSFkk8S2.png', NULL, '2025-07-15 10:52:42', '2025-07-15 10:52:42'),
(169, 33, 2, 3, 20, 'variant-images/Iq89YXNiduBF5UdAc2p32adN4pc3ExZAJ4uymhCA.png', NULL, '2025-07-15 10:52:42', '2025-07-15 10:52:42'),
(170, 33, 3, 3, 20, 'variant-images/f3MfpzTVEERsePsPwwzKTgr8roWkLvb9ZIqCLQQl.png', NULL, '2025-07-15 10:52:42', '2025-07-15 10:52:42'),
(171, 33, 1, 5, 20, 'variant-images/GE2T0Ze4MSybJzvcL0ukF4pLYkjKKgvA8xFbb0ag.png', NULL, '2025-07-15 10:52:42', '2025-07-15 10:52:42'),
(172, 33, 2, 5, 20, 'variant-images/p4vsdhdRaYQ2X0teNSup07kM93qa6xSHUzDE954U.png', NULL, '2025-07-15 10:52:42', '2025-07-15 10:52:42'),
(173, 33, 3, 5, 20, 'variant-images/BGGLUTwQZ0RxoZRUTFl67UoYv56HWHGBiBgGAi7K.png', NULL, '2025-07-15 10:52:42', '2025-07-15 10:52:42'),
(174, 34, 1, 2, 20, 'variant-images/Qv0REbIIXCbhCW6gXnjGCT0jrGCKfpSzWvucnJoo.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(175, 34, 2, 2, 20, 'variant-images/la1lMN52GkAjepWd62s7MrsBe2sfgmQ3o58GzKiU.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(176, 34, 3, 2, 20, 'variant-images/JQ2fyVhui9kuDvcDPnWD5j4bBbRHuNXpHyifnhEW.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(177, 34, 1, 9, 20, 'variant-images/VB8NZPD1YSGxIHedmC2RFr07q7uZ7Bt9B5mQ5VU9.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(178, 34, 2, 9, 20, 'variant-images/7a0s3Q1tYvHBdBv8ZluKJwzVQeC5ox7SdMBgpfS4.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(179, 34, 3, 9, 20, 'variant-images/DU4SU75OiXuqZmdV6NR7RNTVXw4vseDHWsshTS1m.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(180, 34, 1, 5, 20, 'variant-images/nPBIKatKflPi2r9diQHlhnbQsgLom29qE61cKe2R.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(181, 34, 2, 5, 20, 'variant-images/4kjbh1NIGwg3yfYQLcFJk8wm51OCGXaBrhYxo4dV.png', NULL, '2025-07-15 10:56:49', '2025-07-15 10:56:49'),
(182, 34, 3, 5, 15, 'variant-images/qRGBPYjo52bWczfPTAHV7BDHMBySvRqTm39sq6d9.png', NULL, '2025-07-15 10:56:49', '2025-07-21 15:42:44'),
(183, 35, 1, 10, 19, 'variant-images/0ymBh8XYWMa1Avjtq5K6E7gNfaisytxXJk4glUuz.png', NULL, '2025-07-15 11:00:53', '2025-07-15 16:01:56'),
(184, 35, 2, 10, 20, 'variant-images/v40hAATB2X1ljHkpi7XMeOowUaYcFLSgzQWOIbD8.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(185, 35, 3, 10, 20, 'variant-images/xjkcMvPHMR4wEUXsYb2ExJufRd4pDUPHedgfy64l.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(186, 35, 1, 6, 20, 'variant-images/em6Ndo4nNxxcK9qzq498X6x36IFb0UTeNaQ7iVj1.png', NULL, '2025-07-15 11:00:53', '2025-07-15 15:39:40'),
(187, 35, 2, 6, 19, 'variant-images/Tjv5vp3nKUGRs9iIH5lufB6o18RnCuhhaJn9nk38.png', NULL, '2025-07-15 11:00:53', '2025-07-15 14:26:17'),
(188, 35, 3, 6, 20, 'variant-images/Cvtak4p27tdf4zhkXOY3ceswUdutPi0qIUyGwi9H.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(189, 35, 1, 2, 20, 'variant-images/b9HF0puN0nplgBBFpSBflejwGRPAUaXsTa7ANxbc.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(190, 35, 2, 2, 20, 'variant-images/w6dZ7qRcGDG4klkV8DrfBZP9PNh1k3hcP384sF21.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(191, 35, 3, 2, 20, 'variant-images/RCj3QA4tmp3aOW6X4bZSqk0igwPiJPEdsxIWKJkK.png', NULL, '2025-07-15 11:00:53', '2025-07-15 15:48:44'),
(192, 35, 1, 1, 20, 'variant-images/Jg37amKWAInUcRwUxonMLWSTHZDD5tzLSULMbEJm.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(193, 35, 2, 1, 20, 'variant-images/gTtnTp5gYek7CT36M9jwCo0AKwba3XfXCAlZljb6.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(194, 35, 3, 1, 20, 'variant-images/DGykQVFekuX3ZHYqPFooKK7RtdGusVAxUagEegZo.png', NULL, '2025-07-15 11:00:53', '2025-07-15 11:00:53'),
(195, 36, 1, 11, 17, 'variant-images/1YWNwR8OTpEekVVYtpYjSV3UE64JOt3DchsznGxi.png', NULL, '2025-07-15 11:04:31', '2025-07-16 10:14:31'),
(196, 36, 2, 11, 20, 'variant-images/FKGg9Lkvpucg6ettyjTNUKmgr3g9wWzoWougsCaY.png', NULL, '2025-07-15 11:04:31', '2025-07-15 11:04:31'),
(197, 36, 3, 11, 20, 'variant-images/DsHg0EnCxPU0F4q26l7yakhRXNWVWHmIK8zCMz0E.png', NULL, '2025-07-15 11:04:31', '2025-07-15 11:04:31'),
(198, 36, 1, 3, 20, 'variant-images/3BoXH8RPzaGaUGD415RoJe6hwMQQhAhSgzdLb1uQ.png', NULL, '2025-07-15 11:04:31', '2025-07-15 15:39:40'),
(199, 36, 2, 3, 18, 'variant-images/Dm56Qeha7zUezHUiAYTx0YbwvFHr1cuHrwLtzFVx.png', NULL, '2025-07-15 11:04:31', '2025-07-21 15:59:06'),
(200, 36, 3, 3, 20, 'variant-images/VTFzgs69SYqvQhH32pfPwX16xp6ubgW98xhGf0Fy.png', NULL, '2025-07-15 11:04:31', '2025-07-15 11:04:31'),
(204, 39, 1, 6, 100, 'variants/m4ZN3XXoxE1sVNnFzaXoNhYY0HfymmauiP4OWPoP.png', NULL, '2025-07-18 16:46:09', '2025-07-25 09:47:08'),
(205, 39, 2, 3, 100, 'variants/Vfl6donwcfvZLIWDT1ob2Kr2rGC7YkWthaFJCuvg.png', NULL, '2025-07-18 16:46:09', '2025-07-25 09:47:08'),
(206, 39, 4, 8, 100, 'variants/pvwHKUkMxfmWuVq9Ov9EGQtVmeLYPI09p8ASstEK.png', NULL, '2025-07-18 16:46:09', '2025-07-25 09:47:08'),
(207, 39, 1, 3, 50, 'variants/7qx1rIk7bvnxlgdq5I740inwg0ndftW5Quql5rnk.png', NULL, '2025-07-25 09:25:00', '2025-07-25 09:47:08'),
(208, 39, 1, 8, 50, 'variants/j5TqITHNtJpiJs5Z0oxAwM8XrirHFVOxc0Br7I4E.png', NULL, '2025-07-25 09:25:00', '2025-07-25 09:47:08'),
(209, 39, 2, 6, 50, 'variants/p7ZvHjamaDdtVbUlieWX0bzINMUd0LcZlS2LdrFG.png', NULL, '2025-07-25 09:25:00', '2025-07-25 09:47:08'),
(210, 39, 2, 8, 50, 'variants/ol7jHBptoDfwSbIb3Mkawy9SWtETQT6taH5iE56j.png', NULL, '2025-07-25 09:25:00', '2025-07-25 09:47:08'),
(211, 39, 4, 6, 50, 'variants/iUad04ecHwUDkUOFI1sgymEVsQzyvTrodgLW22MU.png', NULL, '2025-07-25 09:25:00', '2025-07-25 09:47:08'),
(212, 39, 4, 3, 50, 'variants/F1GXvY6v5tSAfoK0bUCUb3Kmg7MqvyTLk7ieGM5N.png', NULL, '2025-07-25 09:25:00', '2025-07-25 09:47:08'),
(213, 40, 4, 3, 60, 'variants/dGfEkyRK5ZR0Nja0CrAnaQI3MFlIXMQtKSMrSgtX.png', NULL, '2025-07-25 09:55:44', '2025-07-25 09:56:36'),
(214, 40, 4, 1, 60, 'variants/M3wPSmqNH3ZAbeWKpw27ZQjii8hJfVqXVJHI2nEj.png', NULL, '2025-07-25 09:55:44', '2025-07-25 09:56:36'),
(215, 40, 2, 3, 60, 'variants/7nQvXPS7OSXpD261sWnR6XdSHj6XZDg6YcLYUkXA.png', NULL, '2025-07-25 09:55:44', '2025-07-25 09:57:49'),
(216, 40, 2, 1, 60, 'variants/Toz3KXtR2ZMbejhhqsn0NXY85N0cUupPhyhmhlWR.png', NULL, '2025-07-25 09:55:44', '2025-07-25 09:56:36'),
(217, 40, 3, 3, 60, 'variants/2IcX2pCIHPPbnpcCEfgoXkHmnNIEORC6j6IAJlQO.png', NULL, '2025-07-25 09:55:44', '2025-07-25 09:57:32'),
(218, 40, 3, 1, 60, 'variants/Ntou20fHfJyumasx6FMA0JMgDf3hIqPz84LNI49i.png', NULL, '2025-07-25 09:55:44', '2025-07-25 09:56:36'),
(219, 41, 2, 2, 30, 'variant-images/8lQphdUYZ3xQ9PVTYu7DhVPbkJFupAt0Jhjis5Jx.png', NULL, '2025-07-25 10:14:27', '2025-07-25 10:14:27'),
(220, 41, 2, 9, 30, 'variant-images/FxIea4FaMCEClt7UhiIh38oZYJRU1Qq22eZfTLSl.png', NULL, '2025-07-25 10:14:27', '2025-07-25 10:14:27'),
(221, 41, 3, 2, 30, 'variant-images/RWpsWj2mKDfgfxzy1UWNWX3dfxiVbINs7N8EsWe4.png', NULL, '2025-07-25 10:14:27', '2025-07-25 10:14:27'),
(222, 41, 3, 9, 30, 'variant-images/PhrxZ9Q5o0PD9v12xnv976x3wEVavv1s8LKkN4Xv.png', NULL, '2025-07-25 10:14:27', '2025-07-25 10:14:27'),
(223, 42, 1, 1, 40, 'variant-images/DrAhDZoMHeJxfqUmdDvFTbfDN8GSzpYiQxcJ1pSU.png', NULL, '2025-07-25 10:18:57', '2025-07-25 10:18:57'),
(224, 42, 1, 11, 40, 'variant-images/eS1q8O3JGcFmGqeuOUl0o11hVdSsuF5H9qdNO0Ac.png', NULL, '2025-07-25 10:18:57', '2025-07-25 10:18:57'),
(225, 42, 1, 6, 40, 'variant-images/iiGb05TIHzZUP30W1iyKKRAmpgz9hDNiPTLzt68k.png', NULL, '2025-07-25 10:18:57', '2025-07-25 10:18:57'),
(226, 42, 2, 1, 40, 'variant-images/RwECAyK0p1IHEvklLCmrH5wrSFSJZtmWXbKoDP6f.png', NULL, '2025-07-25 10:18:57', '2025-07-25 10:18:57'),
(227, 42, 2, 11, 40, 'variant-images/vCfTvKPSZC2zRrXWfFQLMvLZv23497NNE49h7F7q.png', NULL, '2025-07-25 10:18:57', '2025-07-25 10:18:57'),
(228, 42, 2, 6, 40, 'variant-images/mqdn19a9ebr9WNXPYwBp6a7mLJqCFyxqefL1Wff6.png', NULL, '2025-07-25 10:18:57', '2025-07-25 10:18:57'),
(229, 43, 1, 6, 60, 'variant-images/nGvIwtFB19xGGiBQZosZ0Ki3EGcfyMUvqnoHqr9v.png', NULL, '2025-07-25 10:23:53', '2025-07-25 10:23:53'),
(230, 43, 2, 6, 60, 'variant-images/C0N8kMHGzr2t5ZhMQxbud4Pj1QkWKp5zvisj2Xal.png', NULL, '2025-07-25 10:23:53', '2025-07-25 10:23:53'),
(231, 43, 3, 6, 60, 'variant-images/DBxNFe55kv6EBvUgeckath6bvN6vmeQw9vYZAqfx.png', NULL, '2025-07-25 10:23:53', '2025-07-25 10:23:53'),
(232, 44, 1, 1, 35, 'variant-images/WKeHFkwlVAGwslhGLMHMtT6zefKeCmB8JVoVf8kZ.png', NULL, '2025-07-25 10:28:06', '2025-07-25 10:28:06'),
(233, 44, 1, 5, 34, 'variant-images/mmFkDGb5C4yqGFeRZ7ty3bZkGl0jeCouFh3jZXqD.png', NULL, '2025-07-25 10:28:06', '2025-08-08 14:58:48'),
(234, 44, 2, 1, 34, 'variant-images/0eT5VrJUggDjrAJI1CBzC5EFU3HuickoY2kczOFs.png', NULL, '2025-07-25 10:28:06', '2025-08-08 14:19:59'),
(235, 44, 2, 5, 35, 'variant-images/ip3zjbCCx7novlfj5oqvLu5ZhVnmHIypfYhu88Pn.png', NULL, '2025-07-25 10:28:06', '2025-07-25 10:28:06'),
(236, 45, 2, 1, 20, 'variant-images/ULNHzrA36BSBmDA2aH4wIqfeQrlW26pYCnMZ6qi1.png', NULL, '2025-07-25 10:35:00', '2025-07-25 10:35:00'),
(237, 45, 2, 6, 20, 'variant-images/jQ6JJhPSHAN8QJdgfV12O0tv94v3qMGNGsieWY8f.png', NULL, '2025-07-25 10:35:00', '2025-07-25 10:35:00'),
(238, 45, 3, 1, 19, 'variant-images/kqGqch5RLQvUOja5FMx1QBFE08S7Mq43pbsfEnXe.png', NULL, '2025-07-25 10:35:00', '2025-08-08 14:58:48'),
(239, 45, 3, 6, 20, 'variant-images/PwFhlSioldlasEaBFUPB6B0nf3FiAs2wOmJC54d6.png', NULL, '2025-07-25 10:35:00', '2025-07-25 10:35:00'),
(240, 45, 4, 1, 20, 'variant-images/CE6jSyWuBwMWRXwrM6PGwWCRRmvBHYNwt7qyV5eP.png', NULL, '2025-07-25 10:35:00', '2025-07-25 10:35:00'),
(241, 45, 4, 6, 20, 'variant-images/MdtEqqWFJ0UiLwe96FgA9AgStmZYQyAlyb3sJh33.png', NULL, '2025-07-25 10:35:00', '2025-07-25 10:35:00'),
(242, 45, 5, 6, 20, 'variant-images/DMtEDMLYKAwFcH4f2f8CV1QQ35ykjV1UcB2DOWzg.png', NULL, '2025-07-25 10:35:00', '2025-07-25 10:35:00'),
(243, 46, 1, 3, 25, 'variant-images/fCcAvfPV8ISNehLaI9LHPyCJ7H22T17HwdGjvlY5.png', NULL, '2025-07-25 10:39:16', '2025-07-25 10:39:16'),
(244, 46, 1, 8, 25, 'variant-images/rr9jJO0N1vwaBJ5BMVQHotLVrILfiyKVl2lYxmDn.png', NULL, '2025-07-25 10:39:16', '2025-07-25 10:39:16'),
(245, 46, 1, 11, 25, 'variant-images/rFIfs3rKTezFGmnHvjCoNfoHpiZnIzhKogCZvg21.png', NULL, '2025-07-25 10:39:16', '2025-07-25 10:39:16'),
(246, 46, 2, 3, 25, 'variant-images/HILJ7Gvsxi8cxseNDi1JyYdeachRS0eGifnWHyWE.png', NULL, '2025-07-25 10:39:16', '2025-07-25 10:39:16'),
(247, 46, 2, 8, 25, 'variant-images/e4nCxix17NAYkm8DrPtvln1PhMXcgCweUpVpfnnQ.png', NULL, '2025-07-25 10:39:16', '2025-07-25 10:39:16'),
(248, 46, 3, 11, 25, 'variant-images/csuk36xVHW3fEv85yqqWmYXayVYY6PA5C34ik1xF.png', NULL, '2025-07-25 10:39:16', '2025-07-25 10:39:16'),
(249, 47, 1, 10, 30, 'variant-images/aET4MQhwkzMREiKQsskljfhaVSDctLGJsXQhRFSo.png', NULL, '2025-07-25 10:43:40', '2025-07-25 10:43:40'),
(250, 47, 1, 1, 30, 'variant-images/rxWIgq0OHG0DiZ0Q36zwtLKTZetkWzMUNt8Cu4SL.png', NULL, '2025-07-25 10:43:40', '2025-07-25 10:43:40'),
(251, 48, 2, 1, 45, 'variant-images/okQkGayMRufTREZLuyhWuJgv8nVgIfHXtAHUluz9.png', NULL, '2025-07-25 10:48:59', '2025-07-25 10:48:59'),
(252, 48, 3, 1, 45, 'variant-images/sygTsq5XRv15EtauyT01WYs3D3fARorPVx9TUyEx.png', NULL, '2025-07-25 10:48:59', '2025-07-25 10:48:59'),
(253, 48, 2, 8, 45, 'variant-images/e2PAjFMgWI38kaIMFEHyIOEhIPEwhJWvXf2yhcC4.png', NULL, '2025-07-25 10:48:59', '2025-07-25 10:48:59'),
(254, 48, 3, 8, 45, 'variant-images/8msz2oxNrj3kBChG5uvo9Xx48MIzSM5WoKmw6Rou.png', NULL, '2025-07-25 10:48:59', '2025-07-25 10:48:59'),
(255, 49, 1, 2, 32, 'variant-images/YbXQI5A6HkT2tNY8MrmX2xtmHKsMaDwjokQ1iVkY.png', NULL, '2025-07-25 10:53:51', '2025-07-25 10:53:51'),
(256, 49, 1, 10, 32, 'variant-images/r0rMJmIA7nWZE71muWzrhzXd0zBtr0uAB7LsvMDG.png', NULL, '2025-07-25 10:53:51', '2025-07-25 10:53:51'),
(257, 49, 2, 10, 32, 'variant-images/ZpLve7NrMXWDH2HSlNykNpVkOAXi853TaT4OOxpk.png', NULL, '2025-07-25 10:53:51', '2025-07-25 10:53:51'),
(258, 49, 2, 2, 32, 'variant-images/h9svoRlhAJ9ehDCyLYfpBU2IbmVOW01Ktt5egfEh.png', NULL, '2025-07-25 10:53:51', '2025-07-25 10:53:51'),
(259, 50, 2, 9, 30, 'variant-images/oQvXgRq9zVPRL09DaFYRLxkymCJaqOuID8WJWtSD.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(260, 50, 2, 2, 30, 'variant-images/LFCHpSsfsaTVEArps6fldeHUJTjR8PBZysy975fp.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(261, 50, 2, 3, 30, 'variant-images/hRZVvyeTqQVGrzwRJ66kofMOVsm41TyFixjCm6f5.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(262, 50, 3, 9, 30, 'variant-images/chYu112ze2hKkg1azGVpXId7En6qB5uyEVsSO78B.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(263, 50, 3, 2, 30, 'variant-images/2sTmzmwQWfW9jC72IbLXKc3iyPZHrKZsEFYC2h8D.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(264, 50, 3, 3, 30, 'variant-images/fnQ9qx4abIg4wfrBVcy59cFdc7eJhbVaaCdTT15K.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(265, 50, 4, 3, 30, 'variant-images/IqeqpKjxOTBkwj0SUdTwNtvEQAqlcdxVSkr37YkM.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(266, 50, 4, 2, 30, 'variant-images/D2Bw80ncyiS8U2LpCPMaN385UNKAsEKCaNq6b1hL.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(267, 50, 5, 9, 30, 'variant-images/GoL6zWLdA5bcKyzv9orJmtnMX5a97pTtmbyG5qeD.png', NULL, '2025-07-25 11:02:12', '2025-07-25 11:02:12'),
(268, 51, 2, 1, 40, 'variant-images/xzN0EFyzJoU3T458xN6yeu5P0fFpDgCVOOuw3ObA.png', NULL, '2025-07-25 11:05:40', '2025-07-25 11:05:40'),
(269, 51, 2, 6, 36, 'variant-images/Pe6VzR5qWHa35EihzoMQjvfOfjF8MtM4mzfbzvlx.png', NULL, '2025-07-25 11:05:40', '2025-08-02 00:53:23'),
(270, 51, 3, 6, 40, 'variant-images/kMmR2u6SI6gv0AxVQJaHZO45wdcxOWNOAKHToQJa.png', NULL, '2025-07-25 11:05:40', '2025-07-25 11:05:40'),
(271, 51, 3, 1, 40, 'variant-images/ah3IbmQG8Ylwzrn5YyWv8FhaHUv8U5XlMimj8Si0.png', NULL, '2025-07-25 11:05:40', '2025-07-25 11:05:40'),
(272, 52, 1, 3, 15, 'variant-images/iAJ2Bi5ChzZJ17IsKGOuGls9I1PIt5q1Jqm4kIqY.png', NULL, '2025-07-25 11:09:24', '2025-07-25 11:09:24'),
(273, 52, 1, 1, 15, 'variant-images/ngYJoZ4b7kHyVvAuHFapKqPympkdg0le5BsVkOHZ.png', NULL, '2025-07-25 11:09:24', '2025-07-25 11:09:24'),
(274, 52, 2, 3, 15, 'variant-images/6d75aHBeq8RrsX7LynLiP9nYBTD3WZ2dHfND8HLT.png', NULL, '2025-07-25 11:09:24', '2025-07-25 11:09:24'),
(275, 52, 2, 1, 15, 'variant-images/rMNZs0Azn58KphyuBNxG18dtzopfurqBukQ4SetD.png', NULL, '2025-07-25 11:09:24', '2025-07-25 11:09:24'),
(276, 53, 1, 1, 50, 'variant-images/mgeFqWisxNCxKcAArKUR8QV9jrZfEMxdi8H3e4C8.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(277, 53, 1, 2, 50, 'variant-images/Q5X4iAi77DUTvUvASUc7H6dqTATyqV7iqmAVYp72.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(278, 53, 1, 5, 50, 'variant-images/6kDlVlLAHKpYtJEBLOIDpIlGHn7xdynW58yEocHb.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(279, 53, 2, 1, 50, 'variant-images/GdW4hkNo3Su4LiOmbvo7iPT9XkUXpVsZojlJZ218.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(280, 53, 2, 2, 43, 'variant-images/PQhH5xQ8b1G7fN5QGx4R86SINAjjwT6vij6Jt2NQ.png', NULL, '2025-07-25 11:13:53', '2025-08-08 12:13:33'),
(281, 53, 2, 5, 50, 'variant-images/KOGfXsnBwC4E3v3dl4ySfCPkal0D3by3DAwZI290.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(282, 53, 3, 1, 50, 'variant-images/PytfHeLhpOn6cfPSE2ignBvSoUhDdjid5vY8RE58.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(283, 53, 3, 2, 50, 'variant-images/pbxyKkGaxeIXbWImISjhcQhwj1tMGnhjbDq73dCN.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(284, 53, 3, 5, 50, 'variant-images/t40FXxp5qvBk6j82b3EAEmtJPvhrdsnsCFYHejbH.png', NULL, '2025-07-25 11:13:53', '2025-07-25 11:13:53'),
(285, 54, 1, 1, 40, 'variant-images/LtYtHdf6IjKrrQTezuNcDAUQkfnEWNlebCO0sZ1C.png', NULL, '2025-07-25 11:18:03', '2025-07-25 11:18:03'),
(286, 54, 1, 6, 40, 'variant-images/BYehrNPno5qC0cPgPiaEb1YaEQni283VddgRHZtX.png', NULL, '2025-07-25 11:18:03', '2025-07-25 11:18:03'),
(287, 54, 2, 1, 40, 'variant-images/dQkzuXcJsKtfAlNH8tMy99No5yToNetJ746vPR7Q.png', NULL, '2025-07-25 11:18:03', '2025-07-25 11:18:03'),
(288, 54, 2, 6, 40, 'variant-images/3QxFktmU1FQFDU6E44wStamNMQfgncmEciqX3X3H.png', NULL, '2025-07-25 11:18:03', '2025-07-25 11:18:03'),
(289, 55, 2, 1, 30, 'variant-images/eXdM0ElmrChUnI5iDVYeQRAMX6hg7aqEdCSd5kTM.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(290, 55, 2, 2, 30, 'variant-images/U8dmxpDgeIiOvncxVxPaEZK1UMHQp7Jrx4kch2gB.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(291, 55, 2, 8, 30, 'variant-images/utRsgSPjecUKGlYkFF2rPddKjzgFpXgxE8uRTepu.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(292, 55, 3, 1, 30, 'variant-images/gd1yHq4zegxMPg12GRDiWbay9J7kWeM1baWWsETC.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(293, 55, 3, 2, 30, 'variant-images/i4tDTC6VSdFw8L8Auc4aQLSEs3aOT7RWIq1hWGoG.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(294, 55, 3, 8, 30, 'variant-images/rsIpPDL8SgYiffJouqAsOKERVK7y0lkBcepZbDoX.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(295, 55, 4, 1, 30, 'variant-images/XmQfqjeAPGecUUXAeJD8NNBj7UGSE5UHBhOIbsHQ.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(296, 55, 4, 2, 30, 'variant-images/yrAs3kqBryZ9SLEqBhxxZZxcC9alJBLImkQagiwl.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:51'),
(297, 55, 4, 8, 30, 'variant-images/2coJu3zSnDy8T3RYZrbnZHCMqR1MUjQhxnKRdTpB.png', NULL, '2025-07-25 11:25:16', '2025-07-25 11:25:16'),
(298, 56, 1, 11, 25, 'variant-images/rN0f3OBY1yISA14sjHzQzI4TozDKRKYPh9efXT6c.png', NULL, '2025-07-25 11:29:50', '2025-07-25 11:29:50'),
(299, 56, 1, 1, 25, 'variant-images/jMotGfnN9eBgoYHBQ0YITz0MnAj0O7o4LEbPOpxn.png', NULL, '2025-07-25 11:29:50', '2025-07-25 11:29:50'),
(300, 56, 1, 3, 25, 'variant-images/Hu07uGijpnvdj0kv2xMpUInAFB1TA1IeJ3D17eRI.png', NULL, '2025-07-25 11:29:50', '2025-07-25 11:29:50'),
(301, 56, 2, 11, 25, 'variant-images/IxzthJOvftyquzi3xoGv71MvSZlC1FgJZmnNcycu.png', NULL, '2025-07-25 11:29:50', '2025-07-25 11:29:50'),
(302, 56, 2, 1, 23, 'variant-images/w0KMYtL6dNxmeMbpOsQb1J1EXg8ZtQOCHeMxKM4V.png', NULL, '2025-07-25 11:29:50', '2025-08-08 18:01:14'),
(303, 56, 2, 3, 25, 'variant-images/2ulY6mYrTbm0IKkqvlt1THELKXHk0IGnkk5z4cMP.png', NULL, '2025-07-25 11:29:50', '2025-07-25 11:29:50'),
(304, 57, 2, 5, 26, 'variant-images/ljHQ1W1xl8yMMaUaYrAWRsYgLMzAQFSxSu01rNEY.png', NULL, '2025-07-25 11:34:17', '2025-07-25 11:34:17'),
(305, 57, 2, 3, 26, 'variant-images/UonOSnZu6CppteBolpnxEp1KL4pyr3ssqKRgRjPc.png', NULL, '2025-07-25 11:34:17', '2025-07-25 11:34:17'),
(306, 57, 2, 1, 26, 'variant-images/Cn06pX6DrWJmGiE4TlNOU129nm5t0U8msoyQ4Es3.png', NULL, '2025-07-25 11:34:17', '2025-07-25 11:34:17'),
(307, 57, 3, 5, 26, 'variant-images/NskeNwJA0Ex9uAX0KuS9byObgj3XSPbNI6K5z2dc.png', NULL, '2025-07-25 11:34:17', '2025-07-25 11:34:17'),
(308, 57, 3, 3, 26, 'variant-images/i0te1ErTP8hinXjhevqj22Fh9KoqyDOYeOold1Sr.png', NULL, '2025-07-25 11:34:17', '2025-07-25 11:34:17'),
(309, 57, 3, 1, 26, 'variant-images/S5SGVIDrwsVXMVSbyA5gyp50HlnOm08hQCe3rYNa.png', NULL, '2025-07-25 11:34:17', '2025-07-25 11:34:17'),
(310, 58, 2, 1, 19, 'variant-images/2JufFTdVAqQDY7nHXqkbc8nh2WLqr3DGldc0xQF7.png', NULL, '2025-07-25 11:38:18', '2025-08-01 22:56:50'),
(311, 58, 2, 3, 22, 'variant-images/HECvjjK80au1PpKzkdNveHpvu0H4OUaBcQ4DAxNX.png', NULL, '2025-07-25 11:38:18', '2025-07-25 11:38:18'),
(312, 58, 3, 3, 22, 'variant-images/OskFKQor0JacuxXQ7ykSDcU4HLBK4cjTbWzZPbho.png', NULL, '2025-07-25 11:38:18', '2025-07-25 11:38:18'),
(313, 58, 3, 1, 22, 'variant-images/VyRVwWdvg7CTHaEywAEuGvNKppFlTOZdIlu9m3no.png', NULL, '2025-07-25 11:38:18', '2025-07-25 11:38:18'),
(314, 59, 1, 10, 23, 'variant-images/aGndXHj7VIiNEdoFxYsR0jE2z6lzgiDgkuqKBSXO.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(315, 59, 2, 10, 23, 'variant-images/4S1UX1hCMHWyqA10WMKzT6llHTndiuQTISPYVBmr.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(316, 59, 3, 10, 23, 'variant-images/KJUgJWX3CKOM5yAJyeHaF9zM3wP1GoIMahCvGNBk.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(317, 59, 4, 10, 23, 'variant-images/DE89IfMBH91p4EvGIYYUDqxYvZ4vJx7XH57z8Z1i.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(318, 59, 1, 9, 23, 'variant-images/MbpIyHODqjd6BEgSxaBnb8Lt8GKO0C9OvXuSgtGt.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(319, 59, 2, 9, 23, 'variant-images/G6KpLceiHBIsA8C4Fk75ZjYt4vZ0JyBRFZlON5Gb.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(320, 59, 3, 9, 23, 'variant-images/Orx0Wnduq5RWtmmyY24xXaZkO33IVf3q5EDZZCKV.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(321, 59, 4, 9, 23, 'variant-images/a9VA5APrWdfhpmmV6PskHucCyT4vLaAlazCzBAk9.png', NULL, '2025-07-25 11:41:35', '2025-07-25 11:41:35'),
(322, 60, 2, 2, 20, 'variant-images/8OtsKbYCx8AqcSiuOotrgYUkc9SzW17NjZzOwr6s.png', NULL, '2025-07-25 11:47:01', '2025-07-25 11:47:01'),
(323, 60, 3, 2, 20, 'variant-images/47XfgmX9J1FaJ2hjG70VJWJxQz0EB1tEDRSUWC6Z.png', NULL, '2025-07-25 11:47:01', '2025-07-25 11:47:01'),
(324, 60, 4, 2, 20, 'variant-images/R3d0Vfo2SF3UEY0B7mmWtl7rewlEK3AC5m701E0w.png', NULL, '2025-07-25 11:47:01', '2025-07-25 11:47:01'),
(325, 61, 1, 6, 40, 'variant-images/lv1KPO24PVaxkCAVLwQaMOq7vDWfQo4n7oc6WAtP.png', NULL, '2025-07-25 11:50:02', '2025-07-25 11:50:02'),
(326, 61, 2, 9, 40, 'variant-images/MTHgzmmXEwxtqISaTRPjerfkEeHVxmhfvAiwD7c8.png', NULL, '2025-07-25 11:50:02', '2025-07-25 11:50:02'),
(327, 61, 3, 6, 40, 'variant-images/ybZ200e8p3LxjW7rfrIOocbJzcaaBaepWRDYA22Y.png', NULL, '2025-07-25 11:50:02', '2025-07-25 11:50:02'),
(328, 61, 2, 6, 40, 'variant-images/QpijLhgXePN9J1eJjFDgn0K40X4ZWdITF0YrIGod.png', NULL, '2025-07-25 11:50:02', '2025-07-25 11:50:02'),
(329, 61, 1, 9, 40, 'variant-images/vfaiTN3Z1zZjR6eh0mQj8matlIlvjodNgvoajqZz.png', NULL, '2025-07-25 11:50:02', '2025-07-25 11:50:02'),
(330, 62, 1, 5, 23, 'variant-images/wtVHb5N1KDvwGIYogdrZ0UxnNvETWolNIl4rgxyZ.png', NULL, '2025-07-25 11:52:25', '2025-07-25 11:52:25'),
(331, 62, 1, 3, 23, 'variant-images/57abMjDlBE44KUZI24oWlZAc0nsINd5jsjlcfV1V.png', NULL, '2025-07-25 11:52:25', '2025-07-25 11:52:25'),
(332, 62, 2, 5, 23, 'variant-images/YSt4K0T5WlSUaiO381StZOKvchka3W4V7VBI4PQv.png', NULL, '2025-07-25 11:52:25', '2025-07-25 11:52:25'),
(333, 62, 2, 3, 23, 'variant-images/zYSrZdsL91uRLxafagHQaxOeXngc0ZZ2KZ5QH2gm.png', NULL, '2025-07-25 11:52:25', '2025-07-25 11:52:25'),
(334, 62, 3, 5, 23, 'variant-images/JNMUpcVs7c3j4dknpThfYUxpmvW6moTinhoiYRuo.png', NULL, '2025-07-25 11:52:25', '2025-07-25 11:52:25'),
(335, 62, 3, 3, 23, 'variant-images/lV9kEs1IUuKGo3uDz3kkjjRvdqvXB024H7B5lr8n.png', NULL, '2025-07-25 11:52:25', '2025-07-25 11:52:25'),
(336, 63, 1, 5, 56, 'variant-images/StMAK59FUdFArCsuj0lTI3BlIXEaPM63J1qSeqEj.png', NULL, '2025-07-25 11:54:38', '2025-07-25 11:54:38'),
(337, 63, 1, 1, 56, 'variant-images/JUIwybebZgBqgdaZFlLkZftn2Q9IazB6ZbMN79L5.png', NULL, '2025-07-25 11:54:38', '2025-07-25 11:54:38'),
(338, 63, 2, 5, 56, 'variant-images/SCNbvaileYA18Pjn4H9L0WO0rlhcJHO5rfB2oDQZ.png', NULL, '2025-07-25 11:54:38', '2025-07-25 11:54:38'),
(339, 63, 2, 1, 56, 'variant-images/4X9B58rSqllM5ZDmyAyh7DBOwXMEfkqNWZZrCHQB.png', NULL, '2025-07-25 11:54:38', '2025-07-25 11:54:38'),
(340, 64, 1, 5, 12, 'variant-images/VWdQrB4QFlOKtRHOjbKUF8RNQCHxPDkXxko87LEs.png', NULL, '2025-07-25 11:57:40', '2025-07-25 11:57:40'),
(341, 64, 1, 1, 12, 'variant-images/DbP5d9d63D2EWWijg1psQPJ6Y2DBPpvm5yEVjgQt.png', NULL, '2025-07-25 11:57:40', '2025-07-25 11:57:40'),
(342, 64, 2, 1, 12, 'variant-images/YMcEMuagKnmupZ7o4KskOpCqU9BcdW8YPRpkgsgn.png', NULL, '2025-07-25 11:57:40', '2025-07-25 11:57:40'),
(343, 64, 2, 5, 12, 'variant-images/I0UYJuSWJOFHxmaG9HdZzDJRvUDe3HXTlwf6lhve.png', NULL, '2025-07-25 11:57:40', '2025-07-25 11:57:40'),
(344, 64, 3, 1, 12, 'variant-images/JCVx76a1sFUBeME56SP8zueFg6LuqvACe1dJV3vT.png', NULL, '2025-07-25 11:57:40', '2025-07-25 11:57:40'),
(345, 64, 3, 5, 12, 'variant-images/PsSGQsobmk0OKE9UB8uUaAgZtY6gUVdiSlXNBmK7.png', NULL, '2025-07-25 11:57:40', '2025-07-25 11:57:40'),
(346, 65, 2, 1, 15, 'variant-images/5ObOpipkzzLgcHHxPsuXscd8bErzfL6R8s8eva1L.png', NULL, '2025-07-25 11:59:56', '2025-07-25 11:59:56'),
(347, 65, 2, 8, 15, 'variant-images/MMs9uIlwtXN3iuUzNbRt5j7n63sAkaI2ZwEWkqz4.png', NULL, '2025-07-25 11:59:56', '2025-07-25 11:59:56'),
(348, 65, 3, 1, 0, 'variant-images/YW7upVDUnVcjSRa8D5LNfoKHYmORQyhzxEbgkMpo.png', NULL, '2025-07-25 11:59:56', '2025-08-02 01:29:50'),
(349, 65, 3, 8, 15, 'variant-images/38UEWrxobUrM96lZEKBaqZWb117BohtKPWfC5Lut.png', NULL, '2025-07-25 11:59:56', '2025-07-25 11:59:56'),
(350, 66, 1, 7, 24, 'variant-images/pa5qWdyngqOfkmJiziYljIHeqKhkI1CL7QW4Ixdx.png', NULL, '2025-07-25 12:02:01', '2025-07-25 12:02:01'),
(351, 66, 1, 3, 24, 'variant-images/FkFXFoFFXJ9DUmW2dS7htGVpawxtwoQXryJTkHrJ.png', NULL, '2025-07-25 12:02:01', '2025-07-25 12:02:01'),
(352, 66, 2, 7, 24, 'variant-images/pTXIeS40szTlKJweXM7O4AwehQqe8NaU4LPhj9h6.png', NULL, '2025-07-25 12:02:01', '2025-08-06 16:44:53'),
(353, 66, 2, 3, 24, 'variant-images/Ay5LVjwmGxQ8QwS4OnwgiuQP7MzN7Czsv0VYdw8V.png', NULL, '2025-07-25 12:02:01', '2025-07-25 12:02:01'),
(354, 67, 1, 2, 33, 'variant-images/w19dNY2caEXXqOqgqGpA4cWj29WD3MQnvTqj0CdS.png', NULL, '2025-07-25 12:05:41', '2025-07-25 12:05:41'),
(355, 67, 1, 4, 33, 'variant-images/6c7ytq97vAL2Z89u17k9QJTQg8OHPuuvJmvxgN57.png', NULL, '2025-07-25 12:05:41', '2025-07-25 12:05:41'),
(356, 67, 2, 2, 33, 'variant-images/EtTcnS24o9T0Xw5DMlBvqeihTM8VObkxtcuPSs9n.png', NULL, '2025-07-25 12:05:41', '2025-07-25 12:05:41'),
(357, 67, 2, 4, 33, 'variant-images/HpXnKjFgrzwTPgAiliguow1UcHaXDTfguCQHUvEx.png', NULL, '2025-07-25 12:05:41', '2025-07-25 12:05:41'),
(358, 67, 3, 2, 33, 'variant-images/eqTU9K7JjIiuhURGD6wGeg09G0VNJg4Nm95M3vXm.png', NULL, '2025-07-25 12:05:41', '2025-07-25 12:05:41'),
(359, 67, 4, 4, 33, 'variant-images/HKSbJamFh8w9q9oihdVJCreAUScw3IXTvPGLEij1.png', NULL, '2025-07-25 12:05:41', '2025-07-25 12:05:41'),
(360, 68, 1, 8, 17, 'variant-images/LVv8UxXTrTVw6jlEAitjk387lyms3mUzF1cSTazY.png', NULL, '2025-07-25 12:08:14', '2025-07-25 12:08:14'),
(361, 68, 1, 9, 17, 'variant-images/0XpUQWLoYv3FY4vysH1hNBEZuxPjqZH3lJgPvjce.png', NULL, '2025-07-25 12:08:14', '2025-07-25 12:08:14'),
(362, 68, 2, 8, 17, 'variant-images/dVjxMZTgTnnnhsfO3KUInSy3uh0i0Y72VZspIvCc.png', NULL, '2025-07-25 12:08:14', '2025-07-25 12:08:14'),
(363, 68, 2, 9, 17, 'variant-images/7NYASWPMoeFFQZh6QZw8KcGeaNOonDtyegNJtr0D.png', NULL, '2025-07-25 12:08:14', '2025-07-25 12:08:14'),
(364, 68, 3, 8, 17, 'variant-images/obSbFkx2MEAiKpJHirbjBwtdaHAj2cYoDu3BqtI0.png', NULL, '2025-07-25 12:08:14', '2025-07-25 12:08:14'),
(365, 68, 3, 9, 17, 'variant-images/miu7u9EKL1uWbWmNkNG4pcB9OFZLRk3XS8VMoTiD.png', NULL, '2025-07-25 12:08:14', '2025-07-25 12:08:14'),
(366, 69, 1, 10, 14, 'variant-images/eLMoxP4SG1iguf2UuqF8iQfIwEJ95qOEUh8qgN1p.png', NULL, '2025-07-25 12:10:46', '2025-07-25 12:10:46'),
(367, 69, 1, 2, 14, 'variant-images/x6zsLrJtVJ2YBb75Kv49Wtee2vwZ8n7SBZwgk9TS.png', NULL, '2025-07-25 12:10:46', '2025-07-25 12:10:46'),
(368, 69, 2, 6, 14, 'variant-images/FfqcpejAjraRH4l90H0P3qemaTITBGl6nAAvaq27.png', NULL, '2025-07-25 12:10:46', '2025-07-25 12:10:46'),
(369, 69, 3, 10, 14, 'variant-images/qMekRlNW42m050uHfNAZLiRSKCtUt12jOz1TyNBS.png', NULL, '2025-07-25 12:10:46', '2025-07-25 12:10:46'),
(370, 70, 2, 2, 20, 'variant-images/78ntSF0w3wqwkaGeLRDKHKFtlhYzZz8sTmMRIljR.png', NULL, '2025-07-25 12:57:04', '2025-07-25 12:57:04'),
(371, 70, 2, 3, 20, 'variant-images/vnETSDnuD2IqDSvcB3Qohz0p3xV3cfBI7AJVBRkl.png', NULL, '2025-07-25 12:57:04', '2025-07-25 12:57:04'),
(372, 70, 3, 2, 20, 'variant-images/9U0oqD9y14dP6lWe5YzCBazSKwrg3cVlMwLT2XH2.png', NULL, '2025-07-25 12:57:04', '2025-07-25 12:57:04'),
(373, 70, 3, 3, 20, 'variant-images/ninVPj7mJiNGVe42lRc4cB4CS4r5MvAJRGosidrC.png', NULL, '2025-07-25 12:57:04', '2025-07-25 12:57:04'),
(374, 70, 4, 2, 20, 'variant-images/kYyz0YeMTO79Lzml6hVojZchmyifGu3VVwf8eJEA.png', NULL, '2025-07-25 12:57:04', '2025-07-25 12:57:04'),
(375, 70, 4, 3, 20, 'variant-images/SloUKAoia98cyLnGRaEAV5Udn3IivL3CIbFVd70s.png', NULL, '2025-07-25 12:57:04', '2025-07-25 12:57:04'),
(376, 71, 2, 1, 21, 'variant-images/AYXqOpNlJsblf352YCuAjrhNLGnM46Mo9jmy6Xme.png', NULL, '2025-07-25 12:58:54', '2025-07-25 12:58:54'),
(377, 71, 2, 5, 21, 'variant-images/XFsiyjwn2hr0iQAiFJvRhtKH1KPDlJNlH1Wnhqpw.png', NULL, '2025-07-25 12:58:54', '2025-07-25 12:58:54'),
(378, 71, 3, 1, 21, 'variant-images/49qeDtyKaEr67z8R4CsditZf1DWoJRO9mitq8pVC.png', NULL, '2025-07-25 12:58:54', '2025-07-25 12:58:54'),
(379, 71, 3, 5, 21, 'variant-images/FWOaiVHaeyb01mIzCtARMOlji4yHeqqKvPP3m1Kq.png', NULL, '2025-07-25 12:58:54', '2025-07-25 12:58:54'),
(380, 72, 1, 3, 21, 'variant-images/MIPxm06xeHjkv1F3Tc3CQcy85Fy5ziWqHRww4he9.png', NULL, '2025-07-25 13:00:39', '2025-07-25 13:00:39'),
(381, 72, 1, 6, 21, 'variant-images/KKaPV5Z0k91LQxFtNtgqrRTyJmOvtp65wFZ8g2pY.png', NULL, '2025-07-25 13:00:39', '2025-07-25 13:00:39'),
(382, 72, 2, 3, 21, 'variant-images/1Lt8cDSNKSHYL6i9WIlVv75qKrgOu13KO75vAMmO.png', NULL, '2025-07-25 13:00:39', '2025-07-25 13:00:39'),
(383, 72, 2, 6, 21, 'variant-images/AWTXyUoc1PA0hg5aBbCtk9czamebKVaImGreekGc.png', NULL, '2025-07-25 13:00:39', '2025-07-25 13:00:39'),
(384, 73, 1, 1, 51, 'variant-images/oRUCn1tPW41LypeJ2ZyvvOsEfMoXduzrtFwMZySa.png', NULL, '2025-07-25 13:04:26', '2025-07-25 13:04:26'),
(385, 73, 1, 8, 51, 'variant-images/DvKDVKa7izjUqvjSxVKEjILL0SL48HhT7oq1gbSo.png', NULL, '2025-07-25 13:04:26', '2025-07-25 13:04:26'),
(386, 73, 2, 1, 51, 'variant-images/oTFjeXP0Gbs91U92J3ChwvtobFOrzjYOLKGlXY2u.png', NULL, '2025-07-25 13:04:26', '2025-07-25 13:04:26'),
(387, 73, 2, 8, 51, 'variant-images/QGs2HMRh22wIcVsnTmjlRG3CUkNqWnzRIOHaoUdI.png', NULL, '2025-07-25 13:04:26', '2025-07-25 13:04:26'),
(388, 74, 1, 1, 19, 'variant-images/CKD8aFoO5gIAiu1yBRrWPjYvaDamh3915biwUm04.png', NULL, '2025-07-25 13:06:15', '2025-07-25 13:06:15'),
(389, 74, 1, 3, 19, 'variant-images/RdHvNhkI8ZUYMSTsn7TDJzUpdetXOD83DHuafOpf.png', NULL, '2025-07-25 13:06:15', '2025-07-25 13:06:15'),
(390, 74, 2, 1, 19, 'variant-images/NmxCOC1S7TqnQVihTuVfhs7r5S2J6DKzZCbsExR0.png', NULL, '2025-07-25 13:06:15', '2025-07-25 13:06:15'),
(391, 74, 2, 3, 19, 'variant-images/tAa8HLgOwRx1jE0nTM6H4yoRLIaUDdeOsNDcQzei.png', NULL, '2025-07-25 13:06:15', '2025-07-25 13:06:15'),
(392, 75, 2, 1, 22, 'variant-images/Uipk7FNbLVZP2LF1TZmuVBR86MNnNyGvptSgHP8i.png', NULL, '2025-07-25 13:08:03', '2025-07-25 13:08:03'),
(393, 75, 2, 9, 22, 'variant-images/GHTD8G1fInusqxIAg30nsrHtGk1C7EbpFd3ZeIbV.png', NULL, '2025-07-25 13:08:03', '2025-07-25 13:08:03'),
(394, 75, 3, 1, 22, 'variant-images/qZOwP5wCCS16weVVMzi8B4JsdmCIPEtnOqRTqPBj.png', NULL, '2025-07-25 13:08:03', '2025-07-25 13:08:03'),
(395, 75, 3, 9, 22, 'variant-images/vB7HhiA9FFAwYPhXi1L9kw05FpBbnGrGrZa6QCda.png', NULL, '2025-07-25 13:08:03', '2025-07-25 13:08:03'),
(396, 76, 1, 8, 24, 'variant-images/C0MQpYfpbOjztlmhh3awVWB1ACB9BdEes62KVxcD.png', NULL, '2025-07-25 13:10:09', '2025-07-25 13:10:09'),
(397, 76, 1, 7, 24, 'variant-images/khd3PQb0Jj8DOhkeVQyrVqc1b8aB7Fl2ssleZYQ8.png', NULL, '2025-07-25 13:10:09', '2025-07-25 13:10:09'),
(398, 76, 3, 8, 24, 'variant-images/FvmxeMT1EwkEezX1e0Oi6qXfqJwwx6MLvVFDgmEN.png', NULL, '2025-07-25 13:10:09', '2025-07-25 13:10:09'),
(399, 76, 3, 7, 24, 'variant-images/qT4sIeCddXov075GlOrZKgdAJxLlpIBVI7YqFiBQ.png', NULL, '2025-07-25 13:10:09', '2025-07-25 13:10:09'),
(400, 77, 1, 2, 23, 'variant-images/xXKQQQdGh5fsC9H8LbqbKEZ43mzYiQ6zAxR8kz8M.png', NULL, '2025-07-25 13:12:01', '2025-07-25 13:12:01'),
(401, 77, 2, 2, 23, 'variant-images/mvTpM0jyarFG73eATwn7daRL1vM0Jf3Xx36NHBId.png', NULL, '2025-07-25 13:12:01', '2025-07-25 13:12:01'),
(402, 77, 3, 2, 23, 'variant-images/8dCD32LwoUFH3sariaEyKqAtl0Z7tnJBF9xCBj2L.png', NULL, '2025-07-25 13:12:01', '2025-07-25 13:12:01'),
(403, 78, 2, 2, 13, 'variant-images/dldK2QNWOjy9WD1Vwgs6caOr67XI72idAPPOkBMF.png', NULL, '2025-07-25 13:14:01', '2025-07-25 13:14:01'),
(404, 78, 2, 9, 13, 'variant-images/c1aadi5xmeKaZLSKWsf06fNS9TUXBj7wfCsIOCUU.png', NULL, '2025-07-25 13:14:01', '2025-07-25 13:14:01'),
(405, 78, 3, 2, 13, 'variant-images/kuSmjKylxaRYHROz8OoTxHlcxSxkFzLW3H4cIEF2.png', NULL, '2025-07-25 13:14:01', '2025-07-25 13:14:01'),
(406, 78, 3, 9, 13, 'variant-images/SOFXNtgxkXfoVYVesvDz67MhkSRGvQWOAaGHfcGL.png', NULL, '2025-07-25 13:14:01', '2025-07-25 13:14:01'),
(407, 78, 4, 2, 13, 'variant-images/RKSKkrgSdYRVSFT8vXv34HhK0iR930IGjw3r5lfo.png', NULL, '2025-07-25 13:14:01', '2025-07-25 13:14:01'),
(408, 78, 4, 9, 13, 'variant-images/piJeGfRu9hxT35p70kPWrg5reqn8SqqIjRBI1okm.png', NULL, '2025-07-25 13:14:01', '2025-07-25 13:14:01'),
(409, 79, 2, 8, 14, 'variant-images/jzpX2dYjsdXqUJFoWkDSM42RP2MeMOjraBnwN4zC.png', NULL, '2025-07-25 13:16:03', '2025-07-25 13:16:03'),
(410, 79, 2, 3, 14, 'variant-images/iBO98ieApyM6lBLqrzDTUst9UCddAkWqKl20xCcL.png', NULL, '2025-07-25 13:16:03', '2025-07-25 13:16:03'),
(411, 79, 3, 8, 14, 'variant-images/IqAn76mNY7zhQ5ISMYmejdHoSxt4MkkQbBjsglIS.png', NULL, '2025-07-25 13:16:03', '2025-07-25 13:16:03'),
(412, 79, 3, 3, 14, 'variant-images/6inQpeGO5oczhmzNRp1YTQR08gTZzkxiQfBO7L0C.png', NULL, '2025-07-25 13:16:03', '2025-07-25 13:16:03'),
(413, 80, 1, 8, 23, 'variant-images/8ESaPKH9nhFxkPG0jeBIDF8jmpmkEGTIQLANFYWQ.png', NULL, '2025-07-25 13:18:44', '2025-07-25 13:18:44'),
(414, 80, 2, 2, 23, 'variant-images/TwXIzGfMUJ1bXkjCL2IG5hUAQL8kxkKOAaOtYOML.png', NULL, '2025-07-25 13:18:44', '2025-07-25 13:18:44'),
(415, 80, 2, 8, 23, 'variant-images/Sg4jlJg14XqBJDhuNNUH50KArfKghmSDdccDjG9M.png', NULL, '2025-07-25 13:18:44', '2025-07-25 13:18:44'),
(416, 80, 3, 2, 23, 'variant-images/J0XmAL4faeqgN6XftRBoYx1S8uMfz2nXOpZ59brS.png', NULL, '2025-07-25 13:18:44', '2025-07-25 13:18:44'),
(417, 80, 3, 8, 23, 'variant-images/mVNQuRt0qg2IOYAZKxZsP8WSYjAzpPdEtyvWMYbA.png', NULL, '2025-07-25 13:18:44', '2025-07-25 13:18:44'),
(418, 81, 1, 1, 25, 'variant-images/Nz3jd6amujo4pE4zW8BxaO55PkLiv8gOSsc96KtV.png', NULL, '2025-07-25 13:21:09', '2025-07-25 13:21:09'),
(419, 81, 2, 1, 25, 'variant-images/8am8TQSHE0EIXDCuiva7rPiPOYZT3iZr207jD3Sj.png', NULL, '2025-07-25 13:21:09', '2025-07-25 13:21:09'),
(420, 81, 2, 9, 25, 'variant-images/yDI7INtktDZYi0YzC0PtSldqcqTeYKhR6iX2xJ8c.png', NULL, '2025-07-25 13:21:09', '2025-07-25 13:21:09'),
(421, 81, 3, 2, 25, 'variant-images/eBXkDOoRBt2cptX89FhZgJwmionSKYrTsL2gBDUZ.png', NULL, '2025-07-25 13:21:09', '2025-07-25 13:21:09'),
(422, 81, 3, 9, 25, 'variant-images/xWmfdGyj63slVltMUdrBUyF48r83IqKB45cOOrqk.png', NULL, '2025-07-25 13:21:09', '2025-07-25 13:21:09'),
(423, 82, 2, 2, 22, 'variant-images/9ov45BROnQccff2MNfLTK5s9BMS3vVwIxKfKagU6.png', NULL, '2025-07-25 13:22:56', '2025-07-25 13:22:56'),
(424, 82, 2, 3, 22, 'variant-images/jeFfu8ITJ2mPxBVqeZtikcpNX47rEpkKNVSJTypp.png', NULL, '2025-07-25 13:22:56', '2025-07-25 13:22:56'),
(425, 82, 3, 2, 22, 'variant-images/NPC5W63PiKHTer2lTjuMQrjCbseJSZa3hw0HZzg9.png', NULL, '2025-07-25 13:22:56', '2025-07-25 13:22:56'),
(426, 82, 3, 3, 22, 'variant-images/gyznSx9ES0k6uyZhWxsLrwLlY7kBLWjFGU9dA6A6.png', NULL, '2025-07-25 13:22:56', '2025-07-25 13:22:56'),
(427, 83, 1, 2, 26, 'variant-images/6G0LvzJaKIINgMHQtPJAtg3eMRw8cJydcuRuKkXv.png', NULL, '2025-07-25 13:24:44', '2025-07-25 13:24:44'),
(428, 83, 1, 1, 26, 'variant-images/R7UOrbcNMBFUxw2hDqzl3pbI4NtOaoUICl8z36id.png', NULL, '2025-07-25 13:24:44', '2025-07-25 13:24:44'),
(429, 83, 2, 2, 26, 'variant-images/ATwc4bhNCbJpKtZ73BTEbSofw5yNHQLSUIgnOdfG.png', NULL, '2025-07-25 13:24:44', '2025-07-25 13:24:44'),
(430, 83, 2, 1, 26, 'variant-images/JVYetBumM0NReix1hOkFziZZ7jbVLO8v9KR3b2Rz.png', NULL, '2025-07-25 13:24:44', '2025-07-25 13:24:44'),
(431, 84, 1, 8, 27, 'variant-images/UKm5wiFjd0Em6kIQnPcblaEtVQPUrP1Xbi2d7RO0.png', NULL, '2025-07-25 13:26:31', '2025-07-25 13:26:31'),
(432, 84, 1, 5, 27, 'variant-images/njEKmXyig895mVGwm4HA8nWyQkazRNLckCPV1bNY.png', NULL, '2025-07-25 13:26:31', '2025-07-25 13:26:31'),
(433, 84, 2, 8, 27, 'variant-images/1pzNgOCz7LPPu46fYaCwXvr3c49MkJtY92S1XVpD.png', NULL, '2025-07-25 13:26:31', '2025-07-25 13:26:31'),
(434, 84, 2, 5, 27, 'variant-images/NAzfDP0B4PM5CL3SDXyssj7ShSEfFNLNXFLLKWzi.png', NULL, '2025-07-25 13:26:31', '2025-07-25 13:26:31'),
(435, 85, 2, 1, 28, 'variant-images/hHK7mgMssHL9I2RFD0fMGKdvKr14lIFO4nB7vk8B.png', NULL, '2025-07-25 13:28:17', '2025-07-25 13:28:17'),
(436, 85, 2, 8, 28, 'variant-images/RLm5tb2RwpQevlRFWDwTIjW4ob60vjAB5azlc4sN.png', NULL, '2025-07-25 13:28:17', '2025-07-25 13:28:17'),
(437, 85, 3, 1, 28, 'variant-images/D6buKesnYbk0Ujuwu9cxfKO4fmf9yrRJk0QtlaYA.png', NULL, '2025-07-25 13:28:17', '2025-07-25 13:28:17'),
(438, 85, 3, 8, 28, 'variant-images/y0nGfNq4914w01rDVgiTuOP5o1iXehiFDSpVrwi3.png', NULL, '2025-07-25 13:28:17', '2025-07-25 13:28:17'),
(439, 86, 1, 7, 29, 'variant-images/9KGH93mKbDRRzGAuVqmXVaThF4o9wExCZWVbtPv4.png', NULL, '2025-07-25 13:29:55', '2025-07-25 13:29:55'),
(440, 86, 1, 5, 29, 'variant-images/S6ckOHItRF2qMxbB2Z8ezl60FbgiEaruakU9NiWC.png', NULL, '2025-07-25 13:29:55', '2025-07-25 13:29:55'),
(441, 86, 2, 7, 29, 'variant-images/gKblm9CYHnX27N72jSjH7mDsg5iF7LVbQiYHTxvo.png', NULL, '2025-07-25 13:29:55', '2025-07-25 13:29:55'),
(442, 86, 2, 5, 29, 'variant-images/rmrkETJe46zWWllg9kcen6IV4LH6X9YXswY2UQyC.png', NULL, '2025-07-25 13:29:56', '2025-07-25 13:29:56'),
(443, 87, 1, 3, 29, 'variant-images/S4joNr4q4wKJjPiO5SbqFbmhMLqHGci5bveDUt3R.png', NULL, '2025-07-25 13:31:37', '2025-08-08 14:58:48'),
(444, 87, 1, 6, 30, 'variant-images/sfXWrOvmSesBvLACzbYjzvh6qiMp5zV8Xi3l6T5G.png', NULL, '2025-07-25 13:31:37', '2025-07-25 13:31:37'),
(445, 87, 2, 3, 30, 'variant-images/omBUz3m8J8awKnqdGjQZUuQztxiyyQWWVqzdUDng.png', NULL, '2025-07-25 13:31:37', '2025-07-25 13:31:37'),
(446, 87, 2, 6, 0, 'variant-images/BmmjMCLvgGl2wmvUodMJ9xvSCMkX2ZWzJkVuziPc.png', NULL, '2025-07-25 13:31:37', '2025-08-08 13:37:59'),
(447, 88, 2, 1, 31, 'variant-images/cZjO3czesi0b2PazJKU7Qy452euLC8WYN5hqfRJy.png', NULL, '2025-07-25 13:33:46', '2025-07-25 13:33:46'),
(448, 88, 2, 3, 31, 'variant-images/r7Q0fcut4Ifl0D9JU7LhfEW2VsGLBaPYLeaWcHfV.png', NULL, '2025-07-25 13:33:46', '2025-07-25 13:33:46'),
(449, 88, 3, 1, 31, 'variant-images/XnszklJdVpEyncJx3lqPV1dakCKujZCCETZNuFnJ.png', NULL, '2025-07-25 13:33:46', '2025-07-25 13:33:46'),
(450, 88, 3, 3, 0, 'variant-images/hd6WMqmEyDEoTlqkY33wUpiPuiMqndLbMYOieAcH.png', NULL, '2025-07-25 13:33:46', '2025-08-08 11:01:58'),
(451, 88, 4, 1, 31, 'variant-images/AdaSwwtfkM4s10BQ224d0e5FDrNQDd59LjQyKeZP.png', NULL, '2025-07-25 13:33:46', '2025-07-25 13:33:46'),
(452, 88, 4, 3, 30, 'variant-images/RjHhUu1rfA3fsmiL7QHxSBPVPSflc0wuOsnWF3JF.png', NULL, '2025-07-25 13:33:46', '2025-08-01 19:25:16'),
(453, 89, 1, 9, 32, 'variant-images/Uqu4pfLT0Ksg5ExpPhQH3cJuqhnupOvfKCBF6CZr.png', NULL, '2025-07-25 13:36:42', '2025-07-25 13:36:42'),
(454, 89, 1, 6, 32, 'variant-images/JM80wQl0o6ke3EPsZqZWmGlvR0j1eJQ8W71UQJWr.png', NULL, '2025-07-25 13:36:42', '2025-07-25 13:36:42'),
(455, 89, 2, 9, 32, 'variant-images/TWhfRmfdFLdcwWthQtPLsFvwpgoglgA2mL1qG2nK.png', NULL, '2025-07-25 13:36:42', '2025-07-25 13:36:42'),
(456, 89, 2, 6, 0, 'variant-images/k5xE3Tj34mxksqb5nxJtKh8iIkuB9lAhE9tS5qxG.png', NULL, '2025-07-25 13:36:42', '2025-08-06 18:55:22'),
(457, 90, 2, 8, 15, 'variant-images/wwIcxGYp60clcuVAbFwyTlEDhWapf5Y3TEhAPgTH.png', NULL, '2025-07-25 13:38:46', '2025-07-25 13:38:46'),
(458, 90, 3, 11, 15, 'variant-images/6ym4dPsCuzvdRdO3prZhLBude05AU8kdnRvyInt4.png', NULL, '2025-07-25 13:38:46', '2025-07-25 13:38:46'),
(459, 90, 3, 8, 14, 'variant-images/RnBplWcU6q6o6kZU4T4ZP88HyijQ5K5BVguZAWqA.png', NULL, '2025-07-25 13:38:46', '2025-08-06 17:02:47'),
(460, 90, 4, 11, 14, 'variant-images/0TUn2mXwaKacYbSa8xDgOI0BwusvqOVLxt2tmd3U.png', NULL, '2025-07-25 13:38:46', '2025-08-08 14:19:32'),
(461, 91, 1, 1, 37, 'variant-images/tqEy2KsntPLvMNkoWNmL1VmbQoPH9hy0lTHSYOrm.png', NULL, '2025-07-25 13:41:48', '2025-07-25 13:41:48'),
(462, 91, 1, 8, 37, 'variant-images/qwKNUyVd4zevofS6FEokVVNzPraPfWZIGI1iOne9.png', NULL, '2025-07-25 13:41:48', '2025-07-25 13:41:48'),
(463, 91, 1, 9, 37, 'variant-images/Vs0reyxBXCNlDQ6tJcp3dKgAEsvVym5hnC0i5Z8f.png', NULL, '2025-07-25 13:41:48', '2025-07-25 13:41:48'),
(464, 91, 2, 1, 37, 'variant-images/DMwi2DljkbsQx5vfc8d4RWhPH2bN0S33q6Jng8O7.png', NULL, '2025-07-25 13:41:48', '2025-07-25 13:41:48'),
(465, 91, 2, 8, 0, 'variant-images/Fko31RRtSH8ydo3qaIECFZwsiQtYmJ0b6UJ8wGpS.png', NULL, '2025-07-25 13:41:48', '2025-08-08 13:59:38'),
(466, 91, 2, 9, 37, 'variant-images/ZmCZHOXntnZ0QhkVdAlXpuKdGoFzqoK86x1gcPM8.png', NULL, '2025-07-25 13:41:48', '2025-07-25 13:41:48'),
(467, 91, 3, 1, 37, 'variant-images/IsIqA7zShlzRmgFNSoqplziVn8M0jVc14Cf1Bozz.png', NULL, '2025-07-25 13:41:48', '2025-07-25 13:41:48'),
(468, 91, 3, 8, 37, 'variant-images/1ykvU9Ezo5BuEZpkiMn77txdmRBnj0W3bPEortdn.png', NULL, '2025-07-25 13:41:48', '2025-07-25 13:41:48'),
(469, 91, 3, 9, 36, 'variant-images/WdXOq0T5xBTpa7lrEaYE08U45cf3aDvYnvVbR3GU.png', NULL, '2025-07-25 13:41:48', '2025-08-06 17:02:47'),
(470, 92, 1, 3, 37, 'variant-images/Zkf4sTs96CJV9tk745b0tzWzkycMijgTkeunFRgw.png', NULL, '2025-07-25 13:43:32', '2025-08-06 17:10:47'),
(471, 92, 1, 1, 38, 'variant-images/lfK18a3kcGFxpraX7AIOMHdrup6s8MiCAPdX4Z5w.png', NULL, '2025-07-25 13:43:32', '2025-08-06 16:58:44'),
(472, 92, 2, 3, 35, 'variant-images/su1znkya8WW2wRgL4DHcfbYq3V71gHuYsVn4o6RN.png', NULL, '2025-07-25 13:43:32', '2025-08-08 18:01:14'),
(473, 92, 2, 1, 0, 'variant-images/E6BtmOSOgYMpekjejTAzSbkDwxmQ9wyr2HoPuGCO.png', NULL, '2025-07-25 13:43:32', '2025-08-08 14:00:31'),
(474, 93, 1, 5, 39, 'variant-images/pu8vxza6T9wBbgKSuinHSgkce1cemKneSrtmLy3A.png', NULL, '2025-07-25 13:45:30', '2025-07-25 13:45:30'),
(475, 93, 1, 3, 39, 'variant-images/xJSGW0oTPaPrMzR3yLInkRkxRgNJU2DnsKeKEaTx.png', NULL, '2025-07-25 13:45:30', '2025-07-25 13:45:30'),
(476, 93, 2, 5, 39, 'variant-images/N54XWzJgeloSCM263v6zfm9QSxIUkcrnUA2FYWRN.png', NULL, '2025-07-25 13:45:30', '2025-07-25 13:45:30'),
(477, 93, 2, 3, 31, 'variant-images/aHYoKJ4oz3m3rDSE55X8r0O50g455xHEdevzYbqd.png', NULL, '2025-07-25 13:45:30', '2025-08-08 14:15:21'),
(478, 94, 1, 2, 1, 'variant-images/NF4IHufzZ4P2mRlnAacBAiEr8Pf95vrvXtz0QeEq.png', NULL, '2025-07-25 13:47:20', '2025-08-06 15:21:23'),
(479, 94, 2, 2, 0, 'variant-images/F2ajLtwvtp47ZL1BMdOIfQUK9LgP9mvZMe1eyZk5.png', NULL, '2025-07-25 13:47:20', '2025-08-06 18:37:13'),
(480, 94, 3, 2, 34, 'variant-images/xzHdk2qou9pvVzRvWy5qLDuZZS7WxUCkWabsVXgL.png', NULL, '2025-07-25 13:47:20', '2025-07-25 13:47:20'),
(481, 95, 2, 6, 0, 'variant-images/DWIfFNkqqYOrCg4LPgi20bhnHRiNDozZYr9o3E22.png', NULL, '2025-07-25 13:49:12', '2025-08-08 13:58:25');
INSERT INTO `product_variants` (`id`, `product_id`, `size_id`, `color_id`, `stock`, `image`, `price`, `created_at`, `updated_at`) VALUES
(482, 95, 2, 2, 0, 'variant-images/gWoT7KfbkOmruANcCVIl7Z5z2oZstKy9N6Bxqfzv.png', NULL, '2025-07-25 13:49:12', '2025-08-06 17:53:53'),
(483, 95, 3, 6, 31, 'variant-images/w80h6pIIYJPMvu9cCYq2CO5mkX2I3aS1VCyRFNbE.png', NULL, '2025-07-25 13:49:12', '2025-08-08 14:19:32'),
(484, 95, 3, 2, 0, 'variant-images/0iWb4cl1Fq7J0yRZ71dOVAGlEYRYc3yX1tO99Og5.png', NULL, '2025-07-25 13:49:12', '2025-08-06 18:30:53'),
(485, 96, 2, 2, 0, 'variant-images/lm17bYAwc3rnX7f6qDEMsDixPeFgKu5rzhpwxHAY.png', NULL, '2025-07-25 13:50:39', '2025-08-05 14:06:41'),
(486, 96, 2, 8, 0, 'variant-images/bQhlAvkyoaUa1zQaf8Oi0KLqYKaucHwrfG5ts1f7.png', NULL, '2025-07-25 13:50:39', '2025-08-05 14:06:41'),
(487, 96, 3, 2, 0, 'variant-images/4CwXTHE0MCbLhqUFpQrzm7DrGy6D1pDHDsOQ4q38.png', NULL, '2025-07-25 13:50:39', '2025-08-08 13:52:29'),
(488, 96, 3, 8, 0, 'variant-images/d6KlmGMaHimEkyYeTufuuyZfZO80SpaD8E5KaRyS.png', NULL, '2025-07-25 13:50:39', '2025-08-05 14:06:41'),
(489, 97, 1, 8, 0, 'variant-images/zT5Gi3wcVP5K00DEHNzoZ4COIJn8kGK1iqKebXGO.png', NULL, '2025-07-25 13:53:29', '2025-08-05 14:56:56'),
(490, 97, 2, 8, 1, 'variant-images/JYRViAJ396eFHfysdg7lBgVxFgMOPrtUPMyxivic.png', NULL, '2025-07-25 13:53:29', '2025-08-08 13:40:45'),
(491, 97, 3, 8, 0, 'variant-images/EvsftfwoV4vFYiCyEMJlPw3Oqrtj8ccEZuvrXKXv.png', NULL, '2025-07-25 13:53:29', '2025-08-05 14:57:10'),
(492, 97, 4, 8, 38, 'variant-images/xh9iM5HoS3OXUw9I1L1LRFR5pO5LHRHsvIbBQuLc.png', NULL, '2025-07-25 13:53:29', '2025-08-01 19:15:59'),
(493, 98, 1, 2, 0, 'variant-images/KaFfylEFBJi1FrSAPMLsaCmYtYlYfvdbFvB5AoiT.png', NULL, '2025-07-25 13:55:51', '2025-08-02 01:25:44'),
(494, 98, 1, 6, 0, 'variant-images/2cY6nrNqPtxuinKUz4X3SAQnuqYZujWnTUE3llwR.png', NULL, '2025-07-25 13:55:51', '2025-08-02 01:25:44'),
(495, 98, 2, 2, 1, 'variant-images/V7yU3rF5cz13dfKfOI81AnIy70AJdlJ4fqPFykGw.png', NULL, '2025-07-25 13:55:51', '2025-08-02 01:25:44'),
(496, 98, 2, 6, 1, 'variant-images/2UrKevQgiJkxbI3P8RNtFNpU3nVjpZp6obOBGlOI.png', NULL, '2025-07-25 13:55:51', '2025-08-02 01:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original_bank_name` varchar(255) DEFAULT NULL,
  `original_account_number` varchar(255) DEFAULT NULL,
  `original_account_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2j44PDUF1RjWaXNrHHm6kCX4IsI9oo5IfeKfXxzQ', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSFVQcHQwR2x1dHNBTEg5NE9sM1Z0ZmlndFNzanNGNU10VTRDQzJhOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvcHJvZHVjdHMvZGV0YWlsL2Zhdmljb24ucG5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2NsaWVudC9jYXJ0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1755609454),
('lo61erEZoNLSwhaje7btzSkl2oucOQ5AmvqBfBMy', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoidk5Rb0pnVFpmSllEU1dWa3Zqa3UyY0xlWEZES0hZWkZ0ZnUzNThpMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvY2FydCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO3M6MTQ6InNlbGVjdGVkX2l0ZW1zIjtzOjU6Ijg4LDg5IjtzOjEwOiJjYXJ0X3RvdGFsIjtkOjI0ODUwMDtzOjEyOiJzaGlwcGluZ19mZWUiO2k6MzAwMDA7czoxMToiZmluYWxfdG90YWwiO2Q6MjQ4NTAwO3M6MTk6ImZpbmFsX3dpdGhfc2hpcHBpbmciO2Q6Mjc4NTAwO30=', 1754676108),
('LoYS5tEHT1erKpZJlLCoUaz7Aygak3MxLdCkOV6y', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZzdjN0VjOWlrbFRIdU1LU2cyUFhORGVJamRLZXprWWZkNHRRdUd3SCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Byb2R1Y3QvaW5kZXgiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1754733590),
('mVi23NW5PqAAQP74u096W4kQHwPV4BtPb71TJRkP', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV0ZLVlhncGlvYzRMU0RzQmdEdUo0VFVWMVpRbEh6Tnc4cFMwOUlaTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjExO30=', 1755612032),
('R05Jmc2FPL6Xqbqp0CKrVgnrfzk0wnb805FH6qwq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkcxVVVyRG1GQXdOeWpOTUdWZkRjSzNQd0xGTDEyNFNya0Fmdzl2VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1754811375);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'S', NULL, NULL),
(2, 'M', NULL, NULL),
(3, 'L', NULL, NULL),
(4, 'Xl', NULL, NULL),
(5, 'XXL', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'New', NULL, NULL, NULL),
(2, 'Hot', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL DEFAULT 'other',
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1: Admin, 2: User, 3: Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `gender`, `avatar`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `role`) VALUES
(1, 'thiennguyen', 'thiennvph38294@fpt.edu.vn', NULL, '$2y$12$d.yzlfMWxWRyss41pXfUR.zji0NAOB1c.w5TZNxgFITBzMmHBgSlO', '034572006', 'Lục Ngạn - Bắc Giang', 'other', NULL, NULL, '2025-06-06 09:16:27', '2025-06-06 09:16:27', NULL, 1),
(2, 'manh', 'manh@gmail.com', NULL, 'e5076524b519ce461222e5f2ac664da0', NULL, 'ha noi', 'other', NULL, NULL, '2025-06-07 09:24:01', '2025-07-14 15:14:26', NULL, 2),
(3, 'Nguyen Than Thien', 'viettel555111@gmail.com', NULL, '$2y$12$pKjWGX0QrwhByRoaCuYGoOlHRt2nudz1XZrINivEPYJa8nFiemH2G', '0987654321', 'Lục Ngạn - Bắc Giang', 'other', '', NULL, '2025-06-13 09:31:12', '2025-07-15 14:04:24', NULL, 3),
(4, 'chien', 'chien@gmail.com', NULL, '$2y$12$yn5btkojeGWQg5CruLFtk.iOXxWTg.Y7I9iy5KeOQ89P9v5u2B9ji', '03232323', 'lang son', 'other', 'avatars/7bZeFCVJ8WfEez0Nbb0tgs6TgDWy6HpoV5srsuj6.jpg', NULL, '2025-06-26 09:05:01', '2025-08-01 16:02:03', NULL, 1),
(5, 'ha', 'ha@gmail.com', NULL, '$2y$12$D9xgw5ackRGJCgfpXTZFUu5JqixFwiYlb08LxQdAw0zAhuwQwGhG6', '02355888888', 'Hà Nội', 'other', NULL, NULL, '2025-07-02 17:09:22', '2025-07-02 17:42:12', NULL, 1),
(6, 'long', 'long@gmail.com', NULL, '$2y$12$jnNPdtgVD2Eg1.IzPGcKyuxSo3Spxfy6SwaspFuR7Kt3d6KMfVAHu', NULL, NULL, 'other', NULL, NULL, '2025-07-02 18:58:41', '2025-07-14 15:25:00', NULL, 3),
(7, 'lanh', 'lanh@gmail.com', NULL, '$2y$12$vTH7Hovfuaovog6u9FZXjOX5vNvkr0VVQ8Jj83/cMXIDanAQJAxN2', '03535532', 'ha noi', 'other', NULL, NULL, '2025-07-02 21:13:10', '2025-07-02 21:25:31', NULL, 2),
(8, 'lan', 'lan@gmail.com', NULL, '$2y$12$KVNxTbUyxkGicMaZj6vg4e9YpEZKbSyysRZZL.0NMT4G7.CTd7eoG', '03232222222', 'ha noi', 'other', NULL, NULL, '2025-07-03 00:58:22', '2025-07-09 03:12:21', NULL, 3),
(9, 'Nguyen Than Thien', 'viettel5551111@gmail.com', NULL, '$2y$12$q9QdJhKjwxMwAyIU76IjOeasOm8MsjssVCkO1xwN.Q8.hdqd29Vzm', '0987654321', 'Lục Ngạn - Bắc Giang', 'other', NULL, NULL, '2025-07-10 16:13:19', '2025-07-14 15:09:30', NULL, 1),
(10, 'duong', 'ht232425duong@gmail.com', NULL, '$2y$12$BGJdvuRZkR9k/9yIzHmrQ.362/ndVeSBu6Pqnxpdf9StvaBhwfIo6', '0349043276', '29 abc', 'other', NULL, NULL, '2025-07-16 15:58:14', '2025-08-01 18:08:29', NULL, 1),
(11, 'Dương', 'duongnnph40648@fpt.edu.vn', NULL, '$2y$12$u/p2CyVKNliJVeaNp5d2BuCLtKpE/64gry6MvBa6G0ryxfGu0UIX2', '0388728681', '1 a', 'other', 'avatars/qzRRW4XsNkcvU6F0PMFERLyIEPMdlPjwnz6Qdadl.png', NULL, '2025-08-01 18:08:56', '2025-08-01 18:09:41', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_coupons`
--

INSERT INTO `user_coupons` (`id`, `user_id`, `coupon_id`, `used_at`, `created_at`, `updated_at`) VALUES
(1, 10, 25, '2025-08-01 18:05:57', '2025-08-01 18:05:57', '2025-08-01 18:05:57'),
(2, 10, 24, '2025-08-01 19:13:21', '2025-08-01 19:13:21', '2025-08-01 19:13:21'),
(3, 11, 25, '2025-08-02 00:53:23', '2025-08-02 00:53:23', '2025-08-02 00:53:23'),
(6, 11, 22, '2025-08-06 17:07:30', '2025-08-06 17:07:30', '2025-08-06 17:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_variant_id_foreign` (`product_variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  ADD KEY `orders_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_variant_id_foreign` (`product_variant_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pending_orders_txn_ref_unique` (`txn_ref`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_order_item_id_foreign` (`order_item_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`),
  ADD KEY `product_variants_size_id_foreign` (`size_id`),
  ADD KEY `product_variants_color_id_foreign` (`color_id`);

--
-- Indexes for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refund_requests_order_id_foreign` (`order_id`),
  ADD KEY `refund_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_order_id_foreign` (`order_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_coupons_user_id_foreign` (`user_id`),
  ADD KEY `user_coupons_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`),
  ADD KEY `wallet_transactions_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=497;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cart_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_variants_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD CONSTRAINT `refund_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refund_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD CONSTRAINT `user_coupons_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_coupons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
