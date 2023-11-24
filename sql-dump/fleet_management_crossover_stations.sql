-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: fleet_management
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `crossover_stations`
--

DROP TABLE IF EXISTS `crossover_stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crossover_stations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `from_station_id` bigint unsigned NOT NULL,
  `to_station_id` bigint unsigned NOT NULL,
  `trip_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crossover_stations_from_station_id_foreign` (`from_station_id`),
  KEY `crossover_stations_to_station_id_foreign` (`to_station_id`),
  KEY `crossover_stations_trip_id_foreign` (`trip_id`),
  CONSTRAINT `crossover_stations_from_station_id_foreign` FOREIGN KEY (`from_station_id`) REFERENCES `stations` (`id`),
  CONSTRAINT `crossover_stations_to_station_id_foreign` FOREIGN KEY (`to_station_id`) REFERENCES `stations` (`id`),
  CONSTRAINT `crossover_stations_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crossover_stations`
--

LOCK TABLES `crossover_stations` WRITE;
/*!40000 ALTER TABLE `crossover_stations` DISABLE KEYS */;
INSERT INTO `crossover_stations` VALUES (1,7,8,1,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(2,5,6,2,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(3,8,9,3,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(4,7,8,4,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(5,6,7,5,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(6,7,8,5,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(7,8,9,6,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(8,2,3,7,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(9,3,4,7,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(10,4,5,7,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(11,5,6,7,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(12,6,7,7,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(13,7,8,7,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(14,1,2,8,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(15,2,3,8,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(16,3,4,8,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(17,4,5,8,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL),(18,5,6,8,'2023-11-23 20:34:37','2023-11-23 20:34:37',NULL);
/*!40000 ALTER TABLE `crossover_stations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-24 16:39:35
