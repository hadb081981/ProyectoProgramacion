-- Atención Ciudadana · base de datos completa (estructura + datos de ejemplo)
-- Equivale a: php artisan migrate --seed
-- Uso: en phpMyAdmin cree la base "atencion_ciudadana" (utf8mb4) e importe este archivo.
-- Usuarios de prueba (solo para uso local):
--   admin@atencionciudadana.test         / Admin12345      (administrador)
--   mantenimiento@atencionciudadana.test / Encargado12345  (encargado de Mantenimiento)


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'Mantenimiento','2026-11-12 21:39:34','2026-11-12 21:39:34'),(2,'Alumbrado público','2026-11-12 21:39:34','2026-11-12 21:39:34'),(3,'Agua potable','2026-11-12 21:39:34','2026-11-12 21:39:34');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `icono` varchar(40) NOT NULL DEFAULT 'bi-exclamation-circle' COMMENT 'Clase de Bootstrap Icons',
  `idarea` bigint(20) unsigned DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categorias_idarea_foreign` (`idarea`),
  CONSTRAINT `categorias_idarea_foreign` FOREIGN KEY (`idarea`) REFERENCES `areas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Bacheo y calles','Baches, hundimientos o calles en mal estado.','bi-cone-striped',1,1,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(2,'Alumbrado público','Lámparas apagadas, intermitentes o dañadas.','bi-lightbulb-off',2,1,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(3,'Limpieza y recolección','Basura acumulada, falta de recolección o basureros clandestinos.','bi-trash3',1,1,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(4,'Agua potable','Fugas, falta de agua o tuberías dañadas del servicio de agua potable.','bi-droplet-half',3,1,'2026-11-12 21:39:34','2026-11-12 21:39:34');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `comunidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comunidades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `tipo` varchar(30) NOT NULL DEFAULT 'Barrio' COMMENT 'Cabecera, Barrio, Colonia, Aldea, Caserío o Finca',
  `baja` timestamp NULL DEFAULT NULL COMMENT 'Fecha en que se dio de baja; NULL = activa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `comunidades` WRITE;
/*!40000 ALTER TABLE `comunidades` DISABLE KEYS */;
INSERT INTO `comunidades` VALUES (1,'Morales (casco urbano)','Cabecera',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(2,'Bananera','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(3,'Caribe','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(4,'Carrizal','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(5,'La Bolsa','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(6,'La Cancha','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(7,'La Corrugadora','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(8,'La Gasolinera','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(9,'Michal','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(10,'Nuevo Morales','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(11,'San Antonio','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(12,'Suchiate','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(13,'Villa Real','Barrio',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(14,'El Naranjo','Colonia',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(15,'Hermana Patricia','Colonia',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(16,'Santa Bárbara','Colonia',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(17,'Arapahoe Viejo','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(18,'Barranca','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(19,'Birrinche','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(20,'Cayuga','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(21,'Chiriqui','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(22,'Cucharas','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(23,'Cumbre de La Sierra Abajo','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(24,'El Cedro','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(25,'El Gran Cañón','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(26,'Finca El Real','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(27,'La Coroza','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(28,'La Libertad','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(29,'La Ruidosa','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(30,'Las Pozas','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(31,'Los Cerritos','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(32,'Milla Seis','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(33,'Milla Siete','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(34,'Milla Treintisiete','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(35,'Mirasol','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(36,'Negro Norte Arriba','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(37,'Oneida','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(38,'Playitas','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(39,'Río Blanco','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(40,'Río Negro','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(41,'San Isidro','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(42,'San Miguel','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(43,'Tenedores','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(44,'Virginia','Aldea',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(45,'Buena Vista (cerca de Oneida)','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(46,'Buena Vista (cerca de Playitas)','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(47,'Cerro Azul','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(48,'Cruce Riachuelo Las Ánimas','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(49,'Cruce de Picuatz','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(50,'Cruce de Tenedores','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(51,'Cumbre Fría','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(52,'Cumbre de La Sierra Arriba','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(53,'Cumbre de La Sierra Tope','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(54,'Dartmouth','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(55,'El Chispal','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(56,'El Naranjito','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(57,'El Playón','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(58,'El Quetzalito','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(59,'El Quinto','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(60,'El Rosario','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(61,'El Satélite','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(62,'Franceses','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(63,'Guaytán','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(64,'La Ceiba','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(65,'La Ceibita','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(66,'La Chiclera','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(67,'La Democracia','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(68,'La Esperanza','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(69,'La Nueva Unión Santa Clara','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(70,'La Pedrera','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(71,'Las Cruces','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(72,'Las Flores','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(73,'Las Jaras','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(74,'Las Veguitas','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(75,'Las Ánimas','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(76,'Mancalito','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(77,'Manzanal','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(78,'Merendoncito','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(79,'Navajoa','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(80,'Negro Norte Abajo','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(81,'Nueva Concepción','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(82,'Nuevo San José','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(83,'Pablo Creek','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(84,'Picuatz','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(85,'Quebrada Grande (cerca de Birrinche)','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(86,'Quebrada Grande (cerca de Cucharas)','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(87,'Rancho Grande','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(88,'Riachuelo','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(89,'San Joaquín','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(90,'San Marcos','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(91,'San Miguel (cerca de Río Negro)','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(92,'San Vicente','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(93,'Santa Rosita','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(94,'Sebalan','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(95,'Seneca','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(96,'Shanne','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(97,'Tepemechines','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(98,'Tres Pinos','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(99,'Valladares','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(100,'Valle Nuevo','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(101,'York','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(102,'Zarco Creek','Caserío',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(103,'Campo Bull','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(104,'Finca Bonanza','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(105,'Finca Las Vírgenes','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(106,'Finca Santa Teresa','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(107,'Hacienda El Rejón','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(108,'Hacienda Libra','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(109,'Hacienda Mi Reina','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(110,'Hacienda Nuevos Horizontes','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(111,'Hacienda Villa Sonia','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(112,'Labor El Sendero','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(113,'Lanquín II','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(114,'Tikal','Finca',NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34');
/*!40000 ALTER TABLE `comunidades` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_11_12_000001_crear_areas_y_usuarios',1),(2,'2026_11_12_000002_crear_comunidades',1),(3,'2026_11_12_000003_crear_categorias',1),(4,'2026_11_12_000004_crear_reportes',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `reporte_comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte_comentarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idreporte` bigint(20) unsigned NOT NULL,
  `idusuario` bigint(20) unsigned DEFAULT NULL,
  `estado_anterior` varchar(15) DEFAULT NULL,
  `estado_nuevo` varchar(15) NOT NULL,
  `comentario` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reporte_comentarios_idreporte_foreign` (`idreporte`),
  KEY `reporte_comentarios_idusuario_foreign` (`idusuario`),
  CONSTRAINT `reporte_comentarios_idreporte_foreign` FOREIGN KEY (`idreporte`) REFERENCES `reportes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reporte_comentarios_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `reporte_comentarios` WRITE;
/*!40000 ALTER TABLE `reporte_comentarios` DISABLE KEYS */;
INSERT INTO `reporte_comentarios` VALUES (1,1,NULL,NULL,'recibido',NULL,'2026-11-09 21:39:34'),(2,2,NULL,NULL,'recibido',NULL,'2026-11-10 21:39:34'),(3,2,1,'recibido','en_proceso','El equipo de alumbrado revisará las lámparas el jueves.','2026-11-12 21:39:34'),(4,3,NULL,NULL,'recibido',NULL,'2026-11-11 21:39:34'),(5,3,1,'recibido','resuelto','Se reparó la tubería. Gracias por reportarlo.','2026-11-12 21:39:34');
/*!40000 ALTER TABLE `reporte_comentarios` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `reporte_fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte_fotos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idreporte` bigint(20) unsigned NOT NULL,
  `ruta` varchar(255) NOT NULL COMMENT 'Ruta dentro del disco privado "reportes"',
  `mime` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reporte_fotos_idreporte_foreign` (`idreporte`),
  CONSTRAINT `reporte_fotos_idreporte_foreign` FOREIGN KEY (`idreporte`) REFERENCES `reportes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `reporte_fotos` WRITE;
/*!40000 ALTER TABLE `reporte_fotos` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte_fotos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `reportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reportes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idcategoria` bigint(20) unsigned NOT NULL,
  `idarea` bigint(20) unsigned DEFAULT NULL,
  `idcomunidad` bigint(20) unsigned DEFAULT NULL,
  `nombre` varchar(120) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `descripcion` text NOT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'recibido',
  `ip` varchar(45) DEFAULT NULL,
  `fecha_cierre` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reportes_idcategoria_foreign` (`idcategoria`),
  KEY `reportes_idarea_foreign` (`idarea`),
  KEY `reportes_idcomunidad_foreign` (`idcomunidad`),
  KEY `reportes_estado_index` (`estado`),
  CONSTRAINT `reportes_idarea_foreign` FOREIGN KEY (`idarea`) REFERENCES `areas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reportes_idcategoria_foreign` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`id`),
  CONSTRAINT `reportes_idcomunidad_foreign` FOREIGN KEY (`idcomunidad`) REFERENCES `comunidades` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `reportes` WRITE;
/*!40000 ALTER TABLE `reportes` DISABLE KEYS */;
INSERT INTO `reportes` VALUES (1,1,1,3,'MARIA LOPEZ','55551001','Bache grande frente a la escuela; los carros se desvían.','Frente a la escuela','recibido',NULL,NULL,'2026-11-09 21:39:34','2026-11-09 21:39:34'),(2,2,2,2,'JUAN PEREZ','55551002','Tres lámparas apagadas en la calle principal desde hace una semana.','Calle principal','en_proceso',NULL,NULL,'2026-11-10 21:39:34','2026-11-10 21:39:34'),(3,4,3,4,'ANA GARCIA','55551003','Fuga de agua en la tubería de la esquina.','Esquina del parque','resuelto',NULL,'2026-11-12 21:39:34','2026-11-11 21:39:34','2026-11-11 21:39:34');
/*!40000 ALTER TABLE `reportes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo_usuario` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `idarea` bigint(20) unsigned DEFAULT NULL,
  `baja` timestamp NULL DEFAULT NULL COMMENT 'Fecha en que se dio de baja; NULL = activo',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_idarea_foreign` (`idarea`),
  CONSTRAINT `users_idarea_foreign` FOREIGN KEY (`idarea`) REFERENCES `areas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@atencionciudadana.test','$2y$10$TTJFHiAQdUdYJbd29tXSMeG7MMCQDRW6vnWlRelnMOmThMQYZsHN6',1,NULL,NULL,NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34'),(2,'Encargado de Mantenimiento','mantenimiento@atencionciudadana.test','$2y$10$DwFREsB88YaznUAjRdHJKOH8hOQW67aoPAF9AVRRFXk8Avgrq.SK6',0,1,NULL,NULL,'2026-11-12 21:39:34','2026-11-12 21:39:34');
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

