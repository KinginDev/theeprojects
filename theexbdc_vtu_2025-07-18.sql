# ************************************************************
# Sequel Ace SQL dump
# Version 20025
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: host.docker.internal (MySQL 5.5.5-10.6.21-MariaDB-ubu2004)
# Database: theexbdc_vtu
# Generation Time: 2025-07-17 23:32:56 +0000
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

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;

INSERT INTO `cache` (`key`, `value`, `expiration`)
VALUES
	('1574bddb75c78a6fd2251d61e2993b5146201319','i:1;',1751994839),
	('1574bddb75c78a6fd2251d61e2993b5146201319:timer','i:1751994839;',1751994839);

/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;


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



# Dump of table merchant_menu_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchant_menu_items`;

CREATE TABLE `merchant_menu_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `page_id` bigint(20) unsigned DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `target` varchar(255) NOT NULL DEFAULT '_self',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchant_menu_items_menu_id_foreign` (`menu_id`),
  KEY `merchant_menu_items_parent_id_foreign` (`parent_id`),
  KEY `merchant_menu_items_page_id_foreign` (`page_id`),
  CONSTRAINT `merchant_menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `merchant_menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `merchant_menu_items_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `merchant_pages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `merchant_menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `merchant_menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchant_menu_items` WRITE;
/*!40000 ALTER TABLE `merchant_menu_items` DISABLE KEYS */;

INSERT INTO `merchant_menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `page_id`, `order`, `target`, `is_active`, `created_at`, `updated_at`)
VALUES
	(3,1,NULL,'Home',NULL,5,2,'_self',1,'2025-07-08 03:16:18','2025-07-08 03:16:18'),
	(4,1,NULL,'About',NULL,6,3,'_self',1,'2025-07-08 03:24:18','2025-07-08 03:24:18'),
	(5,1,NULL,'Contact',NULL,7,4,'_self',1,'2025-07-08 03:24:36','2025-07-08 03:24:36'),
	(7,1,NULL,'Dashboard','https://unisubz.theeprojects.test/user/dashboard',NULL,5,'_self',1,'2025-07-17 03:00:56','2025-07-17 03:00:56');

/*!40000 ALTER TABLE `merchant_menu_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table merchant_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchant_menus`;

CREATE TABLE `merchant_menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL DEFAULT 'header',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchant_menus_merchant_id_name_unique` (`merchant_id`,`name`),
  CONSTRAINT `merchant_menus_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchant_menus` WRITE;
/*!40000 ALTER TABLE `merchant_menus` DISABLE KEYS */;

INSERT INTO `merchant_menus` (`id`, `merchant_id`, `name`, `location`, `is_active`, `created_at`, `updated_at`)
VALUES
	(1,1,'FirstMenu','header',1,'2025-07-08 02:32:37','2025-07-08 02:39:21'),
	(2,1,'Super Admin','footer',1,'2025-07-08 14:45:44','2025-07-08 14:45:44');

/*!40000 ALTER TABLE `merchant_menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table merchant_pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchant_pages`;

CREATE TABLE `merchant_pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `meta_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_data`)),
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `template` varchar(255) NOT NULL DEFAULT 'default',
  `is_home` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indicates if this page is the home page',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchant_pages_merchant_id_slug_unique` (`merchant_id`,`slug`),
  KEY `merchant_pages_slug_index` (`slug`),
  CONSTRAINT `merchant_pages_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchant_pages` WRITE;
/*!40000 ALTER TABLE `merchant_pages` DISABLE KEYS */;

INSERT INTO `merchant_pages` (`id`, `merchant_id`, `title`, `slug`, `content`, `meta_data`, `is_published`, `template`, `is_home`, `created_at`, `updated_at`)
VALUES
	(5,1,'Enim aliqua Quam se','Eos deserunt maxime','<header class=\"header navbar navbar-expand-lg position-absolute navbar-sticky navbar-dark\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-navbar-padding-x: 0; --si-navbar-padding-y: 0.5rem; --si-navbar-color: rgba(255, 255, 255); --si-navbar-hover-color: #0A24F4; --si-navbar-disabled-color: rgba(255, 255, 255, 0.4); --si-navbar-active-color: #0A24F4; --si-navbar-brand-padding-y: 0.5rem; --si-navbar-brand-margin-end: 1rem; --si-navbar-brand-font-size: 1.375rem; --si-navbar-brand-color: #fff; --si-navbar-brand-hover-color: #fff; --si-navbar-nav-link-padding-x: 0.875rem; --si-navbar-toggler-padding-y: 0.625rem; --si-navbar-toggler-padding-x: 0.25rem; --si-navbar-toggler-font-size: 1.125rem; --si-navbar-toggler-icon-bg: initial; --si-navbar-toggler-border-color: transparent; --si-navbar-toggler-border-radius: 0; --si-navbar-toggler-focus-width: 0; --si-navbar-toggler-transition: box-shadow 0.15s ease-in-out; padding: 8px 0px; --si-navbar-stuck-bg: #0b0f19; --si-navbar-toggler-color: rgba(255, 255, 255, 0.85); top: 0px; left: 0px; width: 2033px; z-index: 1030;\"><div class=\"container px-3\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 0; width: 1536px; padding-right: 0.75rem; padding-left: 0.75rem; max-width: 1536px;\"><span style=\"color: rgb(255, 255, 255); font-family: Inter, sans-serif; font-size: 5rem; font-weight: 900; background-color: rgb(11, 15, 25);\"><br></span></div></header><section class=\"container mt-2 pt-3 pt-lg-5 pb-5\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 0; width: 1536px; padding: 0.75rem 12px 1.25rem; max-width: 1536px;\"><div class=\"row align-items-lg-center pt-md-3 pb-5 mb-2 mb-lg-4 mb-xl-5\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 0; margin: 0px -12px 0.5rem; padding-bottom: 1.25rem;\"><div class=\"col-md-7 order-md-1\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 896px; padding-right: 12px; padding-left: 12px; margin-top: 0px;\"><div class=\"pe-xl-5 me-md-2 me-lg-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><p class=\"fs-3 text-start text-md-start pb-2 pb-md-3 mb-3 text-dark\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 0.75rem; margin-left: 0px; -webkit-font-smoothing: antialiased; padding-bottom: 0.5rem; color: rgb(11, 15, 25) !important;\">Whether you\'re looking for flexible loans, smarter savings options, or sound investment opportunities, Hestia Funding offers innovative and reliable solutions to help you achieve your financial goals.</p><div class=\"d-md-flex align-items-md-start\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"></div></div></div></div></section><section id=\"services\" class=\"py-5\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; padding-top: 1.25rem; padding-bottom: 1.25rem;\"><div class=\"container\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 0; width: 1536px; padding-right: 12px; padding-left: 12px; max-width: 1536px;\"><div class=\"text-center \" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><h2 class=\"section-heading text-center display-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 3rem; margin-left: 0px; font-weight: 700; line-height: 1.3; color: rgb(11, 15, 25); -webkit-font-smoothing: antialiased; position: relative; padding-bottom: 1rem;\">Business Solutions</h2></div><div class=\"row align-items-center\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 0; margin-top: 0px; margin-right: -12px; margin-left: -12px;\"><div class=\"col-lg-6 mb-5 mb-lg-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 768px; padding-right: 12px; padding-left: 12px; margin-top: 0px; margin-bottom: 1.25rem;\"><p class=\"lead mb-5\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 1.25rem; margin-left: 0px; -webkit-font-smoothing: antialiased; font-size: 1.5rem;\">Access the capital your business needs to grow and thrive with our flexible funding options.</p><div class=\"d-flex flex-column gap-4 mb-5\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; margin-bottom: 1.25rem; gap: 1rem;\"><div class=\"d-flex gap-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; gap: 1rem;\"><div class=\"icon-box flex-shrink-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-chart-line text-info\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"chart-line\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M64 400C64 408.8 71.16 416 80 416H480C497.7 416 512 430.3 512 448C512 465.7 497.7 480 480 480H80C35.82 480 0 444.2 0 400V64C0 46.33 14.33 32 32 32C49.67 32 64 46.33 64 64V400zM342.6 278.6C330.1 291.1 309.9 291.1 297.4 278.6L240 221.3L150.6 310.6C138.1 323.1 117.9 323.1 105.4 310.6C92.88 298.1 92.88 277.9 105.4 265.4L217.4 153.4C229.9 140.9 250.1 140.9 262.6 153.4L320 210.7L425.4 105.4C437.9 92.88 458.1 92.88 470.6 105.4C483.1 117.9 483.1 138.1 470.6 150.6L342.6 278.6z\"></path></svg></div><div style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><h4 style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-weight: inherit; line-height: 1.4; color: rgb(11, 15, 25); font-size: inherit; -webkit-font-smoothing: antialiased;\">Business Expansion</h4><p class=\"text-muted mb-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-left: 0px; -webkit-font-smoothing: antialiased; color: rgb(147, 151, 173) !important;\">Fund your growth initiatives and expansion plans</p></div></div><div class=\"d-flex gap-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; gap: 1rem;\"><div class=\"icon-box flex-shrink-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-screwdriver-wrench text-info\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"screwdriver-wrench\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M331.8 224.1c28.29 0 54.88 10.99 74.86 30.97l19.59 19.59c40.01-17.74 71.25-53.3 81.62-96.65c5.725-23.92 5.34-47.08 .2148-68.4c-2.613-10.88-16.43-14.51-24.34-6.604l-68.9 68.9h-75.6V97.2l68.9-68.9c7.912-7.912 4.275-21.73-6.604-24.34c-21.32-5.125-44.48-5.51-68.4 .2148c-55.3 13.23-98.39 60.22-107.2 116.4C224.5 128.9 224.2 137 224.3 145l82.78 82.86C315.2 225.1 323.5 224.1 331.8 224.1zM384 278.6c-23.16-23.16-57.57-27.57-85.39-13.9L191.1 158L191.1 95.99l-127.1-95.99L0 63.1l96 127.1l62.04 .0077l106.7 106.6c-13.67 27.82-9.251 62.23 13.91 85.39l117 117.1c14.62 14.5 38.21 14.5 52.71-.0016l52.75-52.75c14.5-14.5 14.5-38.08-.0016-52.71L384 278.6zM227.9 307L168.7 247.9l-148.9 148.9c-26.37 26.37-26.37 69.08 0 95.45C32.96 505.4 50.21 512 67.5 512s34.54-6.592 47.72-19.78l119.1-119.1C225.5 352.3 222.6 329.4 227.9 307zM64 472c-13.25 0-24-10.75-24-24c0-13.26 10.75-24 24-24S88 434.7 88 448C88 461.3 77.25 472 64 472z\"></path></svg></div><div style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><h4 style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-weight: inherit; line-height: 1.4; color: rgb(11, 15, 25); font-size: inherit; -webkit-font-smoothing: antialiased;\">Equipment Financing</h4><p class=\"text-muted mb-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-left: 0px; -webkit-font-smoothing: antialiased; color: rgb(147, 151, 173) !important;\">Acquire the equipment you need to stay competitive</p></div></div><div class=\"d-flex gap-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; gap: 1rem;\"><div class=\"icon-box flex-shrink-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-dollar-sign text-info\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"dollar-sign\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 320 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M160 0C177.7 0 192 14.33 192 32V67.68C193.6 67.89 195.1 68.12 196.7 68.35C207.3 69.93 238.9 75.02 251.9 78.31C268.1 82.65 279.4 100.1 275 117.2C270.7 134.3 253.3 144.7 236.1 140.4C226.8 137.1 198.5 133.3 187.3 131.7C155.2 126.9 127.7 129.3 108.8 136.5C90.52 143.5 82.93 153.4 80.92 164.5C78.98 175.2 80.45 181.3 82.21 185.1C84.1 189.1 87.79 193.6 95.14 198.5C111.4 209.2 136.2 216.4 168.4 225.1L171.2 225.9C199.6 233.6 234.4 243.1 260.2 260.2C274.3 269.6 287.6 282.3 295.8 299.9C304.1 317.7 305.9 337.7 302.1 358.1C295.1 397 268.1 422.4 236.4 435.6C222.8 441.2 207.8 444.8 192 446.6V480C192 497.7 177.7 512 160 512C142.3 512 128 497.7 128 480V445.1C127.6 445.1 127.1 444.1 126.7 444.9L126.5 444.9C102.2 441.1 62.07 430.6 35 418.6C18.85 411.4 11.58 392.5 18.76 376.3C25.94 360.2 44.85 352.9 60.1 360.1C81.9 369.4 116.3 378.5 136.2 381.6C168.2 386.4 194.5 383.6 212.3 376.4C229.2 369.5 236.9 359.5 239.1 347.5C241 336.8 239.6 330.7 237.8 326.9C235.9 322.9 232.2 318.4 224.9 313.5C208.6 302.8 183.8 295.6 151.6 286.9L148.8 286.1C120.4 278.4 85.58 268.9 59.76 251.8C45.65 242.4 32.43 229.7 24.22 212.1C15.89 194.3 14.08 174.3 17.95 153C25.03 114.1 53.05 89.29 85.96 76.73C98.98 71.76 113.1 68.49 128 66.73V32C128 14.33 142.3 0 160 0V0z\"></path></svg></div><div style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><h4 style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-weight: inherit; line-height: 1.4; color: rgb(11, 15, 25); font-size: inherit; -webkit-font-smoothing: antialiased;\">Working Capital</h4><p class=\"text-muted mb-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-left: 0px; -webkit-font-smoothing: antialiased; color: rgb(147, 151, 173) !important;\">Maintain healthy cash flow for daily operations</p></div></div></div></div><div class=\"col-lg-6\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 768px; padding-right: 12px; padding-left: 12px; margin-top: 0px;\"><img src=\"https://hestiafunding.com/asset/images/business-funding.jpg\" class=\"img-fluid rounded-4 shadow\" alt=\"Business Funding\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1),0 1px 2px 0 rgba(0, 0, 0, 0.06); --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; display: block; box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px; border-radius: 16px !important;\"></div></div><div class=\"row g-4 mt-5\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 1.5rem; margin-top: 1.25rem; margin-right: -12px; margin-left: -12px;\"><div class=\"col-md-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 512px; padding-right: 12px; padding-left: 12px; margin-top: 24px;\"><div class=\"service-card\" style=\"border: 1px solid rgba(0, 0, 0, 0.05); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border-radius: 16px; padding: 2rem; height: 431.984px; transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column;\"><div class=\"service-icon\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 64px; height: 64px; background: rgba(13, 202, 240, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;\"><svg class=\"svg-inline--fa fa-chart-line\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"chart-line\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M64 400C64 408.8 71.16 416 80 416H480C497.7 416 512 430.3 512 448C512 465.7 497.7 480 480 480H80C35.82 480 0 444.2 0 400V64C0 46.33 14.33 32 32 32C49.67 32 64 46.33 64 64V400zM342.6 278.6C330.1 291.1 309.9 291.1 297.4 278.6L240 221.3L150.6 310.6C138.1 323.1 117.9 323.1 105.4 310.6C92.88 298.1 92.88 277.9 105.4 265.4L217.4 153.4C229.9 140.9 250.1 140.9 262.6 153.4L320 210.7L425.4 105.4C437.9 92.88 458.1 92.88 470.6 105.4C483.1 117.9 483.1 138.1 470.6 150.6L342.6 278.6z\"></path></svg></div><div class=\"service-card-content\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; flex-grow: 1; display: flex; flex-direction: column;\"><h3 class=\"h4 mb-3\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 0.75rem; margin-left: 0px; font-weight: 700; line-height: 1.4; color: rgb(11, 15, 25); -webkit-font-smoothing: antialiased;\">Business Loans</h3><p class=\"text-muted mb-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 1rem; margin-left: 0px; -webkit-font-smoothing: antialiased; color: rgb(147, 151, 173) !important;\">Access flexible funding solutions with competitive rates for your business expansion and working capital needs.</p><ul class=\"list-unstyled mb-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; margin-right: 0px; margin-left: 0px; -webkit-font-smoothing: antialiased; flex-grow: 1;\"><li class=\"mb-2\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Quick approval process</li><li class=\"mb-2\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Flexible repayment terms</li><li style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Competitive interest rates</li></ul></div><div class=\"service-card-footer\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; margin-top: auto;\"></div></div></div><div class=\"col-md-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 512px; padding-right: 12px; padding-left: 12px; margin-top: 24px;\"><div class=\"service-card\" style=\"border: 1px solid rgba(0, 0, 0, 0.05); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border-radius: 16px; padding: 2rem; height: 431.984px; transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column;\"><div class=\"service-icon\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 64px; height: 64px; background: rgba(13, 202, 240, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;\"><svg class=\"svg-inline--fa fa-handshake\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"handshake\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 640 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M0 383.9l64 .0404c17.75 0 32-14.29 32-32.03V128.3L0 128.3V383.9zM48 320.1c8.75 0 16 7.118 16 15.99c0 8.742-7.25 15.99-16 15.99S32 344.8 32 336.1C32 327.2 39.25 320.1 48 320.1zM348.8 64c-7.941 0-15.66 2.969-21.52 8.328L228.9 162.3C228.8 162.5 228.8 162.7 228.6 162.7C212 178.3 212.3 203.2 226.5 218.7c12.75 13.1 39.38 17.62 56.13 2.75C282.8 221.3 282.9 221.3 283 221.2l79.88-73.1c6.5-5.871 16.75-5.496 22.62 1c6 6.496 5.5 16.62-1 22.62l-26.12 23.87L504 313.7c2.875 2.496 5.5 4.996 7.875 7.742V127.1c-40.98-40.96-96.48-63.88-154.4-63.88L348.8 64zM334.6 217.4l-30 27.49c-29.75 27.11-75.25 24.49-101.8-4.371C176 211.2 178.1 165.7 207.3 138.9L289.1 64H282.5C224.7 64 169.1 87.08 128.2 127.9L128 351.8l18.25 .0369l90.5 81.82c27.5 22.37 67.75 18.12 90-9.246l18.12 15.24c15.88 12.1 39.38 10.5 52.38-5.371l31.38-38.6l5.374 4.498c13.75 11 33.88 9.002 45-4.748l9.538-11.78c11.12-13.75 9.036-33.78-4.694-44.93L334.6 217.4zM544 128.4v223.6c0 17.62 14.25 32.05 31.1 32.05L640 384V128.1L544 128.4zM592 352c-8.75 0-16-7.246-16-15.99c0-8.875 7.25-15.99 16-15.99S608 327.2 608 336.1C608 344.8 600.8 352 592 352z\"></path></svg></div><div class=\"service-card-content\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; flex-grow: 1; display: flex; flex-direction: column;\"><h3 class=\"h4 mb-3\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 0.75rem; margin-left: 0px; font-weight: 700; line-height: 1.4; color: rgb(11, 15, 25); -webkit-font-smoothing: antialiased;\">Equity Financing</h3><p class=\"text-muted mb-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 1rem; margin-left: 0px; -webkit-font-smoothing: antialiased; color: rgb(147, 151, 173) !important;\">Partner with investors who share your vision and can provide strategic capital for growth.</p><ul class=\"list-unstyled mb-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; margin-right: 0px; margin-left: 0px; -webkit-font-smoothing: antialiased; flex-grow: 1;\"><li class=\"mb-2\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Strategic partnerships</li><li class=\"mb-2\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Growth capital</li><li style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Expert guidance</li></ul></div><div class=\"service-card-footer\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; margin-top: auto;\"></div></div></div><div class=\"col-md-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 512px; padding-right: 12px; padding-left: 12px; margin-top: 24px;\"><div class=\"service-card\" style=\"border: 1px solid rgba(0, 0, 0, 0.05); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border-radius: 16px; padding: 2rem; height: 431.984px; transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column;\"><div class=\"service-icon\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 64px; height: 64px; background: rgba(13, 202, 240, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;\"><svg class=\"svg-inline--fa fa-gift\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"gift\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M152 0H154.2C186.1 0 215.7 16.91 231.9 44.45L256 85.46L280.1 44.45C296.3 16.91 325.9 0 357.8 0H360C408.6 0 448 39.4 448 88C448 102.4 444.5 115.1 438.4 128H480C497.7 128 512 142.3 512 160V224C512 241.7 497.7 256 480 256H32C14.33 256 0 241.7 0 224V160C0 142.3 14.33 128 32 128H73.6C67.46 115.1 64 102.4 64 88C64 39.4 103.4 0 152 0zM190.5 68.78C182.9 55.91 169.1 48 154.2 48H152C129.9 48 112 65.91 112 88C112 110.1 129.9 128 152 128H225.3L190.5 68.78zM360 48H357.8C342.9 48 329.1 55.91 321.5 68.78L286.7 128H360C382.1 128 400 110.1 400 88C400 65.91 382.1 48 360 48V48zM32 288H224V512H80C53.49 512 32 490.5 32 464V288zM288 512V288H480V464C480 490.5 458.5 512 432 512H288z\"></path></svg></div><div class=\"service-card-content\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; flex-grow: 1; display: flex; flex-direction: column;\"><h3 class=\"h4 mb-3\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 0.75rem; margin-left: 0px; font-weight: 700; line-height: 1.4; color: rgb(11, 15, 25); -webkit-font-smoothing: antialiased;\">Grants</h3><p class=\"text-muted mb-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 1rem; margin-left: 0px; -webkit-font-smoothing: antialiased; color: rgb(147, 151, 173) !important;\">Discover non-dilutive funding opportunities through our curated grant programs.</p><ul class=\"list-unstyled mb-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; margin-right: 0px; margin-left: 0px; -webkit-font-smoothing: antialiased; flex-grow: 1;\"><li class=\"mb-2\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Non-repayable funding</li><li class=\"mb-2\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Industry-specific grants</li><li style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased;\"><svg class=\"svg-inline--fa fa-check text-info me-2\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z\"></path></svg>Application assistance</li></ul></div><div class=\"service-card-footer\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; margin-top: auto;\"></div></div></div></div></div></section><section class=\"py-5 bg-light\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; padding-top: 1.25rem; padding-bottom: 1.25rem; --si-bg-opacity: 1; background-color: rgb(255, 255, 255) !important;\"><div class=\"container\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 0; width: 1536px; padding-right: 12px; padding-left: 12px; max-width: 1536px;\"><div class=\"text-center \" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; color: rgb(86, 89, 115); font-family: Graphik, sans-serif;\"><h2 class=\"section-heading text-center display-4\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; margin-right: 0px; margin-bottom: 3rem; margin-left: 0px; font-weight: 700; line-height: 1.3; color: rgb(11, 15, 25); -webkit-font-smoothing: antialiased; position: relative; padding-bottom: 1rem;\">Personal Solutions</h2><div><br></div></div><div class=\"row align-items-center flex-lg-row-reverse\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; --si-gutter-x: 1.5rem; --si-gutter-y: 0; margin-top: 0px; margin-right: -12px; margin-left: -12px; color: rgb(86, 89, 115); font-family: Graphik, sans-serif;\"><div class=\"col-lg-6 mb-5 mb-lg-0\" style=\"border-width: 0px; border-style: solid; border-color: rgb(229, 231, 235); --tw-border-opacity: 1; --tw-shadow: 0 0 #0000; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59, 130, 246, 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; -webkit-font-smoothing: antialiased; width: 768px; padding-right: 12px; padding-left: 12px; margin-top: 0px; margin-bottom: 1.25rem;\"></div></div></div></section>',X'7B226465736372697074696F6E223A22457374207365642073656420766F6C7570746174222C226B6579776F726473223A2253697420616C697175696420636F6D6D6F646F227D',1,'default',0,'2025-07-08 03:15:45','2025-07-17 03:40:11'),
	(6,1,'Aute nulla nihil per','Cupidatat impedit e',NULL,X'7B226465736372697074696F6E223A22496E6369646964756E7420617574206469676E69222C226B6579776F726473223A22506172696174757220437570696461746174227D',1,'default',0,'2025-07-08 03:23:42','2025-07-08 03:23:42'),
	(7,1,'Sunt consectetur a','Ut possimus dolores',NULL,X'7B226465736372697074696F6E223A22416D65742073756E74207175696120666163222C226B6579776F726473223A224D696E696D612063756D7175652064656C656E69227D',1,'sidebar',0,'2025-07-08 03:23:55','2025-07-08 03:23:55');

/*!40000 ALTER TABLE `merchant_pages` ENABLE KEYS */;
UNLOCK TABLES;


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
	(13,13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-07 12:05:57','2025-07-07 12:05:57'),
	(14,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-07 23:45:37','2025-07-07 23:45:37'),
	(22,22,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-08 18:15:59','2025-07-08 18:15:59');

/*!40000 ALTER TABLE `merchant_preferences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table merchant_role_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchant_role_user`;

CREATE TABLE `merchant_role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchant_role_user_merchant_id_role_id_unique` (`merchant_id`,`role_id`),
  KEY `merchant_role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `merchant_role_user_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `merchant_role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `merchant_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchant_role_user` WRITE;
/*!40000 ALTER TABLE `merchant_role_user` DISABLE KEYS */;

INSERT INTO `merchant_role_user` (`id`, `merchant_id`, `role_id`, `created_at`, `updated_at`)
VALUES
	(3,1,1,NULL,NULL),
	(12,22,1,NULL,NULL);

/*!40000 ALTER TABLE `merchant_role_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table merchant_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchant_roles`;

CREATE TABLE `merchant_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`permissions`)),
  `merchant_id` bigint(20) unsigned NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchant_roles_merchant_id_foreign` (`merchant_id`),
  CONSTRAINT `merchant_roles_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchant_roles` WRITE;
/*!40000 ALTER TABLE `merchant_roles` DISABLE KEYS */;

INSERT INTO `merchant_roles` (`id`, `name`, `slug`, `description`, `permissions`, `merchant_id`, `is_default`, `created_at`, `updated_at`)
VALUES
	(1,'Jasmine Rivera','admin','Aut beatae minus sit',X'5B224D616E61676520526F6C6573222C2256696577205472616E73616374696F6E73222C2256696577205265706F727473222C224D616E6167652053657474696E6773225D',1,1,NULL,'2025-07-08 16:31:46'),
	(2,'Josiah Petty','josiah-petty','Qui sed quis consequ',X'5B2256696577205472616E73616374696F6E73222C2246756E642055736572204163636F756E7473222C224D616E6167652053657474696E6773222C224D616E616765205365727669636573225D',1,1,'2025-07-08 16:35:15','2025-07-08 16:35:15');

/*!40000 ALTER TABLE `merchant_roles` ENABLE KEYS */;
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
	(5,13,9,'user','2025-07-07 12:08:27','2025-07-07 12:08:27'),
	(6,14,10,'user','2025-07-07 23:46:08','2025-07-07 23:46:08');

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
  `theme` varchar(255) NOT NULL DEFAULT 'default' COMMENT 'The theme used by the merchant for their storefront',
  `password` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_merchant_id` bigint(20) unsigned DEFAULT NULL,
  `token` varchar(60) DEFAULT NULL,
  `onboarded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchants_slug_unique` (`slug`),
  UNIQUE KEY `merchants_email_unique` (`email`),
  KEY `merchants_parent_merchant_id_foreign` (`parent_merchant_id`),
  CONSTRAINT `merchants_parent_merchant_id_foreign` FOREIGN KEY (`parent_merchant_id`) REFERENCES `merchants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `merchants` WRITE;
/*!40000 ALTER TABLE `merchants` DISABLE KEYS */;

INSERT INTO `merchants` (`id`, `name`, `slug`, `email`, `phone`, `address`, `status`, `domain`, `theme`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `parent_merchant_id`, `token`, `onboarded_at`)
VALUES
	(1,'UniSubz','unisubz','qonacovepi@mailinator.com',NULL,NULL,1,'unisubz.theeprojects.test','default','$2y$12$Yi8nXhROrGX.TjXtWFOU.uQrncS0sV1Orzco6u5SRg1EdMo3lH3Sa','2025-06-30 02:12:00',NULL,'2025-06-24 20:48:18','2025-07-08 15:06:43',NULL,NULL,NULL),
	(2,'Joel Hobbs','joel-hobbs','xica@mailinator.com',NULL,NULL,1,'joel-hobbs.theeprojects.test','default','$2y$12$72s7xddvwJq5yO/GpcG5RuWksREc2ZiGYJcoB/hyVLsXOR2n/iSDy',NULL,'89u6BQHtrgWvP78kAbf50rqf4bFXKTszfxkyiPBlveE8q7hQxkfVbJl9Xc6f','2025-06-30 00:25:48','2025-06-30 00:25:48',NULL,NULL,NULL),
	(3,'Ivan Ray','ivan-ray','loliq@mailinator.com',NULL,NULL,1,'ivan-ray.theeprojects.test','default','$2y$12$a/8rQx7/GHKtCERACWHKiuWtM797gnlWOqbpUp/iddjBvM7nAuGPW',NULL,'VAGtZOTdL6QpC2HxsOrJxAw73xPNaXxpQJMvnYFjl9ji1CWNdTI25dGPc6C9','2025-06-30 00:26:41','2025-06-30 00:26:41',NULL,NULL,NULL),
	(4,'Ann Rodgers','ann-rodgers','cyxalaguni@mailinator.com',NULL,NULL,1,'ann-rodgers.theeprojects.test','default','$2y$12$5/oSa6NquuouVeQ3l7FGpeGH/dmP2UywmyNO5YitGnqYQqGFPrtWO',NULL,NULL,'2025-06-30 00:27:22','2025-06-30 00:27:22',NULL,NULL,NULL),
	(5,'Jayme Barron','jayme-barron','kehupuvaj@mailinator.com',NULL,NULL,1,'jayme-barron.theeprojects.test','default','$2y$12$Na5N4NJUFclLDtDQkjvYlOtwMA5HJEioe2pPgPqx3MJ8g3hLpV9mu',NULL,'Gfb628ZbofAQlHxndXRWUkiASlIR6SghEH7mfH0RsE6yjQh1gGYhI0TcIoMB','2025-06-30 00:28:10','2025-06-30 00:28:10',NULL,NULL,NULL),
	(6,'Claire Mcknight','claire-mcknight','ranak@mailinator.com',NULL,NULL,1,'claire-mcknight.theeprojects.test','default','$2y$12$QDGOBKGnfjulgtdw6z.kvOUScytNV8Mw72DJN6QUig3RJGrKgSB/6',NULL,'wwMOpCWtmnUb46NEfYLt39jZQt0aXzf4eDAc5f6HznN2PHHr5qKAMoeDlWyP','2025-06-30 00:37:07','2025-06-30 00:37:07',NULL,NULL,NULL),
	(7,'Kasper Underwood','kasper-underwood','hebu@mailinator.com',NULL,NULL,1,'kasper-underwood.theeprojects.test','default','$2y$12$IiB5C8ifwBVR8F4qjCbLpeUrkhDPTCc/c5EQQzrtxwefzYBr77L1a',NULL,'awVFvHnhMhVmxxz3zuPC49qGrEMzZWHpVcT7AjaAVNkI00eECQraXXIlPpXM','2025-06-30 00:39:20','2025-06-30 00:39:20',NULL,NULL,NULL),
	(8,'Theodore Slater','theodore-slater','zuqipas@mailinator.com',NULL,NULL,1,'theodore-slater.theeprojects.test','default','$2y$12$dQdm6SiQdSQqBaxWFq8/rOPRGGeYvv6iKcmeDvpINoVAVDSD0HbX2',NULL,NULL,'2025-06-30 00:48:36','2025-06-30 00:48:36',NULL,NULL,NULL),
	(9,'Cade Todd','cade-todd','limag@mailinator.com',NULL,NULL,1,'cade-todd.theeprojects.test','default','$2y$12$S4Z9cmVJ9O/pVHcc/WUd/OtmuJ16hLDxoSamUielNWsgAghI/aAIG',NULL,NULL,'2025-06-30 00:52:29','2025-06-30 00:52:29',NULL,NULL,NULL),
	(10,'Rudyard Hayden','rudyard-hayden','lemuvyle@mailinator.com',NULL,NULL,1,'rudyard-hayden.theeprojects.test','default','$2y$12$VRQvwSWsY2RvIuOffPTFKOra/6AtZCd/BmLx97LjP0FBFO.ofKYT2',NULL,NULL,'2025-06-30 00:55:25','2025-06-30 00:55:25',NULL,NULL,NULL),
	(11,'Magee Copeland','magee-copeland','towyki@mailinator.com',NULL,NULL,1,'magee-copeland.theeprojects.test','default','$2y$12$HYq9UZoubbf1qF0GcoD5jumk9Ja7veEUNYl7TzC.tzctoDwbLXGwa',NULL,NULL,'2025-06-30 00:55:48','2025-06-30 00:55:48',NULL,NULL,NULL),
	(12,'Xanthus Garza','xanthus-garza','lulenihix@mailinator.com',NULL,NULL,1,'xanthus-garza.theeprojects.test','default','$2y$12$u2ZamQy9Zy2mkmcQ.u9sFu9MFlREMykybXKM.gBW//kI0NPM.xHQ2','2025-06-30 02:24:47',NULL,'2025-06-30 02:21:20','2025-06-30 02:24:47',NULL,NULL,NULL),
	(13,'Justin Guerra','justin-guerra','loroku@mailinator.com',NULL,NULL,1,'justin-guerra.theeprojects.test','default','$2y$12$2wr3th1o8/2.xd36.gWy7ONbMOutWToKvnqN8Nc/09OJpY2yH8Czy','2025-07-07 12:06:04',NULL,'2025-07-07 12:05:57','2025-07-07 12:06:04',NULL,NULL,NULL),
	(14,'Charlotte Sykes','charlotte-sykes','hizoteji@mailinator.com',NULL,NULL,1,'charlotte-sykes.theeprojects.test','default','$2y$12$COO3XzOjQ7wgF7FHkkpI4OkRAnh1ZH6aV3kYdUOvVvCOHur/l7bom','2025-07-07 23:45:44',NULL,'2025-07-07 23:45:37','2025-07-07 23:45:44',NULL,NULL,NULL),
	(22,'Rae Barker','rae-barker','rymux@mailinator.com','+1 (844) 655-2786',NULL,1,'unisubz.theeprojects.test','default',NULL,NULL,NULL,'2025-07-08 18:15:59','2025-07-08 18:15:59',1,'YxifgNlOhIk4g5SZNwc0BtvAo6qUX5s0HMxZvCJXojJKeehHzue3yq7dPvD8',NULL);

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
	(34,'2025_06_25_030423_add_kind_to_transactions_table',3),
	(35,'2025_07_08_012614_create_merchant_menus_table',4),
	(36,'2025_07_08_012614_create_merchant_pages_table',4),
	(37,'2025_07_08_012615_create_merchant_menu_items_table',4),
	(48,'2025_07_08_021708_add_theme_col_to_merchants_table',5),
	(49,'2025_07_08_030434_add_is_home_col_to_merchant_pages_table',5),
	(54,'2025_07_08_151829_add_role_and_tel_and_address_cols_to_merchant_table',6),
	(55,'2025_07_08_153638_create_merchant_roles_table',6),
	(57,'2025_07_08_175839_add_token_col_to_merchant_table',7);

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
	('Pzc4rXJdsebuexROzETt6kYdcIX1DPVUEgbrCfNq',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZjNIWnFMT2Vvcnc3YXdITUMyY29FY1NEeFhPNWdkVXhrMFJVWHRPQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vdGhlZXByb2plY3RzLnRlc3QvbWVyY2hhbnQvcGFnZXMiO31zOjU1OiJsb2dpbl9tZXJjaGFudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1752723653),
	('SAOWjoKBbQnIIRXQthWFvBwNjojWBv9Q3fNvwWwM',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoiSE9BbXdmVFJVU3pXSWZ2SnNtZEtCd3NQWnJyNU9xdFZnWjdOc0J1RyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752794397),
	('VYomOvAitmUOS6eg2LSx3VmYFf0ztixzDuPuHgTO','8','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibHJoVUEwSXExNVlWM3hmWmVnZElOUE1DMmkxUERWZVdGcmY3MzhQeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHBzOi8vdW5pc3Viei50aGVlcHJvamVjdHMudGVzdC9wYWdlL0VvcyUyMGRlc2VydW50JTIwbWF4aW1lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODt9',1752723912);

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
	(1,'UID989F26131','UniSubz','hahote','$2y$12$p16YpDxeC9hsHQ5Hug9hdOHAFTkMBKGB1HWD2ndB5QtUhxQU2kvxC','0298828826','wypa@mailinator.com',8907.00,'103 Cemetery Street','Beatae at ut aute en','0',0.00,2,'1','0','0',1,NULL,'skSWTTkgoWNwLOschfED0Vhe1Y9rcVhAT5LNqobz8vR90rlIaRDHNDCf9u9r','2025-06-24 20:48:41','2025-07-08 14:54:16'),
	(2,'UID05A565562','Forrest Jordan','xodyjilovu','$2y$12$dhU01bDfLTuOSmi4p1RxAewzHcFar1GBF88F/e5R2qwVEi02/Wq.G','Perferendis officia','lawa@mailinator.com',0.00,'Dicta eveniet aut v','Pariatur Rerum corr','0',0.00,2,'1','0','0',1,NULL,NULL,'2025-06-24 20:50:22','2025-06-24 20:50:22'),
	(3,'UID76693F523','Ross Owen','livovulyti','$2y$12$6PmRvQcYs14jteCPpPIT2.UYa6btfUG8phLpNrdC5j4Dn025Hu9L.','Alias cupidatat dolo','lixikod@mailinator.com',0.00,'Repudiandae perferen','In modi non reprehen','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:28:39','2025-06-30 01:28:39'),
	(4,'UID8B679F914','Nayda Avery','nuwihyvyce','$2y$12$m5oWhOcd6WMWkYRmBy17v.bFZ8G5F/ifZZ7xZN8xxjbjW2PUCwnnK','Provident debitis e','lebyva@mailinator.com',0.00,'Aut culpa quia exerc','Dolore impedit odio','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:34:15','2025-06-30 01:34:15'),
	(5,'UIDDF2F03835','Wynter Peters','zebiby','$2y$12$oRfFT26OljDRT0WABgAX0uY0ih8u0fhCctOZZmwdjnRqNm4vN6u/y','Exercitationem optio','zonidyd@mailinator.com',0.00,'Qui inventore non qu','Vel sint amet nobis','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:36:19','2025-06-30 01:36:19'),
	(6,'UIDD77BD7036','Thor Shields','gobodibef','$2y$12$R5Y2GLXN7vCO9V7bUsOe/.adG6cVPrEyHojq8WMMBEARMh4RP1Jn2','Autem labore ut aute','koqiq@mailinator.com',0.00,'Nulla amet laborum','Distinctio Recusand','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:37:55','2025-06-30 01:37:55'),
	(7,'UID5496AC2D7','Jana Chaney','gosypep','$2y$12$4QoXN9liEyXkNvSl0fTuueY2j4dLmbv7jBiCCrUljPUQl1GGGWB1S','Vitae eius ut ex mol','qyrun@mailinator.com',0.00,'Itaque adipisci pari','Sequi minim sapiente','0',0.00,2,'0','0','0',1,NULL,NULL,'2025-06-30 01:39:05','2025-06-30 01:39:05'),
	(8,'UIDC78EE9458','Geraldine Carver','synyhu','$2y$12$N7jWq.4WvtXRvYv1GqV/GuFB1Yo1ALMCM.vGGBtmhEyKRyZo0Xqni','Quasi neque anim mag','jolitutu@mailinator.com',0.00,'Iusto doloremque mag','Libero doloremque no','0',0.00,2,'0','0','0',1,'2025-06-30 02:09:10','KYCvx1MVaXB4cBjgjPSn2hLU5WeQc0qBa04syQr024b3NadAtO4XTX99xYpe','2025-06-30 01:58:58','2025-06-30 02:09:10'),
	(9,'UID0576013C9','Ruth Finch','miwezux','$2y$12$gLNrvgcFNdOl.vAeCk9KCOccI9FP7i8cMikXR9kkvOdorxDBR5W5y','Ipsam facere laborum','micifanupi@mailinator.com',0.00,'Sint do pariatur Au','Cum in itaque ipsum','0',0.00,2,'0','0','0',1,'2025-07-07 12:08:31',NULL,'2025-07-07 12:08:27','2025-07-07 12:08:31'),
	(10,'UID5680514410','Cullen Wilkins','tiruri','$2y$12$j4LQBN42KeowK7nEHpHpTuKlaroElFXbmHenLe7IdG5ypRUAVr13C','Facere obcaecati adi','mejurog@mailinator.com',0.00,'Deleniti est ex temp','Cillum et necessitat','0',0.00,2,'0','0','0',1,'2025-07-07 23:46:13',NULL,'2025-07-07 23:46:08','2025-07-07 23:46:13');

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
	(26,'App\\Models\\User',9,'NGN',0.00,'2025-07-07 12:08:27','2025-07-07 12:08:27'),
	(27,'App\\Models\\User',14,'NGN',0.00,'2025-07-07 23:45:37','2025-07-07 23:45:37'),
	(28,'App\\Models\\Merchant',14,'NGN',0.00,'2025-07-07 23:45:37','2025-07-07 23:45:37'),
	(29,'App\\Models\\User',10,'NGN',0.00,'2025-07-07 23:46:08','2025-07-07 23:46:08'),
	(32,'App\\Models\\User',16,'NGN',0.00,'2025-07-08 17:09:56','2025-07-08 17:09:56'),
	(33,'App\\Models\\Merchant',16,'NGN',0.00,'2025-07-08 17:09:56','2025-07-08 17:09:56'),
	(42,'App\\Models\\User',21,'NGN',0.00,'2025-07-08 18:12:42','2025-07-08 18:12:42'),
	(43,'App\\Models\\Merchant',21,'NGN',0.00,'2025-07-08 18:12:42','2025-07-08 18:12:42'),
	(44,'App\\Models\\User',22,'NGN',0.00,'2025-07-08 18:15:59','2025-07-08 18:15:59'),
	(45,'App\\Models\\Merchant',22,'NGN',0.00,'2025-07-08 18:15:59','2025-07-08 18:15:59');

/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
