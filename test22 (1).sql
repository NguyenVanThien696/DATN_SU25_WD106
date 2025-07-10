-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 10, 2025 lúc 05:12 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test22`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `position` enum('homepage','category','product','custom') NOT NULL DEFAULT 'homepage',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
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
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Áo', '', NULL, NULL),
(2, 'Quần', '', NULL, NULL),
(3, 'Nam', NULL, NULL, NULL),
(4, 'Nữ', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Đen', '#000000', NULL, NULL),
(2, 'Xanh', '#0000FF', NULL, NULL),
(3, 'Trắng', '#FFFFFF', NULL, NULL),
(4, 'Đỏ', '#FF0000', NULL, NULL),
(5, 'Be', '#FFCC66', NULL, NULL),
(6, 'Nâu', '#8B4513', NULL, NULL),
(7, 'Vàng', '#FFFF00', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `discount_percent` int(11) DEFAULT NULL,
  `discount_amount` int(11) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','expired') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_percent`, `discount_amount`, `expires_at`, `start_at`, `end_at`, `usage_limit`, `used`, `status`, `created_at`, `updated_at`) VALUES
(11, 'HRAJKFANCA', 'percent', 10, NULL, NULL, '2025-07-03 03:50:00', '2025-07-27 03:50:00', 10, 0, 'active', '2025-07-03 20:50:56', '2025-07-03 20:50:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `jobs`
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
-- Cấu trúc bảng cho bảng `job_batches`
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
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
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
(49, '2025_07_09_103126_update_coupons_add_more_fields', 24);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_price` decimal(10,0) NOT NULL DEFAULT 0,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','confirmed','processing','completed','cancelled','cancelled_paid','refunded','delivery_failed') NOT NULL DEFAULT 'pending',
  `payment_method` enum('cod','bank','momo','vnpay') NOT NULL DEFAULT 'cod',
  `payment_status` enum('unpaid','paid','failed','refunded') NOT NULL DEFAULT 'unpaid',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `shipping_address_id`, `total_price`, `shipping_fee`, `discount`, `status`, `payment_method`, `payment_status`, `note`, `created_at`, `updated_at`) VALUES
(1, 'DH0339040720259W8J', 4, NULL, 529000, 30000.00, 0, 'completed', 'cod', 'unpaid', NULL, '2025-07-03 20:39:27', '2025-07-04 00:04:56'),
(2, 'DH034404072025APZF', 7, NULL, 3269700, 0.00, 363300, 'cancelled', 'cod', 'unpaid', NULL, '2025-07-03 20:44:51', '2025-07-03 20:47:43'),
(3, 'DH035104072025KTF2', 7, NULL, 389100, 30000.00, 39900, 'refunded', 'vnpay', 'refunded', NULL, '2025-07-03 20:52:23', '2025-07-03 20:56:24'),
(4, 'DH122405072025WT9Q', 4, NULL, 529000, 30000.00, 0, 'processing', 'cod', 'unpaid', NULL, '2025-07-05 05:24:19', '2025-07-08 04:02:19'),
(5, 'DH2200050720256KEH', 4, NULL, 529000, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-05 15:00:50', '2025-07-05 15:03:50'),
(6, 'DH230905072025FKM6', 4, NULL, 1278000, 0.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-05 16:09:43', '2025-07-05 16:21:45'),
(7, 'DH213707072025XCFT', 5, NULL, 529000, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-07 14:37:16', '2025-07-07 14:43:17'),
(8, 'DH214507072025VXRW', 5, NULL, 1278000, 0.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-07 14:45:34', '2025-07-07 14:47:14'),
(9, 'DH215207072025DGYA', 4, NULL, 529000, 30000.00, 0, 'completed', 'cod', 'unpaid', NULL, '2025-07-07 14:52:07', '2025-07-07 14:52:42'),
(10, 'DH220807072025U6DN', 4, NULL, 410000, 30000.00, 0, 'completed', 'cod', 'paid', NULL, '2025-07-07 15:08:04', '2025-07-08 03:55:31'),
(11, 'DH070609072025QMBT', 4, NULL, 410000, 30000.00, 0, 'processing', 'cod', 'unpaid', NULL, '2025-07-09 00:06:43', '2025-07-09 00:07:06'),
(12, 'DH072509072025GPSH', 4, NULL, 529000, 30000.00, 0, 'confirmed', 'cod', 'unpaid', NULL, '2025-07-09 00:25:59', '2025-07-09 00:36:37'),
(13, 'DH073709072025LBVH', 4, NULL, 529000, 30000.00, 0, 'pending', 'vnpay', 'paid', NULL, '2025-07-09 00:37:52', '2025-07-09 00:37:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_variant_id`, `quantity`, `price`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 98, 1, 499000.00, NULL, '2025-07-03 20:39:27', '2025-07-03 20:39:27'),
(2, 2, 98, 3, 499000.00, NULL, '2025-07-03 20:44:51', '2025-07-03 20:44:51'),
(3, 2, 99, 2, 399000.00, NULL, '2025-07-03 20:44:51', '2025-07-03 20:44:51'),
(4, 2, 100, 2, 669000.00, NULL, '2025-07-03 20:44:51', '2025-07-03 20:44:51'),
(5, 3, 99, 1, 399000.00, NULL, '2025-07-03 20:52:23', '2025-07-03 20:52:23'),
(6, 4, 98, 1, 499000.00, NULL, '2025-07-05 05:24:19', '2025-07-05 05:24:19'),
(7, 5, 98, 1, 499000.00, NULL, '2025-07-05 15:00:50', '2025-07-05 15:00:50'),
(8, 6, 103, 1, 380000.00, NULL, '2025-07-05 16:09:43', '2025-07-05 16:09:43'),
(9, 6, 101, 1, 499000.00, NULL, '2025-07-05 16:09:43', '2025-07-05 16:09:43'),
(10, 6, 99, 1, 399000.00, NULL, '2025-07-05 16:09:43', '2025-07-05 16:09:43'),
(11, 7, 98, 1, 499000.00, NULL, '2025-07-07 14:37:16', '2025-07-07 14:37:16'),
(12, 8, 101, 1, 499000.00, NULL, '2025-07-07 14:45:34', '2025-07-07 14:45:34'),
(13, 8, 103, 1, 380000.00, NULL, '2025-07-07 14:45:34', '2025-07-07 14:45:34'),
(14, 8, 99, 1, 399000.00, NULL, '2025-07-07 14:45:34', '2025-07-07 14:45:34'),
(15, 9, 101, 1, 499000.00, NULL, '2025-07-07 14:52:07', '2025-07-07 14:52:07'),
(16, 10, 103, 1, 380000.00, NULL, '2025-07-07 15:08:04', '2025-07-07 15:08:04'),
(17, 11, 103, 1, 380000.00, NULL, '2025-07-09 00:06:43', '2025-07-09 00:06:43'),
(18, 12, 101, 1, 499000.00, NULL, '2025-07-09 00:25:59', '2025-07-09 00:25:59'),
(19, 13, 101, 1, 499000.00, NULL, '2025-07-09 00:37:52', '2025-07-09 00:37:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pending_orders`
--

CREATE TABLE `pending_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `txn_ref` varchar(255) NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `note` text DEFAULT NULL,
  `user_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`user_info`)),
  `cart_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cart_items`)),
  `total_price` int(11) NOT NULL,
  `discount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `shipping_fee` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tag_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `brand_id`, `created_at`, `updated_at`, `tag_id`) VALUES
(8, 'aso 1', 'raast ddejp', 120000.00, 'uploads/JSwCqK3o0AE1nAgvEh1p7vDVUQSpyyyBRonIFSY4.png', 1, 1, NULL, '2025-06-05 22:44:09', NULL),
(9, 'aso 1', 'raast ddejp', 120000.00, 'uploads/E3pA7wxHuWfO39lH7DomTLaZRK6smjgPkDUuk7gl.png', 1, 1, NULL, '2025-06-05 22:43:52', NULL),
(10, 'Floral Heart Tee - Áo thun', 'Áo thun mang phong cách trẻ trung, năng động, nổi bật với họa tiết trái tim được tạo hình đen đan xen đầy nghệ thuật. \r\n\r\nChất liệu cotton mềm mại, thoáng mát, thấm hút mồ hôi tốt, phù hợp cho các hoạt động thường ngày hoặc những buổi dạo phố mùa hè.\r\n\r\nThiết kế cổ tròn, tay ngắn basic dễ mặc, dễ phối đồ với nhiều item khác như quần jean, short, chân váy.', 325000.00, 'uploads/JUuxOIW0LG35jxjo90iebb5jZSkI2NWTaFNbzmMt.png', 4, 4, NULL, '2025-06-06 03:01:51', NULL),
(11, 'Áo sơ mi tay dài nam linen cotton.Regular', NULL, 540000.00, 'uploads/zGFaDseuehmok8vkHUOiRt9ikSxHG5nbIiB1tQH0.png', 3, 6, NULL, '2025-06-06 02:57:11', NULL),
(12, 'Bún đậu nước mắm', 'Rất đẹp', 123456.00, 'uploads/TOlSZfU7NZUaLeFlKf57xqxWcFIFd8gO3k1gv3DJ.png', 2, 2, '2025-06-05 06:40:33', '2025-06-05 22:44:25', NULL),
(13, 'Áo Phao Xanhh', 'ok', 650000.00, 'uploads/0LJ540MSfLRRPecmwuxUf7G8WpGyBoJn5QpVfjg1.png', 2, 2, '2025-06-05 08:55:09', '2025-06-05 22:43:23', NULL),
(14, 'Áo Hoodie Yoguu Tay Tháo Rời', 'Một sản phẩm phá cách mới ra mắt: Áo hoodie unisex có tay tháo rời. Thiết kế trẻ trung, linh hoạt, đa dạng cách sử dụng vô cùng thú vị. Chất vải dày dặn, đanh chắc, không bai dão và ít xù đem lại độ bền bỉ, ấm áp cho chiếc áo này.', 669000.00, 'uploads/QIrGfDZ8uBjiZSb2TLp6d8lEwH9D1OWhRR0ggocZ.png', 2, 2, '2025-06-05 10:31:49', '2025-06-06 02:57:51', NULL),
(15, 'Áo T-shirt - TSN253671', 'Áo thun kiểu dáng body fit tôn dáng người mặc.\r\nMàu sắc trẻ trung, năng động.\r\nChất liệu: 57% Cotton, 38% Polyester, 5% Spandex', 395000.00, 'uploads/bQPZILeKCbd49cm6JFlZ1owgox3BIpDTERPVmLQQ.png', 3, 1, '2025-06-05 10:41:05', '2025-06-06 02:52:37', NULL),
(16, 'Bộ quần áo nam', 'Set quần áo nam được làm bằng chất liệu waffle, thiết kế trẻ trung năng động phù hợp với nhiều hoàn cảnh mặc khác nhau. Bo cổ dệt kẻ phối màu, quần thiết kế can phối phong cách thể thao khỏe khoắn.', 799000.00, 'uploads/WljPD8TjyC94QXOU8X4jrFPM4EJSnw4r5LzBnk04.png', 3, 1, '2025-06-05 11:04:35', '2025-06-06 02:46:32', NULL),
(17, 'T-shirt Nữ Ôm Cổ Cao Croptop', 'Chất liệu Single Bamboo mềm mại thoáng mát, thấm hút mồ hôi tốt, thân thiện với làn da và an toàn cho người sử dụng. Sợi tre tự nhiên co giãn đàn hồi, giữ form lâu dài mang đến trải nghiệm thoải mái, tự tin và phong cách cho phái đẹp. Chất liệu bền bỉ, ít nhăn nhàu, dễ giặt ủi.', 99000.00, 'uploads/Nekvq7RioDGc3pV355MZPmcpG7CViHcbZ74aGEVi.png', 4, 2, '2025-06-05 11:07:31', '2025-06-06 02:44:00', NULL),
(18, 'Áo Hoodie Yoguu Tay Tháo Rời', 'Một sản phẩm phá cách mới ra mắt: Áo hoodie unisex có tay tháo rời. Thiết kế trẻ trung, linh hoạt, đa dạng cách sử dụng vô cùng thú vị. Chất vải dày dặn, đanh chắc, không bai dão và ít xù đem lại độ bền bỉ, ấm áp cho chiếc áo này', 669000.00, 'uploads/kC0Tm2XAe5xMszztFsTy0rg9TK6LE5LUJvJgQfuc.png', 4, 2, '2025-06-05 11:09:11', '2025-07-03 20:42:29', 1),
(19, 'Set Áo Sơ Mi Cổ Tàu Tay Chuông', 'Co giãn linh hoạt: Đàn hồi tốt, mang lại sự thoải mái khi vận động.\r\nSiêu nhẹ & thoáng khí: Giúp người mặc luôn cảm thấy nhẹ nhàng, dễ chịu.\r\nMềm mại êm ái: Chất vải mịn màng, dịu nhẹ trên da.', 399000.00, 'uploads/GSquXJy5PJRnNtWAJtdESZx7BuaF2TIpYfiCVztr.png', 4, 2, '2025-06-05 11:09:59', '2025-07-02 21:03:35', 1),
(20, 'Vest Nữ Gile Cúc Bọc Túi Cơi', 'Vest gile nữ với chất liệu double face kim cương độc đáo, không nhăn, không xù. Vải co giãn nhẹ tạo cảm giác thoải mái. Thiết kế túi cơi tiện dụng tôn lên vẻ đẹp hiện đại, thanh lịch. Là sự lựa chọn hoàn hảo cho những quý cô sành điệu.', 499000.00, 'uploads/0si2M5OJQqnfKUO7QrBcpV5zK1p23fQtD0WqhoQ0.png', 4, 2, '2025-06-05 12:02:29', '2025-06-17 06:30:21', 1),
(25, 'Áo Phông Thun Rib Họa Tiết', 'Co giãn & đàn hồi: Mang lại sự linh hoạt, thoải mái khi vận động.\r\nBền bỉ & giữ phom: Không bai dão, hạn chế nhăn nhàu, luôn gọn gàng.\r\nThân thiện với da: Chất liệu mềm mại, không gây ngứa, dễ chịu khi mặc.', 380000.00, 'uploads/3e279ed4c388b3be16807915f4abfbc0.jpg', 4, 3, '2025-07-04 21:18:21', '2025-07-04 21:18:21', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_reviews`
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
-- Đang đổ dữ liệu cho bảng `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `order_item_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 4, 20, NULL, 5, 'sản phẩm tốt', '2025-07-01 02:19:56', '2025-07-01 02:19:56'),
(2, 4, 20, NULL, 5, 'jadjada', '2025-07-05 14:37:18', '2025-07-05 14:37:18'),
(3, 4, 20, NULL, 5, 'sản phẩm chất lượng', '2025-07-05 15:34:57', '2025-07-05 15:34:57'),
(4, 4, 20, NULL, 5, '231131', '2025-07-05 15:47:38', '2025-07-05 15:47:38'),
(5, 4, 20, 1, 5, 'tốt', '2025-07-05 15:58:32', '2025-07-05 15:58:32'),
(6, 4, 20, 7, 5, '131231231', '2025-07-05 15:59:52', '2025-07-05 15:59:52'),
(7, 4, 20, 9, 5, 'tốtttttt', '2025-07-07 14:53:09', '2025-07-07 14:53:09'),
(8, 4, 20, 15, 5, 'chiến', '2025-07-07 15:07:00', '2025-07-07 15:07:00'),
(9, 4, 25, 8, 5, 'sản phẩm tốt', '2025-07-07 15:22:38', '2025-07-07 15:22:38'),
(10, 4, 25, 16, 5, 'sản phẩm tốt', '2025-07-07 15:22:55', '2025-07-07 15:22:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
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
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size_id`, `color_id`, `stock`, `image`, `price`, `created_at`, `updated_at`) VALUES
(98, 20, 1, 1, 0, 'uploads/2e1e854cb9b2215fd3f10a5fa0fb3afb.jpg', NULL, '2025-07-03 08:49:43', '2025-07-07 14:37:16'),
(99, 19, 1, 1, 2, NULL, NULL, '2025-07-03 20:42:11', '2025-07-07 14:45:34'),
(100, 18, 1, 1, 50, NULL, NULL, '2025-07-03 20:42:29', '2025-07-03 20:47:43'),
(101, 20, 1, 5, 15, 'uploads/110f813dbc4a8ba5fbbfa743f2ea3cf7.jpg', NULL, '2025-07-04 19:50:58', '2025-07-09 00:37:52'),
(102, 20, 1, 6, 30, 'uploads/0si2M5OJQqnfKUO7QrBcpV5zK1p23fQtD0WqhoQ0.png', NULL, '2025-07-04 19:52:43', '2025-07-04 19:52:43'),
(103, 25, 1, 1, 26, 'variants/JtierSyS1L0TpcSQigYIgG6GrjtZYgheVAM9UEh8.png', NULL, '2025-07-04 21:18:22', '2025-07-09 00:06:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
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
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cwm9P3T3IPLl3pqMJfI6a74eeQNYx9t4fdyFsj1C', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGNZY3k5cHF3VHZneW5Ba2tHUWt3dklHWmlSbUl4TTZtSnhUVVlSdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1752030761),
('dfEJMOFVVdVvW6A8bmZuKKbsCwhfr5mZUbagiYor', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQlU2dzFVMHBjakZ3T1pZM2hhSktCeE1xRGVSeEdWQmFCUERYNFM0WSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi92b3VjaGVycy9jcmVhdGUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1752030923);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping_addresses`
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
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'S', NULL, NULL),
(2, 'M', NULL, NULL),
(3, 'L', NULL, NULL),
(4, 'Xl', NULL, NULL),
(5, 'XXL', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tags`
--

INSERT INTO `tags` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'New', NULL, NULL, NULL),
(2, 'Hot', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
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
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `gender`, `avatar`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `role`) VALUES
(1, 'thiennguyen', 'thiennvph38294@fpt.edu.vn', NULL, '$2y$12$d.yzlfMWxWRyss41pXfUR.zji0NAOB1c.w5TZNxgFITBzMmHBgSlO', '034572006', 'Lục Ngạn - Bắc Giang', 'other', NULL, NULL, '2025-06-06 09:16:27', '2025-06-06 09:16:27', NULL, 2),
(2, 'manh', 'manh@gmail.com', NULL, '$2y$12$0ovg6VlK0ax41ptZBLAtFec9vZY26QiTJj7Xj1t8SgFzLkuXLuc.e', NULL, 'ha noi', 'other', NULL, NULL, '2025-06-07 09:24:01', '2025-07-02 08:10:22', NULL, 2),
(3, 'Nguyen Than Thien', 'viettel555111@gmail.com', NULL, '$2y$12$pKjWGX0QrwhByRoaCuYGoOlHRt2nudz1XZrINivEPYJa8nFiemH2G', '0987654321', 'Lục Ngạn - Bắc Giang', 'other', '', NULL, '2025-06-13 09:31:12', '2025-06-16 05:06:24', NULL, 1),
(4, 'chien', 'chien@gmail.com', NULL, '$2y$12$Hz/n/OuaE18EG3iqN6Z/a.MDwh/feTlL4w6rv63/ZOTKFkvQ5.2S.', '03232323', 'lang son', 'other', NULL, NULL, '2025-06-26 09:05:01', '2025-07-09 03:03:22', NULL, 1),
(5, 'ha', 'ha@gmail.com', NULL, '$2y$12$D9xgw5ackRGJCgfpXTZFUu5JqixFwiYlb08LxQdAw0zAhuwQwGhG6', '02355888888', 'Hà Nội', 'other', NULL, NULL, '2025-07-02 17:09:22', '2025-07-02 17:42:12', NULL, 2),
(6, 'long', 'long@gmail.com', NULL, '$2y$12$jnNPdtgVD2Eg1.IzPGcKyuxSo3Spxfy6SwaspFuR7Kt3d6KMfVAHu', NULL, NULL, 'other', NULL, NULL, '2025-07-02 18:58:41', '2025-07-02 18:58:41', NULL, 2),
(7, 'lanh', 'lanh@gmail.com', NULL, '$2y$12$vTH7Hovfuaovog6u9FZXjOX5vNvkr0VVQ8Jj83/cMXIDanAQJAxN2', '03535532', 'ha noi', 'other', NULL, NULL, '2025-07-02 21:13:10', '2025-07-02 21:25:31', NULL, 2),
(8, 'lan', 'lan@gmail.com', NULL, '$2y$12$KVNxTbUyxkGicMaZj6vg4e9YpEZKbSyysRZZL.0NMT4G7.CTd7eoG', '03232222222', 'ha noi', 'other', NULL, NULL, '2025-07-03 00:58:22', '2025-07-09 03:12:21', NULL, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_coupons`
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
-- Đang đổ dữ liệu cho bảng `user_coupons`
--

INSERT INTO `user_coupons` (`id`, `user_id`, `coupon_id`, `used_at`, `created_at`, `updated_at`) VALUES
(16, 7, 11, '2025-07-03 20:52:23', '2025-07-03 20:52:23', '2025-07-03 20:52:23');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_variant_id_foreign` (`product_variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_variant_id_foreign` (`product_variant_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pending_orders_txn_ref_unique` (`txn_ref`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_tag_id_foreign` (`tag_id`);

--
-- Chỉ mục cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_order_item_id_foreign` (`order_item_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`),
  ADD KEY `product_variants_size_id_foreign` (`size_id`),
  ADD KEY `product_variants_color_id_foreign` (`color_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_coupons_user_id_foreign` (`user_id`),
  ADD KEY `user_coupons_coupon_id_foreign` (`coupon_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT cho bảng `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cart_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Các ràng buộc cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_variants_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Các ràng buộc cho bảng `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD CONSTRAINT `user_coupons_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_coupons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
