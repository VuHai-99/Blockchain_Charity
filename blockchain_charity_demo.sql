-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2021 at 02:51 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blockchain_charity_testnetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `private_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_address`, `name`, `email`, `password`, `email_verified_at`, `private_key`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0x4C713A3983548984D6B9F5adBB2328CC6c3c0530', 'Admin_1', 'admin1@gmail.com', '$2y$10$eELjsXd8iqND3GgSI4d/..c2sx8OYz.ajPr8LADWgalpr2pfoJ6wi', '2021-10-29 05:27:25', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `authority_information`
--

CREATE TABLE `authority_information` (
  `authority_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authority_location_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authority_location_post_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authority_information`
--

INSERT INTO `authority_information` (`authority_address`, `email`, `password`, `authority_location_name`, `authority_location_post_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0x2821E40a6cddc5c217B1DFDceB587a81ee1d325d', 'authority1@gmail.com', '$2y$10$YRe01sI1DtjXPfV8fQFh.usvpfw4HjFPXvEJEE9woUQazUlMk.Pxm', 'Hà Nội', '34', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blockchain_requests`
--

CREATE TABLE `blockchain_requests` (
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_type` int(11) NOT NULL COMMENT '0 is validateHost, 1 is open campaign, 3 is open donation activity. 4 is cashout order donation activity request\r\n',
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requested_user_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campaign_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authority_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `donation_activity_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campaign_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `target_contribution_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blockchain_requests`
--

INSERT INTO `blockchain_requests` (`request_id`, `request_type`, `amount`, `requested_user_address`, `campaign_address`, `authority_address`, `donation_activity_address`, `campaign_name`, `date_start`, `date_end`, `target_contribution_amount`, `description`, `created_at`, `updated_at`) VALUES
('0xdb9d76207e8398f140c3346b8a03745e720bc152', 0, NULL, '0xdb9d76207e8398f140c3346b8a03745e720bc152', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-09 08:58:01', '2021-12-09 08:58:01');

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `campaign_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum_contribution` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_contribution_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`campaign_address`, `name`, `host_address`, `description`, `minimum_contribution`, `target_contribution_amount`, `current_balance`, `date_start`, `date_end`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0x6b7bad288c8a192dd73a6bd6bab564d245e59312', 'TRÁI TIM CHO EM', '0x9ef5f229045f9ab196188ebf80bbf80450777816', '“Trái tim cho em” là chương trình từ thiện nhân đạo do Tập đoàn Công nghiệp - Viễn thông Quân đội (Viettel) và Quỹ Tấm Lòng Việt – Đài Truyền hình Việt Nam phối hợp thực hiện. Theo đó chương trình thực hiện phẫu thuật tim miễn phí cho trẻ em nghèo dưới 16 tuổi tại Việt Nam; tài trợ nâng cao năng lực khám chữa các bệnh về tim mạch cho hệ thống y tế tại Việt Nam; tổ chức các hoạt động khám sàng lọc bệnh tim bẩm sinh dành cho trẻ em khu vực vùng sâu vùng xa để giúp phát hiện và điều trị kịp thời cho các em nhỏ mắc bệnh tim bẩm sinh.', '1000', '200000000000000000', '100000001000000000', '2021-12-08 00:00:00', '2022-11-01 00:00:00', '2021-12-08 07:15:13', '2021-12-08 13:36:25', NULL),
('0xf7d154ec405ab96a4ce59d799af3f7bc2f5e2432', 'NHÀ TÌNH THƯƠNG', '0x64282E8dC77287a91a366B58849Ea228C186F811', 'Nhà tình thương là những căn nhà ở được xây cất từ nguồn của các hoạt động từ thiện của cộng đồng hay quyên góp của chính quyền hoặc các tổ chức đoàn thể để xây cất những ngôi nhà ở để dành cho những người có hoàn cảnh kinh tế, gia đình khó khăn (thường là người cao tuổi không còn có thể làm việc để kiếm đủ tiền để trả tiền thuê nhà, hoặc những người già cả, neo đơn không nơi nương tựa) để giải quyết vấn đề chỗ ở của họ trong một cộng đồng cụ thể. Chính sách của nhà tình thương thường nhắm vào những người nghèo của địa phương. Việc xây nhà tình thương thường được duy trì bởi một tổ chức từ thiện, hoặc những \"mạnh thường quân\". Nhà tình thương là một trong những chính sách thiện nguyện xã hội, góp phần rất lớn trong chính sách an sinh xã hội của các quốc gia, chính quyền địa phương.', '2000', '210000000000000000', '1000000', '2021-12-14 00:00:00', '2022-10-13 00:00:00', '2021-12-08 07:56:03', '2021-12-08 08:03:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_imgs`
--

CREATE TABLE `campaign_imgs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_type` int(11) NOT NULL,
  `donation_activity_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_imgs`
--

INSERT INTO `campaign_imgs` (`id`, `campaign_address`, `file_path`, `photo_type`, `donation_activity_address`, `created_at`, `updated_at`) VALUES
(49, '0x6b7bad288c8a192dd73a6bd6bab564d245e59312', '/storage/1638947737_Trai_tim_cho_em_main.png', 0, NULL, '2021-12-08 07:15:37', '2021-12-08 07:15:37'),
(50, '0x6b7bad288c8a192dd73a6bd6bab564d245e59312', '/storage/1638947737_trai_tim_cho_em_side_2.jpg', 1, NULL, '2021-12-08 07:15:37', '2021-12-08 07:15:37'),
(51, '0x6b7bad288c8a192dd73a6bd6bab564d245e59312', '/storage/1638947737_trai_tim_cho_em_side1.jpg', 1, NULL, '2021-12-08 07:15:37', '2021-12-08 07:15:37'),
(52, '0xf7d154ec405ab96a4ce59d799af3f7bc2f5e2432', '/storage/1638950183_nha_tinh_thuong_main.jpg', 0, NULL, '2021-12-08 07:56:23', '2021-12-08 07:56:23'),
(53, '0xf7d154ec405ab96a4ce59d799af3f7bc2f5e2432', '/storage/1638950183_nha_tinh_thuong_side1.jpg', 1, NULL, '2021-12-08 07:56:23', '2021-12-08 07:56:23'),
(54, '0xf7d154ec405ab96a4ce59d799af3f7bc2f5e2432', '/storage/1638950183_nha_tinh_thuong_side2.jpg', 1, NULL, '2021-12-08 07:56:23', '2021-12-08 07:56:23');

-- --------------------------------------------------------

--
-- Table structure for table `cashout_donation_activities`
--

CREATE TABLE `cashout_donation_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `authority_confirmation` tinyint(4) NOT NULL,
  `cashout_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cashout_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation_activity_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashout_donation_activities`
--

INSERT INTO `cashout_donation_activities` (`id`, `authority_confirmation`, `cashout_amount`, `cashout_code`, `donation_activity_address`, `created_at`, `updated_at`) VALUES
(6, 0, '1000', '0x000000000000000000000000000000000000000000000000000007630e2f5cf6', '0x2d20e91fc2fa5105eac6837a59b75aafc7246449', '2021-12-08 07:20:43', '2021-12-08 07:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `donation_activities`
--

CREATE TABLE `donation_activities` (
  `donation_activity_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campaign_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authority_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation_activity_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation_activity_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donation_activities`
--

INSERT INTO `donation_activities` (`donation_activity_address`, `campaign_address`, `host_address`, `authority_address`, `donation_activity_description`, `donation_activity_name`, `date_start`, `date_end`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0x2d20e91fc2fa5105eac6837a59b75aafc7246449', '0x6b7bad288c8a192dd73a6bd6bab564d245e59312', '0x9ef5f229045f9ab196188ebf80bbf80450777816', '0x2821E40a6cddc5c217B1DFDceB587a81ee1d325d', 'Hỗ trợ 3 em nhỏ ở trung tâm khuyết tật hà nội mắc chứng bệnh tim bẩm sinh.', 'Đợt từ thiện 1', '2021-12-08 00:00:00', '2021-12-09 00:00:00', '2021-12-08 07:17:26', '2021-12-08 07:17:26', NULL),
('0xd7c33b047ea0d7c016c17bf2c6f3e800ecb77078', '0xf7d154ec405ab96a4ce59d799af3f7bc2f5e2432', '0x64282E8dC77287a91a366B58849Ea228C186F811', '0x2821E40a6cddc5c217B1DFDceB587a81ee1d325d', 'Xây nhà từ thiện cho các em vùng núi Hà Nội.', 'Đợt từ thiện số 1', '2021-12-08 00:00:00', '2021-12-09 00:00:00', '2021-12-08 08:56:20', '2021-12-08 08:56:20', NULL);

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_10_05_203528_create_admins_table', 1),
(5, '2021_10_13_011328_create_campaigns_table', 1),
(6, '2021_11_11_200219_create_transactions_table', 1),
(7, '2021_11_11_200241_create_blockchain_requests_table', 1),
(9, '2021_12_05_112942_create_campaign_imgs_table', 2),
(10, '2021_12_05_140725_create_authority_information_table', 3),
(11, '2021_12_05_155908_create_order_donation_activities_table', 3),
(13, '2021_12_05_161355_create_order_receipts_table', 3),
(14, '2021_12_05_161926_create_retailer_information_table', 3),
(15, '2021_12_05_162533_create_product_categories_table', 3),
(16, '2021_12_05_215052_create_products_table', 3),
(18, '2021_12_05_160527_create_donation_activities_table', 4),
(19, '2021_12_08_000645_create_cashout_donation_activities_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `order_donation_activities`
--

CREATE TABLE `order_donation_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receipt_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retailer_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_state` tinyint(4) NOT NULL,
  `order_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authority_confirmation` tinyint(4) NOT NULL,
  `total_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_receipts`
--

CREATE TABLE `order_receipts` (
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_receipt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_payment` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retailer_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retailer_information`
--

CREATE TABLE `retailer_information` (
  `retail_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retail_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brief_infor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hot_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_hash`, `sender_address`, `receiver_address`, `transaction_type`, `amount`, `created_at`, `updated_at`) VALUES
('0x055037cb9a5dc1309de8b6ca5088334ade5b63c631ed5c5af6d55ddb5c0fd6d0', '0x9ef5f229045f9ab196188ebf80bbf80450777816', '0x6b7bad288c8a192dd73a6bd6bab564d245e59312', 0, '1000000000', '2021-12-08 07:16:13', '2021-12-08 07:16:13'),
('0xa4c6e271faf421db821d8d0e36e1ecf27560ba0bc1f4dd389144ccf7d5bb9538', '0x9ef5f229045f9ab196188ebf80bbf80450777816', '0x6b7bad288c8a192dd73a6bd6bab564d245e59312', 0, '100000000000000000', '2021-12-08 13:36:24', '2021-12-08 13:36:24'),
('0xf1ab30eac4a015dddeeddca460aad464c317697ad4cd4927f5c9679d52400dbe', '0x64282e8dc77287a91a366b58849ea228c186f811', '0xf7d154ec405ab96a4ce59d799af3f7bc2f5e2432', 0, '1000000', '2021-12-08 08:03:00', '2021-12-08 08:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(4) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet_type` int(11) NOT NULL,
  `amount_of_money` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_code` int(11) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `validate_state` int(11) DEFAULT NULL,
  `private_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_card_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_card_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_address`, `name`, `email`, `role`, `email_verified_at`, `password`, `home_address`, `phone`, `wallet_type`, `amount_of_money`, `otp_code`, `otp_expires_at`, `otp_verified_at`, `validate_state`, `private_key`, `image_card_front`, `image_card_back`, `remember_token`, `created_at`, `updated_at`) VALUES
('0x2713cCFC843FF2c3C78d1500c0E3AfE7EaD6ed80', 'Donator_2', 'donator2@gmail.com', 0, '2021-10-29 05:27:25', '$2y$10$YRe01sI1DtjXPfV8fQFh.usvpfw4HjFPXvEJEE9woUQazUlMk.Pxm', '25 Nguyen Chieu Thanh Xuan Ha Noi', '0987632738', 1, NULL, NULL, NULL, NULL, NULL, '2cc0454f129d3b2ecaf62e5595ee0f99e582fa4eb23fde9d7d63305fdbfa6fe1', '0', '0', NULL, '2021-12-06 07:20:52', '2021-12-06 07:58:22'),
('0x64282E8dC77287a91a366B58849Ea228C186F811', 'Host_2', 'host2@gmail.com', 1, '2021-10-29 05:27:25', '$2y$10$O7cRD3KrQS2kOzLUi77se.O/pfByGa.dQATMvZvo9MmlE6hiH2aeC', '25 Nguyen Chieu Thanh Xuan Ha Noi', '0987632738', 1, NULL, NULL, NULL, NULL, 2, '425609957bf25ac650cc868d42c656a48be9cdc9cfb19c5a7d509b32b032641a', '/storage/1638772905_Screenshot (5).png', '/storage/1638772905_Screenshot (7).png', NULL, '2021-12-06 06:41:45', '2021-12-08 10:34:05'),
('0x93c790c75bc431aa548bb788786408e9aac776d4', 'Donator_1', 'donator1@gmail.com', 0, '2021-10-29 05:27:25', '$2y$10$7rvXZUVkAfGCs6ReRQuxjuXPvG2wgL7uSRPqWHdiQwE1CN5mSZzXG', '43 Tan Ap', '0987632738', 0, '96992307279999940000', NULL, NULL, NULL, NULL, NULL, '0', '0', NULL, '2021-12-06 07:16:32', '2021-12-06 07:20:25'),
('0x9ef5f229045f9ab196188ebf80bbf80450777816', 'Host_1', 'host1@gmail.com', 1, '2021-10-29 05:27:25', '$2y$10$Ocgy7zGHtbF1tvcJ/OGB4.K3piZVW64VawkNr.LwavIp7U9P3FMpW', '25 Nguyen Chieu Thanh Xuan Ha Noi', '0987632738', 0, '59802275317988321000', 353897, '2021-12-09 09:56:38', '2021-12-08 13:30:41', 2, NULL, '/storage/1638769066_Screenshot (5).png', '/storage/1638769066_Screenshot (7).png', NULL, '2021-12-06 05:37:46', '2021-12-09 08:56:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_address`);

--
-- Indexes for table `authority_information`
--
ALTER TABLE `authority_information`
  ADD PRIMARY KEY (`authority_address`);

--
-- Indexes for table `blockchain_requests`
--
ALTER TABLE `blockchain_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`campaign_address`);

--
-- Indexes for table `campaign_imgs`
--
ALTER TABLE `campaign_imgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashout_donation_activities`
--
ALTER TABLE `cashout_donation_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation_activities`
--
ALTER TABLE `donation_activities`
  ADD PRIMARY KEY (`donation_activity_address`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_donation_activities`
--
ALTER TABLE `order_donation_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_receipts`
--
ALTER TABLE `order_receipts`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retailer_information`
--
ALTER TABLE `retailer_information`
  ADD PRIMARY KEY (`retail_address`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_hash`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_address`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaign_imgs`
--
ALTER TABLE `campaign_imgs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `cashout_donation_activities`
--
ALTER TABLE `cashout_donation_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_donation_activities`
--
ALTER TABLE `order_donation_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
