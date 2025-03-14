-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: haj
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'default','{\"uuid\":\"1bb0c63a-8c4d-4e0b-9c5f-0f75b24d90d1\",\"displayName\":\"App\\\\Events\\\\NotificationSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:27:\\\"App\\\\Events\\\\NotificationSent\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1739192174,1739192174),(2,'default','{\"uuid\":\"238daf4b-547e-46c7-a7f6-8005e561dd56\",\"displayName\":\"App\\\\Events\\\\NotificationSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:27:\\\"App\\\\Events\\\\NotificationSent\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1739192194,1739192194),(3,'default','{\"uuid\":\"da616280-f98e-4557-92e5-a0adbbc0fecb\",\"displayName\":\"App\\\\Events\\\\NotificationSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:27:\\\"App\\\\Events\\\\NotificationSent\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1739192202,1739192202);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_09_10_220245_create_personal_access_tokens_table',1),(5,'2025_01_09_171046_create_restaurants_table',1),(6,'2025_01_09_171059_create_branches_table',1),(7,'2025_01_09_173421_create_categories_table',1),(8,'2025_01_09_173608_create_branch_category_table',1),(9,'2025_01_09_195842_create_notifications_table',1),(10,'2025_01_09_222413_create_items_table',1),(11,'2025_02_03_103530_create_users_table',2),(12,'2025_02_03_113059_create_notifications_table',3),(13,'2025_02_03_113626_add_whatsapp_address_location_to_users_table',4),(14,'2025_02_03_121358_add_email_verified_at_to_users_table',5),(16,'2025_02_04_051731_add_admin_to_users_role_enum',6),(17,'2025_02_04_081554_add_additional_fields_to_users_table',7),(18,'2025_02_08_070803_add_center_fields_to_centers',8),(19,'2025_02_10_093816_create_ratings_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_status` enum('unread','read') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `read_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,176,'You have received a new rating.','rating','unread',NULL,1,'2025-02-10 20:21:58','2025-02-10 20:21:58'),(2,176,'Your rating has been updated.','rating','unread',NULL,1,'2025-02-10 20:56:14','2025-02-10 20:56:14'),(3,176,'Your rating has been updated.','rating','unread',NULL,1,'2025-02-10 20:56:34','2025-02-10 20:56:34'),(4,176,'Your rating has been updated.','rating','unread',NULL,1,'2025-02-10 20:56:42','2025-02-10 20:56:42');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('ayat34@gmail.com','$2y$12$tUm4m85.93NE/BeE/RWRs.NkUxGsPjNIagfV9t1XKDYb5uzfUtJj2','2025-02-09 18:10:52'),('ayatalmom55@gmail.com','$2y$12$uiSilYAeTGJHCFBEdSlAuuptHUVtmCV.pdzVC4ZdQ78v0vhhqNvPS','2025-02-10 20:53:36');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',49,'haj','543c99efecdae01233a122bc93019dbe8b7bd4e014d20b6070267ae6f72d1de4','[\"*\"]',NULL,NULL,'2025-02-04 17:32:30','2025-02-04 17:32:30'),(2,'App\\Models\\User',49,'haj','2520fa4cb7dc5ee5751508341f72d7646fe77413cbd21c71ffa51d46132bc162','[\"*\"]',NULL,NULL,'2025-02-04 17:32:36','2025-02-04 17:32:36'),(3,'App\\Models\\User',49,'haj','9deddce96ce457bd1e4be0d35bcc399f061a0178dd904dee4dc0591bc0e2cf30','[\"*\"]',NULL,NULL,'2025-02-04 17:32:49','2025-02-04 17:32:49'),(4,'App\\Models\\User',49,'haj','43cc44908f0f19cf3ae519bd57a286093f29cf1949f2fa89999c3e9420265783','[\"*\"]',NULL,NULL,'2025-02-04 17:36:39','2025-02-04 17:36:39'),(5,'App\\Models\\User',49,'haj','698bcf0be15717d6a2c1dc4e1e9918269532a0421ebc9465dad3f8734fc0b42a','[\"*\"]',NULL,NULL,'2025-02-04 17:37:02','2025-02-04 17:37:02'),(6,'App\\Models\\User',49,'haj','b42c630a57389fa207c7c288f786792aed573906d5524df2ac2e6460a855dbf5','[\"*\"]',NULL,NULL,'2025-02-04 17:37:19','2025-02-04 17:37:19'),(7,'App\\Models\\User',49,'haj','b4756ba80084540605ea7ccf92335f74fe86deea5ec7d21a90440e054bc40342','[\"*\"]',NULL,NULL,'2025-02-04 17:37:23','2025-02-04 17:37:23'),(8,'App\\Models\\User',49,'haj','97a7ec2fa166057a75364e4a97482de5bea97bbde800e61a915ddc8f57cc4538','[\"*\"]',NULL,NULL,'2025-02-04 17:37:26','2025-02-04 17:37:26'),(9,'App\\Models\\User',49,'haj','1fd4962f1b7b0295457c32ce1cf925051d61f919c382610d6aaf11e31d64ac76','[\"*\"]',NULL,NULL,'2025-02-04 17:38:23','2025-02-04 17:38:23'),(10,'App\\Models\\User',49,'haj','995507e48e42f0edd7bfc9160656bae7e08020f58e1251827dde7dde76f1e88b','[\"*\"]',NULL,NULL,'2025-02-04 17:41:15','2025-02-04 17:41:15'),(11,'App\\Models\\User',49,'haj','0d4a542afda79ed4d7c1d9a2cf897d1ff0340fc7b5c710a1e4e956c817063d58','[\"*\"]',NULL,NULL,'2025-02-04 17:54:26','2025-02-04 17:54:26'),(12,'App\\Models\\User',61,'haj','16f2e06eb5124dd9c9e8fbb2f09633ee75b1bf2ae0dec1ef3e027fca5694c56d','[\"*\"]',NULL,NULL,'2025-02-04 18:29:16','2025-02-04 18:29:16'),(13,'App\\Models\\User',62,'haj','aa54ca1f01abcf361466d02ded2989a828e10b7019aa8733bb984a55eb14d1c4','[\"*\"]',NULL,NULL,'2025-02-04 18:32:12','2025-02-04 18:32:12'),(14,'App\\Models\\User',62,'haj','392b05595fead8a6b4abf034c2e262743357a6742cf9cae20c9bb0e8852982e4','[\"*\"]',NULL,NULL,'2025-02-04 18:33:54','2025-02-04 18:33:54'),(15,'App\\Models\\User',62,'haj','9ee2089d0c33d9f5fed0b3bcb379b4aa8e7ac767d78118b797b8528b51ad1506','[\"*\"]',NULL,NULL,'2025-02-04 20:12:45','2025-02-04 20:12:45'),(16,'App\\Models\\User',62,'haj','e34da792d2747a65dcff35a0bd6cfb26e595486b9344cf9823fab47825f92e50','[\"*\"]',NULL,NULL,'2025-02-05 15:28:21','2025-02-05 15:28:21'),(17,'App\\Models\\User',62,'haj','ad0900158e8d96e746df53fbb31160c150e65b7ce97f1850e03e18c5535478af','[\"*\"]',NULL,NULL,'2025-02-05 15:28:22','2025-02-05 15:28:22'),(18,'App\\Models\\User',62,'haj','d6da994904481e0b7b9d3eaf5b3d6407c97eb4ca3d165240ede75f6b8cc1326f','[\"*\"]',NULL,NULL,'2025-02-05 15:34:08','2025-02-05 15:34:08'),(19,'App\\Models\\User',62,'haj','1a688adc73b2464df18b0c701c534bf58c7501e549f94c9919ef634c8834d69f','[\"*\"]',NULL,NULL,'2025-02-05 15:38:27','2025-02-05 15:38:27'),(20,'App\\Models\\User',62,'haj','fd6f839bde303ad581c7569c370c41c79322573e0660bbe769e83a8b3ed649b9','[\"*\"]',NULL,NULL,'2025-02-05 15:41:21','2025-02-05 15:41:21'),(21,'App\\Models\\User',65,'haj','49b6364c36d5eb33f27117010abd040c4b41ebb1c6ead63d79c8c0eb6904f791','[\"*\"]',NULL,NULL,'2025-02-05 15:48:34','2025-02-05 15:48:34'),(22,'App\\Models\\User',65,'haj','69f6af5b1f232dd2d2e24e8a2797f6b530867d3cbde977068dabf9ee5a7472ce','[\"*\"]',NULL,NULL,'2025-02-05 16:05:18','2025-02-05 16:05:18'),(23,'App\\Models\\User',175,'haj','4a58a5f960f11e2fe099692a2ec2ad6d8cc15b88fe5d08bd07b552be4ad04da6','[\"*\"]',NULL,NULL,'2025-02-08 16:18:01','2025-02-08 16:18:01'),(24,'App\\Models\\User',175,'haj','9e3891427601f8ac738a7a188ddffa63692d441e9bf99564b5b5c68c44f54553','[\"*\"]',NULL,NULL,'2025-02-08 16:19:52','2025-02-08 16:19:52'),(25,'App\\Models\\User',175,'haj','4f15fd3dc3cd450b50f7aa097502767ea58e8c242a2d873ab5c4004bd6568e13','[\"*\"]',NULL,NULL,'2025-02-08 16:19:59','2025-02-08 16:19:59'),(26,'App\\Models\\User',175,'haj','3148586fa38e4e68176f7dad2d69d414a27a2fa2141a78d785611a69c996ebb2','[\"*\"]',NULL,NULL,'2025-02-08 16:20:44','2025-02-08 16:20:44'),(27,'App\\Models\\User',197,'haj','460484439fa2365798026231802720f5c439a8efb21fdd33bccad019e7ecf054','[\"*\"]',NULL,NULL,'2025-02-09 18:03:23','2025-02-09 18:03:23'),(28,'App\\Models\\User',197,'haj','ba76a5832f7c79ed4b7d55d847bd504941db9b6bd4a7a107444875ad9e60ea3a','[\"*\"]',NULL,NULL,'2025-02-09 18:08:42','2025-02-09 18:08:42'),(29,'App\\Models\\User',197,'haj','348b765c98085e7fe13ce896ac7845bd7f9dffb23678504ac01fb93a2cfba415','[\"*\"]',NULL,NULL,'2025-02-09 18:08:55','2025-02-09 18:08:55'),(30,'App\\Models\\User',197,'haj','e392ee2375c88243767c7a654c7a1f5279f4b70618f093af3bd0d2114560c821','[\"*\"]',NULL,NULL,'2025-02-09 18:09:51','2025-02-09 18:09:51'),(31,'App\\Models\\User',197,'haj','d0a7927a6ee64ca8f1194cdb78143612e719af9b7eefd561577c945eff7b654b','[\"*\"]',NULL,NULL,'2025-02-09 18:09:59','2025-02-09 18:09:59'),(32,'App\\Models\\User',197,'haj','be5688c5627d320dee6bccc38669bc699b1578de10d38dd28363199709205fdc','[\"*\"]',NULL,NULL,'2025-02-09 18:10:18','2025-02-09 18:10:18'),(33,'App\\Models\\User',198,'haj','b324b02a737db3948d4fc74156df77602645e2d7f02d1a6a72b05ba813afe3c2','[\"*\"]',NULL,NULL,'2025-02-09 18:14:19','2025-02-09 18:14:19'),(34,'App\\Models\\User',198,'haj','86a4915c563bd2010117bd935acfdaf6b60972a0f0f5a0fa30dd510c215fcf3a','[\"*\"]',NULL,NULL,'2025-02-09 18:15:10','2025-02-09 18:15:10'),(35,'App\\Models\\User',198,'haj','ea580dc5d639511ef46b6a50e084816c0ac2a67bb92d501bdfe6bf16a7e8c483','[\"*\"]','2025-02-10 20:54:59',NULL,'2025-02-10 18:50:41','2025-02-10 20:54:59'),(36,'App\\Models\\User',176,'haj','5de65f20ef0b6da54bc77ea630db13c88aa6bf8dc4f9ecdb9f4ce3f66c8e86a3','[\"*\"]','2025-02-10 20:56:42',NULL,'2025-02-10 20:55:53','2025-02-10 20:56:42');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `trainer_id` bigint unsigned NOT NULL,
  `rating` int NOT NULL DEFAULT '0',
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_user_id_foreign` (`user_id`),
  KEY `ratings_trainer_id_foreign` (`trainer_id`),
  CONSTRAINT `ratings_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` VALUES (2,176,176,5,'good','hi','2025-02-10 18:47:52','2025-02-10 20:56:42'),(3,175,176,4,'good','like it','2025-02-10 18:51:09','2025-02-10 18:51:09'),(4,175,176,4,'good','like it','2025-02-10 20:10:29','2025-02-10 20:10:29'),(5,175,176,4,'good','like it','2025-02-10 20:21:33','2025-02-10 20:21:33'),(6,175,176,4,'good','like it','2025-02-10 20:21:58','2025-02-10 20:21:58');
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('3p310Zay6Izj7DuBaxdpRce96bTWyCvUIqF8DeX3',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY0pyMUJMdWgwN0dFZXhkTXM1RFoxZXZQZFFIY0ZZMU5mYWVxeHRsdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjt9fQ==',1739192153),('vNETskCYV4x8sZx2as7NF4Fzif5n8sgXJ4ri4juq',NULL,'127.0.0.1','PostmanRuntime/7.43.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXdKYjdSYWtzSjVGSmgwYVZWRXZ2eWhtVUFVaGtubGpPZUVWbkIwTiI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1739191849),('xqweMo3gHzaWF1kL2No0pzSI6JclpXYRd2Ms5LpG',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaUl0enRtSTd5T1FFcmIxZlZCbUpyb20wdWVxeFdaZTVlNWNyRXYzTCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1739184641),('XVQeN37Ae1BPljyrQqfUQB05sitPcZoFAv9lXlQa',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOG5Ma1lhTG9kQXpjekU5MlNBRmZsRnVHV2lPN0VVdmx4NFltUDBZMyI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3JlZ2lzdGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1739176852);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('trainee','instructor','training_center','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `years_of_experience` int DEFAULT NULL,
  `training_type` enum('beginner','advanced','highway_driving','city_driving') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `license_type` enum('private','motorcycle','truck') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `session_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_price` decimal(8,2) DEFAULT NULL,
  `session_time` enum('morning','afternoon','evening') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_training_available` tinyint(1) NOT NULL DEFAULT '0',
  `test_preparation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_training_programs` enum('women','elderly','special_needs') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `center_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `center_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (175,'Maria','ayatalmom55@gmail.com','2025-01-14 23:30:07','$2y$12$17OBjWTlZ.bbCKTA9X1Ra.AloxrMUX8qDdnBAh/pCpkGMR.NDpDLG','trainee','07870045343','Amman',0,'2025-02-08 16:16:36','2025-02-08 16:16:36','0797885675',NULL,NULL,NULL,NULL,NULL,NULL,NULL,22,NULL,NULL,NULL,0,'true',NULL,1,'images/zUMSbSGixdKM0CiDEmJxbBELThfO6MigLzOCOamg.jpg',NULL,NULL),(176,'Maria','ayatalmani655@gmail.com','2025-01-14 23:30:07','$2y$12$lX7LrzFA0NqZNMyjDFh7Dey0l7kxGekMLLfwkZ3XTmS1aN5J0UUGW','trainee','07870045343','Amman',0,'2025-02-08 16:19:18','2025-02-08 16:19:18','0797885675',NULL,NULL,NULL,NULL,NULL,NULL,NULL,22,NULL,NULL,NULL,0,'false',NULL,1,'images/0mEKtJ2il9SRhmxTLok6HdxorvHO8b987nZrA1qs.jpg',NULL,NULL),(177,'Maria','ayatalmomani22@gmail.com',NULL,'$2y$12$uHbjqwn2OMZWXswyT6rtqOW0PqR.8d4PTyFCKaiWeYTcKT3lUpk22','trainee','07870045343','Amman',0,'2025-02-08 16:22:26','2025-02-08 16:22:26','0797885675',NULL,NULL,NULL,NULL,NULL,NULL,NULL,22,NULL,NULL,NULL,0,'true',NULL,1,'images/jZSpHRTdjlrh8t9P2mj3X8YEDGCk5nHNito97XCx.jpg',NULL,NULL),(178,'Maria','ayatalmomani33@gmail.com',NULL,'$2y$12$xm09Y1p5nYS9M.iSMUCpiu99So6ZvS0i949ox0H0jfsBg15R4k8Dm','instructor','07870045343','Amman',0,'2025-02-08 16:26:15','2025-02-08 16:26:15','0797885675',NULL,'arabic',5,'beginner','test',NULL,'private',22,'120',33.00,'morning',0,'true','women',1,'images/apEHfMVlUUtrX8xCl0luOylpfQLnjyISoSB34ULS.jpg',NULL,NULL),(179,'Ayat Almomani','ayatalm58855@gmail.com',NULL,'$2y$12$kaRTbBwCklPZJsPRLiDV4uFy4tgw8ok5SSO4M6z3GXgr5zi9Q6Aky','training_center','4444444','amman',0,'2025-02-09 16:16:41','2025-02-09 16:16:41','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,'images/hRPzKr8gOdewD6uDeQbcie8VMIBj7fEdgEpGNk9i.jpg',NULL,NULL),(180,'╪º┘è╪º╪¬','ayatal33@gmail.com',NULL,'$2y$12$lPMYyrd8txZURWtfzp6bhOC827L.o9UU85/8lX9pPAQpLai9Pa3cu','instructor','07870021034','╪º┘ä╪º╪▒╪»┘å',0,'2025-02-09 16:20:58','2025-02-09 16:20:58','0787002103',NULL,NULL,4,'beginner','test',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,'images/ofN3pE0oJd1XzvvLHgvv177tDOKVfIsrmLqDCZR9.jpg',NULL,NULL),(181,'Ayat Almomani','ayatalm584444855@gmail.com',NULL,'$2y$12$8nMfwqPJvi7ofJdP0tejG.maEywN53QTbs2Usg.wvZEzaqI8KvA32','trainee','4444444','amman',0,'2025-02-09 16:28:55','2025-02-09 16:28:55','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/vaBIxD5G25ZyxjKCeFYL1v2Qjwn4QunTBqbd5K52.jpg',NULL,NULL),(182,'test','ayatalm5777755@gmail.com',NULL,'$2y$12$T2hwlA0BEvCve1cN9tmXdOMj/M.JcDe6VtII9zyZ.YkLwtsQTTWU.','trainee','0777885645','test',0,'2025-02-09 16:35:12','2025-02-09 16:35:12','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/kmoyQLgCony0v3CFen9OSOYDoK3gkA7q91UOb9Fo.jpg',NULL,NULL),(183,'test','ayatalm57777455@gmail.com',NULL,'$2y$12$VBjh.9DdobUIIV0nVn2N6O27rePukbkTgmFxzd0IcQ0TEmweYx.w6','trainee','0777885645','test',0,'2025-02-09 16:37:40','2025-02-09 16:37:40','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/YIocSk6xvpU94H1GT7Ptec9C9ZVok1LfNvSM7PQv.jpg',NULL,NULL),(184,'test2','ayatalm5777007455@gmail.com',NULL,'$2y$12$Ny0N.4XMtWvzOUN0YDACrO/mrAqe/AG85eaKwd/I9BwwwxMy149yy','trainee','0777885645','test',0,'2025-02-09 17:20:48','2025-02-09 17:20:48','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/Yc6Ko25eqtZrvwzxE1Ry5NsWS49vp0pULI1V9C0R.jpg',NULL,NULL),(185,'test2','ayata7007455@gmail.com',NULL,'$2y$12$0qpSpopPYjTfKuOlARr7xeaPJOKbpjGDs7SJhZ6NJ.94MxQJ41r1S','trainee','0777885645','test',0,'2025-02-09 17:26:03','2025-02-09 17:26:03','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/ey4mRiDWzN8GLZYRmDgv9YdF4vnybiFXMpz0MCl2.jpg',NULL,NULL),(186,'test2','ayata700749855@gmail.com',NULL,'$2y$12$5Jit1wwoSyIz3TsBFhU7OOBv9x.rDCQHQyDOfgjsaSVqrL.EUakv2','trainee','0777885645','test',0,'2025-02-09 17:28:39','2025-02-09 17:28:39','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/PXy87PBISqVIuD54pRB2rWb4ABWFWMS49WF1OO5e.jpg',NULL,NULL),(187,'Ayat Almomani','ayatalmoma45@gmail.com',NULL,'$2y$12$JapKghOH8irX/HgBsfThI.k0jl8iMBaIH4bzOAoqWsE28Ag0R3ZDi','trainee','4444444','amman',0,'2025-02-09 17:29:19','2025-02-09 17:29:19','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/Tb5ffNQVXyTiMgQ9eQvxObYGHCGl8O7bY1FvgFR2.jpg',NULL,NULL),(188,'Ayat Almomani','ayatalmomani65533@gmail.com',NULL,'$2y$12$3lcfP59uOIOldZar2MAvq.RZX8A0DKNBMkB9cOkI7Q4BP5ROGWpl6','training_center','4444444','amman',0,'2025-02-09 17:33:33','2025-02-09 17:33:33','97879599454',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'on',NULL,1,'images/47xKDN5TyH1vPX66O3930KtfcyxrLgrXOVFcU0Q7.jpg','test','amman'),(189,'Ayat Almomani','ayatalmomani653335@gmail.com',NULL,'$2y$12$CQGF9v0/v1JUO4kWWJjpduq3WFMs2Gs3qXmRoKZ6ucQvWow0BU9Mu','instructor','4444444','amman',0,'2025-02-09 17:34:49','2025-02-09 17:34:49','12334556655',NULL,'╪╣╪▒╪¿┘è',3,'beginner','test',NULL,'private',NULL,'120',10.00,'morning',0,'on','women',1,NULL,NULL,NULL),(190,'Ayat Almomani','ayatalmomani63255@gmail.com',NULL,'$2y$12$7sifm6APzaC4Cy5MnJ83PupA6bjg45YcuiaOIleI7.YfMN4WpYeMG','instructor','4444444','amman',0,'2025-02-09 17:36:12','2025-02-09 17:36:12','12334556655',NULL,'╪╣╪▒╪¿┘è',2,'beginner','test',NULL,'private',NULL,'120',10.00,'morning',0,'on','women',1,'images/ULv6sEPoIrJgbPh8boeISY5IYiLZQvXjlkrB8uZd.jpg',NULL,NULL),(191,'Ayat Almomani','ayatalm5885599@gmail.com',NULL,'$2y$12$cHUtQdFhZfvP8YNuzUt/.e5K4tRgYTVu1t6vh28hUAf7XDNYs.ky.','trainee','4444444','amman',0,'2025-02-09 17:40:19','2025-02-09 17:40:19','12334556655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,0,'on',NULL,1,'images/4s8RubqOjl64yWadUgR1O6y9Hi4DdERycSKYV0oZ.jpg',NULL,NULL),(192,'Ayat Almomani','ayata55@gmail.com',NULL,'$2y$12$hPQSbj5JrEz80Rc4jaYgouFTHLQ00kkRitkdlZLao8dfIWfqCrK/O','instructor','4444444','amman',0,'2025-02-09 17:41:44','2025-02-09 17:41:44','12334556655',NULL,'╪╣╪▒╪¿┘è',4,'beginner','test',NULL,'motorcycle',NULL,'120',10.00,'morning',0,'on','women',1,'images/xQSNX8bi8dV7Nmlij7zr9WCpE7z3Fyi5yohCoZtZ.jpg',NULL,NULL),(193,'aua','ayat58855@gmail.com',NULL,'$2y$12$swlMt5./VZsPXJGHSQW78OpITnWyb3G2PmmLhtZgouMwHoA.Xw5Ee','training_center','77777777','amman',0,'2025-02-09 17:43:38','2025-02-09 17:43:38','333333333333',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'on',NULL,1,'images/Oiek6E8mdafton1IuMfgxkxRpS9mnDsEgQn9IkrP.jpg','test','amman'),(194,'Ayat Almomani','ayatappp55@gmail.com',NULL,'$2y$12$L2wQprwPri1KWRRtDfRIwOj2Sn0u9uY.k9Wskkkm6Sbi9R2XA1KN2','instructor','4444444','amman',0,'2025-02-09 17:49:52','2025-02-09 17:49:52','333333333333',NULL,'╪╣╪▒╪¿┘è',2,'beginner','test',NULL,'private',NULL,'120',10.00,'morning',0,'on','elderly',1,'images/SJEoMzobcUt1XtFU6CUoKfA5RN5YFPVg9qK8h9on.jpg',NULL,NULL),(195,'Ayat Almomani','ayatalm99@gmail.com',NULL,'$2y$12$7A6HOwqE5BUv/9hSokJUwOGdvQ3f4hJe/0nkXogL6n.wfQh2dHUby','instructor','4444444','amman',0,'2025-02-09 17:56:08','2025-02-09 17:56:08','333333333333',NULL,'╪╣╪▒╪¿┘è',4,'beginner','test',NULL,'private',33,'120',10.00,'evening',0,'on','elderly',1,'images/sgKVW6mrfPT9KaDwHEZWVqOA7BmdQnTfSYMSFFgA.jpg',NULL,NULL),(196,'Ayat Almomani','ayat@gmail.com',NULL,'$2y$12$5294t52OE6F3GuULTIMSDuD/bbTuSMT17uuHPlZtref/otpZxbGx6','training_center','4444444','amman',0,'2025-02-09 18:01:19','2025-02-09 18:01:19','333333333333',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'on',NULL,1,'images/H4CBwu85q3koLcLvrNQRj41AKE7Bnvvnnl3KKeAa.jpg','test','amman'),(197,'Ayat Almomani','ayat34@gmail.com','2025-01-14 23:30:07','$2y$12$sTwnu3RtBkqqivX4G5bKP.FxmHAnPRqLNWLVSu1p.TctX48EIUyXm','trainee','4444444','amman',0,'2025-02-09 18:02:11','2025-02-09 18:02:11','333333333333',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'on',NULL,1,'images/AAkd44ijl5iq6coZnvkk77W9p1KYjqG4GUS3BP5j.jpg',NULL,NULL),(198,'Ayat Almomani','ayatalmomani655@gmail.com','2025-02-09 18:14:04','$2y$12$QAW2OA1LIbJFpRZ04iboLeEkMnrlb/ReUVMemtco/D3J6GJI3/gWa','trainee','4444444','amman',0,'2025-02-09 18:12:17','2025-02-09 18:14:55','78668884343',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'on',NULL,1,'images/kHCdtWUa8Nq41LKaWdP4y2HtKjHa5UKdSqRWBlO0.jpg',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-10  5:55:30
