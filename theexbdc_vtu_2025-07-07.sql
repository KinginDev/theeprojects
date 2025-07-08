# ************************************************************
# Sequel Ace SQL dump
# Version 20025
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: host.docker.internal (MySQL 5.5.5-10.6.21-MariaDB-ubu2004)
# Database: theexbdc_vtu
# Generation Time: 2025-07-07 22:30:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'admin','admin@admin.com','$2y$12$uVxXm/HH3aBwOyuzn4qK0.D2LIf5zdaVX0.e.ysGuIZWoNalFi3Ju','admin',NULL,NULL,NULL);

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table airtimes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `airtimes`;

CREATE TABLE `airtimes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) NOT NULL,
  `provider_charge_price` varchar(255) NOT NULL,
  `recharge_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table airtimes_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `airtimes_transactions`;

CREATE TABLE `airtimes_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `network` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(255) NOT NULL,
  `current_bal` varchar(255) NOT NULL,
  `percent_profit` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `airtimes_transactions_user_id_foreign` (`user_id`),
  KEY `airtimes_transactions_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `airtimes_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `airtimes_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `airtimes_transactions` WRITE;
/*!40000 ALTER TABLE `airtimes_transactions` DISABLE KEYS */;

INSERT INTO `airtimes_transactions` (`id`, `user_id`, `transaction_id`, `network`, `tel`, `amount`, `reference`, `identity`, `prev_bal`, `current_bal`, `percent_profit`, `status`, `created_at`, `updated_at`)
VALUES
	(2,1,3,'mtn','08011111111','1500','17508027563126961241966263','08011111111','5020.00','3535','15','delivered','2025-06-24 22:06:03','2025-06-24 22:06:03');

/*!40000 ALTER TABLE `airtimes_transactions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table cache_locks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table data_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `data_transactions`;

CREATE TABLE `data_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `api_response` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(255) NOT NULL,
  `current_bal` varchar(255) NOT NULL,
  `percent_profit` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `data_transactions_user_id_foreign` (`user_id`),
  KEY `data_transactions_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `data_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `data_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table education_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `education_transactions`;

CREATE TABLE `education_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `purchased_code` varchar(255) NOT NULL,
  `response_description` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(255) NOT NULL,
  `current_bal` varchar(255) NOT NULL,
  `percent_profit` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `education_transactions_user_id_foreign` (`user_id`),
  KEY `education_transactions_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `education_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `education_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table electricity_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `electricity_transactions`;

CREATE TABLE `electricity_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `purchased_code` varchar(255) NOT NULL,
  `response_description` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(255) NOT NULL,
  `current_bal` varchar(255) NOT NULL,
  `percent_profit` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `electricity_transactions_user_id_foreign` (`user_id`),
  KEY `electricity_transactions_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `electricity_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `electricity_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fund_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fund_transactions`;

CREATE TABLE `fund_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `prev_bal` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Previous balance before transaction',
  `current_bal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reference` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fund_transactions_reference_unique` (`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table insurance_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `insurance_transactions`;

CREATE TABLE `insurance_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `purchased_code` text DEFAULT NULL,
  `response_description` text DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(255) NOT NULL,
  `current_bal` varchar(255) NOT NULL,
  `percent_profit` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `insurance_transactions_reference_unique` (`reference`),
  KEY `insurance_transactions_user_id_foreign` (`user_id`),
  KEY `insurance_transactions_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `insurance_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `insurance_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table job_batches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_batches`;

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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table merchant_preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchant_preferences`;

CREATE TABLE `merchant_preferences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint(20) unsigned NOT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `site_token` varchar(255) DEFAULT NULL,
  `monnify_api_key` varchar(255) DEFAULT NULL,
  `monnify_contract_code` varchar(255) DEFAULT NULL,
  `monnify_percent` varchar(255) DEFAULT NULL,
  `airtime_api_url` varchar(255) DEFAULT NULL,
  `transaction_api_url` varchar(255) DEFAULT NULL,
  `data_network_api_url` varchar(255) DEFAULT NULL,
  `data_api_url` varchar(255) DEFAULT NULL,
  `data_mtn` varchar(255) DEFAULT NULL,
  `data_airtime` varchar(255) DEFAULT NULL,
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
  `test_color` varchar(255) DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `site_bank_name` varchar(255) DEFAULT NULL,
  `site_bank_account_name` varchar(255) DEFAULT NULL,
  `site_bank_account_account` varchar(255) DEFAULT NULL,
  `bonus` varchar(255) DEFAULT NULL,
  `site_bank_comment` text DEFAULT NULL,
  `whatsapp_number` text DEFAULT NULL,
  `welcome_message` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchant_preferences_merchant_id_unique` (`merchant_id`),
  CONSTRAINT `merchant_preferences_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchant_preferences` WRITE;
/*!40000 ALTER TABLE `merchant_preferences` DISABLE KEYS */;

INSERT INTO `merchant_preferences` (`id`, `merchant_id`, `api_key`, `secret_key`, `site_token`, `monnify_api_key`, `monnify_contract_code`, `monnify_percent`, `airtime_api_url`, `transaction_api_url`, `data_network_api_url`, `data_api_url`, `data_mtn`, `data_airtime`, `electricity_pay_api_url`, `electricity_verify_api_url`, `tv_bouquet_api_url`, `tv_billcode_api_url`, `education_waec_registration_api_url`, `education_waec_api_url`, `education_jamb_api_url`, `education_check_result_api_url`, `education_jamb_verify_api_url`, `insurance_health_insurance_api_url`, `insurance_personal_accident_api_url`, `insurance_ui_insure_api_url`, `insurance_state_api_url`, `insurance_color_api_url`, `insurance_brand_api_url`, `insurance_engine_capacity_api_url`, `header_color`, `template_color`, `test_color`, `site_name`, `site_logo`, `company_address`, `company_email`, `company_phone`, `site_bank_name`, `site_bank_account_name`, `site_bank_account_account`, `bonus`, `site_bank_comment`, `whatsapp_number`, `welcome_message`, `email`, `created_at`, `updated_at`)
VALUES
	(1,1,'17b750cf5e5ff61142e9b93412923133','SK_31862977407f222f4b1789c4a4c892b8e6f706972da','705cfc0d749212ea4da1e0c56228fd9d6ebda99a','MK_PROD_FHQDK06011','861657460624','1.6','https://sandbox.vtpass.com/api/pay','https://sandbox.vtpass.com/api/requery','https://lucysrosedata.com/api/network/','https://lucysrosedata.com/api/data/','https://vtpass.com/api/service-variations?serviceID=mtn-data','https://vtpass.com/api/service-variations?serviceID=airtel-data','https://vtpass.com/api/pay','https://vtpass.com/api/merchant-verify','https://vtpass.com/api/pay','https://vtpass.com/api/merchant-verify','https://vtpass.com/api/service-variations?serviceID=waec-registration','https://vtpass.com/api/service-variations?serviceID=waec','https://vtpass.com/api/service-variations?serviceID=jamb','https://vtpass.com/api/pay','https://vtpass.com/api/merchant-verify','https://vtpass.com/api/service-variations?serviceID=health-insurance-rhl','https://vtpass.com/api/service-variations?serviceID=personal-accident-insurance','https://vtpass.com/api/service-variations?serviceID=ui-insure','https://vtpass.com/api/universal-insurance/options/state','https://vtpass.com/api/universal-insurance/options/color','https://vtpass.com/api/universal-insurance/options/brand','https://vtpass.com/api/universal-insurance/options/engine-capacity','#ad3636','#94705c','#2f2d2d','E Project','logos/zJ30QxqU2bpJ7FZfC4dVLdKExTn1W66PIfVvkQr6.png','Abuja Nigeria','theeproject@gmail.com','08132575487','Opay','Okika Arinze','8142751702','5','You can deposit or transfer fund into our account stated above. Use your registered username as depositor\'s name, naration or remarks Your account will be funded as soon as your payment is confirmed. Ooo','2347017325724','Hi, I\'m...... I have a complaint','lucysrosedataplus@gmail.com',NULL,'2025-05-02 01:50:47'),
	(2,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:25:48','2025-06-30 00:25:48'),
	(3,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:26:41','2025-06-30 00:26:41'),
	(4,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:27:22','2025-06-30 00:27:22'),
	(5,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:28:10','2025-06-30 00:28:10'),
	(6,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:37:07','2025-06-30 00:37:07'),
	(7,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:39:20','2025-06-30 00:39:20'),
	(8,8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:48:36','2025-06-30 00:48:36'),
	(9,9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:52:29','2025-06-30 00:52:29'),
	(10,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:55:25','2025-06-30 00:55:25'),
	(11,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 00:55:48','2025-06-30 00:55:48'),
	(12,12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-30 02:21:20','2025-06-30 02:21:20'),
	(13,13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-07 12:05:57','2025-07-07 12:05:57');

/*!40000 ALTER TABLE `merchant_preferences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table merchant_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchant_users`;

CREATE TABLE `merchant_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `type` enum('user','merchant') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_merchant_user` (`merchant_id`,`user_id`),
  KEY `merchant_users_user_id_foreign` (`user_id`),
  CONSTRAINT `merchant_users_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE SET NULL,
  CONSTRAINT `merchant_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchant_users` WRITE;
/*!40000 ALTER TABLE `merchant_users` DISABLE KEYS */;

INSERT INTO `merchant_users` (`id`, `merchant_id`, `user_id`, `type`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'user','2025-06-24 20:48:41','2025-06-24 20:48:41'),
	(2,1,2,'user','2025-06-24 20:50:22','2025-06-24 20:50:22'),
	(3,1,7,'user','2025-06-30 01:39:05','2025-06-30 01:39:05'),
	(4,1,8,'user','2025-06-30 01:58:58','2025-06-30 01:58:58'),
	(5,13,9,'user','2025-07-07 12:08:27','2025-07-07 12:08:27');

/*!40000 ALTER TABLE `merchant_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table merchants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchants`;

CREATE TABLE `merchants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT 'The status of the merchant, can be active or inactive',
  `domain` varchar(255) DEFAULT NULL COMMENT 'The domain of the merchant to access application from eg https://merchantname.theprojects.com',
  `password` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchants_slug_unique` (`slug`),
  UNIQUE KEY `merchants_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchants` WRITE;
/*!40000 ALTER TABLE `merchants` DISABLE KEYS */;

INSERT INTO `merchants` (`id`, `name`, `slug`, `email`, `phone`, `address`, `status`, `domain`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Cora Mcknight','cora-mcknight','qonacovepi@mailinator.com',NULL,NULL,1,'cora-mcknight.theeprojects.test','$2y$12$Yi8nXhROrGX.TjXtWFOU.uQrncS0sV1Orzco6u5SRg1EdMo3lH3Sa','2025-06-30 02:12:00',NULL,'2025-06-24 20:48:18','2025-06-30 02:12:00'),
	(2,'Joel Hobbs','joel-hobbs','xica@mailinator.com',NULL,NULL,1,'joel-hobbs.theeprojects.test','$2y$12$72s7xddvwJq5yO/GpcG5RuWksREc2ZiGYJcoB/hyVLsXOR2n/iSDy',NULL,'89u6BQHtrgWvP78kAbf50rqf4bFXKTszfxkyiPBlveE8q7hQxkfVbJl9Xc6f','2025-06-30 00:25:48','2025-06-30 00:25:48'),
	(3,'Ivan Ray','ivan-ray','loliq@mailinator.com',NULL,NULL,1,'ivan-ray.theeprojects.test','$2y$12$a/8rQx7/GHKtCERACWHKiuWtM797gnlWOqbpUp/iddjBvM7nAuGPW',NULL,'VAGtZOTdL6QpC2HxsOrJxAw73xPNaXxpQJMvnYFjl9ji1CWNdTI25dGPc6C9','2025-06-30 00:26:41','2025-06-30 00:26:41'),
	(4,'Ann Rodgers','ann-rodgers','cyxalaguni@mailinator.com',NULL,NULL,1,'ann-rodgers.theeprojects.test','$2y$12$5/oSa6NquuouVeQ3l7FGpeGH/dmP2UywmyNO5YitGnqYQqGFPrtWO',NULL,NULL,'2025-06-30 00:27:22','2025-06-30 00:27:22'),
	(5,'Jayme Barron','jayme-barron','kehupuvaj@mailinator.com',NULL,NULL,1,'jayme-barron.theeprojects.test','$2y$12$Na5N4NJUFclLDtDQkjvYlOtwMA5HJEioe2pPgPqx3MJ8g3hLpV9mu',NULL,'Gfb628ZbofAQlHxndXRWUkiASlIR6SghEH7mfH0RsE6yjQh1gGYhI0TcIoMB','2025-06-30 00:28:10','2025-06-30 00:28:10'),
	(6,'Claire Mcknight','claire-mcknight','ranak@mailinator.com',NULL,NULL,1,'claire-mcknight.theeprojects.test','$2y$12$QDGOBKGnfjulgtdw6z.kvOUScytNV8Mw72DJN6QUig3RJGrKgSB/6',NULL,'wwMOpCWtmnUb46NEfYLt39jZQt0aXzf4eDAc5f6HznN2PHHr5qKAMoeDlWyP','2025-06-30 00:37:07','2025-06-30 00:37:07'),
	(7,'Kasper Underwood','kasper-underwood','hebu@mailinator.com',NULL,NULL,1,'kasper-underwood.theeprojects.test','$2y$12$IiB5C8ifwBVR8F4qjCbLpeUrkhDPTCc/c5EQQzrtxwefzYBr77L1a',NULL,'awVFvHnhMhVmxxz3zuPC49qGrEMzZWHpVcT7AjaAVNkI00eECQraXXIlPpXM','2025-06-30 00:39:20','2025-06-30 00:39:20'),
	(8,'Theodore Slater','theodore-slater','zuqipas@mailinator.com',NULL,NULL,1,'theodore-slater.theeprojects.test','$2y$12$dQdm6SiQdSQqBaxWFq8/rOPRGGeYvv6iKcmeDvpINoVAVDSD0HbX2',NULL,NULL,'2025-06-30 00:48:36','2025-06-30 00:48:36'),
	(9,'Cade Todd','cade-todd','limag@mailinator.com',NULL,NULL,1,'cade-todd.theeprojects.test','$2y$12$S4Z9cmVJ9O/pVHcc/WUd/OtmuJ16hLDxoSamUielNWsgAghI/aAIG',NULL,NULL,'2025-06-30 00:52:29','2025-06-30 00:52:29'),
	(10,'Rudyard Hayden','rudyard-hayden','lemuvyle@mailinator.com',NULL,NULL,1,'rudyard-hayden.theeprojects.test','$2y$12$VRQvwSWsY2RvIuOffPTFKOra/6AtZCd/BmLx97LjP0FBFO.ofKYT2',NULL,NULL,'2025-06-30 00:55:25','2025-06-30 00:55:25'),
	(11,'Magee Copeland','magee-copeland','towyki@mailinator.com',NULL,NULL,1,'magee-copeland.theeprojects.test','$2y$12$HYq9UZoubbf1qF0GcoD5jumk9Ja7veEUNYl7TzC.tzctoDwbLXGwa',NULL,NULL,'2025-06-30 00:55:48','2025-06-30 00:55:48'),
	(12,'Xanthus Garza','xanthus-garza','lulenihix@mailinator.com',NULL,NULL,1,'xanthus-garza.theeprojects.test','$2y$12$u2ZamQy9Zy2mkmcQ.u9sFu9MFlREMykybXKM.gBW//kI0NPM.xHQ2','2025-06-30 02:24:47',NULL,'2025-06-30 02:21:20','2025-06-30 02:24:47'),
	(13,'Justin Guerra','justin-guerra','loroku@mailinator.com',NULL,NULL,1,'justin-guerra.theeprojects.test','$2y$12$2wr3th1o8/2.xd36.gWy7ONbMOutWToKvnqN8Nc/09OJpY2yH8Czy','2025-07-07 12:06:04',NULL,'2025-07-07 12:05:57','2025-07-07 12:06:04');

/*!40000 ALTER TABLE `merchants` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'0001_01_01_000000_create_users_table',1),
	(2,'0001_01_01_000001_create_cache_table',1),
	(3,'0001_01_01_000002_create_jobs_table',1),
	(4,'2024_06_24_create_transactions_table',1),
	(5,'2024_06_24_create_wallet_transactions_table',1),
	(6,'2024_07_28_213522_create_airtimes_table',1),
	(7,'2024_07_29_193741_create_airtimestransactions_table',1),
	(8,'2024_07_29_194038_create_datatransactions_table',1),
	(9,'2024_08_18_150245_education_transactions',1),
	(10,'2024_08_23_121240_create_insurance_transactions_table',1),
	(11,'2024_08_24_052507_create_eletricity_transactions_table',1),
	(12,'2024_08_24_053013_create_tv_transactions_table',1),
	(13,'2024_08_28_173206_create_message_table',1),
	(14,'2024_08_29_053757_create_notifications_table',1),
	(15,'2024_08_29_082458_create_fund_transactions_table',1),
	(16,'2024_08_30_083735_create_referrals_table',1),
	(17,'2024_09_10_062731_create_settings_table',1),
	(18,'2024_09_11_120231_create_percentage_table',1),
	(19,'2024_09_28_114522_create_merchants_table',1),
	(20,'2025_06_18_121717_add_user_id_to_users_table',1),
	(21,'2025_06_18_124016_add_prev_bal_to_fund_transactions_table',1),
	(22,'2025_06_18_180239_create_products_table',1),
	(23,'2025_06_18_180246_create_merchants_table',1),
	(24,'2025_06_18_190630_add_merchant_id_col_to_users_table',1),
	(25,'2025_06_19_013715_create_admins_table',1),
	(26,'2025_06_24_093648_create_merchant_users_table',1),
	(27,'2025_06_24_093712_remove_merchant_id_from_users_table',1),
	(28,'2025_06_24_110223_create_merchant_perfrences_table',1),
	(29,'2025_06_24_124906_add_transaction_id_to_product_transactions_table',1),
	(30,'2025_06_24_131018_add_product_id_to_percentages_table',1),
	(31,'2025_06_24_143336_create_wallets_table',1),
	(32,'2025_06_24_214544_add_service_name_class_to_products_table',2),
	(34,'2025_06_25_030423_add_kind_to_transactions_table',3);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `msghead` varchar(255) NOT NULL,
  `msgbody` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `route_title` varchar(255) DEFAULT NULL,
  `route_name` varchar(255) DEFAULT NULL,
  `action` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table password_reset_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`)
VALUES
	('qonacovepi@mailinator.com','$2y$12$jTp2y9NqqhfvAhj6XLbmJ.wa0E1gZ/kgAkqms4M80QIb80ftOw2Wu','2025-06-30 01:15:00');

/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table percentages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `percentages`;

CREATE TABLE `percentages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `smart_earners_percent` varchar(255) DEFAULT NULL,
  `topuser_earners_percent` varchar(255) DEFAULT NULL,
  `api_earners_percent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `percentages_product_id_foreign` (`product_id`),
  CONSTRAINT `percentages_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `percentages` WRITE;
/*!40000 ALTER TABLE `percentages` DISABLE KEYS */;

INSERT INTO `percentages` (`id`, `product_id`, `service`, `smart_earners_percent`, `topuser_earners_percent`, `api_earners_percent`, `created_at`, `updated_at`)
VALUES
	(1,13,'9mobile_GIFTING_Data','4.00','4.00','4.00',NULL,'2025-06-24 21:51:15'),
	(2,21,'Aba_Electric_Payment_-_ABEDC','0.5','1','1',NULL,'2025-06-24 21:51:15'),
	(3,22,'Abuja_Electricity_Distribution_Company_-_AEDC','0.5','0.5','0.5',NULL,'2025-06-24 21:51:15'),
	(4,2,'Airtel_Airtime_VTU','1','2','3',NULL,'2025-06-24 21:51:15'),
	(5,9,'Airtel_GIFTING_Data','1','2','2',NULL,'2025-06-24 21:51:15'),
	(6,23,'Benin_Electricity_-_BEDC','1.50','1.50','1.50',NULL,'2025-06-24 21:51:15'),
	(7,17,'DSTV_Subscription','1.50%','1.50%','1.50%',NULL,'2025-06-24 21:51:15'),
	(8,24,'Eko_Electric_Payment_-_EKEDC','1.00','1.00','1.00',NULL,'2025-06-24 21:51:15'),
	(9,25,'Enugu_Electric_-_EEDC','1.40','1.40','1.40',NULL,'2025-06-24 21:51:15'),
	(10,4,'9mobile_Airtime_VTU','2','2','2',NULL,'2025-06-24 21:51:15'),
	(11,14,'9mobile_CORPORATE_GIFTING_Data','4','2','2',NULL,'2025-06-24 21:51:15'),
	(12,3,'GLO_Airtime_VTU','1','2','3',NULL,'2025-06-24 21:51:15'),
	(13,11,'GLO_GIFTING_Data','3','4.00','4.00',NULL,'2025-06-24 21:51:15'),
	(14,12,'GLO_CORPORATE_GIFTING_Data','4.00','4.00','4.00',NULL,'2025-06-24 21:51:15'),
	(15,18,'Gotv_Payment','1.50','1.50','1.50',NULL,'2025-06-24 21:51:15'),
	(16,37,'Home_Cover_Insurance','6.00%','6.00%','6.00%',NULL,'2025-06-24 21:51:15'),
	(17,26,'IBEDC_-_Ibadan_Electricity_Distribution_Company','1.10','1.10','1.10',NULL,'2025-06-24 21:51:15'),
	(18,27,'Ikeja_Electric_Payment_-_IKEDC','1.00','1.00','1.00',NULL,'2025-06-24 21:51:15'),
	(19,28,'Jos_Electric_-_JED','0.90','0.90','0.90',NULL,'2025-06-24 21:51:15'),
	(20,29,'Kaduna_Electric_-_KAEDCO','1.50','1.50','1.50',NULL,'2025-06-24 21:51:15'),
	(21,30,'KEDCO_-_Kano_Electric','1.00','2.00','1.00',NULL,'2025-06-24 21:51:15'),
	(22,1,'MTN_Airtime_VTU','1','2','3',NULL,'2025-06-24 21:51:15'),
	(23,5,'MTN_SME_Data','-2','3.00','3.00',NULL,'2025-06-24 21:51:15'),
	(24,35,'Personal_Accident_Insurance','10.00','10.00','10.00',NULL,'2025-06-24 21:51:15'),
	(25,31,'PHED_-_Port_Harcourt_Electric','2.00','2.00','2.00',NULL,'2025-06-24 21:51:15'),
	(26,20,'ShowMax','1.50%','1.50%','1.50%',NULL,'2025-06-24 21:51:15'),
	(27,15,'Smile_Payment','5.00%','5.00%','5.00%',NULL,'2025-06-24 21:51:15'),
	(28,39,'SMSclone.com','3.00%','3.00%','3.00%',NULL,'2025-06-24 21:51:15'),
	(29,16,'Spectranet_Internet_Data','3.00%','3.00%','3.00%',NULL,'2025-06-24 21:51:15'),
	(30,19,'Startimes_Subscription','2.00%','2.00%','2.00%',NULL,'2025-06-24 21:51:15'),
	(31,36,'Third_Party_Motor_Insurance_-_Universal_Insurance','6.00','6.00','6.00',NULL,'2025-06-24 21:51:15'),
	(32,33,'WAEC_Result_Checker_PIN','10','10','10',NULL,'2025-06-24 21:51:15'),
	(33,34,'WAEC_Registration_PIN','150','150','150',NULL,'2025-06-24 21:51:15'),
	(34,32,'Yola_Electric_Disco_Payment_-_YEDC','1.20','1.20','1.20',NULL,'2025-06-24 21:51:15'),
	(35,38,'VTpass_POS_Terminal_Payment','-','-','-',NULL,'2025-06-24 21:51:15'),
	(36,NULL,'Smile_Network_Payment','5.00%','5.00%','5.00%',NULL,NULL),
	(37,10,'Airtel_CORPORATE_GIFTING_Data','3.40','3.40','3.40',NULL,'2025-06-24 21:51:15'),
	(38,6,'MTN_SME2_Data','1','-3','-3',NULL,'2025-06-24 21:51:15'),
	(39,7,'MTN_GIFTING_Data','1.00','2.00','3.00',NULL,'2025-06-24 21:51:15'),
	(41,8,'MTN_CORPORATE_GIFTING_Data','3.00','3.00','3.00',NULL,'2025-06-24 21:51:15'),
	(42,NULL,'Dstv_Payment','1.50','1.50','1.50',NULL,'2024-09-14 06:05:43'),
	(43,NULL,'Startime_Payment','1.50','3.50','1.50',NULL,'2024-09-14 06:06:27'),
	(44,NULL,'Showmax_Payment','1.50','1.50','1.50',NULL,'2024-09-14 06:06:10');

/*!40000 ALTER TABLE `percentages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('airtime','data','electricity','tv','education','insurance','wallet','other') NOT NULL,
  `price` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `name`, `slug`, `service_name`, `description`, `type`, `price`, `is_active`, `image`, `created_at`, `updated_at`)
VALUES
	(1,'MTN Airtime','MTN_Airtime_VTU','mtn','MTN Airtime VTU for all networks','airtime',NULL,1,NULL,NULL,NULL),
	(2,'Airtel Airtime','Airtel_Airtime_VTU','airtel','Airtel Airtime VTU for all networks','airtime',NULL,1,NULL,NULL,NULL),
	(3,'Glo Airtime','GLO_Airtime_VTU','glo','Glo Airtime VTU for all networks','airtime',NULL,1,NULL,NULL,NULL),
	(4,'9mobile Airtime','9mobile_Airtime_VTU','9mobile','9mobile Airtime VTU for all networks','airtime',NULL,1,NULL,NULL,NULL),
	(5,'MTN SME Data','MTN_SME_Data',NULL,'MTN SME Data bundles','data',NULL,1,NULL,NULL,NULL),
	(6,'MTN SME2 Data','MTN_SME2_Data',NULL,'MTN SME2 Data bundles','data',NULL,1,NULL,NULL,NULL),
	(7,'MTN Gifting Data','MTN_GIFTING_Data',NULL,'MTN Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(8,'MTN Corporate Gifting Data','MTN_CORPORATE_GIFTING_Data',NULL,'MTN Corporate Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(9,'Airtel Gifting Data','Airtel_GIFTING_Data',NULL,'Airtel Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(10,'Airtel Corporate Gifting Data','Airtel_CORPORATE_GIFTING_Data',NULL,'Airtel Corporate Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(11,'Glo Gifting Data','GLO_GIFTING_Data',NULL,'Glo Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(12,'Glo Corporate Gifting Data','GLO_CORPORATE_GIFTING_Data',NULL,'Glo Corporate Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(13,'9mobile Gifting Data','9mobile_GIFTING_Data',NULL,'9mobile Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(14,'9mobile Corporate Gifting Data','9mobile_CORPORATE_GIFTING_Data',NULL,'9mobile Corporate Gifting Data bundles','data',NULL,1,NULL,NULL,NULL),
	(15,'Smile  Payment','Smile_Payment',NULL,'Smile Network Data bundles','data',NULL,1,NULL,NULL,NULL),
	(16,'Spectranet Internet Data','Spectranet_Internet_Data',NULL,'Spectranet Internet Data bundles','data',NULL,1,NULL,NULL,NULL),
	(17,'DSTV Subscription','DSTV_Subscription',NULL,'DSTV subscription packages','tv',NULL,1,NULL,NULL,NULL),
	(18,'GOTV Subscription','Gotv_Payment',NULL,'GOTV subscription packages','tv',NULL,1,NULL,NULL,NULL),
	(19,'Startimes Subscription','Startimes_Subscription',NULL,'Startimes subscription packages','tv',NULL,1,NULL,NULL,NULL),
	(20,'Showmax Subscription','ShowMax',NULL,'Showmax subscription packages','tv',NULL,1,NULL,NULL,NULL),
	(21,'Aba Electric Payment','Aba_Electric_Payment_-_ABEDC',NULL,'Aba Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(22,'Abuja Electricity Distribution','Abuja_Electricity_Distribution_Company_-_AEDC',NULL,'Abuja Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(23,'Benin Electricity','Benin_Electricity_-_BEDC',NULL,'Benin Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(24,'Eko Electric Payment','Eko_Electric_Payment_-_EKEDC',NULL,'Eko Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(25,'Enugu Electric','Enugu_Electric_-_EEDC',NULL,'Enugu Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(26,'Ibadan Electric','IBEDC_-_Ibadan_Electricity_Distribution_Company',NULL,'Ibadan Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(27,'Ikeja Electric Payment','Ikeja_Electric_Payment_-_IKEDC',NULL,'Ikeja Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(28,'Jos Electric','Jos_Electric_-_JED',NULL,'Jos Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(29,'Kaduna Electric','Kaduna_Electric_-_KAEDCO',NULL,'Kaduna Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(30,'Kano Electric','KEDCO_-_Kano_Electric',NULL,'Kano Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(31,'Port Harcourt Electric','PHED_-_Port_Harcourt_Electric',NULL,'Port Harcourt Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(32,'Yola Electric','Yola_Electric_Disco_Payment_-_YEDC',NULL,'Yola Electricity Distribution Company bill payment','electricity',NULL,1,NULL,NULL,NULL),
	(33,'WAEC Result Checker','WAEC_Result_Checker_PIN',NULL,'WAEC result checker PIN','education',NULL,1,NULL,NULL,NULL),
	(34,'WAEC Registration','WAEC_Registration_PIN',NULL,'WAEC registration PIN','education',NULL,1,NULL,NULL,NULL),
	(35,'Personal Accident Insurance','Personal_Accident_Insurance',NULL,'Personal accident insurance coverage','insurance',NULL,1,NULL,NULL,NULL),
	(36,'Third Party Motor Insurance','Third_Party_Motor_Insurance_-_Universal_Insurance',NULL,'Third party motor insurance - Universal Insurance','insurance',NULL,1,NULL,NULL,NULL),
	(37,'Home Cover Insurance','Home_Cover_Insurance',NULL,'Home cover insurance protection','insurance',NULL,1,NULL,NULL,NULL),
	(38,'VTpass POS Terminal Payment','VTpass_POS_Terminal_Payment',NULL,'VTpass POS Terminal Payment services','other',NULL,1,NULL,NULL,NULL),
	(39,'SMSclone.com','SMSclone.com',NULL,'SMSclone.com services','other',NULL,1,NULL,NULL,NULL);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table referrals
# ------------------------------------------------------------

DROP TABLE IF EXISTS `referrals`;

CREATE TABLE `referrals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `referral_user_id` varchar(255) NOT NULL,
  `referral_username` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`)
VALUES
	('49MMmAdRpz8fVmMLaSVrnV0rZQy0baI8xhwRKCPy','1','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNEZ4NDhFb215NXJodHpENmxnZHBsRVZobVBwa2c3TDhhV1Rvb2lQTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vY29yYS1tY2tuaWdodC50aGVlcHJvamVjdHMudGVzdC91c2VyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo4OiJ1c2VybmFtZSI7czo2OiJoYWhvdGUiO30=',1751824906),
	('6sSY3cPBrFIGAiPrFIa51inPBxX0iO7vFoQgnsCA','1','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVXROejVwRWcwZ0tIZ0ZMSkJGZW9wa3B5MFVLY2tIMFZTRjE4cUY0QyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cHM6Ly90aGVlcHJvamVjdHMudGVzdC9tZXJjaGFudC9hZGQvZnVuZC8xIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvZGFzaGJvYXJkP2FjdGlvbj1zaG93TW9kYWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU1OiJsb2dpbl9tZXJjaGFudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1751830480),
	('855HyXfRUrRT9jFfGD8Inx20kem2jkM3JXT2LjFw','8','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoicENyQWl5d3FMY1NIbVl1c3l0c2wzZGdaYmFYVDNOdjFWN3FJSW8wUyI7czozMToibG9nLXZpZXdlcjpzaG9ydGVyLXN0YWNrLXRyYWNlcyI7YjowO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzg6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvZW1haWwvdmVyaWZ5Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvZW1haWwvdmVyaWZ5Ijt9czo1NToibG9naW5fbWVyY2hhbnRfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=',1751244584),
	('apExIjlzcJceF61zDV6xl5cRF9mvFPxH5de1xECn','12','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoic2FpRFZ5QTZCbjRUVzBBT1pXWDN0SXhuRFhHT21ONVNUb1ZSWG5IMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvZGFzaGJvYXJkIjt9czo1NToibG9naW5fbWVyY2hhbnRfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjt9',1751250287),
	('B3h78z44csmhwCHxSX4R0ENvo3VNPm6u9mFEJs9v','7','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN3ZESVdUNGxjSENjVDlZUGVkVGlyQzZZOTJkdU5FR1l3NG43bnd4ZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NDoiaHR0cHM6Ly9jb3JhLW1ja25pZ2h0LnRoZWVwcm9qZWN0cy50ZXN0L3VzZXIvZGFzaGJvYXJkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHBzOi8vY29yYS1tY2tuaWdodC50aGVlcHJvamVjdHMudGVzdC91c2VyL2VtYWlsL3ZlcmlmeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==',1751248445),
	('BiSH4IqQcLAb0bH77Vr5nYcNoKs4nXCZqJhBn7YB',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUFud1FsbXFqTzFiakVNRnVJRFNtQmVBOXlrYjZ1Rll1UnBGMzloUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1751890751),
	('E9r0pd1zt3bx73YyBPr9QNInF46tGHjB2I7maB7S',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQVg1bXduRmNQVVRXRldvbWJTTlprVWxNWE9PczF3WlBkYTZMSUFrWiI7czozMToibG9nLXZpZXdlcjpzaG9ydGVyLXN0YWNrLXRyYWNlcyI7YjowO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6NDc6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvZW1haWwvdmVyaWZ5Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvcmVnaXN0ZXIiO319',1751244747),
	('Eh9PveRMshr7uoDlhkWmxGqdy8X50tCS8nbFsphS','10','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWDduRkdRWXFIZFRYb0ZmdzJrbFNZVTJjRTFVYVkwRDc1dzRQYXBieiI7czozMToibG9nLXZpZXdlcjpzaG9ydGVyLXN0YWNrLXRyYWNlcyI7YjowO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ3OiJodHRwczovL3RoZWVwcm9qZWN0cy50ZXN0L21lcmNoYW50L2VtYWlsL3ZlcmlmeSI7fXM6NTU6ImxvZ2luX21lcmNoYW50XzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==',1751244925),
	('GBoMRIP3vlfzptUkDTZlFQ6KCokOVb5DTTuZuLVB','3','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiME5aZmRRVHBhSDVDOTNDNTk1RW9oZjNUZmhaUVZ4NDluMnhDZGF6NCI7czozMToibG9nLXZpZXdlcjpzaG9ydGVyLXN0YWNrLXRyYWNlcyI7YjowO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NDoiaHR0cHM6Ly90aGVlcHJvamVjdHMudGVzdC9tZXJjaGFudC9kYXNoYm9hcmQiO31zOjU1OiJsb2dpbl9tZXJjaGFudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==',1751243201),
	('HRDO2SUDtSNKjyplPC3sOkf3G4hwGJraufr52X7z','8','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidUIyeWkwekpqeHExa3drakI4RzZiR0FMZ1FKTHVDR1R4WG1yR1VkUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vY29yYS1tY2tuaWdodC50aGVlcHJvamVjdHMudGVzdC91c2VyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==',1751252078),
	('IvWpydbAtUQlz1PcbgA3uyGgO3elcDLCMrOzDGFu',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQW5Cc2Frb0xpNDA0WXJzZ1JTeWVqVlZDY0Rpd1RQUWw4QUlreWhqdCI7czozMToibG9nLXZpZXdlcjpzaG9ydGVyLXN0YWNrLXRyYWNlcyI7YjowO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1751243136),
	('l5oam059HEi1Z8X2FSZh1RXwapLNxWymPlydtA6a','1','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGRGc1RZZnV4c1dCdk9aVFI4OUdIdjhpSzVTbmpkTlliWnJndVl1RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvYWRkL2Z1bmQvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTU6ImxvZ2luX21lcmNoYW50XzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1751810522),
	('O1HAROrcUedHDxwJ6S796DUpwTeM8IAifsGtwiKy','13','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNTZiVk5YOGVEeW45UlVIRkhUQXZTbmVicHVMeHlGemlVVnJWR2ZpTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NToibG9naW5fbWVyY2hhbnRfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMztzOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1751892750),
	('oJBCQSlFDPhhtmMilXEEj7uiq5pYA8jeU78O7z8U','1','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSk9pNFQ1Y2tLaEtIblhUUVFNck4wSVpNbmNNNjdZWmxJNDhYM2FaZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NDoiaHR0cHM6Ly9jb3JhLW1ja25pZ2h0LnRoZWVwcm9qZWN0cy50ZXN0L3VzZXIvZGFzaGJvYXJkIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vY29yYS1tY2tuaWdodC50aGVlcHJvamVjdHMudGVzdC91c2VyL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1751242038),
	('P8kgUDptj8yNdlFnsbDLaBB5uRSM9lxrSRSCxopi',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoiWlk5VEJzVG5zWnZmbEtCbG1xVkg0OURFOHVnOE5ua2laWkJQeWxqQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1751242075),
	('PUoE6P8G817W91vWUpXU1CE3tkBatpe5cUP3M6xp','2','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYW5SbkZBUXNBMHRBVVoxUlpnNkZ5aVR6akdXY1V2bDdwSTlkZ1ZCbiI7czozMToibG9nLXZpZXdlcjpzaG9ydGVyLXN0YWNrLXRyYWNlcyI7YjowO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NDoiaHR0cHM6Ly90aGVlcHJvamVjdHMudGVzdC9tZXJjaGFudC9kYXNoYm9hcmQiO31zOjU1OiJsb2dpbl9tZXJjaGFudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',1751243149),
	('s4GKHirOkiYLMXGwpofqYAfU8CHkqFQtwJfGyjX7',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMkhSVVpVZVNpY1EyUDkyNXlXV1BuZmlHOXd5S01pUUxGRHNyN3V3MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHBzOi8vY29yYS1tY2tuaWdodC50aGVlcHJvamVjdHMudGVzdC91c2VyL2VtYWlsL3ZlcmlmeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1751248559),
	('WnzK7MGC7p8C15g9aYUtLh8dRr2E3qyvqfqbCqr6','9','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYmF0OGZ3eUFwalF5bENQSjNQdTRDeUJZampFcWJSM1ozRzBRdnNGbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vanVzdGluLWd1ZXJyYS50aGVlcHJvamVjdHMudGVzdC91c2VyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==',1751892744),
	('xTzvyzCMytz7JuiihYqGfBoPyfhY2KErsLwo3dh1','1','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoid0xwQnZsS1BSWUU4dzZmckM2TVI5RHdKdVJ5eHJoN09wZzFDM1VCSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vY29yYS1tY2tuaWdodC50aGVlcHJvamVjdHMudGVzdC91c2VyL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo4OiJ1c2VybmFtZSI7czo2OiJoYWhvdGUiO30=',1751244655);

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `api_key` varchar(255) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `site_token` varchar(255) DEFAULT NULL,
  `monnify_api_key` varchar(255) DEFAULT NULL,
  `monnify_percent` varchar(255) DEFAULT NULL,
  `monnify_contract_code` varchar(255) DEFAULT NULL,
  `airtime_api_url` varchar(255) DEFAULT NULL,
  `transaction_api_url` varchar(255) DEFAULT NULL,
  `data_network_api_url` varchar(255) DEFAULT NULL,
  `data_api_url` varchar(255) DEFAULT NULL,
  `data_mtn` varchar(255) DEFAULT NULL,
  `data_airtime` varchar(255) DEFAULT NULL,
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
  `test_color` varchar(255) DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `site_bank_name` varchar(255) DEFAULT NULL,
  `site_bank_account_name` varchar(255) DEFAULT NULL,
  `site_bank_account_account` varchar(255) DEFAULT NULL,
  `bonus` varchar(255) DEFAULT NULL,
  `site_bank_comment` text DEFAULT NULL,
  `whatsapp_number` text DEFAULT NULL,
  `welcome_message` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `api_key`, `secret_key`, `site_token`, `monnify_api_key`, `monnify_percent`, `monnify_contract_code`, `airtime_api_url`, `transaction_api_url`, `data_network_api_url`, `data_api_url`, `data_mtn`, `data_airtime`, `electricity_pay_api_url`, `electricity_verify_api_url`, `tv_bouquet_api_url`, `tv_billcode_api_url`, `education_waec_registration_api_url`, `education_waec_api_url`, `education_jamb_api_url`, `education_check_result_api_url`, `education_jamb_verify_api_url`, `insurance_health_insurance_api_url`, `insurance_personal_accident_api_url`, `insurance_ui_insure_api_url`, `insurance_state_api_url`, `insurance_color_api_url`, `insurance_brand_api_url`, `insurance_engine_capacity_api_url`, `header_color`, `template_color`, `test_color`, `site_name`, `site_logo`, `company_name`, `company_address`, `company_phone`, `company_email`, `site_bank_name`, `site_bank_account_name`, `site_bank_account_account`, `bonus`, `site_bank_comment`, `whatsapp_number`, `welcome_message`, `email`, `created_at`, `updated_at`)
VALUES
	(1,'7d8f0828ffe0216c336942500be11ade','SK_4483c4800d8c7750929648aede472ee24753eedbfcc','705cfc0d749212ea4da1e0c56228fd9d6ebda99a','MK_PROD_FHQDK06011','1.6','861657460624','https://vtpass.com/api/pay','https://vtpass.com/api/requery','https://lucysrosedata.com/api/network/','https://lucysrosedata.com/api/data/','https://vtpass.com/api/service-variations?serviceID=mtn-data','https://vtpass.com/api/service-variations?serviceID=airtel-data','https://vtpass.com/api/pay','https://vtpass.com/api/merchant-verify','https://vtpass.com/api/pay','https://vtpass.com/api/merchant-verify','https://vtpass.com/api/service-variations?serviceID=waec-registration','https://vtpass.com/api/service-variations?serviceID=waec','https://vtpass.com/api/service-variations?serviceID=jamb','https://vtpass.com/api/pay','https://vtpass.com/api/merchant-verify','https://vtpass.com/api/service-variations?serviceID=health-insurance-rhl','https://vtpass.com/api/service-variations?serviceID=personal-accident-insurance','https://vtpass.com/api/service-variations?serviceID=ui-insure','https://vtpass.com/api/universal-insurance/options/state','https://vtpass.com/api/universal-insurance/options/color','https://vtpass.com/api/universal-insurance/options/brand','https://vtpass.com/api/universal-insurance/options/engine-capacity','#ad3636','#94705c','#2f2d2d','E Project','logos/BTG7fdfzTW4ilmD7CNirnkAjKHaoRLcvWPIr8iAk.png',NULL,'Abuja Nigeria','08132575487','theeproject@gmail.com','Opay','Okika Arinze','8142751702','5','You can deposit or transfer fund into our account stated above. Use your registered username as depositor\'s name, naration or remarks Your account will be funded as soon as your payment is confirmed. Ooo','2347017325724','Hi, I\'m...... I have a complaint','lucysrosedataplus@gmail.com',NULL,'2025-06-24 22:37:19');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `transactable_type` varchar(255) NOT NULL,
  `transactable_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('airtime','data','electricity','tv','education','insurance','wallet','other') NOT NULL,
  `kind` enum('credit','debit') NOT NULL DEFAULT 'credit',
  `status` enum('pending','processing','success','failed') NOT NULL DEFAULT 'pending',
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `provider_reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_reference_unique` (`reference`),
  KEY `transactions_transactable_type_transactable_id_index` (`transactable_type`,`transactable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;

INSERT INTO `transactions` (`id`, `reference`, `transactable_type`, `transactable_id`, `amount`, `type`, `kind`, `status`, `payload`, `provider_reference`, `created_at`, `updated_at`, `provider`)
VALUES
	(1,'TRX685B0F9E6D842','App\\Models\\User',1,7000.00,'wallet','credit','pending',X'7B2255736572204E616D65223A224269616E63612042726F636B222C225573657220456D61696C223A2277797061406D61696C696E61746F722E636F6D222C22726564697265637455726C223A2268747470733A5C2F5C2F636F72612D6D636B6E696768742E7468656570726F6A656374732E746573745C2F757365725C2F64617368626F617264227D',NULL,'2025-06-24 20:50:38','2025-06-24 20:50:38',NULL),
	(3,'TRX685B214B2B076','App\\Models\\User',1,1500.00,'airtime','debit','pending',X'7B2255736572204E616D65223A224269616E63612042726F636B222C225573657220456D61696C223A2277797061406D61696C696E61746F722E636F6D222C226465736372697074696F6E223A226D746E2041697274696D65205075726368617365222C225472616E73616374696F6E2054797065223A2241697274696D65205075726368617365227D',NULL,'2025-06-24 22:06:03','2025-06-24 22:06:03',NULL),
	(4,'TRX685B3AAB7D70F','App\\Models\\Merchant',1,7000.00,'wallet','credit','pending',X'7B224D65726368616E74204E616D65223A22436F7261204D636B6E69676874222C224D65726368616E7420646F6D61696E223A22636F72612D6D636B6E696768742E7468656570726F6A656374732E74657374227D',NULL,'2025-06-24 23:54:19','2025-06-24 23:54:19',NULL),
	(5,'TRX685B3B62EFEA8','App\\Models\\Merchant',1,20000.00,'wallet','credit','pending',X'7B224D65726368616E74204E616D65223A22436F7261204D636B6E69676874222C224D65726368616E7420646F6D61696E223A22636F72612D6D636B6E696768742E7468656570726F6A656374732E74657374227D',NULL,'2025-06-24 23:57:22','2025-06-24 23:57:22',NULL),
	(6,'TRX685B3C190AD0B','App\\Models\\User',1,7000.00,'wallet','credit','pending',X'7B2255736572204E616D65223A224269616E63612042726F636B222C225573657220456D61696C223A2277797061406D61696C696E61746F722E636F6D222C22726564697265637455726C223A2268747470733A5C2F5C2F636F72612D6D636B6E696768742E7468656570726F6A656374732E746573745C2F757365725C2F64617368626F617264227D',NULL,'2025-06-25 00:00:25','2025-06-25 00:00:25',NULL),
	(7,'TRX685B3CB0934E9','App\\Models\\Merchant',1,7000.00,'wallet','credit','pending',X'7B224D65726368616E74204E616D65223A22436F7261204D636B6E69676874222C224D65726368616E7420646F6D61696E223A22636F72612D6D636B6E696768742E7468656570726F6A656374732E74657374227D',NULL,'2025-06-25 00:02:56','2025-06-25 00:02:56',NULL),
	(8,'TRX685B3D6257D71','App\\Models\\Merchant',1,25000.00,'wallet','credit','pending',X'7B224D65726368616E74204E616D65223A22436F7261204D636B6E69676874222C224D65726368616E7420646F6D61696E223A22636F72612D6D636B6E696768742E7468656570726F6A656374732E74657374227D',NULL,'2025-06-25 00:05:54','2025-06-25 00:05:54',NULL),
	(9,'TRX685B3D63C5E0A','App\\Models\\Merchant',1,25000.00,'wallet','credit','pending',X'7B224D65726368616E74204E616D65223A22436F7261204D636B6E69676874222C224D65726368616E7420646F6D61696E223A22636F72612D6D636B6E696768742E7468656570726F6A656374732E74657374227D',NULL,'2025-06-25 00:05:55','2025-06-25 00:05:55',NULL),
	(10,'TRX685B3D692FE5B','App\\Models\\User',1,7000.00,'wallet','credit','pending',X'7B2255736572204E616D65223A224269616E63612042726F636B222C225573657220456D61696C223A2277797061406D61696C696E61746F722E636F6D222C22726564697265637455726C223A2268747470733A5C2F5C2F636F72612D6D636B6E696768742E7468656570726F6A656374732E746573745C2F757365725C2F64617368626F617264227D',NULL,'2025-06-25 00:06:01','2025-06-25 00:06:01',NULL),
	(11,'TRX685B3E9830D08','App\\Models\\Merchant',1,20000.00,'wallet','credit','pending',X'7B224D65726368616E74204E616D65223A22436F7261204D636B6E69676874222C224D65726368616E7420646F6D61696E223A22636F72612D6D636B6E696768742E7468656570726F6A656374732E74657374227D',NULL,'2025-06-25 00:11:04','2025-06-25 00:11:04',NULL),
	(12,'TRX685B3EB0CA82E','App\\Models\\User',1,9000.00,'wallet','credit','pending',X'7B2255736572204E616D65223A224269616E63612042726F636B222C225573657220456D61696C223A2277797061406D61696C696E61746F722E636F6D222C22726564697265637455726C223A2268747470733A5C2F5C2F636F72612D6D636B6E696768742E7468656570726F6A656374732E746573745C2F757365725C2F64617368626F617264227D',NULL,'2025-06-25 00:11:28','2025-06-25 00:11:28',NULL),
	(14,'TRX685C9FA2066D3','App\\Models\\User',2,7000.00,'wallet','credit','success',X'7B2255736572204E616D65223A22466F7272657374204A6F7264616E222C225573657220456D61696C223A226C617761406D61696C696E61746F722E636F6D222C22726564697265637455726C223A2268747470733A5C2F5C2F636F72612D6D636B6E696768742E7468656570726F6A656374732E746573745C2F757365725C2F64617368626F617264227D',NULL,'2025-06-26 01:17:22','2025-06-26 01:17:38',NULL),
	(15,'TRX686ACFCCCC831','App\\Models\\Merchant',1,1500.00,'wallet','credit','pending',X'7B224D65726368616E74204E616D65223A22436F7261204D636B6E69676874222C224D65726368616E7420646F6D61696E223A22636F72612D6D636B6E696768742E7468656570726F6A656374732E74657374227D',NULL,'2025-07-06 19:34:36','2025-07-06 19:34:36',NULL),
	(16,'TRX686BB8E7EB776','App\\Models\\User',9,7000.00,'wallet','credit','pending',X'7B2255736572204E616D65223A22527574682046696E6368222C225573657220456D61696C223A226D69636966616E757069406D61696C696E61746F722E636F6D222C22726564697265637455726C223A2268747470733A5C2F5C2F6A757374696E2D6775657272612E7468656570726F6A656374732E746573745C2F757365725C2F64617368626F617264227D',NULL,'2025-07-07 12:09:11','2025-07-07 12:09:11',NULL);

/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tv_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tv_transactions`;

CREATE TABLE `tv_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `api_response` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `prev_bal` varchar(255) NOT NULL,
  `current_bal` varchar(255) NOT NULL,
  `percent_profit` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tv_transactions_user_id_foreign` (`user_id`),
  KEY `tv_transactions_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `tv_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tv_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `referrer_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `account_balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `address` varchar(255) NOT NULL,
  `refferal_user` varchar(255) DEFAULT NULL,
  `refferal` varchar(255) NOT NULL DEFAULT '',
  `refferal_bonus` decimal(10,2) NOT NULL DEFAULT 0.00,
  `role` int(11) NOT NULL,
  `smart_earners` varchar(255) NOT NULL,
  `topuser_earners` varchar(255) NOT NULL,
  `api_earners` varchar(255) NOT NULL,
  `cal` int(11) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `referrer_id`, `name`, `username`, `password`, `tel`, `email`, `account_balance`, `address`, `refferal_user`, `refferal`, `refferal_bonus`, `role`, `smart_earners`, `topuser_earners`, `api_earners`, `cal`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'UID989F26131','Cora Mcknight','hahote','$2y$12$p16YpDxeC9hsHQ5Hug9hdOHAFTkMBKGB1HWD2ndB5QtUhxQU2kvxC','4237884336','wypa@mailinator.com',8907.00,'No 6 Ronald Ave\r\nAve St','Beatae at ut aute en','0',0.00,2,'1','0','0',1,NULL,'skSWTTkgoWNwLOschfED0Vhe1Y9rcVhAT5LNqobz8vR90rlIaRDHNDCf9u9r','2025-06-24 20:48:41','2025-06-29 03:53:02'),
	(2,'UID05A565562','Forrest Jordan','xodyjilovu','$2y$12$dhU01bDfLTuOSmi4p1RxAewzHcFar1GBF88F/e5R2qwVEi02/Wq.G','Perferendis officia','lawa@mailinator.com',0.00,'Dicta eveniet aut v','Pariatur Rerum corr','0',0.00,2,'1','0','0',1,NULL,NULL,'2025-06-24 20:50:22','2025-06-24 20:50:22'),
	(3,'UID76693F523','Ross Owen','livovulyti','$2y$12$6PmRvQcYs14jteCPpPIT2.UYa6btfUG8phLpNrdC5j4Dn025Hu9L.','Alias cupidatat dolo','lixikod@mailinator.com',0.00,'Repudiandae perferen','In modi non reprehen','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:28:39','2025-06-30 01:28:39'),
	(4,'UID8B679F914','Nayda Avery','nuwihyvyce','$2y$12$m5oWhOcd6WMWkYRmBy17v.bFZ8G5F/ifZZ7xZN8xxjbjW2PUCwnnK','Provident debitis e','lebyva@mailinator.com',0.00,'Aut culpa quia exerc','Dolore impedit odio','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:34:15','2025-06-30 01:34:15'),
	(5,'UIDDF2F03835','Wynter Peters','zebiby','$2y$12$oRfFT26OljDRT0WABgAX0uY0ih8u0fhCctOZZmwdjnRqNm4vN6u/y','Exercitationem optio','zonidyd@mailinator.com',0.00,'Qui inventore non qu','Vel sint amet nobis','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:36:19','2025-06-30 01:36:19'),
	(6,'UIDD77BD7036','Thor Shields','gobodibef','$2y$12$R5Y2GLXN7vCO9V7bUsOe/.adG6cVPrEyHojq8WMMBEARMh4RP1Jn2','Autem labore ut aute','koqiq@mailinator.com',0.00,'Nulla amet laborum','Distinctio Recusand','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:37:55','2025-06-30 01:37:55'),
	(7,'UID5496AC2D7','Jana Chaney','gosypep','$2y$12$4QoXN9liEyXkNvSl0fTuueY2j4dLmbv7jBiCCrUljPUQl1GGGWB1S','Vitae eius ut ex mol','qyrun@mailinator.com',0.00,'Itaque adipisci pari','Sequi minim sapiente','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:39:05','2025-06-30 01:39:05'),
	(8,'UIDC78EE9458','Geraldine Carver','synyhu','$2y$12$N7jWq.4WvtXRvYv1GqV/GuFB1Yo1ALMCM.vGGBtmhEyKRyZo0Xqni','Quasi neque anim mag','jolitutu@mailinator.com',0.00,'Iusto doloremque mag','Libero doloremque no','0',0.00,2,'0','0','0',1,'2025-06-30 02:09:10',NULL,'2025-06-30 01:58:58','2025-06-30 02:09:10'),
	(9,'UID0576013C9','Ruth Finch','miwezux','$2y$12$gLNrvgcFNdOl.vAeCk9KCOccI9FP7i8cMikXR9kkvOdorxDBR5W5y','Ipsam facere laborum','micifanupi@mailinator.com',0.00,'Sint do pariatur Au','Cum in itaque ipsum','0',0.00,2,'0','0','0',1,'2025-07-07 12:08:31',NULL,'2025-07-07 12:08:27','2025-07-07 12:08:31');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wallet_transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallet_transactions`;

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_owner_type` varchar(255) NOT NULL,
  `wallet_owner_id` bigint(20) unsigned NOT NULL,
  `wallet_id` bigint(20) unsigned NOT NULL,
  `transaction_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `description` varchar(255) DEFAULT NULL,
  `meta_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_data`)),
  `prev_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_transactions_wallet_owner_type_wallet_owner_id_index` (`wallet_owner_type`,`wallet_owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;

INSERT INTO `wallet_transactions` (`id`, `wallet_owner_type`, `wallet_owner_id`, `wallet_id`, `transaction_id`, `amount`, `type`, `status`, `description`, `meta_data`, `prev_balance`, `current_balance`, `created_at`, `updated_at`, `provider`)
VALUES
	(9,'App\\Models\\Merchant',1,1,11,20000.00,'credit','pending',NULL,NULL,0.00,0.00,'2025-06-25 00:11:04','2025-06-25 00:11:04',NULL),
	(10,'App\\Models\\User',1,1,12,9000.00,'credit','pending',NULL,NULL,0.00,0.00,'2025-06-25 00:11:28','2025-06-25 00:11:28',NULL),
	(11,'App\\Models\\User',2,5,14,7000.00,'credit','success',NULL,NULL,0.00,0.00,'2025-06-26 01:17:22','2025-06-26 01:17:38',NULL),
	(12,'App\\Models\\Merchant',1,1,15,1500.00,'credit','pending',NULL,NULL,0.00,0.00,'2025-07-06 19:34:36','2025-07-06 19:34:36',NULL),
	(13,'App\\Models\\User',9,14,16,7000.00,'credit','pending',NULL,NULL,0.00,0.00,'2025-07-07 12:09:11','2025-07-07 12:09:11',NULL);

/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wallets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wallets`;

CREATE TABLE `wallets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_type` varchar(255) NOT NULL,
  `owner_id` bigint(20) unsigned NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'NGN',
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallets_owner_type_owner_id_index` (`owner_type`,`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;

INSERT INTO `wallets` (`id`, `owner_type`, `owner_id`, `currency`, `balance`, `created_at`, `updated_at`)
VALUES
	(1,'App\\Models\\User',1,'NGN',9000.00,'2025-06-24 20:48:18','2025-06-25 00:12:07'),
	(2,'App\\Models\\Merchant',1,'NGN',20000.00,'2025-06-24 20:48:18','2025-06-25 00:11:26'),
	(5,'App\\Models\\User',2,'NGN',16000.00,'2025-06-24 20:48:18','2025-06-26 01:17:38'),
	(6,'App\\Models\\User',2,'NGN',0.00,'2025-06-30 00:25:48','2025-06-30 00:25:48'),
	(7,'App\\Models\\Merchant',2,'NGN',0.00,'2025-06-30 00:25:48','2025-06-30 00:25:48'),
	(8,'App\\Models\\Merchant',3,'NGN',0.00,'2025-06-30 00:26:41','2025-06-30 00:26:41'),
	(9,'App\\Models\\Merchant',4,'NGN',0.00,'2025-06-30 00:27:22','2025-06-30 00:27:22'),
	(10,'App\\Models\\Merchant',5,'NGN',0.00,'2025-06-30 00:28:10','2025-06-30 00:28:10'),
	(11,'App\\Models\\Merchant',6,'NGN',0.00,'2025-06-30 00:37:07','2025-06-30 00:37:07'),
	(12,'App\\Models\\Merchant',7,'NGN',0.00,'2025-06-30 00:39:20','2025-06-30 00:39:20'),
	(13,'App\\Models\\Merchant',8,'NGN',0.00,'2025-06-30 00:48:36','2025-06-30 00:48:36'),
	(14,'App\\Models\\Merchant',9,'NGN',0.00,'2025-06-30 00:52:29','2025-06-30 00:52:29'),
	(15,'App\\Models\\Merchant',10,'NGN',0.00,'2025-06-30 00:55:25','2025-06-30 00:55:25'),
	(16,'App\\Models\\Merchant',11,'NGN',0.00,'2025-06-30 00:55:48','2025-06-30 00:55:48'),
	(17,'App\\Models\\User',3,'NGN',0.00,'2025-06-30 01:28:39','2025-06-30 01:28:39'),
	(18,'App\\Models\\User',4,'NGN',0.00,'2025-06-30 01:34:15','2025-06-30 01:34:15'),
	(19,'App\\Models\\User',5,'NGN',0.00,'2025-06-30 01:36:19','2025-06-30 01:36:19'),
	(20,'App\\Models\\User',6,'NGN',0.00,'2025-06-30 01:37:55','2025-06-30 01:37:55'),
	(21,'App\\Models\\User',7,'NGN',0.00,'2025-06-30 01:39:05','2025-06-30 01:39:05'),
	(22,'App\\Models\\User',8,'NGN',0.00,'2025-06-30 01:58:58','2025-06-30 01:58:58'),
	(23,'App\\Models\\Merchant',12,'NGN',0.00,'2025-06-30 02:21:20','2025-06-30 02:21:20'),
	(24,'App\\Models\\User',13,'NGN',0.00,'2025-07-07 12:05:57','2025-07-07 12:05:57'),
	(25,'App\\Models\\Merchant',13,'NGN',0.00,'2025-07-07 12:05:57','2025-07-07 12:05:57'),
	(26,'App\\Models\\User',9,'NGN',0.00,'2025-07-07 12:08:27','2025-07-07 12:08:27');

/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
