-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 03:44 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jagoansmm`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance_logs`
--

CREATE TABLE `balance_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(5) COLLATE utf8_swedish_ci NOT NULL,
  `amount` double NOT NULL,
  `note` text COLLATE utf8_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'SoundCloud'),
(2, 'Telegram'),
(3, 'Instagram Story Views'),
(4, 'Instagram Live Video'),
(5, 'Instagram Story / Impressions / Saves / Profile Visit'),
(6, 'Twitter Views & Impressions'),
(7, 'Linkedin'),
(8, 'Website Traffic'),
(9, 'Youtube Views'),
(10, 'Spotify'),
(11, 'Facebook Page Likes & Page Followers'),
(12, 'Pinterest'),
(13, 'Shopee/Tokopedia/Bukalapak'),
(14, 'Instagram Like Indonesia'),
(15, 'Instagram Likes'),
(16, 'TikTok Followers'),
(17, 'TikTok Likes'),
(18, 'Youtube Likes / Dislikes / Shares / Comment'),
(19, 'Instagram Followers Indonesia'),
(20, 'Facebook Followers / Friends'),
(21, 'Facebook Post Likes / Comments / Shares'),
(22, 'Instagram Followers [ No Refill ]'),
(23, 'TikTok View/share'),
(24, 'Youtube Live Stream / Youtube Premiered Waiting'),
(25, 'Likee app'),
(26, 'Youtube View Target Negara'),
(27, 'Instagram Followers [guaranteed]'),
(28, 'Twitter Indonesia'),
(29, 'Youtube View Jam Tayang'),
(30, 'Instagram TV'),
(31, 'Instagram Followers Indonesia Guaranted/Refill'),
(32, 'Youtube Subscribers'),
(33, 'Instagram Comments'),
(34, 'Clubhouse'),
(35, 'TikTok INDONESIA'),
(36, 'Instagram Reels'),
(37, 'Facebook Video Views / Live Stream'),
(38, 'Twitter Followers'),
(39, 'YouTube Shorts'),
(40, 'Youtube View  [ for monetization - money maker]'),
(41, 'Tiktok Live Streams'),
(42, 'Instagram VERIFIED '),
(43, 'Instagram Views'),
(44, 'Instagram Like Comment [ top comment ]'),
(45, '- PROMO - ON OFF'),
(46, 'Twitter Favorites/Like'),
(47, 'Instagram Followers Indonesia [ Gender ]'),
(48, 'Tiktok Comments '),
(49, 'Twitch'),
(50, 'Facebook Post Like Emoticon'),
(51, 'Facebook Reels Short Video'),
(52, 'YouTube Live Stream [ Cheap price ] [ 30 Minutes to 24 Hours]');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment` enum('credit','bank','redeem') COLLATE utf8_swedish_ci NOT NULL,
  `type` enum('manual','auto') COLLATE utf8_swedish_ci NOT NULL,
  `method_name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `post_amount` double NOT NULL,
  `amount` double NOT NULL,
  `note` text COLLATE utf8_swedish_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  `status` enum('Pending','Canceled','Success') COLLATE utf8_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_methods`
--

CREATE TABLE `deposit_methods` (
  `id` int(11) NOT NULL,
  `payment` enum('credit','bank') COLLATE utf8_swedish_ci NOT NULL,
  `type` enum('manual','auto') COLLATE utf8_swedish_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `note` text COLLATE utf8_swedish_ci NOT NULL,
  `rate` double NOT NULL,
  `min_amount` double NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `ip_address`, `created_at`) VALUES
(1, 4, '::1', '2023-01-10 09:33:13'),
(2, 4, '::1', '2023-01-10 09:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `content` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `created_at`, `content`) VALUES
(1, '2022-12-22 22:43:02', 'Hello, WELCOME !');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `data` text COLLATE utf8_swedish_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `profit` double NOT NULL,
  `start_count` int(11) NOT NULL DEFAULT 0,
  `remains` int(11) NOT NULL DEFAULT 0,
  `status` enum('Pending','Processing','Error','Partial','Success') COLLATE utf8_swedish_ci NOT NULL,
  `provider_id` int(11) NOT NULL,
  `provider_order_id` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `is_api` int(1) NOT NULL DEFAULT 0,
  `is_refund` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `api_order_log` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `api_status_log` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_swedish_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `content`, `updated_at`) VALUES
(1, 'Information Kontak\r\nRizki Agung Test\r\n0812-9005-36111', '2019-03-20 10:18:14'),
(2, 'Terms & Conditions RIZKIAGUNGID has set the following agreements.\r\n\r\n1. GENERAL\r\n\r\nBy registering and using the Youtube service you automatically agree to all the terms we make. Terms and conditions can change at any time without prior notice.\r\n\r\n2. SERVICE\r\n\r\nRIZKIAGUNGID is only for promotional purposes. Only to help improve the \"appearance\" of your social media account.\r\nRIZKIAGUNGID cannot guarantee that your new followers will interact with you.\r\nRIZKIAGUNGID only guarantees that you will get the followers you pay for.\r\nRIZKIAGUNGID does not guarantee that 100% of our accounts have complete profile pictures or bios.\r\nRIZKIAGUNGID will not refund your balance if you place the wrong order. Make sure you enter the correct data before ordering the service.\r\nRIZKIAGUNGID You Cannot Place Orders For Things That Are Illegal.\r\nRIZKIAGUNGID Does Not Guarantee That All Services Can Last Forever.\r\n\r\n3. RESPONSIBILITY\r\n\r\nRIZKIAGUNGID is not responsible for any losses that may occur to your business.\r\nRIZKIAGUNGID is not responsible for account suspension, deletion of photos or videos or even blocking of your social media account.\r\nRIZKIAGUNGID is not responsible for misuse of the services we provide.\r\nRIZKIAGUNGID is free from all legal claims.\r\n\r\n4. PRICE\r\n\r\nThe prices we offer are subject to change at any time. With or without notice.\r\n\r\n5. ORDERS\r\n\r\nMessages that have been input cannot be canceled.\r\nThe processing time that we attach in the description is only an estimate.\r\n\r\n6. BALANCE\r\n\r\nNo refunds will be made to your payment method. Once the deposit is complete, there is no way to return it. You must use your balance on Youtube\'s instructions.\r\nYou agree that after you complete the payment, you will not file a dispute or chargeback with us for any reason.\r\n\r\n7. ACCOUNT\r\n\r\nWe will not help anything that happens to your account if the data you input during registration does not match the criteria we have suggested.\r\nIf you register and do not make a deposit or top up your balance within more than 1 day, your account will be automatically deactivated by the system. If you are proven to have committed fraud in transactions on Youtube, we will deactivate or even delete your account from our website.', '2019-03-20 00:00:00'),
(3, '1. What is RIZKIAGUNGID?\r\nRIZKIAGUNGID is a business platform that provides various social media marketing services that operate mainly in Indonesia. By joining us, you can become a social media service provider or social media reseller such as services to add Followers, Likes, etc.\r\n\r\n2. How do I register on Youtube?\r\nYou can register directly on the Youtube website on the Register page\r\n\r\n3. How do I make an order?\r\nTo make an order is very easy, you only need to log in to your account first and go to the order page by clicking on the menu that is already available. In addition, you can also make an order via API request.\r\n\r\n4. How do I make a deposit/fill balance?\r\nTo make a deposit/fill balance, you only need to log in first to your account and go to the deposit page by clicking on the menu provided. We provide deposits via bank and credit.', '2019-03-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `api_url_order` text COLLATE utf8_swedish_ci NOT NULL,
  `api_url_status` text COLLATE utf8_swedish_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`id`, `name`, `api_url_order`, `api_url_status`, `api_key`) VALUES
(1, 'RASXMEDIA', 'https://rasxmedia.com/api/social-media', 'https://rasxmedia.com/api/social-media', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `register_logs`
--

CREATE TABLE `register_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `service_name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `note` text COLLATE utf8_swedish_ci NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `price` double NOT NULL,
  `profit` double NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `provider_id` int(11) NOT NULL,
  `provider_service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_cat`
--

CREATE TABLE `service_cat` (
  `id` int(10) NOT NULL,
  `name` varchar(100) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `msg` text COLLATE utf8_swedish_ci NOT NULL,
  `status` enum('Waiting','Responded','Closed') COLLATE utf8_swedish_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `is_admin` int(1) NOT NULL DEFAULT 0,
  `msg` text COLLATE utf8_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `balance` double NOT NULL,
  `level` enum('Member','Reseller','Admin') COLLATE utf8_swedish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `api_key` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `remember_me` varchar(255) COLLATE utf8_swedish_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `voucher_code` text COLLATE utf8_swedish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance_logs`
--
ALTER TABLE `balance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_methods`
--
ALTER TABLE `deposit_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register_logs`
--
ALTER TABLE `register_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_cat`
--
ALTER TABLE `service_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance_logs`
--
ALTER TABLE `balance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_methods`
--
ALTER TABLE `deposit_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `register_logs`
--
ALTER TABLE `register_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=440;

--
-- AUTO_INCREMENT for table `service_cat`
--
ALTER TABLE `service_cat`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
