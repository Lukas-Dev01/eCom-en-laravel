-- MySQL dump 10.13  Distrib 9.5.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ecomm_en
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Current Database: `ecomm_en`
--

/*!40000 DROP DATABASE IF EXISTS `ecomm_en`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ecomm_en` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `ecomm_en`;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1),(2,'2022_03_29_111856_create_users_table',1),(3,'2022_04_03_165539_create_products_table',2),(4,'2022_04_19_112958_create_cart_table',3),(5,'2022_04_26_123849_create_sessions_table',4),(6,'2022_05_09_170217_create_orders_table',5),(7,'2026_05_02_000000_create_wishlist_table',6),(8,'2026_05_04_000001_add_cancel_reason_to_orders_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `cancel_reason` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,260,2,'pending',NULL,'cash','pending','Bangu g.16-5',NULL,NULL),(2,256,2,'pending',NULL,'cash','pending','Bangu g.16-5',NULL,NULL),(3,257,2,'pending',NULL,'cash','pending','Bangu g.16-5',NULL,NULL),(4,260,2,'pending',NULL,'cash','pending','Bangu g.16-5',NULL,NULL),(5,258,4,'pending',NULL,'cash','pending','Bangu g.20',NULL,NULL),(6,260,4,'pending',NULL,'cash','pending','Bangu g.20',NULL,NULL),(7,257,1,'processing',NULL,'online','processing','Homehgfj, hfghfgj, fghjfgjh, gfhjfghj fghjjfgh, United States, +1fghjfghj','2026-05-19 10:31:08','2026-05-19 10:31:08'),(8,256,1,'delivered',NULL,'online','delivered','Homehgfj, hfghfgj, fghjfgjh, gfhjfghj fghjjfgh, United States, +1fghjfghj','2026-05-19 10:31:08','2026-05-19 10:31:08');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `gallery` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (256,'LG Velvet 5G','200','mobile','A compact LG smartphone with a crisp display, 4GB RAM, and dependable everyday cameras.','https://www.lg.com/us/images/cell-phones/md07522101/gallery/desktop-01.jpg',NULL,NULL),(257,'Oppo A52','300','mobile','A slim Oppo phone with smooth performance, generous memory, and a bright full-screen display.','https://cdn.tgdd.vn/Products/Images/42/220649/oppo-a52-den-1-org.jpg',NULL,NULL),(258,'Panasonic 32 inch LED TV','400','tv','A Panasonic flat-screen TV with clean picture quality, simple controls, and living-room ready styling.','https://i.gadgets360cdn.com/products/televisions/large/1548154685_832_panasonic_32-inch-lcd-full-hd-tv-th-l32u20.jpg',NULL,NULL),(259,'Soni Tv','500','tv','A Sony-style Bravia TV with sharp 4K visuals, smart streaming, and a slim modern stand.','https://d1ncau8tqf99kp.cloudfront.net/converted/125729_original_local_1200x1050_v3_converted.webp',NULL,NULL),(260,'LG fridge','200','fridge','A stainless LG refrigerator with roomy storage, quiet cooling, and a polished kitchen-ready finish.','https://media.us.lg.com/transform/ecomm-PDPGalleryThumbnail-350x350/244b5165-5a87-4c84-9c7a-da42b288908d/Refrigerator_LRMVC2306D_gallery_01_5000x5000',NULL,NULL),(262,'Samsung Galaxy A55','420','mobile','A polished 5G phone with a vivid AMOLED display, strong battery life, and a clean camera system.','https://images.kaina24.lt/43/26/samsung-galaxy-a55-128gb.jpg',NULL,NULL),(263,'iPhone 15','799','mobile','A premium smartphone with a bright Super Retina display, powerful performance, and dependable cameras.','https://gsmarena.lt/cdn/shop/files/naujas-iPhone-15-256GB-melynas_1c81f508-4253-48cc-9596-1e0de4acd457.jpg?v=1700683377&width=990',NULL,NULL),(264,'OnePlus Nord 4','499','mobile','A fast everyday phone with smooth performance, rapid charging, and a modern metal design.','https://images.kaina24.lt/43/90/oneplus-nord-4-512gb.jpg',NULL,NULL),(265,'Google Pixel 8a','549','mobile','A smart Android phone with helpful AI features, excellent photos, and a compact everyday feel.','https://fdn2.gsmarena.com/vv/pics/google/google-pixel-8a-1.jpg',NULL,NULL),(266,'Samsung 55 inch Crystal UHD TV','650','tv','A 4K smart TV with crisp color, built-in streaming apps, and a slim living-room friendly profile.','https://images.samsung.com/is/image/samsung/p6pim/lt/ue55cu7172uxxh/gallery/lt-crystal-uhd-cu7000-ue55cu7172uxxh-535498960?$1164_776_PNG$',NULL,NULL),(267,'Sony Bravia 65 inch Google TV','1100','tv','A large 4K smart TV with Google TV, refined color processing, and immersive entertainment features.','https://m.media-amazon.com/images/I/716M5in9SnL._AC_SL1500_.jpg',NULL,NULL),(268,'LG OLED C4 48 inch TV','1200','tv','A premium OLED TV with deep contrast, fast motion handling, and cinematic picture quality.','https://m.media-amazon.com/images/I/81q-FquA3IL._AC_SL1500_.jpg',NULL,NULL),(269,'Samsung Bespoke Fridge','1450','fridge','A modern refrigerator with flexible storage, refined styling, and dependable freshness control.','https://www.novastar.lt/UserFiles/Products/Images/424269-638664-medium.avif',NULL,NULL),(270,'Whirlpool Double Door Fridge','780','fridge','A spacious double door refrigerator with organized storage and efficient cooling for family use.','https://www.whirlpool.com/is/image/content/dam/global/whirlpool/refrigeration/freestanding-refrigerator/images/hero-WRFC5036RZ.tif?fmt=webp-alpha&wid=721',NULL,NULL),(271,'Haier 320L Frost Free Fridge','620','fridge','A frost free refrigerator with balanced capacity, fast cooling, and a practical layout.','https://m.media-amazon.com/images/I/51kZ0TpOZKL._SL1200_.jpg',NULL,NULL),(272,'MacBook Air 13 inch M3','1099','laptop','A thin and light Apple laptop with the M3 chip, all-day battery life, and a bright Liquid Retina display.','https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mba13-m3-midnight-gallery1-202402',NULL,NULL),(273,'PlayStation 5 Slim Console','499','gaming','A compact PlayStation 5 console with fast loading, immersive graphics, and a large game library.','https://gmedia.playstation.com/is/image/SIEPDC/ps5-slim-dualsense-image-block-01-en-16nov23',NULL,NULL),(274,'Meta Quest 3 Headset','499','gaming','A mixed reality headset for immersive games, apps, fitness, entertainment, and virtual worlds.','https://images.kaina24.lt/167/100/meta-quest-3-512gb.jpg',NULL,NULL),(275,'Bose QuietComfort Ultra Headphones','429','audio','Premium noise-canceling headphones with immersive audio, plush comfort, and strong battery life.','https://images.kaina24.lt/5191/31/bose-quietcomfort-ultra.jpg',NULL,NULL),(276,'JBL Flip 6 Speaker','129','audio','A portable waterproof Bluetooth speaker with bold sound, durable design, and long battery life.','https://global.jbl.com/dw/image/v2/BFND_PRD/on/demandware.static/-/Sites-masterCatalog_Harman/default/dwa4af8327/3_JBL_FLIP6_FRONT_TEAL_29503_x2.png?sw=535&sh=535',NULL,NULL),(277,'AirPods Pro 2','249','earbuds','Apple wireless earbuds with active noise cancellation, adaptive audio, and a compact charging case.','https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQD83',NULL,NULL),(278,'Ninja Foodi DualZone Air Fryer','229','appliance','A dual-basket air fryer that cooks two foods at once with independent zones and easy controls.','https://m.media-amazon.com/images/I/61xMRA3NY4L._AC_SL1500_.jpg',NULL,NULL),(279,'iPad Air 11 inch M2','599','tablet','A lightweight Apple tablet with the M2 chip, vivid display, and support for creative work on the go.','https://images.kaina24.lt/308/65/apple-ipad-air-11-128gb-2024.jpg',NULL,NULL),(280,'Google Pixel Watch 3','349','wearable','A sleek Google smartwatch with fitness tracking, helpful apps, and all-day wearable convenience.','https://images.kaina24.lt/5889/16/google-pixel-watch-3-41mm.jpg',NULL,NULL),(281,'GoPro HERO13 Black','399','camera','A rugged action camera built for crisp video, stabilization, and adventure-ready shooting.','https://images.kaina24.lt/9764/13/gopro-hero13.jpg',NULL,NULL),(282,'Canon EOS R50 Camera','679','camera','A compact mirrorless camera for sharp photos, 4K video, and flexible everyday content creation.','https://images.kaina24.lt/71/59/canon-eos-r50.jpg',NULL,NULL),(283,'Samsung Galaxy S24 Ultra','1199','mobile','A premium Galaxy phone with a large display, advanced cameras, S Pen support, and fast performance.','https://images.kaina24.lt/43/64/samsung-galaxy-s24-ultra-256gb.jpg',NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John Smith','john.smith@example.com','$2y$10$9R.YL7exbExqPah7R7D2Ye2wTYesyFuiFmf1Uep/rsRjEwpNLvz02',NULL,NULL),(2,'Emily Johnson','emily.johnson@example.com','$2y$10$UZ.SVOMRvOC5vOQK13fw5e5jr4dqJcz1AOlyXx6tU7Wj7Dj4WFGwe',NULL,NULL),(4,'Michael Brown','michael.brown@example.com','$2y$10$/l1Z2hOP20tUUX/IzSw4Fe6BPw.TpYVtJLjxUQEl0/cJYdur1svz2','2022-05-13 09:49:43','2022-05-13 09:49:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlist_product_id_user_id_unique` (`product_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'ecomm_en'
--

--
-- Dumping routines for database 'ecomm_en'
--
--
-- WARNING: can't read the INFORMATION_SCHEMA.libraries table. It's most probably an old server 5.5.5-10.4.32-MariaDB.
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-20 16:22:22
