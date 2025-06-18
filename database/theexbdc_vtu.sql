-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2025 at 09:22 AM
-- Server version: 10.6.22-MariaDB-cll-lve-log
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `theexbdc_vtu`
--

-- --------------------------------------------------------

--
-- Table structure for table `airtimes`
--

CREATE TABLE `airtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(255) NOT NULL,
  `provider_charge_price` varchar(255) NOT NULL,
  `recharge_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airtimes`
--

INSERT INTO `airtimes` (`id`, `provider`, `provider_charge_price`, `recharge_date`, `created_at`, `updated_at`) VALUES
(1, 'etisalat', '1', NULL, NULL, '2024-09-11 08:24:42'),
(2, 'mtn', '3', NULL, NULL, '2024-09-11 08:19:40'),
(3, 'airtel', '3', NULL, NULL, '2024-09-11 08:24:54'),
(4, 'glo', '2', NULL, NULL, '2024-09-11 08:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `airtimes_transactions`
--

CREATE TABLE `airtimes_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(225) NOT NULL,
  `current_bal` varchar(225) NOT NULL,
  `percent_profit` varchar(225) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airtimes_transactions`
--

INSERT INTO `airtimes_transactions` (`id`, `username`, `network`, `tel`, `amount`, `transaction_id`, `identity`, `prev_bal`, `current_bal`, `percent_profit`, `status`, `created_at`, `updated_at`) VALUES
(11, 'henryleogee', 'mtn', '08011111111', '200', '17263034379329129422761401', '08011111111', '2080479.35', '2080285.35', '6', 'delivered', '2024-09-14 07:44:00', '2024-09-14 07:44:00'),
(12, 'henryleogee', 'mtn', '08011111111', '1000', '17263077854008358764503944', '08011111111', '2080285.35', '2079315.35', '30', 'delivered', '2024-09-14 08:56:26', '2024-09-14 08:56:26'),
(13, 'henryleogee', 'mtn', '08011111111', '1000', '17263890892872264699800072', '08011111111', '2074846.19', '2073876.19', '30', 'delivered', '2024-09-15 07:31:31', '2024-09-15 07:31:31'),
(14, 'henryleogee', 'mtn', '08011111111', '500', '17265622441661555789400554', '08011111111', '1315890.11', '1315405.11', '15', 'delivered', '2024-09-17 07:37:26', '2024-09-17 07:37:26'),
(15, 'henryleogee', 'mtn', '08011111111', '1000', '17265640093042161119746124', '08011111111', '1315405.11', '1314435.11', '30', 'delivered', '2024-09-17 08:06:52', '2024-09-17 08:06:52'),
(16, 'henryleogee', 'airtel', '08011111111', '700', '17265641118806464550273478', '08011111111', '1314435.11', '1313758.91', '23.8', 'delivered', '2024-09-17 08:08:33', '2024-09-17 08:08:33'),
(17, 'henryleogee', 'mtn', '08011111111', '1000', '17265732502553308488621403', '08011111111', '1313758.91', '1312788.91', '30', 'delivered', '2024-09-17 10:40:51', '2024-09-17 10:40:51'),
(18, 'henryleogee', 'mtn', '08011111111', '1000', '17265844436428331725407705', '08011111111', '1311560.89', '1310590.89', '30', 'delivered', '2024-09-17 13:47:25', '2024-09-17 13:47:25'),
(19, 'henryleo', 'mtn', '08011111111', '50', '17276000190069247743357899', '08011111111', '17205.00', '17156.5', '1.5', 'delivered', '2024-09-29 07:53:43', '2024-09-29 07:53:43'),
(20, 'henryleogee', 'airtel', '08011111111', '700', '17276158879302436465395832', '08011111111', '989773.29', '989097.09', '23.8', 'delivered', '2024-09-29 12:18:08', '2024-09-29 12:18:08'),
(21, 'Longevity', 'airtel', '09047933240', '100', '17282913603706643971866083', '09047933240', '692.23', '595.23', '3', 'delivered', '2024-10-07 12:56:02', '2024-10-07 12:56:02'),
(22, 'Longevity', 'mtn', '08142751701', '100', '17297137276385885408836721', '08142751701', '272.23', '175.23', '3', 'delivered', '2024-10-24 00:02:09', '2024-10-24 00:02:09'),
(23, 'Longevity', 'glo', '08070867249', '100', '17297566766921510030700456', '08070867249', '8675.23', '8576.23', '1', 'delivered', '2024-10-24 11:57:57', '2024-10-24 11:57:57'),
(24, 'Babyluv', 'mtn', '08142751701', '100', '17322757402244358551158303', '08142751701', '6601.50', '6503.5', '2', 'delivered', '2024-11-22 16:42:22', '2024-11-22 16:42:22'),
(25, 'okikaarinze@gmail.com', 'mtn', '08011111111', '100', '17409188569013734109398912', '08011111111', '159800.00', '159701', '1', 'delivered', '2025-03-02 17:34:30', '2025-03-02 17:34:30'),
(26, 'okikaarinze@gmail.com', 'airtel', '08011111111', '100', '17409189139251947232715707', '08011111111', '159701.00', '159602', '1', 'delivered', '2025-03-02 17:35:26', '2025-03-02 17:35:26'),
(27, 'okikaarinze@gmail.com', 'glo', '08011111111', '100', '17409189769812629469457540', '08011111111', '159602.00', '159503', '1', 'delivered', '2025-03-02 17:36:26', '2025-03-02 17:36:26'),
(28, 'okikaarinze@gmail.com', 'etisalat', '08011111111', '100', '17409191184083996329432280', '08011111111', '159503.00', '159405', '2', 'delivered', '2025-03-02 17:38:47', '2025-03-02 17:38:47');

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
-- Table structure for table `data_transactions`
--

CREATE TABLE `data_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `api_response` text NOT NULL,
  `network` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(225) NOT NULL,
  `current_bal` varchar(225) NOT NULL,
  `percent_profit` varchar(225) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_transactions`
--

INSERT INTO `data_transactions` (`id`, `username`, `api_response`, `network`, `tel`, `plan`, `amount`, `transaction_id`, `identity`, `prev_bal`, `current_bal`, `percent_profit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'henryleo4', '{\"id\":259606,\"ident\":\"1551335740c213ec95\",\"network\":4,\"balance_before\":\"5948.0\",\"balance_after\":\"5888.0\",\"mobile_number\":\"09047933240\",\"plan\":232,\"Status\":\"successful\",\"api_response\":\"You have successfully gifted 2349047933240 with 100MB of Data. valid till 9\\/2\\/2024 12:00:00 PM\",\"plan_network\":\"AIRTEL\",\"plan_name\":\"100.0MB\",\"plan_amount\":\"60.0\",\"create_date\":\"2024-08-27T08:00:40.717601\",\"Ported_number\":true}', '4', '09047933240', '232', '60', '20240827080089htyyo', 'Data Purchase', '', '', '', 'successful', '2024-08-27 06:00:39', '2024-08-27 06:00:39'),
(2, 'henryleo4', '{\"id\":259607,\"ident\":\"12824119741233bec6\",\"network\":4,\"balance_before\":\"5888.0\",\"balance_after\":\"5828.0\",\"mobile_number\":\"09047933240\",\"plan\":232,\"Status\":\"successful\",\"api_response\":\"You have successfully gifted 2349047933240 with 100MB of Data. valid till 9\\/2\\/2024 12:00:00 PM\",\"plan_network\":\"AIRTEL\",\"plan_name\":\"100.0MB\",\"plan_amount\":\"60.0\",\"create_date\":\"2024-08-27T08:06:59.757119\",\"Ported_number\":true}', '4', '09047933240', '232', '60', '20240827080689htyyo', 'Data Purchase', '', '', '', 'successful', '2024-08-27 06:06:58', '2024-08-27 06:06:58'),
(3, 'henryleo4', '{\"id\":259609,\"ident\":\"1168317579dddb955c\",\"network\":4,\"balance_before\":\"5828.0\",\"balance_after\":\"5768.0\",\"mobile_number\":\"09047933240\",\"plan\":232,\"Status\":\"successful\",\"api_response\":\"You have successfully gifted 2349047933240 with 100MB of Data. valid till 9\\/2\\/2024 12:00:00 PM\",\"plan_network\":\"AIRTEL\",\"plan_name\":\"100.0MB\",\"plan_amount\":\"60.0\",\"create_date\":\"2024-08-27T08:08:55.571277\",\"Ported_number\":true}', '4', '09047933240', '232', '60', '20240827080889htyyo', 'Data Purchase', '', '', '', 'successful', '2024-08-27 06:08:53', '2024-08-27 06:08:53'),
(4, 'henryleo4', 'You have successfully gifted 2349047933240 with 100MB of Data. valid till 9/2/2024 12:00:00 PM', '4', '09047933240', '100.0MB', '60', '141594119637a8afcb', 'Data Purchase', '', '', '', 'successful', '2024-08-27 06:14:44', '2024-08-27 06:14:44'),
(5, 'henryleo4', 'You have successfully gifted 2349047933240 with 100MB of Data. valid till 9/2/2024 12:00:00 PM', '4', '09047933240', '100.0MB', '60', '114784273e7db16d3', 'Data Purchase', '', '', '', 'successful', '2024-08-27 06:16:56', '2024-08-27 06:16:56'),
(6, 'henryleo4', 'You have successfully gifted 2349047933240 with 100MB of Data. valid till 9/2/2024 12:00:00 PM', '4', '09047933240', '100.0MB', '60', '1147842735c0c4a20', 'Data Purchase', '', '', '', 'successful', '2024-08-27 06:50:43', '2024-08-27 06:50:43'),
(7, 'henryleo4', 'MTN Data', 'mtn', '08011111111', '200', '200.00', '17247600979517387782592618', 'Data Purchase', '', '', '', 'successful', '2024-08-27 11:01:37', '2024-08-27 11:01:37'),
(8, 'henryleo4', 'MTN Data', 'mtn', '08011111111', '200', '200.00', '17247601758075781229131251', 'Data Purchase', '', '', '', 'successful', '2024-08-27 11:02:55', '2024-08-27 11:02:55'),
(9, 'henryleo4', 'MTN Data', 'mtn', '08011111111', '200', '200.00', '17247602226938256532997553', 'Data Purchase', '', '', '', 'successful', '2024-08-27 11:03:42', '2024-08-27 11:03:42'),
(10, 'henryleo4', 'MTN Data', 'mtn', '08011111111', '100', '100.00', '17247604939092431620923255', 'Data Purchase', '', '', '', 'successful', '2024-08-27 11:08:13', '2024-08-27 11:08:13'),
(11, 'henryleo4', 'MTN Data', 'mtn', '08011111111', '200', '200.00', '17247606786984317511476419', 'Data Purchase', '', '', '', 'successful', '2024-08-27 11:11:18', '2024-08-27 11:11:18'),
(12, 'henryleogee', 'MTN Data', 'mtn', '08011111111', '100', '100.00', '17248591180143401331884325', 'Data Purchase', '', '', '', 'successful', '2024-08-28 14:31:58', '2024-08-28 14:31:58'),
(13, 'henryleogee', 'MTN Data', 'mtn', '08011111111', '200', '200.00', '17249166805219340749477108', 'Data Purchase', '', '', '', 'successful', '2024-08-29 06:31:19', '2024-08-29 06:31:19'),
(14, 'henryleogee', 'Dear Customer, You have successfully shared 500MB Data to 2349067451209. Your SME data balance is 14880.25GB expires 21/10/2024. Thankyou', '1', '09067451209', '500.0MB', '143.56', '15669496820b14b18b', 'Data Purchase', '2078526.74', '2078383.18', '4.44', 'successful', '2024-09-14 10:59:15', '2024-09-14 10:59:15'),
(15, 'henryleogee', 'MTN Data', 'mtn', '08011111111', 'MTN Data', '194', '17263594392200692065219366', 'Data Purchase', '2078234.19', '2078040.19', '6', 'successful', '2024-09-14 23:17:19', '2024-09-14 23:17:19'),
(16, 'henryleogee', 'MTN Data', 'mtn', '08011111111', 'MTN Data', '194', '17263595203743614855732849', 'Data Purchase', '2078040.19', '2077846.19', '6', 'successful', '2024-09-14 23:18:40', '2024-09-14 23:18:40'),
(17, 'henryleogee', 'MTN Data', 'mtn', '08011111111', 'MTN Data', '970', '17265732888145757618368775', 'Data Purchase', '1312788.91', '1311818.91', '30', 'successful', '2024-09-17 10:41:29', '2024-09-17 10:41:29'),
(18, 'henryleogee', '', '1', '08011111111', '1.0GB', '258.02', '15749352900324d39d', 'Data Purchase', '1311818.91', '1311560.89', '7.98', 'successful', '2024-09-17 13:29:54', '2024-09-17 13:29:54'),
(19, 'henryleogee', '', '1', '08011111111', '500.0MB', '143.56', '68532890892a99d2a', 'Data Purchase', '1310590.89', '1310447.33', '4.44', 'successful', '2024-09-17 15:20:50', '2024-09-17 15:20:50'),
(20, 'henryleogee', 'You have successfully gifted 2349047933240 with 300MB of Data. valid till 10/2/2024 12:00:00 PM', '4', '09047933240', '300.0MB', '99.498', '10356054846953c9da', 'Data Purchase', '1310447.33', '1310347.832', '3.502', 'successful', '2024-09-26 14:10:44', '2024-09-26 14:10:44'),
(21, 'henryleogee', 'You have successfully gifted 2349047933240 with 100MB of Data. valid till 10/2/2024 12:00:00 PM', '4', '09047933240', '100.0MB', '59.93064', '1420331954a92e099c', 'Data Purchase', '1310347.83', '1310287.89936', '2.10936', 'successful', '2024-09-26 14:19:43', '2024-09-26 14:19:43'),
(22, 'henryleogee', 'You have successfully gifted 2349047933240 with 100MB of Data. valid till 10/2/2024 12:00:00 PM', '4', '09047933240', '100.0MB', '59.93064', '830661390db95bdaa', 'Data Purchase', '1310287.90', '1310227.96936', '2.10936', 'successful', '2024-09-26 14:28:26', '2024-09-26 14:28:26'),
(23, 'henryleogee', '', '4', '08011111111', '100.0MB', '59.93064', '15014854769397c1d6', 'Data Purchase', '1310227.97', '1310168.03936', '2.10936', 'successful', '2024-09-26 14:28:45', '2024-09-26 14:28:45'),
(24, 'henryleogee', '', '1', '08011111111', '500.0MB', '147.8668', '2649099800a1d11a3', 'Data Purchase', '1310168.04', '1310020.1732', '4.5732', 'successful', '2024-09-26 14:29:18', '2024-09-26 14:29:18'),
(25, 'jjsjs', '', '1', '08168078895', '500.0MB', '143.56', '18863316194b4861be', 'Data Purchase', '7105.00', '6961.44', '4.44', 'successful', '2024-09-30 07:18:19', '2024-09-30 07:18:19'),
(26, 'jjsjs', 'Dear Customer, You have successfully gifted 08054736511 with 200.0MB of Data. Thank you. Sponsor Balance: 1143968.77GB.', '2', '08054736511', '200.0MB', '59.52', '2681735535bb3795d', 'Data Purchase', '6961.44', '6901.92', '2.48', 'successful', '2024-09-30 08:16:44', '2024-09-30 08:16:44'),
(27, 'jjsjs', 'Dear Customer, You have successfully gifted 08054736511 with 200.0MB of Data. Thank you. Sponsor Balance: 1143894.76GB.', '2', '08054736511', '200.0MB', '61.9008', '1525203245c03b29b6', 'Data Purchase', '6901.92', '6840.0192', '2.5792', 'successful', '2024-09-30 08:19:26', '2024-09-30 08:19:26'),
(28, 'jjsjs', 'Dear Customer, You have successfully gifted 08054736511 with 200.0MB of Data. Thank you. Sponsor Balance: 1143885.59GB.', '2', '08054736511', '200.0MB', '61.9008', '7875973624bca5fc', 'Data Purchase', '6840.02', '6778.1192', '2.5792', 'successful', '2024-09-30 08:19:48', '2024-09-30 08:19:48'),
(29, 'jjsjs', 'Dear Customer, You have successfully gifted 08054736511 with 200.0MB of Data. Thank you. Sponsor Balance: 1143820.0GB.', '2', '08054736511', '200.0MB', '61.9008', '1481774960a06e1a4', 'Data Purchase', '6778.12', '6716.2192', '2.5792', 'successful', '2024-09-30 08:22:43', '2024-09-30 08:22:43'),
(30, 'jjsjs', 'Dear Customer, You have successfully gifted 08054736511 with 200.0MB of Data. Thank you. Sponsor Balance: 1143777.48GB.', '2', '08054736511', '200.0MB', '61.9008', '471501157ad7a3deb', 'Data Purchase', '6716.22', '6654.3192', '2.5792', 'successful', '2024-09-30 08:24:55', '2024-09-30 08:24:55'),
(31, 'jjsjs', 'Dear Customer, You have successfully gifted 08054736511 with 200.0MB of Data. Thank you. Sponsor Balance: 1143577.0GB.', '2', '08054736511', '200.0MB', '62.4', '1155842246611eb3c1', 'Data Purchase', '6654.32', '6591.92', '2.6', 'successful', '2024-09-30 08:34:13', '2024-09-30 08:34:13'),
(32, 'Longevity', 'Dear Customer, You have successfully shared 500MB Data to 2348142751701. Your SME data balance is 9192.91GB expires 06/11/2024. Thankyou', '1', '08142751701', '500.0MB', '148.41', '7414345536e161bd9', 'Data Purchase', '1025.15', '876.74', '4.59', 'successful', '2024-09-30 17:33:33', '2024-09-30 17:33:33'),
(33, 'Longevity', '', '1', '07017325724', '500.0MB', '148.41', '114532950f8abd8c4', 'Data Purchase', '876.74', '728.33', '4.59', 'successful', '2024-09-30 17:34:29', '2024-09-30 17:34:29'),
(34, 'Longevity', '', '1', '07017325724', '1.0GB', '271.6', '774562138e37ef43d', 'Data Purchase', '728.33', '456.73', '8.4', 'successful', '2024-09-30 17:43:48', '2024-09-30 17:43:48'),
(35, 'Longevity', 'Dear Customer, You have successfully shared 1GB Data to 2348142751701. Your SME data balance is 27057.45GB expires 11/11/2024. Thankyou', '1', '08142751701', '1.0GB', '272', '670638963dcc773c', 'Data Purchase', '964.23', '692.23', '8', 'successful', '2024-10-05 23:14:29', '2024-10-05 23:14:29'),
(36, 'Longevity', 'Dear Customer, You have successfully shared 500MB Data to 2348142751701. Your new Corporate Gifting data balance is 51333.74GB expires 13/11/2024. ThankÂ you.', '1', '08142751701', '500.0MB', '142', '66665681568b85c14', 'Data Purchase', '595.23', '453.23', '7', 'successful', '2024-10-07 17:29:21', '2024-10-07 17:29:21'),
(37, 'Longevity', 'Dear Customer, You have successfully shared 500MB Data to 2348142751701. Your SME data balance is 1304.1GB expires 29/11/2024. Thankyou', '1', '08142751701', '500.0MB', '156', '153052024236ec8c0b', 'Data Purchase', '453.23', '297.23', '7.8', 'successful', '2024-10-23 22:01:55', '2024-10-23 22:01:55'),
(38, 'Longevity', 'Dear Customer, You have successfully shared 25MB Data to 2348142751701. Your new Corporate Gifting data balance is 50779.21GB expires 29/11/2024. ThankÂ you.', '1', '08142751701', '25.0MB', '25', '1610442837a4d94377', 'Data Purchase', '297.23', '272.23', '1.25', 'successful', '2024-10-23 22:05:14', '2024-10-23 22:05:14'),
(39, 'Longevity', 'You have successfully gifted 2347017325724 with 100MB of Data. valid till 10/30/2024 12:00:00 PM', '4', '07017325724', '100.0MB', '63', '393295381b45a4e26', 'Data Purchase', '7590.23', '7527.23', '2.142', 'successful', '2024-10-24 18:53:36', '2024-10-24 18:53:36'),
(40, 'henryleogee', 'Airtel Data', 'airtel', '09047933240', 'Airtel Data', '50', '17322731074303485720482561', 'Data Purchase', '989097.09', '989047.09', '1.7', 'successful', '2024-11-22 15:58:29', '2024-11-22 15:58:29'),
(41, 'Babyluv', 'MTN Data', 'mtn', '08142751701', 'MTN Data', '100', '17322760026964146199559774', 'Data Purchase', '6503.50', '6403.5', '3', 'successful', '2024-11-22 16:46:44', '2024-11-22 16:46:44'),
(42, 'okikaarinze@gmail.com', 'MTN Data', 'mtn', '08011111111', 'MTN Data', '1000', '17409210885574347554243418', 'Data Purchase', '159405.00', '158405', '10', 'successful', '2025-03-02 18:11:37', '2025-03-02 18:11:37'),
(43, 'okikaarinze@gmail.com', 'Airtel Data', 'airtel', '08011111111', 'Airtel Data', '100', '17409212209591930843354388', 'Data Purchase', '158405.00', '158305', '1', 'successful', '2025-03-02 18:13:49', '2025-03-02 18:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `education_transactions`
--

CREATE TABLE `education_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `purchased_code` varchar(255) NOT NULL,
  `response_description` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(225) NOT NULL,
  `current_bal` varchar(225) NOT NULL,
  `percent_profit` varchar(225) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education_transactions`
--

INSERT INTO `education_transactions` (`id`, `username`, `product_name`, `type`, `tel`, `amount`, `transaction_id`, `purchased_code`, `response_description`, `transaction_date`, `identity`, `prev_bal`, `current_bal`, `percent_profit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'okika', 'WAEC Registration', 'waec-registraion', '0908', '27500.00', '2024081816511f785c32', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-18 15:51:32', 'waec', '', '', '', 'successful', '2024-08-18 14:51:32', '2024-08-18 14:51:32'),
(2, 'okika', 'WAEC Registration', 'waec-registraion', '08011111111', '27500.00', '2024081816553450c972', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-18 15:55:47', 'waec', '', '', '', 'successful', '2024-08-18 14:55:47', '2024-08-18 14:55:47'),
(3, 'okika', 'WAEC Registration', 'waec-registraion', '08011111111', '27500.00', '20240818165697bccdf8', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-18 15:56:51', 'waec', '', '', '', 'successful', '2024-08-18 14:56:51', '2024-08-18 14:56:51'),
(4, 'okika', 'WAEC Registration', 'waec-registraion', '08011111111', '27500.00', '2024081817068b6db720', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-18 16:06:14', 'waec', '', '', '', 'successful', '2024-08-18 15:06:14', '2024-08-18 15:06:14'),
(5, 'okika', 'WAEC Registration', 'waec-registraion', '0908', '14450.00', '2024081908147852e64f', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-19 07:14:17', 'waec', '', '', '', 'successful', '2024-08-19 06:14:17', '2024-08-19 06:14:17'),
(6, 'okika', 'WAEC Registration', 'waec-registraion', '08011111111', '14450.00', '20240819082064793f9f', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-19 07:20:57', 'waec', '', '', '', 'successful', '2024-08-19 06:20:57', '2024-08-19 06:20:57'),
(7, 'okika', 'WAEC Registration', 'waec-registraion', '08011111111', '14450.00', '2024081908573682d627', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-19 07:57:52', 'waec', '', '', '', 'successful', '2024-08-19 06:57:52', '2024-08-19 06:57:52'),
(8, 'okika', 'waec', 'waecdirect', '09087', '900.00', '2024081909052bb8cb68', 'Serial No:WRN182135587, pin: 373820665258', 'TRANSACTION SUCCESSFUL', '2024-08-19 08:05:54', 'waec', '', '', '', 'successful', '2024-08-19 07:05:54', '2024-08-19 07:05:54'),
(9, 'okika', 'waec', 'waecdirect', '09087', '1800.00', '2024081909085306da1f', 'Serial No:WRN182135587, pin: 373820665258||Serial No:WRN182135588, pin: 373827897584', 'TRANSACTION SUCCESSFUL', '2024-08-19 08:08:08', 'waec', '', '', '', 'successful', '2024-08-19 07:08:08', '2024-08-19 07:08:08'),
(10, 'okika', 'waec', 'waecdirect', '09087', '1800.00', '202408190910e424d764', 'Serial No:WRN182135587, pin: 373820665258||Serial No:WRN182135588, pin: 373827897584', 'TRANSACTION SUCCESSFUL', '2024-08-19 08:10:36', 'waec', '', '', '', 'successful', '2024-08-19 07:10:36', '2024-08-19 07:10:36'),
(11, 'okika', 'waec', 'waecdirect', '0904793324', '900.00', '2024081909125396a238', 'Serial No:WRN182135587, pin: 373820665258', 'TRANSACTION SUCCESSFUL', '2024-08-19 08:12:46', 'waec', '', '', '', 'successful', '2024-08-19 07:12:46', '2024-08-19 07:12:46'),
(12, 'okika', 'waec', 'waecdirect', '0904793324', '900.00', '202408190914bcd0aec1', 'Serial No:WRN182135587, pin: 373820665258', 'TRANSACTION SUCCESSFUL', '2024-08-19 08:14:06', 'waec', '', '', '', 'successful', '2024-08-19 07:14:06', '2024-08-19 07:14:06'),
(13, 'okika', 'waec', 'waecdirect', '0904793324', '1800.00', '2024081909175cb1d039', 'Serial No:WRN182135587, pin: 373820665258||Serial No:WRN182135588, pin: 373827897584', 'TRANSACTION SUCCESSFUL', '2024-08-19 08:17:25', 'waec', '', '', '', 'successful', '2024-08-19 07:17:25', '2024-08-19 07:17:25'),
(14, 'okika', 'Jamb', 'utme', '0908776', '4700.00', '20240820154650050f17', 'Pin : 367574683050773', 'TRANSACTION SUCCESSFUL', '2024-08-20 14:46:17', 'Jamb', '', '', '', 'successful', '2024-08-20 13:46:17', '2024-08-20 13:46:17'),
(15, 'okika', 'Jamb', 'utme', '0908776', '4700.00', '20240820154856bdd9de', 'Pin : 367574683050773', 'TRANSACTION SUCCESSFUL', '2024-08-20 14:48:06', 'Jamb', '', '', '', 'successful', '2024-08-20 13:48:06', '2024-08-20 13:48:06'),
(16, 'okika', 'Third Party Motor Insurance - Universal Insurance', '2', '09047933240', '5000.00', '202408231215d911d337', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-08-23 11:15:51', 'Third Party Motor Insurance', '', '', '', 'successful', '2024-08-23 10:15:51', '2024-08-23 10:15:51'),
(17, 'okika', 'WAEC Registration', 'waec-registraion', '0908', '14450.00', '20240824084840c90123', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-24 07:48:48', 'waec', '', '', '', 'successful', '2024-08-24 06:48:48', '2024-08-24 06:48:48'),
(18, 'henryleo4', 'WAEC Registration', 'waec-registraion', '0908', '14450.00', '2024082708442b6c7fed', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-27 07:44:16', 'waec', '', '', '', 'successful', '2024-08-27 06:44:16', '2024-08-27 06:44:16'),
(19, 'henryleogee', 'WAEC Registration', 'waec-registraion', '0908', '14450.00', '202408281627087cf890d4', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-28 15:27:09', 'waec', '', '', '', 'successful', '2024-08-28 14:27:09', '2024-08-28 14:27:09'),
(20, 'henryleogee', 'WAEC Registration', 'waec-registraion', '0908', '14450.00', '202408281629457da38fa0', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-08-28 15:29:46', 'waec', '', '', '', 'successful', '2024-08-28 14:29:46', '2024-08-28 14:29:46'),
(21, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450.00', '20240915134445319216fa', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 12:44:47', 'waec', '', '', '', 'successful', '2024-09-15 11:44:47', '2024-09-15 11:44:47'),
(22, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '-7225', '20240915141540096268e9', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 13:15:43', 'waec', '1597717.11', '1604942.11', '21675', 'successful', '2024-09-15 12:15:43', '2024-09-15 12:15:43'),
(23, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450.00', '2024091514321555b876d4', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 13:32:23', 'waec', '1604942.11', '1590492.11', '0', 'successful', '2024-09-15 12:32:23', '2024-09-15 12:32:23'),
(24, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450.00', '2024091514500080ef7af5', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 13:50:02', 'waec', '1590492.11', '1576042.11', '0', 'successful', '2024-09-15 12:50:02', '2024-09-15 12:50:02'),
(25, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450.00', '2024091515033561889ac3', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:03:37', 'waec', '1576042.11', '1561592.11', '0', 'successful', '2024-09-15 13:03:37', '2024-09-15 13:03:37'),
(26, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '202409151510258b0aee7a', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:10:27', 'waec', '1561592.11', '1547142.11', '0', 'successful', '2024-09-15 13:10:27', '2024-09-15 13:10:27'),
(27, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '2024091515131336ba4140', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:13:15', 'waec', '1547142.11', '1532692.11', '0', 'successful', '2024-09-15 13:13:15', '2024-09-15 13:13:15'),
(28, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '202409151520069ee647da', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:20:10', 'waec', '1532692.11', '1518242.11', '0', 'successful', '2024-09-15 13:20:10', '2024-09-15 13:20:10'),
(29, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '2024091515292268bae8e1', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:29:24', 'waec', '1518242.11', '1503792.11', '0', 'successful', '2024-09-15 13:29:24', '2024-09-15 13:29:24'),
(30, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '43350', '2024091515300314d646b9', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:30:05', 'waec', '1503792.11', '1460442.11', '0', 'successful', '2024-09-15 13:30:05', '2024-09-15 13:30:05'),
(31, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '20240915153230cb28c0f2', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:32:32', 'waec', '1460442.11', '1445992.11', '0', 'successful', '2024-09-15 13:32:32', '2024-09-15 13:32:32'),
(32, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '202409151534430f0f3e00', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 14:34:44', 'waec', '1445992.11', '1431542.11', '0', 'successful', '2024-09-15 13:34:44', '2024-09-15 13:34:44'),
(33, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '2024091516173760ba239f', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 15:17:39', 'waec', '1431542.11', '1417092.11', '0', 'successful', '2024-09-15 14:17:39', '2024-09-15 14:17:39'),
(34, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '20240915210616dc33b624', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:06:19', 'waec', '1417092.11', '1402642.11', '0', 'successful', '2024-09-15 19:06:19', '2024-09-15 19:06:19'),
(35, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '20240915210905a4c3e5b7', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:09:09', 'waec', '1402642.11', '1388192.11', '0', 'successful', '2024-09-15 19:09:09', '2024-09-15 19:09:09'),
(36, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '20240915210910e816b671', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:09:14', 'waec', '1388192.11', '1373742.11', '0', 'successful', '2024-09-15 19:09:14', '2024-09-15 19:09:14'),
(37, 'henryleogee', 'WAEC Registration', 'waec-registraion', '0908', '14450', '202409152123122e3bb5be', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:23:17', 'waec', '1373742.11', '1359292.11', '0', 'successful', '2024-09-15 19:23:17', '2024-09-15 19:23:17'),
(38, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '202409152129527cfc7b32', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:29:55', 'waec', '1359292.11', '1344992.11', '150', 'successful', '2024-09-15 19:29:55', '2024-09-15 19:29:55'),
(39, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '202409152130592e9e72ac', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:31:02', 'waec', '1344992.11', '1330692.11', '150', 'successful', '2024-09-15 19:31:02', '2024-09-15 19:31:02'),
(40, 'henryleogee', 'waec', 'waecdirect', '09087', '900', '20240915214200c706ebf7', 'Serial No:WRN182135587, pin: 373820665258', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:42:02', 'waec', '1330692.11', '1330042.11', '250', 'successful', '2024-09-15 19:42:02', '2024-09-15 19:42:02'),
(41, 'henryleogee', 'WAEC Registration', 'waec-registraion', '08011111111', '14450', '2024092620224232d2d1b6', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-26 19:22:45', 'waec', '1046973.29', '1032673.29', '150', 'successful', '2024-09-26 18:22:45', '2024-09-26 18:22:45'),
(42, 'henryleogee', 'WAEC Registration', 'waec-registraion', '0908', '14450', '20240926203241faeb9f59', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-26 19:32:43', 'waec', '1032673.29', '1018373.29', '150', 'successful', '2024-09-26 18:32:43', '2024-09-26 18:32:43'),
(43, 'henryleogee', 'WAEC Registration', 'waec-registraion', '0908', '14450', '202409262032434c7b8d85', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-26 19:32:45', 'waec', '1018373.29', '1004073.29', '150', 'successful', '2024-09-26 18:32:45', '2024-09-26 18:32:45'),
(44, 'henryleogee', 'WAEC Registration', 'waec-registraion', '0908', '14450', '2024092620325509903d35', 'Token: 0100070365657400875', 'TRANSACTION SUCCESSFUL', '2024-09-26 19:32:56', 'waec', '1004073.29', '989773.29', '150', 'successful', '2024-09-26 18:32:56', '2024-09-26 18:32:56'),
(45, 'okikaarinze@gmail.com', 'waec', 'waecdirect', '08011111111', '900', '20250302145645c19e22b8', 'Serial No:WRN182135587, pin: 373820665258||Serial No:WRN182135588, pin: 373827897584||Serial No:WRN182135589, pin: 373833873043', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:57:10', 'waec', '140238.50', '139348.5', '10', 'successful', '2025-03-02 18:57:10', '2025-03-02 18:57:10'),
(46, 'okikaarinze@gmail.com', 'waec', 'waecdirect', '08011111111', '900', '202503021456453049c8c2', 'Serial No:WRN182135587, pin: 373820665258||Serial No:WRN182135588, pin: 373827897584||Serial No:WRN182135589, pin: 373833873043', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:57:10', 'waec', '140238.50', '139348.5', '10', 'successful', '2025-03-02 18:57:10', '2025-03-02 18:57:10'),
(47, 'okikaarinze@gmail.com', 'waec', 'waecdirect', '08011111111', '900', '20250302145645116a1214', 'Serial No:WRN182135587, pin: 373820665258||Serial No:WRN182135588, pin: 373827897584||Serial No:WRN182135589, pin: 373833873043', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:57:10', 'waec', '140238.50', '139348.5', '10', 'successful', '2025-03-02 18:57:10', '2025-03-02 18:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `eletricity_transactions`
--

CREATE TABLE `eletricity_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `purchased_code` varchar(255) NOT NULL,
  `response_description` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(225) NOT NULL,
  `current_bal` varchar(225) NOT NULL,
  `percent_profit` varchar(225) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eletricity_transactions`
--

INSERT INTO `eletricity_transactions` (`id`, `username`, `product_name`, `type`, `tel`, `amount`, `transaction_id`, `purchased_code`, `response_description`, `transaction_date`, `identity`, `prev_bal`, `current_bal`, `percent_profit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'henryleo4', 'ikeja-electric', 'prepaid', '09047933240', '1000', '20240824111489htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2024-08-24 10:14:02', 'ikeja-electric', '', '', '', 'successful', '2024-08-24 09:14:02', '2024-08-24 09:14:02'),
(2, 'henryleo4', 'ikeja-electric', 'prepaid', '2349047933240', '1000', '20240824111689htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2024-08-24 10:16:15', 'ikeja-electric', '', '', '', 'successful', '2024-08-24 09:16:15', '2024-08-24 09:16:15'),
(3, 'henryleo4', 'eko-electric', 'prepaid', '09047933240', '1000', '20240824111789htyyo', 'Token : 11786621902768210244', 'TRANSACTION SUCCESSFUL', '2024-08-24 10:17:56', 'eko-electric', '', '', '', 'successful', '2024-08-24 09:17:56', '2024-08-24 09:17:56'),
(4, 'henryleo4', 'ikeja-electric', 'prepaid', '09047933240', '1000', '20240826144489htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2024-08-26 13:44:55', 'ikeja-electric', '', '', '', 'successful', '2024-08-26 12:44:55', '2024-08-26 12:44:55'),
(5, 'henryleo4', 'ikeja-electric', 'prepaid', '09047933240', '1000', '20240827084589htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2024-08-27 07:45:29', 'ikeja-electric', '', '', '', 'successful', '2024-08-27 06:45:29', '2024-08-27 06:45:29'),
(6, 'henryleogee', 'ikeja-electric', 'prepaid', '0908872', '1330', '2024090708542089htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2024-09-07 07:54:21', '1111111111111', '', '', '', 'successful', '2024-09-07 06:54:21', '2024-09-07 06:54:21'),
(7, 'henryleogee', 'Ikeja_Electric_Payment_-_IKEDC', 'prepaid', '08011111111', '1000', '2024091510023889htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2024-09-15 09:02:47', '1111111111111', '2073876.19', '2072876.19', '0', 'successful', '2024-09-15 08:02:47', '2024-09-15 08:02:47'),
(8, 'henryleogee', 'Ikeja_Electric_Payment_-_IKEDC', 'prepaid', '2349047933240', '1000', '2024092616503889htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2024-09-26 15:50:40', '1111111111111', '1310020.17', '1309020.17', '0', 'successful', '2024-09-26 14:50:40', '2024-09-26 14:50:40'),
(9, 'Longevity', 'Enugu_Electric_-_EEDC', 'prepaid', '08142751701', '1000', '2024102409165289htyyo', 'Token : 43747747406311494139', 'TRANSACTION SUCCESSFUL', '2024-10-24 08:16:56', '45022291988', '8576.23', '7590.23', '14', 'successful', '2024-10-24 12:16:56', '2024-10-24 12:16:56'),
(10, 'Babyluv', 'Enugu_Electric_-_EEDC', 'prepaid', '08142751701', '500', '2024112213035089htyyo', 'Token : 18246014015181503534', 'TRANSACTION SUCCESSFUL', '2024-11-22 12:03:54', '45022291988', '6403.50', '5910.5', '7', 'successful', '2024-11-22 17:03:54', '2024-11-22 17:03:54'),
(11, 'okikaarinze@gmail.com', 'Ikeja_Electric_Payment_-_IKEDC', 'prepaid', '09011111111', '1000', '2025030214164989htyyo', 'Token : 26362054405982757802', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:17:01', '1111111111111', '158305.00', '157315', '10', 'successful', '2025-03-02 18:17:01', '2025-03-02 18:17:01'),
(12, 'okikaarinze@gmail.com', 'Eko_Electric_Payment_-_EKEDC', 'prepaid', '09011111111', '1000', '2025030214174889htyyo', 'Token : 11786621902768210244', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:18:02', '1111111111111', '157315.00', '156325', '10', 'successful', '2025-03-02 18:18:02', '2025-03-02 18:18:02'),
(13, 'okikaarinze@gmail.com', 'Abuja_Electricity_Distribution_Company_-_AEDC', 'prepaid', '09011111111', '1000', '2025030214193489htyyo', 'Token : token: 47133458396693522090', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:19:46', '1111111111111', '156325.00', '155330', '5', 'successful', '2025-03-02 18:19:46', '2025-03-02 18:19:46'),
(14, 'okikaarinze@gmail.com', 'KEDCO_-_Kano_Electric', 'prepaid', '09011111111', '1000', '2025030214253989htyyo', '', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:25:52', '1111111111111', '155330.00', '154340', '10', 'successful', '2025-03-02 18:25:52', '2025-03-02 18:25:52'),
(15, 'okikaarinze@gmail.com', 'PHED_-_Port_Harcourt_Electric', 'prepaid', '09011111111', '1000', '2025030214262489htyyo', 'Token: 35419981304203731832', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:26:35', '1111111111111', '154340.00', '153360', '20', 'successful', '2025-03-02 18:26:35', '2025-03-02 18:26:35'),
(16, 'okikaarinze@gmail.com', 'Jos_Electric_-_JED', 'prepaid', '09011111111', '1000', '2025030214270789htyyo', 'Token : 3737-6908-5436-2208-2124', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:27:19', '1111111111111', '153360.00', '152369', '9', 'successful', '2025-03-02 18:27:19', '2025-03-02 18:27:19'),
(17, 'okikaarinze@gmail.com', 'PHED_-_Port_Harcourt_Electric', 'prepaid', '09011111111', '1000', '2025030214305389htyyo', 'Token: 35419981304203731832', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:31:05', '1111111111111', '152369.00', '151389', '20', 'successful', '2025-03-02 18:31:05', '2025-03-02 18:31:05'),
(18, 'okikaarinze@gmail.com', 'Jos_Electric_-_JED', 'prepaid', '09011111111', '1000', '2025030214312789htyyo', 'Token : 3737-6908-5436-2208-2124', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:31:41', '1111111111111', '151389.00', '150398', '9', 'successful', '2025-03-02 18:31:41', '2025-03-02 18:31:41'),
(19, 'okikaarinze@gmail.com', 'Enugu_Electric_-_EEDC', 'prepaid', '09011111111', '1000', '2025030214330689htyyo', 'Token : 07865700760175033702', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:33:19', '1111111111111', '150398.00', '149412', '14', 'successful', '2025-03-02 18:33:19', '2025-03-02 18:33:19'),
(20, 'okikaarinze@gmail.com', 'Benin_Electricity_-_BEDC', 'prepaid', '09011111111', '1000', '2025030214342389htyyo', 'Token : 36001644489787932779', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:34:37', '1111111111111', '149412.00', '148427', '15', 'successful', '2025-03-02 18:34:37', '2025-03-02 18:34:37'),
(21, 'okikaarinze@gmail.com', 'Aba_Electric_Payment_-_ABEDC', 'prepaid', '09011111111', '1000', '2025030214351489htyyo', '', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:35:26', '1111111111111', '148427.00', '147432', '5', 'successful', '2025-03-02 18:35:26', '2025-03-02 18:35:26'),
(22, 'okikaarinze@gmail.com', 'Yola_Electric_Disco_Payment_-_YEDC', 'prepaid', '09011111111', '1000', '2025030214360589htyyo', 'Token : 0009-0860-3703-3721-8537', 'TRANSACTION SUCCESSFUL', '2025-03-02 13:36:17', '1111111111111', '147432.00', '146444', '12', 'successful', '2025-03-02 18:36:17', '2025-03-02 18:36:17');

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
-- Table structure for table `fund_transactions`
--

CREATE TABLE `fund_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(225) NOT NULL,
  `username` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `prev_bal` varchar(111) NOT NULL,
  `current_bal` varchar(111) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fund_transactions`
--

INSERT INTO `fund_transactions` (`id`, `user_id`, `username`, `tel`, `amount`, `transaction_id`, `identity`, `status`, `prev_bal`, `current_bal`, `created_at`, `updated_at`) VALUES
(49, 'UIDDCC92D2546', 'Hartz', '09086337336', 100.00, 'MNFY|02|20241226082024|046241', 'monnify', 'SUCCESS', '600.00', '700', '2024-12-26 12:21:03', '2024-12-26 12:21:03'),
(50, 'UIDAC281CC382', 'author', '09089389903', 100.00, 'MNFY|01|20241226082439|003196', 'monnify', 'SUCCESS', '0.00', '100', '2024-12-26 12:26:36', '2024-12-26 12:26:36'),
(51, 'UID38D0D96F44', 'Babyluv', '09013680640', 6000.00, 'TXN-20241226135334sfBhv', 'Manual Funding', 'Success', '849.50', '6849.5', '2024-12-26 18:53:34', '2024-12-26 18:53:34'),
(52, 'UID38D0D96F44', 'Babyluv', '09013680640', 6000.00, 'TXN-20241226135810hoxAI', 'Manual Funding', 'Success', '849.50', '6849.5', '2024-12-26 18:58:10', '2024-12-26 18:58:10'),
(53, 'UID38D0D96F44', 'Babyluv', '09013680640', 6000.00, 'TXN-20241226135824ZSQ6J', 'Manual Funding', 'Success', '849.50', '6849.5', '2024-12-26 18:58:24', '2024-12-26 18:58:24'),
(54, 'UID38D0D96F44', 'Babyluv', '09013680640', 6000.00, 'TXN-20241226135915k0X6I', 'Manual Funding', 'Success', '849.50', '6849.5', '2024-12-26 18:59:15', '2024-12-26 18:59:15'),
(55, 'UIDBE35BC0A98', 'Longevity', '08142751701', 5000.00, 'TXN-20250113153927rUt8w', 'Manual Funding', 'Success', '0.00', '5000', '2025-01-13 20:39:27', '2025-01-13 20:39:27'),
(56, 'UIDBE35BC0A98', 'Longevity', '08142751701', 1000.00, 'TXN-20250116100422ginJ0', 'Manual Funding', 'SUCCESS', '0.00', '1000', '2025-01-16 15:04:22', '2025-01-16 15:06:11'),
(57, 'UIDBE35BC0A98', 'Longevity', '08142751701', 1050.00, 'TXN-202501161316329qy3v', 'Manual Funding', 'SUCCESS', '950.00', '2000', '2025-01-16 18:16:32', '2025-01-16 18:17:12'),
(58, 'UIDBE35BC0A98', 'Longevity', '08142751701', 100.00, 'MNFY|81|20250206104549|007144', 'monnify', 'SUCCESS', '2950.00', '3050', '2025-02-06 14:46:42', '2025-02-06 14:46:42'),
(59, 'UID128FDE28138', 'okikaarinze@gmail.com', '07017325724', 40000.00, 'TXN-202503021032479aC7W', 'Manual Funding', 'SUCCESS', '0.00', '40000', '2025-03-02 15:32:47', '2025-03-02 17:23:25'),
(60, 'UID128FDE28138', 'okikaarinze@gmail.com', '07017325724', 20000.00, 'TXN-20250421165415CsTUj', 'Manual Funding', 'SUCCESS', '139348.50', '159348.5', '2025-04-21 20:54:15', '2025-04-21 20:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_transactions`
--

CREATE TABLE `insurance_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `purchased_code` text DEFAULT NULL,
  `response_description` text DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(225) NOT NULL,
  `current_bal` varchar(225) NOT NULL,
  `percent_profit` varchar(225) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurance_transactions`
--

INSERT INTO `insurance_transactions` (`id`, `username`, `product_name`, `type`, `tel`, `amount`, `transaction_id`, `purchased_code`, `response_description`, `transaction_date`, `identity`, `prev_bal`, `current_bal`, `percent_profit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'okika', 'Third Party Motor Insurance - Universal Insurance', '1', '09047933240', 3000.00, '20240823132230af7122', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-08-23 11:22:28', 'Third Party Motor Insurance', '', '', '', 'successful', '2024-08-23 11:22:28', '2024-08-23 11:22:28'),
(2, 'okika', 'Health Insurance - HMO', 'option-a', '09047933240', 2500.00, '202408231444c3a27c1d', '', 'TRANSACTION SUCCESSFUL', '2024-08-23 12:44:41', 'Health Insurance', '', '', '', 'successful', '2024-08-23 12:44:41', '2024-08-23 12:44:41'),
(3, 'henryleo4', 'Third Party Motor Insurance - Universal Insurance', '1', '09047933240', 3000.00, '20240828074144a6dad41a', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-08-28 05:41:45', 'Third Party Motor Insurance', '', '', '', 'successful', '2024-08-28 05:41:45', '2024-08-28 05:41:45'),
(4, 'henryleogee', 'Third Party Motor Insurance - Universal Insurance', '1', '09086337336', 3000.00, '20240915221147b4f63400', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:11:49', 'Third Party Motor Insurance', '1330042.11', '1327222.11', '180', 'successful', '2024-09-15 20:11:49', '2024-09-15 20:11:49'),
(5, 'henryleogee', 'Third Party Motor Insurance - Universal Insurance', '2', '09047933240', 5000.00, '2024091522235089cd25b1', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:23:53', 'Third Party Motor Insurance', '1327222.11', '1322522.11', '4700', 'successful', '2024-09-15 20:23:53', '2024-09-15 20:23:53'),
(6, 'henryleogee', 'Third Party Motor Insurance - Universal Insurance', '1', '09088763857', 3000.00, '20240915223336a85f7e1b', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-09-15 20:33:38', 'Third Party Motor Insurance', '1322522.11', '1319702.11', '180', 'successful', '2024-09-15 20:33:38', '2024-09-15 20:33:38'),
(7, 'henryleogee', 'Testimetri Adams', 'option-a', '09088763857', 2250.00, '20240915230359c801c5f7', '', 'TRANSACTION SUCCESSFUL', '2024-09-15 21:04:01', 'Health Insurance', '1319702.11', '1317452.11', '250', 'successful', '2024-09-15 21:04:01', '2024-09-15 21:04:01'),
(8, 'henryleogee', 'Testimetri Adams', 'option-b', '09088763857', 3600.00, '202409152315403a6aa141', '', 'TRANSACTION SUCCESSFUL', '2024-09-15 21:15:42', 'Health Insurance', '1317452.11', '1313852.11', '400', 'successful', '2024-09-15 21:15:42', '2024-09-15 21:15:42'),
(9, 'henryleogee', 'Personal Accident Insurance', 'option-a', '09086337336', 2250.00, '2024091523205522d87411', 'Testimetri Adams', 'TRANSACTION SUCCESSFUL', '2024-09-15 21:20:57', 'Health Insurance', '1313852.11', '1311602.11', '250', 'successful', '2024-09-15 21:20:57', '2024-09-15 21:20:57'),
(10, 'henryleogee', 'Third Party Motor Insurance - Universal Insurance', '2', '09047933240', 5000.00, '202409261752047f962036', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-09-26 15:52:06', 'Third Party Motor Insurance', '1309020.17', '1304320.17', '300', 'successful', '2024-09-26 15:52:06', '2024-09-26 15:52:06'),
(11, 'henryleogee', 'Third Party Motor Insurance - Universal Insurance', '1', '09086337336', 3000.00, '20240926180820bcee254a', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-09-26 16:08:21', 'Third Party Motor Insurance', '1304320.17', '1301500.17', '180', 'successful', '2024-09-26 16:08:21', '2024-09-26 16:08:21'),
(12, 'henryleogee', 'Third Party Motor Insurance - Universal Insurance', '1', '09047933240', 3000.00, '202409261816232fc05037', 'Download Certificate : https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038', 'TRANSACTION SUCCESSFUL', '2024-09-26 16:16:25', 'Third Party Motor Insurance', '1301500.17', '1298680.17', '180', 'successful', '2024-09-26 16:16:25', '2024-09-26 16:16:25');

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
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pages` varchar(255) DEFAULT NULL,
  `pages_id` varchar(225) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `pages`, `pages_id`, `action`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'admin.dashboard', '1', '2024-09-28 12:07:15', '2025-01-16 19:13:14'),
(2, 'Manage users', 'manage', '1', '2024-09-28 12:07:15', '2025-01-16 19:13:11'),
(3, 'Credit User account', 'creditUserAccount', '1', '2024-09-28 12:07:15', '2025-01-16 19:13:05'),
(4, 'Airtime', 'adminAirtime', '1', '2024-09-28 12:07:15', '2025-01-16 19:12:56'),
(5, 'Internet Data', 'adminData', '1', '2024-09-28 12:07:15', '2025-01-16 19:12:47'),
(6, 'Electricity', 'adminElectricity', '1', '2024-09-28 12:07:15', '2025-01-16 19:12:36'),
(7, 'Tv Subscription', 'adminTv', '1', '2024-09-28 12:07:15', '2025-01-16 19:12:41'),
(8, 'Education', 'adminEducation', '1', '2024-09-28 12:07:15', '2025-01-16 19:12:29'),
(9, 'Insurance', 'adminInsurance', '1', '2024-09-28 12:07:15', '2025-01-16 19:11:40'),
(10, 'Messages', 'message', '1', '2024-09-28 12:07:15', '2025-01-16 19:11:31'),
(11, 'Notifications', 'notification', '1', '2024-09-28 12:07:15', '2025-01-16 19:11:22'),
(12, 'Site Setting', 'site_setting', '1', '2024-09-28 12:07:15', '2025-01-16 19:14:35'),
(13, 'Edit Profile', 'edit_profile', '1', '2024-09-28 12:07:15', '2025-01-16 19:10:59'),
(14, 'Add New User/Merchant', 'add_account', '1', '2024-09-28 12:07:15', '2025-01-24 22:58:07'),
(15, 'View Merchant', 'marchant', '1', '2024-09-28 12:07:15', '2025-01-24 22:58:10'),
(16, 'Wallet summary', 'walletSummary.admin', '1', '2024-09-28 12:07:15', '2025-01-16 19:10:51'),
(17, 'Logout', 'logout', '1', '2024-09-28 12:07:15', '2024-09-30 17:24:51'),
(18, 'Dashboard', 'dashboard', '1', '2024-09-28 12:12:58', '2024-09-28 16:33:25'),
(19, 'Buy Airtime', 'airtime', '1', '2024-09-28 12:12:58', '2024-09-28 16:33:34'),
(20, 'Buy Internet Data', 'data', '1', '2024-09-28 12:12:58', '2024-09-28 16:33:38'),
(21, 'Buy Electricity', 'electricity', '1', '2024-09-28 12:12:58', '2025-01-24 22:56:21'),
(22, 'Buy TV Subscription', 'tv', '1', '2024-09-28 12:12:58', '2025-01-24 22:56:15'),
(23, 'Education', 'education', '1', '2024-09-28 12:12:58', '2024-09-28 13:18:30'),
(24, 'Insurance', 'insurance', '1', '2024-09-28 12:12:58', '2025-01-16 19:11:03'),
(25, 'Fund Wallet', 'dashboard', '1', '2024-09-28 12:12:58', '2025-01-16 19:13:28'),
(29, 'Transaction History', 'usertransactions', '1', '2024-09-28 12:12:58', '2024-09-28 16:34:30'),
(30, 'Support', 'usersupport', '1', '2024-09-28 12:12:58', '2024-09-28 16:34:35'),
(31, 'Setting', 'user.setting', '1', '2024-09-28 12:12:58', '2024-09-28 16:17:11'),
(32, 'Logout', 'logout', '1', '2024-09-28 12:12:58', '2024-09-28 15:03:35'),
(33, 'Wallet Summary', 'walletSummary', '1', '2024-09-28 12:12:58', '2024-09-28 17:25:38'),
(34, 'Sales & Accounting', 'calculateTransactions', '0', '2024-09-28 12:12:58', '2025-01-11 20:14:00'),
(35, 'Generate CSV', 'generateUserEmailsCSV', '0', '2024-09-28 12:12:58', '2025-01-11 20:13:52');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `username`, `message`, `created_at`, `updated_at`) VALUES
(1, 'henryleogee', 'hi \r\nplease help', '2024-08-28 16:52:19', '2024-08-28 16:52:19'),
(2, 'henryleogee', 'sss', '2024-08-28 17:43:28', '2024-08-28 17:43:28'),
(3, 'henryleotec200@gmail.com', 'ssss', '2024-08-28 17:52:43', '2024-08-28 17:52:43'),
(4, 'henryleotec200@gmail.com', 'edfrfrfrfrfrfrfrfrfrfrfrfrfrfrh', '2024-08-29 03:41:51', '2024-08-29 03:41:51'),
(5, 'henryleotec200@gmail.com', 'wdwddw', '2024-08-29 03:48:13', '2024-08-29 03:48:13'),
(6, 'henryleotec200@gmail.com', 'ddddd', '2024-08-29 03:50:26', '2024-08-29 03:50:26'),
(7, 'henryleo', 'Am a programmer\newef wdwc wffw wfwf', '2024-09-09 11:53:53', '2024-09-09 11:53:53'),
(8, 'henryleo', 'Am a programmer\nww2 wdw wdw wdwd wdwd', '2024-09-09 11:54:54', '2024-09-09 11:54:54'),
(9, 'henryleo', 'Am a programmer\nggf fff fv', '2024-09-09 11:56:28', '2024-09-09 11:56:28'),
(10, 'henryleogee', 'fddddddff 12345', '2024-09-09 12:29:21', '2024-09-09 12:29:21'),
(11, 'henryleotec200@gmail.com', 'efvv', '2024-09-09 12:30:07', '2024-09-09 12:30:07'),
(12, 'henryleotec200@gmail.com', 'yu8gug98g98og9og9', '2024-10-22 17:55:32', '2024-10-22 17:55:32');

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
(4, '0001_01_01_000000_create_users_table', 1),
(5, '0001_01_01_000001_create_cache_table', 1),
(7, '0001_01_01_000002_create_jobs_table', 2),
(8, '2024_07_28_213522_create_airtimes_table', 3),
(9, '2024_07_29_193741_create_airtimestransactions_table', 4),
(10, '2024_07_29_194038_create_datatransactions_table', 4),
(11, '2024_08_18_150245_education_transactions', 5),
(12, '2024_08_23_121240_create_insurance_transactions_table', 6),
(13, '2024_08_24_052507_create_eletricity_transactions_table', 7),
(14, '2024_08_24_053013_create_tv_transactions_table', 7),
(15, '2024_08_28_173206_create_message_table', 8),
(16, '2024_08_29_053757_create_notifications_table', 9),
(17, '2024_08_29_082458_create_fund_transactions_table', 10),
(18, '2024_08_30_083735_create_referrals_table', 11),
(19, '2024_09_10_062731_create_settings_table', 12),
(20, '2024_09_11_120231_create_percentage_table', 13),
(21, '2024_09_28_114522_create_merchants_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(111) NOT NULL,
  `msghead` varchar(255) NOT NULL,
  `msgbody` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `username`, `msghead`, `msgbody`, `created_at`, `updated_at`) VALUES
(1, 'henryleogee', 'register', 'Arriving at pickup station between 06 September & 10 September when you order within next 16hrs 32mins', '2024-07-06 05:23:17', '2024-07-06 05:23:17'),
(2, 'henryleogee', 'register', 'Arriving at pickup station between 06 September & 10 September when you order within next 16hrs 32mins', '2024-07-06 05:23:17', '2024-07-06 05:23:17'),
(3, 'henryleogee', 'register', 'Arriving at pickup station between 06 September & 10 September when you order within next 16hrs 32mins', '2024-07-06 05:23:17', '2024-07-06 05:23:17'),
(4, 'henryleogee', 'register', 'Arriving at pickup station between 06 September & 10 September when you order within next 16hrs 32mins', '2024-07-06 05:23:17', '2024-07-06 05:23:17'),
(5, 'henryleogee', 'register', 'Arriving at pickup station between 06 September & 10 September when you order within next 16hrs 32mins', '2024-07-06 05:23:17', '2024-07-06 05:23:17'),
(6, 'henryleogee', 'register', 'Arriving at pickup station between 06 September & 10 September when you order within next 16hrs 32mins', '2024-07-06 05:23:17', '2024-07-06 05:23:17'),
(7, 'henryleogee', 'Am a programmer', 'The text-transform: capitalize; style has been added to the <h6> and <p> tags. This will ensure that the first letter of each word is capitalized. If you only want the first letter of the first word to be capitalized, you might need to handle this differently, as CSS alone won\'t achieve that specific effect.', '2024-09-09 12:55:04', '2024-09-09 12:55:04'),
(8, 'hart', 'Am a programmer', 'fbnhfnff  f  f', '2024-09-10 14:41:25', '2024-09-10 14:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('henryleotec2000@gmail.com', '$2y$12$xkcdR78w28irHO0HVM2afeVSKVgaEhO68y82jjt4FJzKa4pBwex92', '2024-10-24 10:54:07'),
('okikaarinze@gmail.com', '$2y$12$ZjE.jzvtgQmPRCL74iIykOZIpShiZPMQsmw/aL7JVwGy6GQSzBe86', '2024-10-23 23:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `percentages`
--

CREATE TABLE `percentages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service` varchar(255) DEFAULT NULL,
  `smart_earners_percent` varchar(255) DEFAULT NULL,
  `topuser_earners_percent` varchar(255) DEFAULT NULL,
  `api_earners_percent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `percentages`
--

INSERT INTO `percentages` (`id`, `service`, `smart_earners_percent`, `topuser_earners_percent`, `api_earners_percent`, `created_at`, `updated_at`) VALUES
(1, '9mobile_GIFTING_Data', '4.00', '4.00', '4.00', NULL, '2024-09-14 05:55:32'),
(2, 'Aba_Electric_Payment_-_ABEDC', '0.5', '1', '1', NULL, '2025-01-16 18:57:25'),
(3, 'Abuja_Electricity_Distribution_Company_-_AEDC', '0.5', '0.5', '0.5', NULL, '2025-01-16 18:59:16'),
(4, 'Airtel_Airtime_VTU', '1', '2', '3', NULL, '2024-11-22 12:29:05'),
(5, 'Airtel_GIFTING_Data', '1', '2', '2', NULL, '2025-01-16 18:43:22'),
(6, 'Benin_Electricity_-_BEDC', '1.50', '1.50', '1.50', NULL, '2024-09-14 05:57:40'),
(7, 'DSTV_Subscription', '1.50%', '1.50%', '1.50%', NULL, NULL),
(8, 'Eko_Electric_Payment_-_EKEDC', '1.00', '1.00', '1.00', NULL, '2024-09-14 05:57:54'),
(9, 'Enugu_Electric_-_EEDC', '1.40', '1.40', '1.40', NULL, '2024-09-14 05:58:13'),
(10, '9mobile_Airtime_VTU', '2', '2', '2', NULL, '2025-01-16 18:26:41'),
(11, '9mobile_CORPORATE_GIFTING_Data', '4', '2', '2', NULL, '2025-01-16 18:37:24'),
(12, 'GLO_Airtime_VTU', '1', '2', '3', NULL, '2024-11-22 12:26:36'),
(13, 'GLO_GIFTING_Data', '3', '4.00', '4.00', NULL, '2024-11-22 16:57:06'),
(14, 'GLO_CORPORATE_GIFTING_Data', '4.00', '4.00', '4.00', NULL, '2024-09-14 05:56:50'),
(15, 'Gotv_Payment', '1.50', '1.50', '1.50', NULL, '2024-09-14 06:05:57'),
(16, 'Home_Cover_Insurance', '6.00%', '6.00%', '6.00%', NULL, NULL),
(17, 'IBEDC_-_Ibadan_Electricity_Distribution_Company', '1.10', '1.10', '1.10', NULL, '2024-09-14 05:58:29'),
(18, 'Ikeja_Electric_Payment_-_IKEDC', '1.00', '1.00', '1.00', NULL, '2024-09-14 05:59:02'),
(19, 'Jos_Electric_-_JED', '0.90', '0.90', '0.90', NULL, '2024-09-14 05:59:17'),
(20, 'Kaduna_Electric_-_KAEDCO', '1.50', '1.50', '1.50', NULL, '2024-09-14 05:59:40'),
(21, 'KEDCO_-_Kano_Electric', '1.00', '2.00', '1.00', NULL, '2024-09-14 06:00:00'),
(22, 'MTN_Airtime_VTU', '1', '2', '3', NULL, '2024-11-22 12:24:37'),
(23, 'MTN_SME_Data', '-2', '3.00', '3.00', NULL, '2024-10-24 00:00:08'),
(24, 'Personal_Accident_Insurance', '10.00', '10.00', '10.00', NULL, '2024-09-14 06:06:53'),
(25, 'PHED_-_Port_Harcourt_Electric', '2.00', '2.00', '2.00', NULL, '2024-09-14 06:04:30'),
(26, 'ShowMax', '1.50%', '1.50%', '1.50%', NULL, NULL),
(27, 'Smile_Payment', '5.00%', '5.00%', '5.00%', NULL, NULL),
(28, 'SMSclone.com', '3.00%', '3.00%', '3.00%', NULL, NULL),
(29, 'Spectranet_Internet_Data', '3.00%', '3.00%', '3.00%', NULL, NULL),
(30, 'Startimes_Subscription', '2.00%', '2.00%', '2.00%', NULL, NULL),
(31, 'Third_Party_Motor_Insurance_-_Universal_Insurance', '6.00', '6.00', '6.00', NULL, '2024-09-14 06:07:05'),
(32, 'WAEC_Result_Checker_PIN', '10', '10', '10', NULL, '2024-11-22 17:27:51'),
(33, 'WAEC_Registration_PIN', '150', '150', '150', NULL, NULL),
(34, 'Yola_Electric_Disco_Payment_-_YEDC', '1.20', '1.20', '1.20', NULL, '2024-09-14 06:05:27'),
(35, 'VTpass_POS_Terminal_Payment', '-', '-', '-', NULL, NULL),
(36, 'Smile_Network_Payment', '5.00%', '5.00%', '5.00%', NULL, NULL),
(37, 'Airtel_CORPORATE_GIFTING_Data', '3.40', '3.40', '3.40', NULL, '2024-09-14 05:55:54'),
(38, 'MTN_SME2_Data', '1', '-3', '-3', NULL, '2025-01-16 18:52:15'),
(39, 'MTN_GIFTING_Data', '1.00', '2.00', '3.00', NULL, '2024-11-22 16:47:55'),
(41, 'MTN_CORPORATE_GIFTING_Data', '3.00', '3.00', '3.00', NULL, '2024-09-14 06:02:08'),
(42, 'Dstv_Payment', '1.50', '1.50', '1.50', NULL, '2024-09-14 06:05:43'),
(43, 'Startime_Payment', '1.50', '3.50', '1.50', NULL, '2024-09-14 06:06:27'),
(44, 'Showmax_Payment', '1.50', '1.50', '1.50', NULL, '2024-09-14 06:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `referral_user_id` varchar(255) NOT NULL,
  `referral_username` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `user_id`, `referral_user_id`, `referral_username`, `created_at`, `updated_at`) VALUES
(1, 'wsfwfrw', 'wrwrw', '3trtr3', NULL, NULL),
(2, '5', '10', 'gdg', '2024-08-30 09:42:56', '2024-08-30 09:42:56'),
(3, 'UID4FEB055B14', 'UIDB7D9662D21', 'Johndoe', '2024-10-24 19:08:38', '2024-10-24 19:08:38'),
(4, 'UIDF0F035C438', 'UID55A0969E40', 'Customer1', '2024-11-22 17:51:07', '2024-11-22 17:51:07'),
(5, 'UID38D0D96F44', 'UID36A3637F57', 'Johndoe', '2024-12-06 00:08:38', '2024-12-06 00:08:38'),
(6, 'UID38D0D96F44', 'UID982D0C1B57', 'Johndoe', '2024-12-06 00:11:29', '2024-12-06 00:11:29'),
(7, 'UID38D0D96F44', 'UIDAC22F7A573', 'Johndoe2', '2024-12-18 16:53:59', '2024-12-18 16:53:59'),
(8, 'UIDDCC92D2546', 'UIDAC281CC382', 'author', '2024-12-26 12:23:02', '2024-12-26 12:23:02');

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
('1fm9OaFY6WLZYpUJC3lhNUhkOPupNFAX0uOmoQ7X', NULL, '43.157.170.126', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV21RSmNlaW1BZVNhaTRiSkl5M2lkRlZucGVJbE1sT2UyQjE1bmllbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750246347),
('2XFT1o5jg5kPh3xIYLfG1SrubBFEgBZA3v5iu3bA', NULL, '18.232.36.1', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Amazonbot/0.1; +https://developer.amazon.com/support/amazonbot) Chrome/119.0.6045.214 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEd6eTNCQ25hVkhGdDVrU0tpVDhGWU83NUx0TUdwRDh2Q2l5UVp3dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750247011),
('3yM5MN0j692lkjIoohSLENPIIIrJkkkhcmZtETmz', NULL, '43.166.132.142', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicHN1eTE4UjM4VXJFSlVTZ0xjMnBSRjM3MEQ1aklJN3pPYmhWekt5aCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750218198),
('7PfXsBYYTqhl2NzMOfNCBcGo01f1mC2NEpH6Hukn', NULL, '185.39.19.97', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicko0MWQxQjB6TWJ1WDNrSWZDWkVXOVJzYWM0T1M4b0g3M0tNZ2NZcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750194888),
('8k8TSN1blewvHEEPeWqddQ0q90OJ38RLUzhbWHbG', NULL, '41.207.81.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2N3dWFTY29HbHg3V0VKYTJEUnFFbWpLbkhkcmZHWHNGV1VnQVFhZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750189071),
('8tJuHCrR93M1kgAgAoLMcz9p8QPe9Kq4H0Orx3FR', NULL, '182.40.104.255', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ21zUElnTEpXUFpKNXN6ZUptMEJDMTVkTmV6SlB0a3JDRzVFSGNQRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750237089),
('aBF7adyYwJiGhXaql3U1KHIQ3LpJ8oZy6nKfiv5F', NULL, '46.101.80.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHFlRnIwQnprTGR0N1ZZYXQ2Mzg2RnpsUkZUMXJIZFdBU25sTmU3YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750222147),
('asIkjreaUZmcuDCuoQ8KIdt8UTCXfzlPlM8aizEW', NULL, '45.230.172.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamdhbEJhS0hMTzM1MlROdVBzVEFIeDM2VFhOdlpLZFVNamhieUVSUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750241610),
('AsJze7nWJyrrPSieCMMyZ9sjDQFo1d13tVVGZBWe', NULL, '124.221.245.78', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHF1bUlvNVRkWE1EM0M5TVlzZ3BFYXZncVFERTU3UzBDSVBScVdGZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750248061),
('BYtzIsOufosS9w20bK8Z9x92ywPvq3lAZvSMYKoy', NULL, '65.21.113.253', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzlWYTVrQTNVdGxJUnJyUmt0Mk9zd1VweTJMZzJhaVdXVnNJNUt4TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9yZWdpc3RyYXRpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750234376),
('CS4aAbWKnBO0ODjHtEJ1FUbSPl3QNcE3omChko92', NULL, '3.213.213.161', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Amazonbot/0.1; +https://developer.amazon.com/support/amazonbot) Chrome/119.0.6045.214 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjNZd05IYlJyM0dMQzVzVGdQaWd5STNlc3hxUWl4VmhSOWdDY3lBSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9yZWdpc3RyYXRpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750200372),
('d7zENBEyZwmM5bPYsIEHmmUTcJtrczyz7qFt1Rj1', NULL, '43.157.142.101', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid3ZkUmF4SnZTdW1aOFlocmNRWVVTWDRmTFUyN0lxbTVERVlpaThRdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750180732),
('dK99ElXfgGvqz1n7ZvT5rFQQnwfGt0Yu4mKfhLZU', NULL, '43.153.113.127', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFA2eThUNzNVZ3VBSFRQWWMxdjNMSWFodjJ0ZUIyQm9GNXpLNHJkcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750183323),
('eXfq8j92mLYA8vTcwR7Uou1O8jceEZd38AsX4odS', NULL, '121.4.97.180', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVNobXdVTnBYMTFGZVV2UHo2cE1FSnVnSENlVjBnRnAyRFE1d0E4ZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750214871),
('fh1qedBVDA8feXokF7wOYz31KIdkx9dbfOlGy2I9', NULL, '57.141.4.14', 'meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVlGUk94cG80SjJJdVIxNzZZb1RhUU5JM2hva1BjdjU0dHBoWkUzMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750227074),
('FTE8IFZZhxXcBSb6C7X2coFlhceIDwqs8EqLcqWs', NULL, '34.225.243.131', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Amazonbot/0.1; +https://developer.amazon.com/support/amazonbot) Chrome/119.0.6045.214 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicTVWbWpDSjJ6YnhrcjZXTHpaRWlxc2EwZDNIeklmUUF5WkJPRjdadCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9mb3JnZXRfcGFzc3dvcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750250811),
('G2QGnIxkV5Dvy8Hg4JHA82PbpEwCNqO4fwivhmB0', NULL, '46.101.80.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoickp2ZU92RGNxTHhKcUZ5V2h4NjZQbVByaUFiZ21kbmVnb0dVdkVTbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9mb3JnZXRfcGFzc3dvcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750222151),
('HrTiP9I9SswsofF0vDJ8Rz3LOksLFkXjC2VZRcXl', NULL, '43.165.69.68', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVRyUGJxbHVKWHJnVjFoNXg3ckJzUHdFMTd4Njk0YnFaOWRFVTdaUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750182876),
('HTyh11ivLkPDZjueSy11XSgr4fSubrUA7nKGMC97', NULL, '49.51.50.147', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjEySWNFRU5tYjFXUEcweUxlWjFlV3FkUTRFU0FHd3lOMkdiRUpOMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750230890),
('iHT8xpTPlSlpABRVI87NF8zLEZEDfK2yIymnzOh6', NULL, '65.21.113.253', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVThvVG1RUEN2UFBGVklRVkt4cmlPbnRxalNJZXg3M1lLMEFQcUc2bCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750186696),
('J9mOlBLSZBu8gR2DWvaNghFaHz8mmAgjTBAdI5Jz', NULL, '46.101.80.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoialBPcHRKeWtSa1IwQUF4SHE1RjlUcWtwYTNoU045S2NUQ3J4dTlXWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750222148),
('jyv06DgtPEoDEEEhnf3mN7SLufRon8lCegaXBwbl', NULL, '65.21.113.253', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS09qQ2Z2b3NKZ2h2MGJlcTZ3ak5JZFJ6YjNOQkZWZmQ3WkI4T0t5cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750234373),
('MLGPwUfg27wsTkDbrW6X95lwvcIiSlLeuaVxbkV8', NULL, '182.42.111.213', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW1pd0lHU0tuUEc4OW9Yc0lGMFVhY3htSDdSNmlxeWdUYmtuam5FSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750193513),
('mlIqLA6zWDpCkoODAxBxS1fWfy7mO24OEP3KrMjj', NULL, '57.141.4.13', 'meta-externalagent/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVFCbmJseGgxWkN0V1V4WExZd1lieHB3NEhRcUFKYzN2aUdwbFhBNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750226032),
('n5KFvmcoG85t0nYAZAJxXg3xHuP2cb6iFrLRPTEM', NULL, '43.128.149.102', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjc4a2ZjM2dkOXV4cFZ2UjVQMW1wNTVwRFBab1hOME9WUW1iZVRGWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750184562),
('pN2RauXSbpszjQBsoXA8Vk6RHj9l1GWsMCgHscaK', NULL, '46.101.80.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibzROWnZnM1JTUWdWa1hNYVpxdWN4a2NpR1EydWhBcVFNaUxTV1ZrUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9yZWdpc3RyYXRpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750222150),
('QLViQ2OtVDGVP9AjY10DK2ceDSo8YbW0dBtFuDwi', NULL, '43.246.140.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRjBqeU9yaUZtQ1RnMVZKZUE0SXpHMHJQQUpyYkNsYkxRdDFYcXljaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750192051),
('QOcmhdUQi2uel7xmNHzBB2TnX3HQWq0HjRSVxFWI', NULL, '223.244.35.77', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnp4V05ROU8zTTAzUTVnZEpubFFyUzJJbmFDcGh3RXhZVDBNUlUzNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750183011),
('r37USljgYMkgcBiEWVuNS2uZrGG9pUMHcSvcDjUV', NULL, '23.229.104.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaUg2elhMclhLU2JZREhBbGZUZnRJTngzVnhaWjB3bzc3RWFHOG02TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750238761),
('s9aqKpgfT2qxu0EZdC3HJssxI4FIAFbuC5scKUed', NULL, '43.128.67.187', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1Jac3JtdVFORWk0V3VDYXhETGRZR2N4NWg0TjBIc3d2QkZldXp4QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750197035),
('SXaPYdbcogQZFway5kcUiun1FLu2860H16FqzgHc', NULL, '65.21.113.253', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWVLSEhrdXNNbXM3VUd3RkF1T2NIeDFuY3BndURINFFjeG5Xa25NVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750234371),
('TYPMJqpQw0qYPL5OHDAJ3i0gKJjxWef7qZdUa6Aj', NULL, '23.229.104.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWl1RVB1WUJWRk9UN2p0b3hYWW53WVd4aGwyaUpoSmFuS3V0QVZMeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750238746),
('uGnodqrog94KgGWKDhFrsK9VbQFJ4tQ6RqWaK1uV', NULL, '43.135.145.73', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGVDV1lBcHR5QVdJWWVhR3VOQkpOSHdsbXFXZWk3UHdxRE8xN05SRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LnRoZWVwcm9qZWN0cy5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750184205),
('WrNt2HOvQCIuJjfQGILzMh64YDKKU2PVWdqCgoAA', NULL, '74.208.194.76', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGQ0TElJY0J3amRpWkZteGpMQmVVS0VONVhJR2h2NkdLT3BnUnJsMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750217724);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `email` varchar(225) NOT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `site_token` varchar(255) DEFAULT NULL,
  `monnify_api_key` varchar(255) DEFAULT NULL,
  `monnify_contract_code` varchar(255) DEFAULT NULL,
  `airtime_api_url` varchar(255) DEFAULT NULL,
  `transaction_api_url` varchar(255) DEFAULT NULL,
  `data_network_api_url` varchar(255) DEFAULT NULL,
  `data_api_url` varchar(255) DEFAULT NULL,
  `data_mtn` varchar(225) DEFAULT NULL,
  `data_airtime` varchar(225) DEFAULT NULL,
  `electricity_pay_api_url` varchar(255) DEFAULT NULL,
  `electricity_verify_api_url` varchar(255) DEFAULT NULL,
  `tv_bouquet_api_url` varchar(255) DEFAULT NULL,
  `tv_billcode_api_url` varchar(255) DEFAULT NULL,
  `education_waec_registration_api_url` varchar(255) DEFAULT NULL,
  `education_waec_api_url` varchar(255) DEFAULT NULL,
  `education_jamb_api_url` varchar(255) DEFAULT NULL,
  `education_check_result_api_url` varchar(255) DEFAULT NULL,
  `education_jamb_verify_api_url` varchar(255) DEFAULT NULL,
  `insurance_health_insurance_api_url` varchar(255) DEFAULT NULL,
  `insurance_personal_accident_api_url` varchar(255) DEFAULT NULL,
  `insurance_ui_insure_api_url` varchar(255) DEFAULT NULL,
  `insurance_state_api_url` varchar(255) DEFAULT NULL,
  `insurance_color_api_url` varchar(255) DEFAULT NULL,
  `insurance_brand_api_url` varchar(255) DEFAULT NULL,
  `insurance_engine_capacity_api_url` varchar(255) DEFAULT NULL,
  `header_color` varchar(255) DEFAULT NULL,
  `template_color` varchar(255) DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `test_color` varchar(225) DEFAULT NULL,
  `site_bank_name` varchar(225) DEFAULT NULL,
  `site_bank_account_name` varchar(225) DEFAULT NULL,
  `site_bank_account_account` varchar(225) DEFAULT NULL,
  `site_bank_comment` text DEFAULT NULL,
  `whatsapp_number` varchar(225) NOT NULL,
  `welcome_message` text NOT NULL,
  `monnify_percent` varchar(111) NOT NULL,
  `bonus` varchar(225) NOT NULL,
  `company_address` varchar(1000) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `company_phone` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `api_key`, `email`, `secret_key`, `site_token`, `monnify_api_key`, `monnify_contract_code`, `airtime_api_url`, `transaction_api_url`, `data_network_api_url`, `data_api_url`, `data_mtn`, `data_airtime`, `electricity_pay_api_url`, `electricity_verify_api_url`, `tv_bouquet_api_url`, `tv_billcode_api_url`, `education_waec_registration_api_url`, `education_waec_api_url`, `education_jamb_api_url`, `education_check_result_api_url`, `education_jamb_verify_api_url`, `insurance_health_insurance_api_url`, `insurance_personal_accident_api_url`, `insurance_ui_insure_api_url`, `insurance_state_api_url`, `insurance_color_api_url`, `insurance_brand_api_url`, `insurance_engine_capacity_api_url`, `header_color`, `template_color`, `site_name`, `site_logo`, `test_color`, `site_bank_name`, `site_bank_account_name`, `site_bank_account_account`, `site_bank_comment`, `whatsapp_number`, `welcome_message`, `monnify_percent`, `bonus`, `company_address`, `company_email`, `company_phone`, `created_at`, `updated_at`) VALUES
(1, '7d8f0828ffe0216c336942500be11ade', 'lucysrosedataplus@gmail.com', 'SK_4483c4800d8c7750929648aede472ee24753eedbfcc', '705cfc0d749212ea4da1e0c56228fd9d6ebda99a', 'MK_PROD_FHQDK06011', '861657460624', 'https://vtpass.com/api/pay', 'https://vtpass.com/api/requery', 'https://lucysrosedata.com/api/network/', 'https://lucysrosedata.com/api/data/', 'https://vtpass.com/api/service-variations?serviceID=mtn-data', 'https://vtpass.com/api/service-variations?serviceID=airtel-data', 'https://vtpass.com/api/pay', 'https://vtpass.com/api/merchant-verify', 'https://vtpass.com/api/pay', 'https://vtpass.com/api/merchant-verify', 'https://vtpass.com/api/service-variations?serviceID=waec-registration', 'https://vtpass.com/api/service-variations?serviceID=waec', 'https://vtpass.com/api/service-variations?serviceID=jamb', 'https://vtpass.com/api/pay', 'https://vtpass.com/api/merchant-verify', 'https://vtpass.com/api/service-variations?serviceID=health-insurance-rhl', 'https://vtpass.com/api/service-variations?serviceID=personal-accident-insurance', 'https://vtpass.com/api/service-variations?serviceID=ui-insure', 'https://vtpass.com/api/universal-insurance/options/state', 'https://vtpass.com/api/universal-insurance/options/color', 'https://vtpass.com/api/universal-insurance/options/brand', 'https://vtpass.com/api/universal-insurance/options/engine-capacity', '#ad3636', '#94705c', 'E Project', 'logos/zJ30QxqU2bpJ7FZfC4dVLdKExTn1W66PIfVvkQr6.png', '#2f2d2d', 'Opay', 'Okika Arinze', '8142751702', 'You can deposit or transfer fund into our account stated above. Use your registered username as depositor\'s name, naration or remarks Your account will be funded as soon as your payment is confirmed. Ooo', '2347017325724', 'Hi, I\'m...... I have a complaint', '1.6', '5', 'Abuja Nigeria', 'theeproject@gmail.com', '08132575487', NULL, '2025-05-02 01:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `tv_transactions`
--

CREATE TABLE `tv_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `api_response` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(225) NOT NULL,
  `current_bal` varchar(225) NOT NULL,
  `percent_profit` varchar(225) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tv_transactions`
--

INSERT INTO `tv_transactions` (`id`, `username`, `api_response`, `network`, `tel`, `plan`, `amount`, `transaction_id`, `identity`, `prev_bal`, `current_bal`, `percent_profit`, `status`, `created_at`, `updated_at`) VALUES
(5, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '0908872', '1212121212', '63885', '2024090709092689htyyo', 'DSTV Subscription', '', '', '', 'successful', '2024-09-07 07:09:28', '2024-09-07 07:09:28'),
(6, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'change', '08011111111', '1212121212', '2565.00', '20240915110333NV8hE', 'DSTV Subscription', '2072876.19', '2070349.665', '38.475', 'successful', '2024-09-15 09:03:36', '2024-09-15 09:03:36'),
(7, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'change', '08011111111', '1212121212', '2565.00', '20240915110416vq7yT', 'DSTV Subscription', '2070349.67', '2067823.145', '38.475', 'successful', '2024-09-15 09:04:18', '2024-09-15 09:04:18'),
(8, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'change', '08011111111', '1212121212', '7900.00', '20240915111132JXc0K', 'DSTV Subscription', '2067823.15', '2060041.65', '118.5', 'successful', '2024-09-15 09:11:34', '2024-09-15 09:11:34'),
(9, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '2024091511215689htyyo', 'DSTV Subscription', '2060041.65', '1997114.925', '1.50', 'successful', '2024-09-15 09:21:57', '2024-09-15 09:21:57'),
(10, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '2024091511303089htyyo', 'DSTV Subscription', '1997114.93', '1934188.205', '1.50', 'successful', '2024-09-15 09:30:32', '2024-09-15 09:30:32'),
(11, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '2024091511382289htyyo', 'DSTV Subscription', '1934188.21', '1871261.485', '958.275', 'successful', '2024-09-15 09:38:25', '2024-09-15 09:38:25'),
(12, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '2024091511434789htyyo', 'DSTV Subscription', '1871261.49', '1808334.765', '1.5', 'successful', '2024-09-15 09:43:50', '2024-09-15 09:43:50'),
(13, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '2024091511464689htyyo', 'DSTV Subscription', '1808334.77', '1745408.045', '958.275', 'successful', '2024-09-15 09:46:48', '2024-09-15 09:46:48'),
(14, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'basic', '09098', '1212121212', '1674.5', '2024091511532989htyyoxxxxx', 'Startimes Subscription', '1745408.05', '1743733.55', '25.5', 'successful', '2024-09-15 09:53:30', '2024-09-15 09:53:30'),
(15, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '2024091511571689htyyo', 'DSTV Subscription', '1743733.55', '1680806.825', '958.275', 'successful', '2024-09-15 09:57:18', '2024-09-15 09:57:18'),
(16, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '20240915120157UAFbG', 'DSTV Subscription', '1680806.83', '1617880.105', '958.275', 'successful', '2024-09-15 10:01:58', '2024-09-15 10:01:58'),
(17, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'full', '08011111111', 'full', '2856.5', '2024091512134389htyyo', 'ShowMax', '1617880.11', '1615023.61', '1.50', 'successful', '2024-09-15 10:13:46', '2024-09-15 10:13:46'),
(18, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'full', '08011111111', 'full', '2856.5', '2024091512164989htyyo', 'ShowMax', '1615023.61', '1612167.11', '43.5', 'successful', '2024-09-15 10:16:51', '2024-09-15 10:16:51'),
(19, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '20240926183213R54nY', 'DSTV Subscription', '1298680.17', '1235753.445', '958.275', 'successful', '2024-09-26 16:32:21', '2024-09-26 16:32:21'),
(20, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '202409262006278JM9Z', 'DSTV Subscription', '1235753.45', '1172826.725', '958.275', 'successful', '2024-09-26 18:06:29', '2024-09-26 18:06:29'),
(21, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '20240926200749yzI4r', 'DSTV Subscription', '1172826.73', '1109900.005', '958.275', 'successful', '2024-09-26 18:07:51', '2024-09-26 18:07:51'),
(22, 'henryleogee', 'TRANSACTION SUCCESSFUL', 'renew', '08011111111', '1212121212', '62926.725', '20240926200811tW5pT', 'DSTV Subscription', '1109900.01', '1046973.285', '958.275', 'successful', '2024-09-26 18:08:13', '2024-09-26 18:08:13'),
(23, 'Babyluv', 'TRANSACTION SUCCESSFUL', 'change', '08142751701', '7552017052', '3300.00', '202412221603101N7t3', 'Gotv Payment', '4100.00', '849.5', '49.5', 'successful', '2024-12-22 20:03:14', '2024-12-22 20:03:14'),
(24, 'Babyluv', 'TRANSACTION FAILED', 'basic-weekly', '08142751701', '2027500202', '1231.25', '2024122615003989htyyoxxxxx', 'Startimes Subscription', '849.50', '-381.75', '18.75', 'successful', '2024-12-26 19:00:42', '2024-12-26 19:00:42'),
(25, 'Babyluv', 'TRANSACTION FAILED', 'basic-weekly', '08142751701', '2027500202', '1231.25', '2024122615050689htyyoxxxxx', 'Startimes Subscription', '-381.75', '-1613', '18.75', 'successful', '2024-12-26 19:05:09', '2024-12-26 19:05:09'),
(26, 'Babyluv', 'TRANSACTION FAILED', 'basic-weekly', '08142751701', '2027500202', '1231.25', '2024122619200289htyyoxxxxx', 'Startimes Subscription', '-1613.00', '-2844.25', '18.75', 'successful', '2024-12-26 23:20:07', '2024-12-26 23:20:07'),
(27, 'okikaarinze@gmail.com', 'TRANSACTION SUCCESSFUL', 'change', '09011111111', '1212121212', '4400.00', '20250302144009HtrBE', 'DSTV Subscription', '146444.00', '142110', '66', 'successful', '2025-03-02 18:40:21', '2025-03-02 18:40:21'),
(28, 'okikaarinze@gmail.com', 'TRANSACTION SUCCESSFUL', 'nova', '08142751701', '1212121212', '1871.5', '2025030214453389htyyoxxxxx', 'Startimes Subscription', '142110.00', '140238.5', '28.5', 'successful', '2025-03-02 18:45:43', '2025-03-02 18:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(225) NOT NULL,
  `email` varchar(255) NOT NULL,
  `account_balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `address` varchar(255) NOT NULL,
  `refferal_user` varchar(111) DEFAULT NULL,
  `refferal` varchar(111) NOT NULL,
  `refferal_bonus` varchar(111) NOT NULL,
  `role` int(5) NOT NULL,
  `cal` int(1) NOT NULL,
  `smart_earners` varchar(225) NOT NULL DEFAULT '1',
  `topuser_earners` varchar(225) NOT NULL DEFAULT '0',
  `api_earners` varchar(225) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `username`, `password`, `tel`, `email`, `account_balance`, `address`, `refferal_user`, `refferal`, `refferal_bonus`, `role`, `cal`, `smart_earners`, `topuser_earners`, `api_earners`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'UID92F081D61', 'Main Admin', 'hart', '$2y$12$7rL6FIj.ZgZ2.i/IZwvuI.fz0U/MgKGLrJcCiB1OJ9cF1iAHE62Ti', '+2349086337335', 'admnin@gmail.com', 63685.00, 'Anambra state,Nigeria', '', '0', '0.0', 0, 1, '1', '0', '0', NULL, NULL, '2024-07-06 05:23:17', '2024-11-25 14:31:54'),
(119, 'UID24C693292', 'Sub Admin', 'Merchant', '$2y$12$Ui9lUJvQcSd/rv9d6LmTbOC.ikJ.0brSbif0hgUBOTvoL.6znb7Ia', '09011111111', 'johndoe@gmail.com', 0.00, 'Address', 'Merchant', '0', '0', 1, 1, '1', '0', '0', NULL, NULL, '2025-02-06 16:27:23', '2025-02-06 16:27:23'),
(120, 'UIDE4FE9C3A120', 'hyvznPwmjrvMdg', 'sCRxzKjtjCrr', '$2y$12$3WsZqjLpTNwGvBvu.JdP7OyR1EtgoLiStY8G8ZXj0NeplWI2g1kjC', '9200061440', 'expanseohorizon7@gmail.com', 0.00, 'SlddBjPFA', 'GiuthRnbXoQ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-06 17:52:55', '2025-02-06 17:52:55'),
(121, 'UIDBFEEB346121', 'lGjNhaNabOMhv', 'YnyOekFEGhOiJ', '$2y$12$KPU7sgZ6caVYzOqNsxVybuNN28AyyOd9xGme9MMLNw2JMHNVr/R8C', '4231032478', 'kismetoo63glyph@gmail.com', 0.00, 'sXuEdhqI', 'pvFRyfgdoyCLUWn', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-07 15:22:11', '2025-02-07 15:22:11'),
(122, 'UID34413F48122', 'yUAHqNGZZcgSmZ', 'SfHeOzUXv', '$2y$12$U0AFWGsxos8FaEymHMYg1eQtfhsjJdZZt3a.I.qnBluRM2aw4m7AO', '3992806574', 'eqenufuy54@gmail.com', 0.00, 'TsNFbIxnCGybCs', 'XxZJRkjgPOjNXc', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-14 19:15:59', '2025-02-14 19:15:59'),
(123, 'UIDAC65A8FC123', 'ieUmZkwHHawma', 'PZPkNFCPHCnU', '$2y$12$csUS7rNTjBLC1qSTs15KWeXSKgjQNdLU/eyuiB3gJ8VrmJVrDzxy6', '3635990992', 'abebehesatuh77@gmail.com', 0.00, 'IbtyJWhrNkqT', 'wqYgeEnNr', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-15 13:54:03', '2025-02-15 13:54:03'),
(124, 'UIDB7B8586F124', 'QgQQKSKqO', 'uhVkiaGnzkb', '$2y$12$fGw1YgSgXfe9yvXyNbOWlOPVk4Vz5nm38D0JN/TWQmBa5l4.Ix3zG', '6207929807', 'veldaell6@gmail.com', 0.00, 'CVkDuoHw', 'kYwsowTTjXl', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-16 06:23:00', '2025-02-16 06:23:00'),
(125, 'UID45F5268F125', 'SopjYrkFdKAJrkl', 'lqgEqCfHOULRQI', '$2y$12$KwVvxtxRuLgotwcyY7sQy.IrvrlwuUbFioLDm4bSuGYS.YFJ3Tr1a', '9464906563', 'katibraypt@gmail.com', 0.00, 'UykFLDlRxIWq', 'UmWdJTAuk', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-16 22:18:42', '2025-02-16 22:18:42'),
(126, 'UID3CA43620126', 'vDvTKxVmUxiCD', 'bYQjLKSEPVKCpOo', '$2y$12$hJY64NsAX8jsv8xgESwatOYdLwv1nAWVeYxSuKUK0MIELjMvgBC0e', '6507090587', 'sdunnu25@gmail.com', 0.00, 'IZFlyMrkqXQBtFP', 'JsciRuMEuxZo', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-17 14:41:33', '2025-02-17 14:41:33'),
(127, 'UID2D6CAF78127', 'ViTIaRVcO', 'WLjoIvOWE', '$2y$12$u4/b2T9twpFy4HKgKrWY/uSCx.kSCqcrsN6l2vR6I1esEC6eWzXna', '4113148096', 'williamsdjessic7@gmail.com', 0.00, 'CPLBUJFv', 'cmaMiqTvNG', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-19 00:57:04', '2025-02-19 00:57:04'),
(128, 'UID8FC3B7E9128', 'KZPCxFoCPGoM', 'OgxCXXrZVRZGjMc', '$2y$12$rWmmCItEfwdqKtpM4blP5uKaaz2oHyYsI6ukilCDlrdSOoUPsKeV6', '8926852918', 'phantomaequartz98oe@gmail.com', 0.00, 'XOpiIqMBeZf', 'JFZnfxBEn', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-20 08:11:08', '2025-02-20 08:11:08'),
(129, 'UID208BF4F7129', 'fbxagMGA', 'yCWwYVKF', '$2y$12$oXJgyzJe9ziPGbnJQV9LcOqDSrx3cCyt7X9FmpW4gg3aqKvI8XO/a', '4135991743', 'lysettas1@gmail.com', 0.00, 'pvTySLubXBu', 'GrmEjuWtg', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-21 07:39:10', '2025-02-21 07:39:10'),
(130, 'UID81BE8B5A130', 'Gkpamtxtoo', 'JoaoNomBiSifSA', '$2y$12$WvfFb7w9QRd7bcjAQEWNOuHJXIluczjr9s6vT2CLQhFuKYaPJDIl2', '5817830483', 'blacheiu34@gmail.com', 0.00, 'ABzulmFuRXkd', 'skTvWjzafxnN', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-22 11:35:10', '2025-02-22 11:35:10'),
(131, 'UIDE52FE894131', 'ULsamjGzNuR', 'SNVbLzqbffN', '$2y$12$8FrF6VLS/A7xhBH2JRG7C.MTxB8qNbwFtv1f/o9oMB0S6hUujxPgi', '9776149302', 'mdeedshgutbq@yahoo.com', 0.00, 'bqSeiktubbSC', 'UgHwtASJzmEKn', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-23 09:21:55', '2025-02-23 09:21:55'),
(132, 'UIDFB65E09C132', 'LfWcjkdhC', 'bLnqGciOmoJxC', '$2y$12$qv9tMeEaVPb4zj/vDUZws.FF5JXvd7iP5pvCuNPBlPqweygpvC65.', '3674119833', 'ouigossameroi81oracle32ae@gmail.com', 0.00, 'evnwOzkrrgpVy', 'NsxlPFhyPEESA', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-25 02:05:42', '2025-02-25 02:05:42'),
(133, 'UIDC823EB60133', 'KVAKHUQTiJFCaj', 'zAfVPECLRAGRsyA', '$2y$12$uOgAIrSSnxh.zi1uANT76eR0TI.LyXf9x8caLcOIkBZKvPvZCRpZK', '4693813418', 'flwfdwtdcgfd@yahoo.com', 0.00, 'LYiYJzhAIFgKqY', 'DxEWHiLtbORUeh', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-27 01:34:35', '2025-02-27 01:34:35'),
(134, 'UIDAB68DA7C134', 'RRIjHWJrE', 'mcDJXqxzKpiIn', '$2y$12$01aHl40sD.CB8kyqPA9PTOwSf0eun2RJutRRx9gf29rDqSqEeIkm2', '2965826926', 'aliklep27@gmail.com', 0.00, 'tLVLByWyAv', 'cPTnKvyqXRdixee', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-27 22:36:08', '2025-02-27 22:36:08'),
(135, 'UID92DAA643135', 'BHjPZSWiiaAn', 'SzReNgJXvpj', '$2y$12$JtPhzt8RaMYUoL4eLHVo/OyVEwWRWRLtfJgeMVGT7mGPi0h7s5v/K', '7470686176', 'espadis2002@gmail.com', 0.00, 'ZCaAXyDopCWbcC', 'XMmILtFFUeztM', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-02-28 20:36:17', '2025-02-28 20:36:17'),
(136, 'UID68C7B128136', 'icNXeIIuOUU', 'DVxdVudJ', '$2y$12$JzUPxgceidRnlOufUf2Czu.7Qlg1giXH.epoWqSuzcEHg3jWiZNZS', '7195796665', 'tizonschaefga15@gmail.com', 0.00, 'azOSSCHGdaSsB', 'jeUVbsLzVMTCnve', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-01 13:00:42', '2025-03-01 13:00:42'),
(137, 'UID7FCC30BB137', 'dniKpjDTeEOP', 'nKaOJgCu', '$2y$12$O2Jfzz2zzTQL0xh16PwU9uC6RzAA40UmniFncGu5p1ghH2Y0Dc8ye', '4192513149', 'nortovi8@gmail.com', 0.00, 'GcglHqGPyFXg', 'NjOuRCfvl', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-02 07:43:00', '2025-03-02 07:43:00'),
(138, 'UID128FDE28138', 'Arinze Okika', 'okikaarinze@gmail.com', '$2y$12$Fwg.r21NyBEtveMEwD2uZuFdHfYKocT6pLuor3gtYV6cnT1lYh3jq', '07017325724', 'okikaarinze@gmail.com', 159298.50, 'No 3 Endurance Street Jikwoyi Abuja, FCT', 'okikaarinze@gmail.com', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-02 15:25:49', '2025-04-21 20:54:50'),
(139, 'UID9E5EFC10139', 'DnYTvNdvEoDkYi', 'YqdtRiVeNnqQg', '$2y$12$fLwpLJsNDiMfFKxMrUnsKewRmDyK8KU.pxDS16BOCyHEmrQCpuofe', '8462548426', 'djisbertm26@gmail.com', 0.00, 'ItnxUCtxQ', 'CTKLmIsU', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-04 18:12:14', '2025-03-04 18:12:14'),
(140, 'UID1841DA50140', 'DvkSJdbrucZBrUp', 'tpiOvoQHxk', '$2y$12$NLe7qCUwS5x.geXBk0QOdO8GT7/RpE.CRpBf/K8LyhVEW2XE9AkOm', '6752917767', 'solisoliviy2001@gmail.com', 0.00, 'tjCbHwHlG', 'mtWfdlqLiDKmJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-05 20:51:31', '2025-03-05 20:51:31'),
(141, 'UID97B9A4CC141', 'ggkkNYtcud', 'SPFzccsFOhZNO', '$2y$12$IUuL3VBxsAx1A6dUQxhUo.l2Ymaj2DS.IM.aDbMnUHx72izG3Zcp.', '2878232324', 'shakyillsb1993@gmail.com', 0.00, 'LhsPHkPYxtU', 'RVRYtQLNdYbnHb', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-07 07:21:46', '2025-03-07 07:21:46'),
(142, 'UIDBCD378D7142', 'wcmSrZNLThFnvo', 'BkQMCKoGQZjjgUM', '$2y$12$ilz1ggb2LAGkpZvAIboOLeta5SEph/.I2c2UyA7YRpvJJasuB6yWy', '7050174115', 'iutempestau72zeal10@gmail.com', 0.00, 'qfQEQYkJtVDs', 'eNMvZecBBJuZzT', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-08 08:48:14', '2025-03-08 08:48:14'),
(143, 'UID25FF7F09143', '* * * Unlock Free Spins Today: https://www.theassignmentsolvers.com/files/78e3eo.php?buq7ef * * * hs=3365477e60901ff9802fb30185c938d6*', 't8ei71', '$2y$12$a3Mkj.GzQF1O1.gfT1zBA.XdJkvDtb9q9hR7ndOEoBU9Ck1Cw2IX.', '786762834701', 'pazapz@mailbox.in.ua', 0.00, 'k8jxxk', '3fcdzw', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-08 18:14:19', '2025-03-08 18:14:19'),
(144, 'UIDE9AA1A75144', 'xGihYcIFZkhzpmg', 'pfxPiukPgri', '$2y$12$fxhTqy6z9iVmH5mWj/tK2eCPZFUp3yCEWJNlwl/fM.d7fYpUXu4Wa', '5036239460', 'lidetaxc18@gmail.com', 0.00, 'xzizWLqnSyEhaC', 'ORDXDZulUjkgA', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-09 02:11:11', '2025-03-09 02:11:11'),
(145, 'UID7BEB6DF1145', 'DNUHNHxvlAwLbik', 'AmEpCgSuT', '$2y$12$1lpHF4Ix7l3qN2W0S3oyRe1ZjSeqwpcZ9DikkZajrSCZryw0RS5pi', '6001211346', 'dunnmakiq@gmail.com', 0.00, 'CbtlUHKwxVdNlI', 'jyKreVPnLghY', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-10 04:03:00', '2025-03-10 04:03:00'),
(146, 'UIDBFEC49F1146', 'SlAfgcDnoS', 'geXXQdjEw', '$2y$12$Y9i6k2e7I52hwYnOoF3oc.B6tN3aP/SdRqmzZsJcBweuzR0U0DB6C', '3199631394', 'x5mcnw9dbg@yahoo.com', 0.00, 'teeLrEQtCnIOw', 'DZPKAuZBifWLRz', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-13 15:00:49', '2025-03-13 15:00:49'),
(147, 'UIDD9F5CFF3147', 'yTpLIoxR', 'yjJZpxTlWAF', '$2y$12$90IlFQ0WcENQ.g5/Wuj2.OdOtZ9h9nof6FnWWdoHUtnEwZpjdf/hS', '2282906029', 'andersonislinie@gmail.com', 0.00, 'IhZNNIGndzc', 'LJVqkcBLb', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-14 16:03:39', '2025-03-14 16:03:39'),
(148, 'UID0D7DF242148', 'zDaRFqQpJenni', 'OSCbIJrFxrYdeoR', '$2y$12$2UYx7hwd9/JL7h39PHFB.ugG8gmu9NDDkdex96oSY5q7k4KMkBbA2', '3149508210', 'mabellastephensond1993@gmail.com', 0.00, 'qSFIDCfVrwMKdmz', 'ROmtnSXF', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-15 13:41:47', '2025-03-15 13:41:47'),
(149, 'UIDAE4C4CCA149', 'XrTIfnkHkaDC', 'MbIYhrfD', '$2y$12$Y4jIf8KxN55RuGue14jFaOqKIZ9iN/MBPB6orPQv9EkZ/UUXM598.', '4801443621', 'briariyjx@gmail.com', 0.00, 'cennrDafHZ', 'VCQGXFYwxcsNx', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-16 08:28:13', '2025-03-16 08:28:13'),
(150, 'UID9CC730CC150', 'tUNAaCCJ', 'QZmYaHxzHmGHtZe', '$2y$12$s8Gk3O7l/lqZ7Ehs8ky00O7rMN7AzATHvBiLrjS8P70muZYOz2Edq', '2786922312', 'juan_maly1997@yahoo.com', 0.00, 'kRzNKRegbLENlp', 'JCkiBEEvhyMw', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-17 03:07:04', '2025-03-17 03:07:04'),
(151, 'UID8EFE00A4151', 'xrzmEEsxo', 'fbeOxhjPeQBROIs', '$2y$12$iSN5z1krjMAZgeL.0tJuf.bZy8/nU96ZQ4W8YT6E8FXUTPX46Yahy', '5918618312', 'merrill.taylor987299@yahoo.com', 0.00, 'zSbAqiSuyUbboXa', 'szBXiNORwBZ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-20 13:54:15', '2025-03-20 13:54:15'),
(152, 'UID9ADCA436152', 'MCSaOCBZfHzQqpd', 'fWtZliRHn', '$2y$12$qxHjDz06lHUUvgovFfidMO2..sMZchzyl2gdEq71tTMiI7S4ZlN7C', '6694289838', 'ckletis1988@gmail.com', 0.00, 'VEIwQOIUvowudRl', 'xdevOvwqYJyVQZM', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-21 04:15:57', '2025-03-21 04:15:57'),
(153, 'UIDA8F8CAD8153', 'oITzGxZoZ', 'XQYgoKUP', '$2y$12$genX1rB.rE9t0uwBoWVyaOF9RP.lnw.nJfiRoKdRF/5.nAuuZ9RY2', '9743642553', 'robinsondan761077@yahoo.com', 0.00, 'OfZfwcPfLJYh', 'nzYBYZdtXCDUd', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-22 11:52:46', '2025-03-22 11:52:46'),
(154, 'UIDBB0E31C3154', 'evCKrLKjxhc', 'LwxuBrwRLfLrvrb', '$2y$12$jpffYlCtIho7fWa9Xb/yB.wvbrGsjyf9uynVdHh3ujcNyhFMSxYWG', '7703148837', 'triyatownsendh20@gmail.com', 0.00, 'nvvMVTsug', 'jvGQzrbHecnw', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-23 02:25:57', '2025-03-23 02:25:57'),
(155, 'UID15278579155', 'IVQzFOQum', 'dicVXEvCvY', '$2y$12$4TNFTB0/dsAJtgLwRXWCOOaE1OeKGtQLUDBTLTGq/98Z86PcxdiZO', '2987164374', 'osbornbennett1981@gmail.com', 0.00, 'dtLIuIRTkgds', 'TbMwNLUXHWo', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-23 16:59:51', '2025-03-23 16:59:51'),
(156, 'UID5148B6FB156', 'KxgrQEzuVhylGE', 'YCQgMgWIG', '$2y$12$9JUVjkZzvD07NMp5DE4SsOsdjLUIo.reyHT8BhAPUNt4BCmk9NhFu', '8190917590', 'marivonnmm52@gmail.com', 0.00, 'ZgsKhHkGcpVkiZg', 'MZmVZCHoxZtCSuR', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-24 09:55:16', '2025-03-24 09:55:16'),
(157, 'UIDAC1208FB157', 'OmzXwLitAypqyK', 'kehpSfxAmU', '$2y$12$PkeqNBP2NPhEUxh.lSUauuSmBi7C/m0.Fvdj.hiSqO9tKOaaGV6Kq', '4154049567', 'megsilvaf52@gmail.com', 0.00, 'cIRFSOWuTG', 'LjkIDCyCOJEE', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-25 23:12:48', '2025-03-25 23:12:48'),
(158, 'UID307440F9158', 'mlhbeaqXhFvSZL', 'ymIXENVW', '$2y$12$vT613zqZo6YXbx7mI8Erq.02w2Wh2AE4SrutPepVAHbgtjIkvEdhG', '2844204712', 'htraernyc1@gmail.com', 0.00, 'uIDeMTLdcOusgcJ', 'WDdGBAOGpXfzFXH', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-28 13:10:14', '2025-03-28 13:10:14'),
(159, 'UIDF96B08FD159', 'krOUFYjSljp', 'nqUGuTZbaEnwHMV', '$2y$12$iOvewWLAo3ZmJmr8FfLRDOG9nIeOL6MbrP583d/ZjhNZsUkyU/uaO', '2322623966', 'stroud_delbert397189@yahoo.com', 0.00, 'YVJwkayIiZt', 'IynviGUMHq', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-29 00:48:19', '2025-03-29 00:48:19'),
(160, 'UID56B801B3160', 'uBtSLvTLeRS', 'rFEAmOrZ', '$2y$12$P2g.CU/NSEdolCDFlrJT4.sCaTp18CxFPV8xm6mD8bba.ORSX1ofS', '4017573732', 'moodybraeden1983@gmail.com', 0.00, 'icsnbXKDkLAVZZ', 'flfLlssIVuI', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-29 19:08:42', '2025-03-29 19:08:42'),
(161, 'UID1608571A161', 'gEUEpnGokqOX', 'MKFnjmqKzW', '$2y$12$m92uVMgmAsGYCw6Ti274.uQrM8gSfA96qRfO5N.2WiEgPLKSywcvi', '9382505898', 'amanda_diaz558032@yahoo.com', 0.00, 'lJmKkRLBd', 'ZsJmzRzoXf', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-03-31 12:01:29', '2025-03-31 12:01:29'),
(162, 'UIDC50B6A50162', 'rlmiuRxBq', 'zCvWlKSwofqpw', '$2y$12$/LS1MyFBmkcXp57iFOGtXuZfur4/ii9jSQ4fuljLGjtyXsR0nPcAm', '6654394030', 'diana.oliveira290601@yahoo.com', 0.00, 'PbugeNXsCiBcPYn', 'LyGgprWszRqx', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-01 14:53:02', '2025-04-01 14:53:02'),
(163, 'UID1ECA7495163', 'AQNvNBkp', 'LNyzIETCbfBo', '$2y$12$eImE9m7HJWSVMjLtTjkywuBJOJKRiKjPqdO4vzZvAWn/fsGFzWrmq', '2580499208', 'jdenverw1990@gmail.com', 0.00, 'MpUkjEVNw', 'IaRpGvSQzEXu', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-02 14:55:25', '2025-04-02 14:55:25'),
(164, 'UID35FC310E164', 'LQfrPhhULgoCt', 'oWrimQfENGisxr', '$2y$12$vVTZuXiSl5VD1vD4EhCax.JxP8hvqWNxI7fvJh9eRPFZ.t5crmbpe', '7480542443', 'jarvismortifz@gmail.com', 0.00, 'LwyzyLPdCGxrexs', 'LXTHnIppqo', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-02 23:14:18', '2025-04-02 23:14:18'),
(165, 'UIDBFF94A68165', 'sAhSYdCnAyxns', 'rHMzNAJUYabs', '$2y$12$85wBXtCcZBc8vPQJo.ZpUuMD13z3G6uraVTQ7O29AsfrBiaFSC1R6', '3682165335', 'alvarstuartbz@gmail.com', 0.00, 'KtqMtUNFmU', 'DdIKVCFTodcmKxn', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-03 05:37:54', '2025-04-03 05:37:54'),
(166, 'UID8F4367AB166', 'ziNaVvIGtyeL', 'kIDXoFxDzfoqb', '$2y$12$jvoE7Ray6H6jvOF8RIGMK.xmV4HfzvGU4270uGExfcDVYOzpzROB6', '7420176875', 'bisshg50@gmail.com', 0.00, 'XwhyElhqVrgPn', 'ebkNbkjBDBDG', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-03 08:05:25', '2025-04-03 08:05:25'),
(167, 'UID05F8FD2E167', 'prxauDuGKb', 'myJwCtIW', '$2y$12$/ByY53ah7/bary05rWseD.fn6kX4dgkRc/Qi0xWFcAqxmPv03lHCm', '5151557359', 'annemaribyt@gmail.com', 0.00, 'KECqCLpIbYENM', 'KRisaJoU', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-04 08:06:34', '2025-04-04 08:06:34'),
(168, 'UID75E55878168', 'duNqrVBfR', 'sbkjFWhQY', '$2y$12$wGJezDfT.omvk2PVZor3vurY7ghi0RRG0YikW7OgXZKh0IKk6qv.u', '9259610100', 'paigesmith1986@yahoo.com', 0.00, 'sIeDoTZSg', 'VDEHcpLPnyLRA', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-06 12:59:58', '2025-04-06 12:59:58'),
(169, 'UID54C5D89A169', 'wlPqMgGsavxcCGU', 'dKWDViqg', '$2y$12$GuQkQja2MYjAwJq5uxr/QuNUgqVRl1SaHXLM/aLSnktHrsgDxRhxq', '3182166520', 'huse_kristin414794@yahoo.com', 0.00, 'uZboZtsylh', 'cXCMtYTWQ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-06 19:51:07', '2025-04-06 19:51:07'),
(170, 'UID79C5B0BE170', 'vLkHdllwv', 'VfQGOueF', '$2y$12$IDvWGLG4FicxSbnYkzMrpeWWgSSth82a5u6tXSqpBNsNL/IPz/1g.', '2727402840', 'sleblancoe53@gmail.com', 0.00, 'ZQjUYetltvS', 'lQDnaYNoUJIr', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-07 02:03:22', '2025-04-07 02:03:22'),
(171, 'UIDC3A6750A171', 'tlULoBwipmouK', 'BUXMejwBvfDNrI', '$2y$12$cxGV7k6nYbTwwvqTkl4DvucB6jPr9tXQ89DmtAh/WkO3uFinLXd0S', '2333815376', 'hduffy1983@gmail.com', 0.00, 'efdCpkyivJ', 'RioqPgGX', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-07 02:59:36', '2025-04-07 02:59:36'),
(172, 'UID8D031BE4172', 'UdWiclebACXJw', 'XIWUnfhTxXT', '$2y$12$dge3pk3o9UOS1xU/WdV8UepmSYQ2.w1d8AIC3AedS9t8iLUvkkmJq', '6316415528', 'angeljamrock93828@yahoo.com', 0.00, 'ycZzejXZjF', 'UmXPnyUHkZZMz', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-07 09:35:41', '2025-04-07 09:35:41'),
(173, 'UID86F5EE88173', 'edlbEGJPnUIqS', 'ddfoZDMdYx', '$2y$12$d2B9OQTAJ1U/Zs1WldoWxeBuhR9U5AEt6uI0r4RnYTbmUqgzRbEqC', '6809319368', 'angiejimenez883758@yahoo.com', 0.00, 'lSUopxMxmMGvSTR', 'pVQXFUoKXAMt', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-07 11:26:08', '2025-04-07 11:26:08'),
(174, 'UID9D368C7B174', 'ywoumehj', 'YNmBdpvDLArJE', '$2y$12$geHzLEGXnmIaLwD8BzE1Se8xqrQ7ouwQFBCgzybUYRugoOOFGM5ca', '6673647061', 'kenneth.ogrodnik269211@yahoo.com', 0.00, 'kPYiALQhflD', 'xfUHXgtS', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-07 17:01:29', '2025-04-07 17:01:29'),
(175, 'UIDF73D5ECF175', 'ZiWgbgbCEuj', 'MMiQIkbw', '$2y$12$4R5M1FLxcM5n13A5773FYOoAGh01Pd1nkn91QPRcGOKGCfy56b3ba', '5917994552', 'robinasimshy2003@gmail.com', 0.00, 'NavLhzLQrULC', 'krAkFiQiqKW', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-09 03:28:42', '2025-04-09 03:28:42'),
(176, 'UID42BA3ED1176', 'IwAkJIOYCImB', 'gdXsObEmnQCaaKK', '$2y$12$J9q5QeKirqeqxhfKMuesv.WgJeiK04P7wI7pFnq7YMuUmUiTh.viS', '9730957992', 'peggibryantxs17@gmail.com', 0.00, 'RfxnOnlhR', 'jKmroqJLcs', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-11 09:33:06', '2025-04-11 09:33:06'),
(177, 'UID36BAD4EE177', 'kGCXVJjd', 'xbXAZzVzFZSjJ', '$2y$12$dBfw5OEXAgiEFDoPNOc/oeKQYXCAm7sXYLJ1smy2huEJ/ocJkGqb2', '6104813537', 'islamzachary576873@yahoo.com', 0.00, 'cEEQDeRok', 'HqsRmtQECpWqWk', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-12 10:18:44', '2025-04-12 10:18:44'),
(178, 'UIDBB72152A178', 'OPBjQVoPDay', 'BbVJWWqJRcFlzko', '$2y$12$IjC2jQ4x2XQ47skbzDXpuef5BwjK5cKYlya0uj6.VA6fC42QKOxse', '9304700701', 'aarronmckinneyw1992@gmail.com', 0.00, 'pXXdeMQynu', 'VpELkhQPMpC', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-12 19:54:27', '2025-04-12 19:54:27'),
(179, 'UID76F59079179', 'PQrYbYDTRHIsRT', 'xjSEyaUR', '$2y$12$dvQRUWaF2HFOITYi.5Bzq.tfXOaMiCAYzPRgh/o1kbFsyf5DmYGuy', '7417877024', 'omoore1982@gmail.com', 0.00, 'fipYdHFurHSOmtA', 'rQfbwTPxECdwNPe', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-13 05:20:28', '2025-04-13 05:20:28'),
(180, 'UID330D6425180', 'GFvlsQDzUt', 'yUenLakhjGjJ', '$2y$12$YoKLKUJHMpzfghHzru15k.7Cnd1rLx.rVuKS5oSBwOp8YwjtU5SbW', '6417721824', 'cherringa2006@gmail.com', 0.00, 'JDyFfUYAWiFGOSy', 'aHPgiPIVVTs', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-13 08:25:22', '2025-04-13 08:25:22'),
(181, 'UID25369F10181', 'uqwWczciNkRp', 'idfWXxptX', '$2y$12$ueOyc.IJwsExnBW0rhc3setTyy/UleZcTzqa.kUVlZ7wUUaS.oqCu', '7555970258', 'crosskaterinev1986@gmail.com', 0.00, 'pkFeRxeXVii', 'muALnyIGCR', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-13 09:07:33', '2025-04-13 09:07:33'),
(182, 'UID0ABE15BD182', 'PeKXFSQEI', 'yqnCtTLPx', '$2y$12$2qULcjaK4/iNgdU7fhHdquSe29YhoXBqIpU6CadQC7R2/R2palnPO', '3948354027', 'tmoont1984@gmail.com', 0.00, 'OaQNpsDdPpjRLnq', 'sOyKHfgyfW', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-15 20:24:09', '2025-04-15 20:24:09'),
(183, 'UIDACC20490183', 'RxZdcHGMJchnEH', 'OkMnOuTkIttQp', '$2y$12$uDVNnQj/9OUjaHVrNmYOcu6CN5SceVG/53uSMiYTzAZBWp7su9UuC', '9618848755', 'pimodjenp35@gmail.com', 0.00, 'oQGiyctikOmvDgL', 'yfViWSXmjnsWJa', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-18 03:31:34', '2025-04-18 03:31:34'),
(184, 'UID004BC471184', 'viNprerF', 'vZFzExrpFK', '$2y$12$dOO9CkXQftSpIt9CIjXDnuDRt3cK5s7uWWFOkVlky/3mjEVtPguhe', '4175441353', 'ruskeyvorfeu1984@yahoo.com', 0.00, 'IQCcHQiKHBSxbfe', 'fiYlEXqjtdMw', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-18 10:38:16', '2025-04-18 10:38:16'),
(185, 'UID3DC3E662185', 'EgpWeCUYcIrGu', 'PAnrvHzFJ', '$2y$12$leHm92P9sI64Rqiv412TgufxlkJV/uBa4pYVMY/u16FPffe8DAEcG', '6859128270', 'perrilqt6@gmail.com', 0.00, 'qkvMRCeQjAsZ', 'JEYCmmpL', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-18 11:55:34', '2025-04-18 11:55:34'),
(186, 'UID2CEC815F186', 'qLnAjdcHTf', 'yFpltaAOfvD', '$2y$12$4JE.tgLTcIQVVLRBewKWV.KyIA/QfJ.24iTGWAECs95u2H0tidZ4q', '3764222982', 'ellisleonapw@gmail.com', 0.00, 'dCfIgpAphfple', 'HWvMYtnXgiwhb', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-18 14:58:40', '2025-04-18 14:58:40'),
(187, 'UID85826012187', 'tnNOfnuRE', 'UipgykXijFHrl', '$2y$12$g48yOPGNhf9OmNhWtMZ/FeyEGtOAj9uxW2.8C.z6y.llf285EmmR6', '4880463817', 'skinnerdjessif7@gmail.com', 0.00, 'cEJxHbEvgnOd', 'eoYwFAlcIz', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-18 19:34:02', '2025-04-18 19:34:02'),
(188, 'UIDCAA5BC5E188', 'VqzSNFdXKLmRQLn', 'MaQOveluVgnSWf', '$2y$12$q.MOLIUap4xAtXSlF4uHJO0fEU8KshDaW5zqunR2vaJFo.1c3yrcu', '8919896189', 'giosmudarac1975@yahoo.com', 0.00, 'OcByERdyuzf', 'lyPZIDTtm', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-19 09:03:55', '2025-04-19 09:03:55'),
(189, 'UID4C330A89189', 'fwvrDwGKmomrV', 'gaOuXluH', '$2y$12$Sduip4T0vbtgvFttD1NyAOBWny9wC73zb99ngaJy4A8pvKUGP3.6C', '3371543827', 'melendeztoppsi@gmail.com', 0.00, 'fukurfvEKYRk', 'iOfLDrBFIProhqF', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-19 19:24:17', '2025-04-19 19:24:17'),
(190, 'UID72DA351C190', 'lVhmcEwkFm', 'tcEasuubb', '$2y$12$cTCFapOGxabYTCASHBcFcOxT2exuR0s56ybKzdUGH.olxlT3aXr1C', '4654924906', 'nidiyac2@gmail.com', 0.00, 'bVMauPpAORAZ', 'CrSVzMQqgYVB', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-20 12:44:47', '2025-04-20 12:44:47'),
(191, 'UID847E81B2191', 'waxGkSdT', 'rObCGSIBX', '$2y$12$tREmO8Jruq0SXsCzifTNyO7bq3dHbmJBMCuQiEqW1VHZfqkQkrPDi', '9680232275', 'nixonklemmio@gmail.com', 0.00, 'yClodVQJQTiKKm', 'myaqefxbV', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-20 18:47:03', '2025-04-20 18:47:03'),
(192, 'UID239E57AB192', 'vRjmZqIlF', 'pkQgaKXOw', '$2y$12$rG2UTuU1Vkq8hdAlZMfX0uNn0sOjsmfVVvbVkJwVDI3aRd5S5Ex2G', '4301080765', 'mervidickec1989@gmail.com', 0.00, 'EBwaXsXyhfPi', 'xPQPgmJcADsbQuP', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-20 18:52:30', '2025-04-20 18:52:30'),
(193, 'UIDAFBAC1AB193', 'aEGXOiegBRIuap', 'wyeznMnCAf', '$2y$12$MsllBICoUdmlvNA88bxr9eKWjA/VirhymMEtr1eqydHKlssFD69Iy', '9920185616', 'jenkinsperonel1@gmail.com', 0.00, 'hbDxzOnzCd', 'CBMaRBpVRwK', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-20 23:34:32', '2025-04-20 23:34:32'),
(194, 'UID4FB2E851194', 'MpVtBfQfHfyGEt', 'HGsNGmfNR', '$2y$12$5HV3V4HKrn/6bx5qolCHdOC9KktDU5JtWW8PSHM6TH9B4IZ/HDinu', '9102632769', 'costanelq2000@gmail.com', 0.00, 'PsGjVBKFiOmNM', 'atrCsZkrmcKB', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-21 21:27:11', '2025-04-21 21:27:11'),
(195, 'UID1AE1AFB9195', 'NwmgHDNqfA', 'nMpPMVKoXnGPftt', '$2y$12$2GoRy2uqAIjGKFhu21rru.AbHbBls6AnRViqNwysVCsQW85Pf44Da', '6236608995', 'kerrmeibel1988@gmail.com', 0.00, 'aMLbzmaRMBqXoi', 'sdGWlagjLydOzx', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-22 00:51:21', '2025-04-22 00:51:21'),
(196, 'UID9B774108196', 'kyOWsefFc', 'SQZWfyxd', '$2y$12$so2ITvgiPX3BBq1uC3k4uO6gzzeABbeWXh7gq84iRolV.szGB8fkG', '4028843045', 'okendragw46@gmail.com', 0.00, 'cgJWTqzOWDzxRe', 'BWIPLRCLvyUcg', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-22 16:32:45', '2025-04-22 16:32:45'),
(197, 'UIDDF1B20C7197', 'vortexpromnes', 'vortexpromnes', '$2y$12$rGx1es6tCLFWwGH304RUE.XM91HpYQ9du6Lw0sxRkJf1ajbXwktJ.', '89179469687', 'louratug@mail.ru', 0.00, 'https://vortexprom.ru', 'vortexpromnes', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-24 07:05:49', '2025-04-24 07:05:49'),
(198, 'UIDB18397B7198', 'AjIwlgQCN', 'QnRyvPscZ', '$2y$12$b7rfwyffy3e1ucq5ji/M4uycLNAc/gL0JvrDwcsB2gV48gDvsfZAe', '3105092936', 'urlidatu1989@yahoo.com', 0.00, 'DMisHzbEZqF', 'dGgnfRQJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-24 14:57:51', '2025-04-24 14:57:51'),
(199, 'UID79322EF4199', 'bFGuiHXmpPtcFJB', 'EpWKzzVqxBq', '$2y$12$K8H.k3PHpqAFTF4g0S527OSqd86klxiM8MSrTzrOaTfTSgkz77RLW', '8381883770', 'ocarofse1975@yahoo.com', 0.00, 'hiMrhHwv', 'SgmxtHCFhYwFWr', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-25 22:56:45', '2025-04-25 22:56:45'),
(200, 'UID84D9733C200', 'esFiMkwdmoZt', 'UkBTAqTcclsNkTw', '$2y$12$o7IAsL437yOJKpsl.2P53evndzDw5VoSrUHbPHoXg8NIcfJSmDr92', '5248311433', 'hatfieverby@gmail.com', 0.00, 'lMLayeOpIR', 'pInlAALqYMyAzZ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-26 04:36:12', '2025-04-26 04:36:12'),
(201, 'UID468C1E2E201', 'hBIBpuboRKb', 'dqAjkjmqeHg', '$2y$12$VVV2qf8CBPn1io6SxW9DEOXo.t0ehKDifDJiDcSDfUHqH0XnXDgm.', '4962228336', 'tifoogolgoa1980@yahoo.com', 0.00, 'wNhilnNkOC', 'myHSinmTrGS', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-26 08:40:41', '2025-04-26 08:40:41'),
(202, 'UID121510B2202', 'QJuuitQYPgQy', 'ocVFbJpcMb', '$2y$12$HUU2EzmRz5nXB1aRYsD.iO4ttcUM6WfIdjDtaViRopKgPDnmoYFd6', '6348732454', 'alfikzq8@gmail.com', 0.00, 'IeNrmovbSRlCvI', 'fhoQjhHz', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-26 11:30:50', '2025-04-26 11:30:50'),
(203, 'UID2BB42259203', 'NzykpPtvVHzwd', 'EYzVWgbwKNfLeX', '$2y$12$SRBnsqEYaB9Y06Afwf8YhuZYOyfwePnuszbKeT4NrS47C1RdD6Jje', '8534170613', 'ebbconleym75@gmail.com', 0.00, 'GmgxXIsbnnKZY', 'XjqHDYPsjfQEX', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-26 20:18:47', '2025-04-26 20:18:47'),
(204, 'UIDCF13D694204', 'JIZOXhcnXk', 'mugdsNOM', '$2y$12$OXdYxM7tsvskTh1eH5/kFe0Aiofmp603sGYLW9pneY0FYBHrOQsXa', '9281262174', 'pennrocampcrook1984@yahoo.com', 0.00, 'zUGoiNmzDGjiGi', 'GjImmXeAveOiG', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-27 04:53:00', '2025-04-27 04:53:00'),
(205, 'UID64E90020205', 'WjeEtnhwoOKZ', 'OZLnGMzf', '$2y$12$rv8FnjEO5WF8YiIBUXpHvOCMSoGwiHgad0RMn2ZNaKAARK3ZJ5DoG', '9372835687', 'trocuperam1975@yahoo.com', 0.00, 'wQHfENbMsQUzhI', 'IqAZhIqGXTnkYkr', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-27 16:44:41', '2025-04-27 16:44:41'),
(206, 'UID21746B3F206', 'xuZieOAHw', 'PbGdLyQbxVXCJY', '$2y$12$H.Yv0zkbJw0iLjK3bqqNP.80i0L7Kb9IjxMp0mSnLG/A8Cpjz3aGK', '3350094237', 'slummomiman1971@yahoo.com', 0.00, 'wESksskmvIvf', 'fQLnOzaUVCBWuP', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-27 19:12:37', '2025-04-27 19:12:37'),
(207, 'UID523F777B207', 'QVySqZNUX', 'UmnPNBBJGbX', '$2y$12$fAQ8irX/Ofz/jg6rMyvFW.qzueVr5/N2TRjpGmWiBdjUFKbez/hk6', '9778523383', 'brynabb27@gmail.com', 0.00, 'pCnTAeuLBaBDI', 'XxTDmiPQnzIw', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-04-29 12:08:12', '2025-04-29 12:08:12'),
(208, 'UID822BA3B3208', 'djwnibcsBNeIr', 'cYuHkBYCUl', '$2y$12$xLPiEC5HT9dna2PnVzpLEuzr/.10/9obZN1b1v/U9S9qjM.1wy81W', '7455258260', 'gensyrobe1976@yahoo.com', 0.00, 'CnUcfMfeIKWGsa', 'iwXLTlOpcrAjhiU', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-01 00:38:24', '2025-05-01 00:38:24'),
(209, 'UID7881FE9F209', 'BzWGMGAOkdyP', 'LUiGlgKqvQGISdv', '$2y$12$OFBg7CtUWIzQ/jVJCtZDmu/d0lf//Jusgxe1qCRnFa/m9zrSQxgL6', '5756866950', 'garmoniyad47@gmail.com', 0.00, 'CIQcjYwhjhTJkQ', 'FFaQgZMYwrabie', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-01 06:38:18', '2025-05-01 06:38:18'),
(210, 'UID1401348A210', 'OdfgOlYrfDy', 'BmIhKAWnD', '$2y$12$xFcO4w9oPNIUUDnlMkzwoOKA94VwlzO2N8e5vb5nV7yTW1dUIHeWS', '7730982762', 'berdainbm30@gmail.com', 0.00, 'JkXmvzbtQ', 'LsdsEbPMg', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-01 07:12:36', '2025-05-01 07:12:36'),
(211, 'UID2A83D578211', 'zDihItwDVtTiKbh', 'SRlWYdPpRE', '$2y$12$z1e8rIJww.uaL9jx6xhlOOw8MzVD6Qs3FSrImIiBi5BeeT1Iogi36', '2848297918', 'wigginsbeiliem@gmail.com', 0.00, 'cnHmGKrCtxe', 'TEUtUTkkX', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-01 08:26:55', '2025-05-01 08:26:55'),
(212, 'UIDF8FB8AB4212', 'PsNnweOMgf', 'kyOkdvUAVO', '$2y$12$jsFTtUNxWaPX1KcZilnzduPyRPduiYM3s1bZh8yjWTXhpn0xlXp/W', '2801266277', 'birdheiz55@gmail.com', 0.00, 'lLuDyiYb', 'qoVvEgYoXPq', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-01 23:36:49', '2025-05-01 23:36:49'),
(213, 'UID2C3A820C213', 'xQRqcyhnx', 'ULEMZafVtdVgW', '$2y$12$PbVRVLnyhWv7yVvAQwxqEOwHJZJ0rdKc1jusKaECM91Ylk8YHhsuC', '2263643419', 'klintlambuh@gmail.com', 0.00, 'GXzTmTEq', 'zuCJFEBdLXltX', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-02 00:06:18', '2025-05-02 00:06:18'),
(214, 'UID0CD957A8214', 'UShygUyTHKZxe', 'GeVwCXvYXL', '$2y$12$VmrqQGmlpJlsmehZF8aEd.1u/mlDBtyTJJmiy9qoPuW8AqK7TRgNm', '9154231714', 'golhopigre1974@yahoo.com', 0.00, 'XrptreNcvEIqujf', 'LfUbkyfGiObpeWu', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-02 10:15:25', '2025-05-02 10:15:25'),
(215, 'UID5716D742215', 'aHyOhyBQN', 'SXtKYhsncLeNM', '$2y$12$fBJDU8qIfigJ6DH1LTtR2OaOJ5qlvFaNpsJ0KE7.ndABFWg5n2Dui', '7349338693', 'zacheribarronn@gmail.com', 0.00, 'eAxTaGqa', 'JRjBDMdtMEWbh', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-03 06:58:21', '2025-05-03 06:58:21'),
(216, 'UID9D035999216', 'dNGTqJFazYRSWKB', 'JINIYSTgVGnki', '$2y$12$lq1q2je9EYa/dmNPVmXXS.2l4L3CkItACS.ZS0EB78jsqBlBDdhl.', '3587311389', 'jenninkorbd7@gmail.com', 0.00, 'rlftNrhrXNI', 'gPYlELEnpegOzkK', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-03 08:29:32', '2025-05-03 08:29:32'),
(217, 'UID7C884844217', 'kVJKHcNVwzb', 'ixKEgeHaqt', '$2y$12$j1AmaW7mlKBN6o.mZjQ3ROIERSw1.yayd4luYAxuj9NyTR/di6d7m', '4677424012', 'obazills1994@gmail.com', 0.00, 'AxWhQQBi', 'xULiDgAGPI', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-04 20:38:12', '2025-05-04 20:38:12'),
(218, 'UID97F88B48218', 'uTnAZITPpSwXInl', 'OXnLveIaPlh', '$2y$12$GthLEOWD1fNiClZGW7VPPep9ZBeyLAQr0qKGnmbgCCwWsu/TmZVdC', '3283444274', 'murillolyannaj@gmail.com', 0.00, 'zHwYMcasxyH', 'gkGZxWipS', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-05 03:02:17', '2025-05-05 03:02:17'),
(219, 'UIDD76D0E5F219', 'LjARAjQGPDEyb', 'QSHoeZtTgBEK', '$2y$12$LtDOHMZA3jPDowAqOpNttuNa3oDAwLI/2QEK4.REpVxxYOcdgwlxW', '2418899977', 'rondamann8@gmail.com', 0.00, 'SoHBavDg', 'YAaMnQSYI', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-06 01:13:20', '2025-05-06 01:13:20'),
(220, 'UID6BC06F6E220', 'xkQctrUTmQnd', 'vHQTbPlkVbd', '$2y$12$7ZXHPUr9eeZSkixTiKm6MONA14HN0XwypMTx12mgXgwo8KBiImYa6', '3100528127', 'endihanson8@gmail.com', 0.00, 'uvdpOZyWjNQXXl', 'RTYUEACDCSbnN', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-06 12:51:24', '2025-05-06 12:51:24'),
(221, 'UID8490461C221', 'OdzDChUQboY', 'AvovAZeozraA', '$2y$12$wMvXzkLNoAtqK5pw5XhrheAgIQb8LOayGoSa8DdWwtu3r0loYk7gS', '3682287378', 'bapkeydowncas1984@yahoo.com', 0.00, 'MfhQqfFBEWSBc', 'ujtWYXNk', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-07 16:06:13', '2025-05-07 16:06:13'),
(222, 'UID73F1B7F0222', 'rhLOzABIPcrgs', 'VqPdaVyh', '$2y$12$Cn38d9gEnMlIAzcyjffg1e.gWu4TeAb/BbVSq/qrREJjD6Q/Ueux.', '9820909260', 'bonihodge8@gmail.com', 0.00, 'tCLqQyYP', 'ROEGZNDWeLsrP', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-09 00:22:50', '2025-05-09 00:22:50'),
(223, 'UID664B882C223', 'JqCCjfWK', 'uCDBUYpau', '$2y$12$jVoev.gU2YKk.ujWK4Yplu7GUmI2uTWap4XeELicO4lcOLy0LraWi', '5109748243', 'makeidbn@gmail.com', 0.00, 'mMWHEhgFrbvfTJ', 'uMWMczrij', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-09 19:34:07', '2025-05-09 19:34:07'),
(224, 'UIDF720A4B1224', 'LwkdPHkzRuzs', 'xltQexhE', '$2y$12$pTz0DWVYATlsUnyR9DoeiuOv/CLbgcLiJRTnysLo//KTqXfPa7Ek6', '3577495821', 'amaliyabryan@gmail.com', 0.00, 'vBImDtWr', 'WJpIPxJkxH', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-10 20:30:07', '2025-05-10 20:30:07'),
(225, 'UIDAA72F7B6225', 'keTSRRQmDL', 'ZIpybKfRHpBmt', '$2y$12$SvjF4lJ.bXrYRxnSI.cW.OSQUrtRG3.acI04uRYIP8IKwKKjCYaOC', '8531448699', 'sullivanglenisn99@gmail.com', 0.00, 'gUvjqTOJXpxMvz', 'rblCGDrqnYatja', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-11 03:52:28', '2025-05-11 03:52:28'),
(226, 'UID705875DB226', 'owBxhfuwzDAnM', 'DTrrTSXifGK', '$2y$12$pz0mIcrP8Xhpj0tR8oqCme2LcHxsxZx95ds.yAoATOeA/dMY.Dc66', '2216188664', 'mbartmb2002@gmail.com', 0.00, 'UdFkEmifFf', 'wICUcloXTenQArD', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-11 14:29:16', '2025-05-11 14:29:16'),
(227, 'UID4E40DEEC227', 'cqVbFNyCYmc', 'nQfPNhkuCE', '$2y$12$o6D.ZYbqIcc3JLPXlcPaIO7oyPKQPKO19xzqNZGaof6u8W/WR4duW', '6303631209', 'martibonniad7@gmail.com', 0.00, 'AccezaATujlIC', 'SBkrjEEX', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-11 20:17:24', '2025-05-11 20:17:24'),
(228, 'UID4E7C491F228', 'EtcsyLtaOovFuN', 'bJuJQftle', '$2y$12$BmAogA2WNQgZBXqTEWMCzueAJHOVafiqbLdrXxU/SWHXYbfTlZ43i', '6621214513', 'martinezcarol889070@yahoo.com', 0.00, 'wnduJATxHwAibn', 'ZIpVknOTfP', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-12 14:22:32', '2025-05-12 14:22:32'),
(229, 'UIDA00DF661229', 'Griffith Aguilar', 'wibaxo', '$2y$12$5bS4jn7.lp1YGfCyvLYdH.R1eEvs6cTEttbRvtZYHru2rmQymQGTW', '0298828826', 'kugucy@mailinator.com', 0.00, 'No 6, Dotunu Street', NULL, '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-14 03:17:03', '2025-05-14 03:17:03'),
(230, 'UID98D64F6F230', 'TLYOmVoJAFOzGg', 'mDsLMbMbqwjJyhg', '$2y$12$2nq2FJxL9JT9WNw2IzF./e3UZVSZDLtf3nPD4OpgCixxX3DwiJi36', '6985100718', 'chunmer9@gmail.com', 0.00, 'YOhoHjVgFvL', 'iodMlaZsBiDrw', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-14 13:29:50', '2025-05-14 13:29:50'),
(231, 'UID276E5DFE231', 'HbEWdPNJcyO', 'zodTBGVt', '$2y$12$0LcPTuyqs.EywCKyKzMgoeAIDm8kx94pHNzrbHFq5Yql8oLEIuXJO', '8755722859', 'mayogellpm5@gmail.com', 0.00, 'RRbGyxgtKih', 'EzeBnRyUKF', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-15 06:52:19', '2025-05-15 06:52:19'),
(232, 'UIDDCC44D18232', 'fFlNzNmg', 'IiTzsSvxGfBT', '$2y$12$UUyE8v9iHnf67Len7BavI.u63Eld60gFMVdt6jwjta0SfMrZCFjCu', '6331633307', 'pinparkerwu38@gmail.com', 0.00, 'HtkgAuaCVqWdt', 'MmKTICPkKM', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-16 14:39:47', '2025-05-16 14:39:47'),
(233, 'UIDDF9EE85B233', 'VHiFgMAMmKB', 'TWNilIgckrdhOf', '$2y$12$zCfgFSPYNpx9hH4/Q57iM.Gm.QFBGiekySGo70pY1QY6AD.RzOD.G', '6834597601', 'ivastuartr42@gmail.com', 0.00, 'OKSjHjsSYoIzEE', 'AcPQcHcqD', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-16 18:49:51', '2025-05-16 18:49:51'),
(234, 'UIDD591362F234', 'MsLSFCSBoK', 'LZyjDWnlnC', '$2y$12$dLEa9gWvW0ju0S0Q55n5b.dv2anESA2bOBv/QrEv4qqzyohop873C', '6121009277', 'geilonbonillaor2003@gmail.com', 0.00, 'BAPWuMFwnzo', 'JQlGcbqzBJJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-17 02:53:32', '2025-05-17 02:53:32'),
(235, 'UID8D5523B3235', 'XxewLqtRCFmKKR', 'zVnqHvxi', '$2y$12$Va5.l6l6dnGA9uNnSzqya.Fdi3XOrU2FTmmL/jL4IMzALWhEdd0VC', '7607429222', 'volfdudleywy@gmail.com', 0.00, 'timOrxqq', 'CWygAERh', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-17 08:00:03', '2025-05-17 08:00:03'),
(236, 'UID571BFCF5236', 'pGABwNyxdGS', 'BdfZFFbZTtI', '$2y$12$HPqhFL9xzEun9I60Fg4RZeT.8/NN9lC51TdCJHXi1cE1hZvXpfXBC', '2626766556', 'hutchinsonhelenel22@gmail.com', 0.00, 'zrbkCPLwJL', 'CUruSSQWYhieLLf', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-18 00:30:07', '2025-05-18 00:30:07'),
(237, 'UID73DC4257237', 'oiINSakxJd', 'dpvUDDYLQYjY', '$2y$12$ypzpOwk9/rNmftyF7SyXn.Qld2ZAJ./8kxKo2rJwzC/V7gNHSmvfa', '7983618324', 'malihgr51@gmail.com', 0.00, 'zGllOjtYPkI', 'EgiowSmdyMnB', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-18 01:57:45', '2025-05-18 01:57:45'),
(238, 'UID9791A190238', 'QeahXULHraMGY', 'pNUKSfKLBruN', '$2y$12$l/fvyOJ.G8FGJkQ4ee2Q0eQP9S.z5QpJuWaHZXnSgzEgN9d173ojq', '4072259262', 'genededrick788668@yahoo.com', 0.00, 'BtgaXMwjriLRu', 'rQhSfEnWZLTy', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-18 15:36:35', '2025-05-18 15:36:35'),
(239, 'UIDCD9FCCE5239', 'AqFcYFPBVk', 'ztuslOApjbL', '$2y$12$fJVg5ho2Gw4OnIzgg.zUp.g5ASUneNLhcwjwbwOyPBNgRAPuoXC5y', '4444872490', 'bkorettaa8@gmail.com', 0.00, 'vwpOwHwUjurN', 'VjFEBVusSPhF', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-19 01:26:25', '2025-05-19 01:26:25'),
(240, 'UIDC592F907240', 'MfodSpnUgaAz', 'BaEzFhqJhmwKhj', '$2y$12$Aafw1Lg/b1l2WWWoKatXOOr7Je3aegRp6RR7gaa7hTOOFZxGSqmSi', '7286176076', 'michaelshop323411@yahoo.com', 0.00, 'JMBsyKZzHeNUbR', 'NuyQfOKQwfga', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-19 09:52:08', '2025-05-19 09:52:08'),
(241, 'UID4417483E241', 'WuTzeYhDBhDvS', 'iaUUyeZBC', '$2y$12$JTF7NZkfO8NnIRkIHhz.0.d81vcBIfDNTavw7U0XTArbvRbECRzsm', '2095737606', 'carrollaezelfridqi43@gmail.com', 0.00, 'iUbVhBXLW', 'traSauttJdiJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-19 14:12:55', '2025-05-19 14:12:55'),
(242, 'UID8BD9699E242', 'enKtZQPjKQ', 'oQdXpAQscPyubN', '$2y$12$lNFBxKunyV2ZSMVPCbjJd.IutQtufPu1UiedOjHX9WK6bB40wxLHy', '7407603761', 'vcabreragw60@gmail.com', 0.00, 'oevfxKvTYcC', 'gIteegdXT', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-20 08:08:34', '2025-05-20 08:08:34'),
(243, 'UID47D4E94B243', 'ecekBMYA', 'tSvCSHTFmVdb', '$2y$12$tDgZ01CAPuswX.9VpSKJg.mk7x8Kc0zxWx82hC9qsHKeVwrurlzX6', '6517174054', 'cooleypeist8@gmail.com', 0.00, 'ywUmRMObVZQq', 'bxQRcovJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-21 03:45:31', '2025-05-21 03:45:31'),
(244, 'UID1EDACCDB244', 'GkSTmofFL', 'iCsMJIclbyc', '$2y$12$PiRfUe5MYZqJtawYkjjIgu/OR1x772VhvB8dORlkLAdnTqjEz2EJ2', '5765290192', 'vanessawilliams756516@yahoo.com', 0.00, 'XVNerVFsteJd', 'QheBxwAGCpd', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-21 19:10:09', '2025-05-21 19:10:09'),
(245, 'UID3F6C31F1245', 'GFhYBGFk', 'KyTcbDdS', '$2y$12$chitQOASdxrPN9cJqBTdsusPjYHRddhHO/UK9fThOqfvPxgvMZG.S', '7971835790', 'gooddjanqd16@gmail.com', 0.00, 'JRRwBkVheGClj', 'BblPNLXsNSjt', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-22 11:40:07', '2025-05-22 11:40:07'),
(246, 'UIDC4518DF7246', 'bfHlnANdsbg', 'jEsonFQi', '$2y$12$aZQFqNirfC7ZHvlcZYZpret2wdm7dgLHKmX6DJtBbS7IDFeZNRdxq', '3623483401', 'englishpayati33@gmail.com', 0.00, 'gqauFyXu', 'FszcwUAQXF', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-23 07:16:12', '2025-05-23 07:16:12'),
(247, 'UIDA45D6FA1247', 'JiVTAaTqem', 'spxGIQysFhw', '$2y$12$GYSc/FngsvD5b1dstE9mmOeUc9qTRfwEb4u/4Yx7VC9fqjlY97Oiq', '5837728424', 'mbriggsyw2004@gmail.com', 0.00, 'oKHoKDMnQsBFxq', 'ZvfDEYSsTnvkt', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-23 09:03:47', '2025-05-23 09:03:47'),
(248, 'UID2504860A248', 'ghGaQRLbazow', 'HkYAURzB', '$2y$12$qBCLq.a.sf.68raF.zFSG.d5M/l2N5ODBrm03lqwCMSFLzvrxtaa2', '5622449455', 'marytrejo128459@yahoo.com', 0.00, 'sqarwBGT', 'sKZTVtoYQtoKtYt', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-24 15:33:26', '2025-05-24 15:33:26'),
(249, 'UID77F2D981249', 'wqEtWyGVETGgz', 'rGSUPovO', '$2y$12$8OcviebcKbQhGv9y7nas2ObqlpMnTe5e.d0mja6xBnRq5GFYpfA6e', '9493815575', 'abidjilfrazierz1990@gmail.com', 0.00, 'tHtjTwMmiSEKO', 'aKIRlJDuemNsgeu', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-25 05:01:57', '2025-05-25 05:01:57'),
(250, 'UIDD2AA5E5A250', 'qiCUeLLpgq', 'UutVyVaLEyF', '$2y$12$26dd.d1.YYkvi5JAgCmeGOD5KPNuWaQnmcZX9o6D6xTkg3dcf9Vo6', '6037448340', 'morarobertinau8@gmail.com', 0.00, 'XjakfkSqv', 'GBHnOOkBkiLgIK', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-25 06:41:40', '2025-05-25 06:41:40'),
(251, 'UID643CD022251', 'dVPqrQEk', 'IreZmIam', '$2y$12$6sga1XyBB8lMDoCORjRVBO6KdrNMzVpK8KYdwl8Ng6rWQdwz.N0/.', '8568309880', 'elfridgarr@gmail.com', 0.00, 'dkukxkGgeCz', 'VslYdRrOv', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-25 12:06:19', '2025-05-25 12:06:19'),
(252, 'UIDFE2D86E6252', 'rOHeLGdBb', 'rjwfuEQXZhdll', '$2y$12$OyLVn.QewhrWMDudffLIOewJS7Kib32ZciWpd4Ag47yj2ZcpyzXJS', '4157966577', 'beharajerome128084@yahoo.com', 0.00, 'oNVOmujtWhr', 'RvpFwEQNKOfJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-26 00:40:23', '2025-05-26 00:40:23'),
(253, 'UID5D39F0C3253', 'oWcsRAFvoKloHKz', 'aYxrERaDFHaFxP', '$2y$12$SZo9t89vUj4sR0WlgPKP8uShdyiy9EIVQW5dsDyCorQKgnm3oGzz.', '2817340399', 'pvelazquezt52@gmail.com', 0.00, 'hBOZKKDTResJQ', 'AxElNUHbagFeR', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-26 06:34:58', '2025-05-26 06:34:58'),
(254, 'UID92F3A68F254', 'SFnRoPJIKGsh', 'BuomulINiH', '$2y$12$oye7DJK5f3I5mGC3FjfpC.y0ZCmJI7r4cS.J6jvUZ1efn0Jcowt5u', '2174091010', 'yoty1981@gmail.com', 0.00, 'FOWPxEjpCGnUBo', 'EOmImouoh', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-26 13:03:02', '2025-05-26 13:03:02'),
(255, 'UIDF02DD399255', 'AznNIeESOY', 'uEMiJBlHqzHxJgk', '$2y$12$CioOr51una6tHI3r4VsTN.5jHmF49N9VAbE54p5HBwf0NK30739y.', '2823834096', 'dandieckman527624@yahoo.com', 0.00, 'TjoqakPvARvlTzm', 'DyVubKuK', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-26 14:35:22', '2025-05-26 14:35:22'),
(256, 'UID4E1B7BD1256', 'RMGxxnVWtGjR', 'PogNczhc', '$2y$12$x5vJ58rbdSJxnaJFdq9V4u8wQa8kP0u/.dGpFpWVgNDTBGqWrdtBW', '3262532787', 'rollinseponawl71@gmail.com', 0.00, 'hcEyqvkZuoIh', 'cnamucRxEbo', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-27 07:02:06', '2025-05-27 07:02:06'),
(257, 'UID4EBB3453257', 'dnIYyIAwpbAGE', 'XlDzSxITwuJwqn', '$2y$12$Mm5eBDDmJdF4c.8/P/pb8e.MBOTDMFBO5oBx1c/vdIwfyswHNFCBC', '4762299560', 'boltonlavinaos32@gmail.com', 0.00, 'jpRhiDdjGePS', 'RsFHQnJBllDe', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-29 01:16:54', '2025-05-29 01:16:54'),
(258, 'UIDC017F837258', 'nNCVRBXE', 'aQXynnACPelF', '$2y$12$WDYs4.AABgTiKFXDrfwpUefCHbNLQeShJBAQhpKWf2VlN10Pfcnmm', '3393072664', 'lnetji2006@gmail.com', 0.00, 'vfUxfoNoYKqtnSy', 'bRByrmjdHSKkAW', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-29 10:32:37', '2025-05-29 10:32:37'),
(259, 'UID32AD11FB259', 'aIHcmTyGL', 'IREHwPONvVcpJ', '$2y$12$S/RQK24pqGe56Gd7NT6kC.mZk6TTrt2a2HlBl.hiyAq64EeyWxIga', '6347248381', 'petthorntf@gmail.com', 0.00, 'yyqPiwlnL', 'WPckiufffqxDWIE', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-29 17:05:33', '2025-05-29 17:05:33'),
(260, 'UID41BD3ACB260', 'lsuVzGVRtVM', 'JqtLeYyZqKZxY', '$2y$12$Kq0WSuE5mdajbo9cPP12AufKKZo9k0X2hxLIqwue3Xe.L.hp.gIE2', '2165394467', 'achaneyxc@gmail.com', 0.00, 'lvvLpCGSJOKUgGk', 'GVZmoBZTvm', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-29 20:57:12', '2025-05-29 20:57:12'),
(261, 'UID93228603261', 'KPTUVVgzV', 'CnXmpgjkFHPCt', '$2y$12$NWL4IMfdbz3cdkjPrBvr7OroD5V8WnGhp5wKVwT7T7M0sBvypptrC', '8167501781', 'ottalan1994@yahoo.com', 0.00, 'pBpTCYXrFADRxM', 'BQqKPLrJt', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-29 23:25:48', '2025-05-29 23:25:48'),
(262, 'UIDB41E8CE7262', 'vMggthYBcgjHVO', 'kkqjzcmkWEoSME', '$2y$12$s753iccLB8jCjl/Ccec.l.K2PbiC8zF9QYiOFM23RLmG0phsWrNwi', '2143802958', 'alfredkeithup@gmail.com', 0.00, 'VSwXZckFVgWkh', 'HIWCFFNrbLzwuiZ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-30 01:43:55', '2025-05-30 01:43:55'),
(263, 'UIDF6866EEE263', 'jpIihvttPAUpd', 'uInYAUsPwzGJO', '$2y$12$DUQ.i5HCS5/PD1h1eIrrBuezRE1FS883M2X6S7i5DSZ42RVfzSw8.', '3790348044', 'topseiram21@gmail.com', 0.00, 'YXLDpxkOds', 'ypuJQOWIm', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-30 05:55:59', '2025-05-30 05:55:59'),
(264, 'UID2321A122264', 'cCUTshZoFwQsXUU', 'MhqEhBLRfsB', '$2y$12$bBjhs417lGKT8AmLMFRyHu.cWL91QCRgcDkvh06JN93Tr013KbcYm', '4303042700', 'pkenitp@gmail.com', 0.00, 'SONqxFReFIX', 'uaxzWojaeZjG', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-30 21:26:17', '2025-05-30 21:26:17'),
(265, 'UID140D5229265', 'QyMgHWDCQ', 'ezpqSoMi', '$2y$12$mPgPlJH3KUrlF0h64gLT4.0EBzpnsw2.8wYLmnLQ.q9vroErFp5Xq', '4448852562', 'rmadkenhy1@gmail.com', 0.00, 'oagMDAwNF', 'mQhkTHBhy', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-05-31 09:17:10', '2025-05-31 09:17:10'),
(266, 'UIDD28FD383266', 'YDtkHlwyjCb', 'UqNWEKnlNK', '$2y$12$AQqNbimnozKtneE7CRkuQO9Pjf7XpwKBe.sdqk1fR4DY0U1J/arIq', '3736803705', 'ivorihorn@gmail.com', 0.00, 'agnEOLnAwRdTUZ', 'CuucgLZgga', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-01 13:44:44', '2025-06-01 13:44:44'),
(267, 'UIDFC99DB34267', 'kIcNimYORJwjzY', 'GQldBmfWjHE', '$2y$12$yRWEZc4Qq9bq.PpjbMnVHueS2SpBWzzO.1TNWBkqIJxn52BtNakgW', '9671268066', 'beachemgina328878@yahoo.com', 0.00, 'bBaLFPmgNBrJze', 'VMWWIleiGvcAQJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-03 13:10:15', '2025-06-03 13:10:15'),
(268, 'UID8C8B31B6268', 'gFiQdzboosuWehT', 'mjDnUBtifQDVJqu', '$2y$12$az0WAo3ndNQTG9pQ2RG6IuRrXRuDNEsbRC/Unmem7.x6iP2X6Ov7S', '4069362463', 'djettn1984@gmail.com', 0.00, 'HuDQfRJoTMR', 'XngtzgQFwV', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-03 21:49:38', '2025-06-03 21:49:38'),
(269, 'UID04D20A4A269', 'KOsXZVrCmWTlQE', 'gkpkNwgzj', '$2y$12$b.Tcl86jY3k1rlvnfYWpr.U2gSjFwNhwc7.h5eDi5hRGvTgVYZEw.', '4997151986', 'rhooperuq@gmail.com', 0.00, 'Lcvvlqmqr', 'NIliQiTvWbYVtP', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-05 04:45:59', '2025-06-05 04:45:59'),
(270, 'UID3CEC580E270', 'kTckmSxrBpOV', 'uPoEmuugIVxPaX', '$2y$12$bomH3L8yjcFeoQJ2tFwFde33j.lFQHKRlCsh0.i188ksiPJ.DTbA2', '4236840714', 'proctorkarleil57@gmail.com', 0.00, 'GGpULuxLj', 'gmBWEvFZJNT', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-05 16:00:21', '2025-06-05 16:00:21'),
(271, 'UID8D3C23FA271', 'tVTAfIVPEtlWo', 'GIZjbNluPn', '$2y$12$JWUdeL.BOzM6ufJhkPSmEOIwpZpg3O9k4sjF0oYgDi8asebH2Rixu', '9198886723', 'kamibx46@gmail.com', 0.00, 'bLqjRiREIcY', 'EoPHuuCAvf', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-05 23:50:28', '2025-06-05 23:50:28'),
(272, 'UID02D648AD272', 'gXUJDdKtpdRO', 'BcseXDsNWlEM', '$2y$12$3.i1zjfYF2loipO.5yfPwurewbAhevew5jiKhrYAYfBL4oaaGoojq', '3595381807', 'dakotalivingstono56@gmail.com', 0.00, 'LyYvRgeOUxmLPIY', 'jvSjUDWK', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-06 01:37:57', '2025-06-06 01:37:57'),
(273, 'UIDF98E833F273', 'WQrwtXaKxdK', 'YdCtbPWnFS', '$2y$12$aOt6vADbJAICLx4NV4pRrOa6RdyR1TfJU9YhOacyGpdNoRsrRpMOi', '9940378148', 'nikkhaas18@gmail.com', 0.00, 'EdoUCNhTC', 'HRcxweAfa', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-06 04:13:59', '2025-06-06 04:13:59'),
(274, 'UIDF6B9A792274', 'XNTXEpAyqf', 'rPLguYPxorEpHT', '$2y$12$Eox7uVjlAFI9BtdmEqVQyOmR4iIYP8poRKQBK/9eJb6AJ2/sVEMwq', '8627825600', 'shawnedens161216@yahoo.com', 0.00, 'KllsXSXuaLEV', 'ZJWAEAXbhZJIuFw', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-06 11:37:42', '2025-06-06 11:37:42'),
(275, 'UID9DBF23CC275', 'hvEuHLkZkoqEuw', 'pcljnsdcXRfIW', '$2y$12$aEU82v3iR8EDOiqF.BztVeH0gYooZ3JVZ/gzqRBf73XNSGMzZaqlS', '9189675666', 'toddkostel879710@yahoo.com', 0.00, 'FjNKdCLeYK', 'fbjgKwsBRtNfUM', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-06 11:48:50', '2025-06-06 11:48:50'),
(276, 'UIDCC7E1630276', 'lKNrfjlEUi', 'DhoQRtSZZUq', '$2y$12$TWn6v0mHmHC7VvMCWdVft.DToVaQWkm/YU.HXD3GftwHnXf0OL8S.', '3342262819', 'dustinmeza37013@yahoo.com', 0.00, 'SylqModkDVHeji', 'xXuphsdTdJ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-06 13:04:26', '2025-06-06 13:04:26'),
(277, 'UIDF1191556277', 'tnNdUufxp', 'QNiezaqOAot', '$2y$12$cxJV2N21tdf.7RjqgMFCV.rXrgXwDh2lVzu6deNx52wrvFzsO/xV.', '6827517418', 'sheliymichaml1996@gmail.com', 0.00, 'uxIdYkOEgvsH', 'WhnhWJauiY', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-06 23:08:18', '2025-06-06 23:08:18'),
(278, 'UID68C5ECC1278', 'ORJEdPtX', 'RtwHkgUHNUGa', '$2y$12$tKD18rGXYH8fk0ISl//ef.KNDxp/EogjVn8PUJcgDKTcsI43d3p7C', '3317983223', 'williamsdjanelgu@gmail.com', 0.00, 'ZWNKbYbv', 'zQIWeBjQDqvEnoy', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-07 01:08:58', '2025-06-07 01:08:58'),
(279, 'UIDAE8711BB279', 'zdvvkIFcT', 'WNADXwoRcknWO', '$2y$12$eS6yDAX62lCNGx1NKe/lnevqnlMKXf8vcMLkQiCBDlT2JZH16vg.W', '7794919947', 'eidenlqj1990@gmail.com', 0.00, 'DGwRyGTt', 'rXGRTEqvDekc', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-07 06:42:10', '2025-06-07 06:42:10'),
(280, 'UID1F727BF0280', 'ovXhHyyw', 'tOxHEbleWQJ', '$2y$12$JIiwar/X/E.bQy/.ATBoge.t54NUO1uC2zCGQO3kIJr1ic9AruALq', '7045200239', 'kmonroehb1999@gmail.com', 0.00, 'OCOAbmhUPY', 'zNlZvMawlPMCChL', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-08 09:20:29', '2025-06-08 09:20:29'),
(281, 'UID06D6C4BF281', 'mSohtIXCsqBG', 'TerROGoGbeVVZEJ', '$2y$12$LTRfBAv6wIKWR354MS34ROYdR3QOt7DMAIRJGnnaTNXyTODhJsKcy', '4508682279', 'perezlisa493633@yahoo.com', 0.00, 'tAKQVXTmk', 'eCKXxtwwdIMww', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-08 18:17:28', '2025-06-08 18:17:28'),
(282, 'UIDB57105FB282', 'UJplcFqMMleLC', 'ZrJIvBOTfzjkx', '$2y$12$ewa2zrq2J3mcb4pPbowZgeeOHQMIXc7kV.y4rSpWttHwUsSceDqxW', '4726851220', 'beckyrose596778@yahoo.com', 0.00, 'vkxTPXHG', 'eShKIaKT', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-09 00:14:42', '2025-06-09 00:14:42'),
(283, 'UID5E1132EC283', 'HFOpSyBmYTkD', 'kMGOCbcimhspGgW', '$2y$12$sIo9xyvEtugYx9UEW3pZX.ot8MNwgDFtP7D4NL9m9QfNI4juiKqe6', '7870252414', 'chuckblair618705@yahoo.com', 0.00, 'iXfuedxCPjXW', 'yKtZrPwik', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-10 08:33:29', '2025-06-10 08:33:29'),
(284, 'UIDC9A72A05284', 'bRdEoUSBVYcbI', 'qtKzhFnBmCwYMox', '$2y$12$REfRj69THacsvcCy012z0eyuLMKbHXrOJ/2/ORVVT0niVILGWSeo6', '2358476770', 'djervispowers47@gmail.com', 0.00, 'ACoWHLYLueE', 'LoVqHFsvEZxjsTW', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-10 09:18:43', '2025-06-10 09:18:43'),
(285, 'UID696F181F285', 'UxtBpxmZJQaqLAd', 'YYWdxIKq', '$2y$12$exOB0hx5S3Ty4h6Pc5KRIOx5f9oY/e/CQbB.eET7XYg/Apfgd21A6', '9927331567', 'lindsiduranl@gmail.com', 0.00, 'foFJaeGKildBT', 'lfaWtrGE', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-11 02:25:49', '2025-06-11 02:25:49'),
(286, 'UIDECE19BE4286', 'ZqwIxdUh', 'BIulLSLrdFXaZ', '$2y$12$bdd1BpliUXULRZmXxNRWO.AwHKc6QBe3aOAYSJyFg7VPhAYBvhCWq', '3917411065', 'kmaynardh2@gmail.com', 0.00, 'rIFTZNvIeOI', 'tMoeSRksas', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-11 21:20:28', '2025-06-11 21:20:28'),
(287, 'UID1B8A81D0287', 'QaDLoKPUYfjakEm', 'aBWSSULfUHtwtg', '$2y$12$oAlsF3XYfo0VDWZXktVBFu7W3ZCowT1lKM1LimupFKrdqvfRsVTZK', '8667663195', 'brinnh2005@gmail.com', 0.00, 'iIrRXneG', 'GFolfehNRchJKbm', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-12 02:09:12', '2025-06-12 02:09:12'),
(288, 'UIDE9393221288', 'SHauKThEvnbbqN', 'BBXqUxjVwBdmGD', '$2y$12$qgJP7fw9pTP.XHOeQ.HVFOnmC3ulXIzLIiiPEPEZN3dC6YMn/zMT6', '8904997112', 'otomdunn3@gmail.com', 0.00, 'DXEuwLDoNxC', 'SNbEJELzGADjzXo', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-12 03:12:54', '2025-06-12 03:12:54'),
(289, 'UID2CE95AE8289', 'OZLwFCGRKO', 'mhLNKnZINxQ', '$2y$12$hHRSZA9gdyp0mq2.BePx2uHOmYFaZTluv11UJ5b2pl801HnNie0Am', '5192724037', 'yilfredrusselltl@gmail.com', 0.00, 'PzYngclDn', 'CdYyLCpszeY', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-12 03:17:13', '2025-06-12 03:17:13'),
(290, 'UIDEDA277E1290', 'EGexSusctSRCi', 'TvwUqAaiNOnG', '$2y$12$v/Y4g2EO8wq8CgjF5vZ5Mu.vhDAiJUVFzwTEE5UToA7DcukKuGPq.', '7530726271', 'bettiwrightv@gmail.com', 0.00, 'VHPWJHTvmFySeUy', 'XICsAIBJNGHZwiI', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-12 09:58:01', '2025-06-12 09:58:01');
INSERT INTO `users` (`id`, `user_id`, `name`, `username`, `password`, `tel`, `email`, `account_balance`, `address`, `refferal_user`, `refferal`, `refferal_bonus`, `role`, `cal`, `smart_earners`, `topuser_earners`, `api_earners`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(291, 'UIDE81D3F64291', 'YPFtDFRuUNut', 'HCLVsrFSdJ', '$2y$12$edpWC.7bBF2K96CcRvACSuXpuxKLT8gxyyH/WyJmIRKiv27Gx0v4y', '8143844751', 'ddjessaio2@gmail.com', 0.00, 'pyaYPouRiS', 'GCyjodlcQjUn', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-13 00:47:54', '2025-06-13 00:47:54'),
(292, 'UIDEE99E7BF292', 'MHPhJpmMjxrM', 'CUeRTDGauGr', '$2y$12$LXbAZh8R.iu8ucsOhqkHgetVKm7rLG.6slaH.g8m6TO4FPqZ/M2le', '5847240255', 'festersm78@gmail.com', 0.00, 'BSeXPvYRUNcKDn', 'eEVHSbTZGY', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-13 01:33:46', '2025-06-13 01:33:46'),
(293, 'UIDBC3FA7E9293', 'gIcDGMmW', 'LMWgdPXyUcfvs', '$2y$12$6qVdPt5sOaX2QcDhZmNyeu5418aGvi6ycPTesLBB5sZOnAsiwIdAq', '3837244124', 'schneiderchristine1995@yahoo.com', 0.00, 'wRGuosnLoTet', 'UZuKBSguadN', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-13 02:31:23', '2025-06-13 02:31:23'),
(294, 'UID0E1BB1F9294', 'OANpYgkGbD', 'gkZNwuMCnqMWFia', '$2y$12$sGlbqlC/kfRREh8DhH2T1.aBuOjPFs1iGPgTPsgNSvXEBYyy8l.q6', '5299002432', 'kellydjeimi1992@gmail.com', 0.00, 'LGfWAihKaTgLPkD', 'VvCqplvjwxojaj', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-13 16:05:51', '2025-06-13 16:05:51'),
(295, 'UID2448791E295', 'TvLDUKFXOS', 'TLDWWSspoug', '$2y$12$BLKBEPvC5tHGYQ8JR1/.juWckmcEC9r2HGlCOxFx8baxWGtvrgbFu', '3002781780', 'brijuare1984@gmail.com', 0.00, 'UNBWpGgacX', 'tzrwqIajJVrtSr', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-14 11:17:58', '2025-06-14 11:17:58'),
(296, 'UIDF7D02350296', 'loNJdued', 'VjKMzXkOxUUOCb', '$2y$12$k463xgm9/4Ux886Yifm9dOul0wYyVqHM2nXC.qcypPMRCXbKHMC6G', '6644078823', 'hmeyersp1@gmail.com', 0.00, 'MRxPOuNuzOekvFG', 'hYLdYuMGEDC', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-15 15:18:41', '2025-06-15 15:18:41'),
(297, 'UID521A050C297', 'WaGRIIKgdOKT', 'PmglUirTNOqURf', '$2y$12$sN6g90X0JzfsqkhB7UA2Y.F2SXRXjBecZexYmd99qasmNMFcVww3u', '2471076047', 'arlainlamb@gmail.com', 0.00, 'MvPHksEEXuzrYHL', 'VBTFAQWJprxarT', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-16 06:20:46', '2025-06-16 06:20:46'),
(298, 'UIDE1880508298', 'qrzTWDgYKGGK', 'NcdGaQRlndLuHba', '$2y$12$l4s5CONycZxedzOxUNBceuqWvBDmR3CTuwt7q/1ZuibBck9muyKYu', '5360853740', 'odicya2004@gmail.com', 0.00, 'IaaYQTzwosfGq', 'tWBTYahvtWvn', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-16 09:56:28', '2025-06-16 09:56:28'),
(299, 'UID59CF1709299', 'ZrHIMbEsoYHhB', 'HfFloSUsZfWpOe', '$2y$12$VxheUO6nASi/mjLt7IqAUeVMiPOSyCTB/cVTiwSQ7xlRriAIkDB1y', '8376277699', 'rhoganmf@gmail.com', 0.00, 'obBupQFJiEIe', 'bkpKGltoBqEyrd', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-17 01:05:29', '2025-06-17 01:05:29'),
(300, 'UIDE757F00A300', 'frSkzMDNOxWPER', 'PiXBIuRajYq', '$2y$12$dufFUwcrIIsy/H4jrnAptOjOr2QN9BY9Om3kFPVXI5oZW8MJ0CX06', '6570353243', 'hvaughnmt9@gmail.com', 0.00, 'UKlJsRIBIQ', 'NygVYSMGBd', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-17 14:26:34', '2025-06-17 14:26:34'),
(301, 'UID66FF8239301', 'aeOKgsomsTtEOQd', 'zFZvDFubUhE', '$2y$12$Xjtk9GiuUjxXDnjD093u4eI9kZslPyrM.H1py6s262rquvqNlDxNy', '4532521643', 'hitkliffmckenzieq2005@gmail.com', 0.00, 'FKlhDHodSIVWnKy', 'WnDxYcMDEGc', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-17 23:37:41', '2025-06-17 23:37:41'),
(302, 'UID09055838302', 'EqqvOnEijsa', 'bPPJZhKUx', '$2y$12$2N1qKSqpOZBrDwS.1R5PZuGPUnlOr2q3WPFyz7TtcMKCxoxntHlTa', '2651154010', 'boydvilder21@gmail.com', 0.00, 'yvXljCJuL', 'zlymsptmcpLhPVX', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-18 00:27:17', '2025-06-18 00:27:17'),
(303, 'UIDEA0FDF7E303', 'zpXkKrfUNngLT', 'VOgtUEGCpfYJBGP', '$2y$12$gcgw60GSQwbP75QUHkb53ehf6YTZPTsELJ98pp/bHhB2drURVj.UG', '6119179178', 'goodwinrozke4@gmail.com', 0.00, 'pPQFxOUdubdvSK', 'tXnRIVhYrDcOkYQ', '0', '0', 2, 1, '1', '0', '0', NULL, NULL, '2025-06-18 14:13:25', '2025-06-18 14:13:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airtimes`
--
ALTER TABLE `airtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `airtimes_transactions`
--
ALTER TABLE `airtimes_transactions`
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
-- Indexes for table `data_transactions`
--
ALTER TABLE `data_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_transactions`
--
ALTER TABLE `education_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eletricity_transactions`
--
ALTER TABLE `eletricity_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fund_transactions`
--
ALTER TABLE `fund_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fund_transactions_transaction_id_unique` (`transaction_id`);

--
-- Indexes for table `insurance_transactions`
--
ALTER TABLE `insurance_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `insurance_transactions_transaction_id_unique` (`transaction_id`);

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
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `percentages`
--
ALTER TABLE `percentages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tv_transactions`
--
ALTER TABLE `tv_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airtimes`
--
ALTER TABLE `airtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `airtimes_transactions`
--
ALTER TABLE `airtimes_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `data_transactions`
--
ALTER TABLE `data_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `education_transactions`
--
ALTER TABLE `education_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `eletricity_transactions`
--
ALTER TABLE `eletricity_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_transactions`
--
ALTER TABLE `fund_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `insurance_transactions`
--
ALTER TABLE `insurance_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `percentages`
--
ALTER TABLE `percentages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tv_transactions`
--
ALTER TABLE `tv_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
