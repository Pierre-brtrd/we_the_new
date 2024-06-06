-- MySQL dump 10.13  Distrib 8.0.34, for macos13 (x86_64)
--
-- Host: localhost    Database: wethenew_dev
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20240526123458',NULL,NULL),('DoctrineMigrations\\Version20240527035629',NULL,NULL),('DoctrineMigrations\\Version20240527035818',NULL,NULL),('DoctrineMigrations\\Version20240527161824',NULL,NULL),('DoctrineMigrations\\Version20240529041108',NULL,NULL),('DoctrineMigrations\\Version20240529075102',NULL,NULL),('DoctrineMigrations\\Version20240529131634',NULL,NULL),('DoctrineMigrations\\Version20240529180638',NULL,NULL),('DoctrineMigrations\\Version20240529195122','2024-05-29 21:51:32',35),('DoctrineMigrations\\Version20240529201309','2024-05-29 22:13:19',54),('DoctrineMigrations\\Version20240530121503','2024-05-30 14:15:25',74),('DoctrineMigrations\\Version20240530122759','2024-05-30 14:43:10',18),('DoctrineMigrations\\Version20240530161014','2024-05-30 18:10:27',72),('DoctrineMigrations\\Version20240531080658','2024-05-31 10:08:37',36),('DoctrineMigrations\\Version20240603191606','2024-06-03 21:16:14',107),('DoctrineMigrations\\Version20240604162036','2024-06-04 18:20:50',106),('DoctrineMigrations\\Version20240604195453','2024-06-04 21:57:20',41),('DoctrineMigrations\\Version20240604201953','2024-06-04 22:19:59',93),('DoctrineMigrations\\Version20240604204452','2024-06-04 22:44:56',67),('DoctrineMigrations\\Version20240604211950','2024-06-04 23:19:54',33),('DoctrineMigrations\\Version20240604212132','2024-06-04 23:24:16',22),('DoctrineMigrations\\Version20240605074802','2024-06-05 09:48:09',68),('DoctrineMigrations\\Version20240605095423','2024-06-05 11:54:29',26),('DoctrineMigrations\\Version20240606075400','2024-06-06 09:54:51',120);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gender` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gender`
--

LOCK TABLES `gender` WRITE;
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` VALUES (1,'Homme','2024-05-27 17:37:46',NULL,1),(2,'Femme','2024-05-27 17:37:53',NULL,1),(4,'Enfant','2024-05-27 18:03:20',NULL,1);
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marque`
--

DROP TABLE IF EXISTS `marque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marque`
--

LOCK TABLES `marque` WRITE;
/*!40000 ALTER TABLE `marque` DISABLE KEYS */;
INSERT INTO `marque` VALUES (1,'Air Jordan','air-jordan',NULL,'air-jordan-6658b42fb0903645890200.webp','2024-05-27 18:39:53','2024-05-30 19:15:27',1),(2,'Adidas','adidas',NULL,'addidas-6658b4291ffc7902300337.webp','2024-05-27 18:55:27','2024-05-30 19:15:21',1),(4,'Nike','nike',NULL,'nike-6658b41e47b0d351090412.webp','2024-05-29 06:27:24','2024-05-30 19:15:10',1),(5,'New balance','new-balance',NULL,'new-balance-6658b43b14c4d585071742.webp','2024-05-30 19:15:39','2024-05-30 19:15:39',1);
/*!40000 ALTER TABLE `marque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `marque_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D79572D94827B9B2` (`marque_id`),
  CONSTRAINT `FK_D79572D94827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model`
--

LOCK TABLES `model` WRITE;
/*!40000 ALTER TABLE `model` DISABLE KEYS */;
INSERT INTO `model` VALUES (1,4,'Nike Dunk','nike-dunk',1,'2024-05-29 06:28:18','2024-05-30 19:56:54','nike-dunk-low-medium-olive-1-d1470d25-7906-4f28-be51-c00b7ae71b2e-6658bde623642105428649.webp'),(2,1,'Air Jordan 4','air-jordan-4',1,'2024-05-29 11:21:16','2024-05-30 19:57:28','air-jordan-4-red-cement-1-6658be08691ae475927416.webp'),(4,2,'Adidas Campus','adidas-campus',1,'2024-05-30 19:55:47','2024-05-30 19:55:47','adidas-campus-00s-black-white-gum-enfant1-6658bda38aa49073317825.webp'),(5,4,'Nike Air force 1','nike-air-force-1',1,'2024-05-30 19:58:17','2024-05-30 19:58:17','air-force-1-low-07-triple-white-348189-6658be3979766839421017.webp'),(6,5,'New Balance 2002 R','new-balance-2002-r',1,'2024-05-30 19:59:09','2024-05-30 19:59:09','new-balance-2002r-protection-pack-black-1-1-6658be6d25afd275003634.webp'),(7,1,'Air Jordan 1','air-jordan-1',1,'2024-05-30 19:59:46','2024-05-30 19:59:46','air-jordan-1-low-og-sp-travis-scott-olive-1-6658be926d95e574724935.webp'),(8,4,'Air Max Plus TN','air-max-plus-tn',1,'2024-05-30 20:01:18','2024-05-30 20:01:18','nike-air-max-plus-yellow-pink-gradient-1-6658beeea2635166542997.webp');
/*!40000 ALTER TABLE `model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gender_id` int DEFAULT NULL,
  `model_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `authenticity` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD708A0E0` (`gender_id`),
  KEY `IDX_D34A04AD7975B7E7` (`model_id`),
  CONSTRAINT `FK_D34A04AD708A0E0` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`),
  CONSTRAINT `FK_D34A04AD7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,1,2,'Air Jordan Jumpman Jack TR Travis Scott Sail','air-jordan-jumpman-jack-tr-travis-scott-sail','et Travis Scott poursuivent leur collaboration avec la première signature shoe du rappeur de Houston, la Jumpman Jack.\r\n\r\nLa Air Jordan Jumpman Jack TR Travis Scott Sail se distingue par son design audacieux et ses matériaux de haute qualité. Cette sneaker combine harmonieusement des nuances de sail, accentuées par des détails marron et une touche de noir pour un look distinctif. Le Swoosh inversé emblématique de Travis Scott orne le côté, tandis que la semelle en gomme ajoute une finition classique et durable. Parfaite pour les amateurs de sneakers à la recherche d\'un style unique, cette collaboration continue de repousser les limites de la mode et du design.\r\n\r\nSKU : FZ8117-100\r\nDate de sortie : Mars 2024\r\n\r\nCouleur :\r\nBlanc\r\nMarron','AUTHENTICITÉ\r\n\r\nTous les produits vendus sur Wethenew sont authentiques. Avant d’arriver entre vos mains, ils ont été contrôlés par nos experts. Avant d\'arriver entre vos mains, tous les produits passent par un contrôle de qualité et d’authenticité.\r\n\r\nTous les produits proviennent directement de notre réseau de revendeurs partenaires, sélectionnés individuellement pour leur expérience. Ils vous sont livrés dans leur boîte d\'origine avec l\'ensemble des accessoires ainsi qu\'un scellé Wethenew qui permet de vous assurer que le produit a bien été controlé et envoyé par notre équipe.\r\n\r\nAttention : vous ne devez pas détacher le scellé avant d\'être absolument sûr.e que vous n\'allez pas retourner le produit, sinon votre demande de retour sera refusée.','2024-05-29 16:24:59',NULL,1),(2,2,1,'Nike dunk Low','nike-dunk-low','Nike Dunk Low',NULL,'2024-05-29 21:14:30',NULL,1),(4,1,2,'Air Jordan 4 Retro Cacao Wow','air-jordan-4-retro-cacao-wow','Modèle créé initialement en 1989, l\'incontournable  s\'approprie une nouvelle teinte.\r\n\r\nCette Air Jordan 4 Retro Cacao Wow affiche une tige marron et beige accompagné par des touches de bleu turquoise. S\'ensuit d\'une midsole blanc cassé partagée à une outsole beige. Par ailleurs nous remarquons des finitions sur la silhouette, des légères taches de noir viennent finaliser la semelle tandis que des touches de turquoise viennent s\'ajuster sur les lacets.\r\n\r\nUne déclinaison de plus pour l\'un des modèles les plus iconiques de  !\r\n\r\nSKU : FB2214-200\r\nDate de sortie : Septembre 2023\r\nColorway : CACAO WOW/GEODE TEAL/ALE BROWN/TWINE/SAIL/LUMINOUS GREEN\r\n\r\nCouleur :\r\nMarron','Tous les produits vendus sur Wethenew sont authentiques. Avant d’arriver entre vos mains, ils ont été contrôlés par nos experts. Avant d\'arriver entre vos mains, tous les produits passent par un contrôle de qualité et d’authenticité.\r\n\r\nTous les produits proviennent directement de notre réseau de revendeurs partenaires, sélectionnés individuellement pour leur expérience. Ils vous sont livrés dans leur boîte d\'origine avec l\'ensemble des accessoires ainsi qu\'un scellé Wethenew qui permet de vous assurer que le produit a bien été controlé et envoyé par notre équipe.\r\n\r\nAttention : vous ne devez pas détacher le scellé avant d\'être absolument sûr.e que vous n\'allez pas retourner le produit, sinon votre demande de retour sera refusée.','2024-05-30 19:12:11',NULL,1),(5,1,4,'Adidas Campus 00s Core Black (Noir)','adidas-campus-00s-core-black-noir','Après la  et la ,  met en avant une nouvelle silhouette inspirée du skate et des années 2000.\r\n\r\nLa Adidas Campus 00s Core Black (Noir) présente une base en suède noir, accompagnée de trois épaisses bandes blanches en cuir sur le panneau latéral, caractéristiques de la marque et accordées à la doublure ainsi qu\'aux brandings sur le heel tab et la languette. Proche de la Campus 80s, ce modèle dévoile également une semelle jaunie, pour accentuer l\'effet vintage, assortie d\'une outsole en gomme. \r\n\r\nCe modèle est livré avec une paire de lacets larges blancs et une autre paire de lacets fins supplémentaires.\r\n\r\nSKU : HQ8708\r\nDate de sortie : Février 2023\r\n\r\nCouleur :\r\nNoir',NULL,'2024-05-31 10:59:51',NULL,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_association`
--

DROP TABLE IF EXISTS `product_association`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_association` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `associated_product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_51AABFD34584665A` (`product_id`),
  KEY `IDX_51AABFD3AE33471B` (`associated_product_id`),
  CONSTRAINT `FK_51AABFD34584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_51AABFD3AE33471B` FOREIGN KEY (`associated_product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_association`
--

LOCK TABLES `product_association` WRITE;
/*!40000 ALTER TABLE `product_association` DISABLE KEYS */;
INSERT INTO `product_association` VALUES (13,4,1),(15,1,4),(16,1,2);
/*!40000 ALTER TABLE `product_association` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_64617F034584665A` (`product_id`),
  CONSTRAINT `FK_64617F034584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_image`
--

LOCK TABLES `product_image` WRITE;
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
INSERT INTO `product_image` VALUES (42,4,'air-jordan-4-retro-cacao-wow3-665990f88d766754278693.webp','2024-05-31 10:09:29','2024-05-31 10:57:28','',0),(43,4,'air-jordan-4-retro-cacao-wow-png-1-665990f88e409300417366.webp','2024-05-31 10:09:29','2024-05-31 10:57:28','',0),(44,4,'air-jordan-4-retro-cacao-wow-png-2-665990f88eda4212749519.webp','2024-05-31 10:09:29','2024-05-31 10:57:28','',0),(45,2,'nike-sb-dunk-low-futura-laboratories-bleached-aqua4-6659910f86798496544980.webp','2024-05-31 10:13:35','2024-05-31 10:57:51','',0),(46,2,'nike-sb-dunk-low-futura-laboratories-bleached-aqua3-6659910f87662545452436.webp','2024-05-31 10:13:35','2024-05-31 10:57:51','',0),(47,2,'nike-sb-dunk-low-futura-laboratories-bleached-aqua2-6659910f8826a709567654.webp','2024-05-31 10:13:35','2024-05-31 10:57:51','',0),(48,2,'nike-sb-dunk-low-futura-laboratories-bleached-aqua1-6659910f88c6c254379737.webp','2024-05-31 10:13:35','2024-05-31 10:57:51','',0),(49,1,'air-jordan-jumpman-jack-tr-travis-scott-sail12-6659914e551de364315417.webp','2024-05-31 10:15:51','2024-05-31 10:58:54','',0),(50,1,'air-jordan-jumpman-jack-tr-travis-scott-sail3-6659914e55f15214247288.webp','2024-05-31 10:15:51','2024-05-31 10:58:54','',0),(51,1,'air-jordan-jumpman-jack-tr-travis-scott-sail2-6659914e56718537183170.webp','2024-05-31 10:15:51','2024-05-31 10:58:54','',0),(52,1,'air-jordan-jumpman-jack-tr-travis-scott-sail1-6659914e5715d708330602.webp','2024-05-31 10:15:51','2024-05-31 10:58:54','',0),(53,5,'adidas-campus-00s-black-white-gum-enfant1-66599187ca9c4195620264.webp','2024-05-31 10:59:51','2024-05-31 10:59:51','',0);
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variant`
--

DROP TABLE IF EXISTS `product_variant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `price_ht` double NOT NULL,
  `size` double NOT NULL,
  `taxe_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_209AA41D4584665A` (`product_id`),
  KEY `IDX_209AA41D1AB947A4` (`taxe_id`),
  CONSTRAINT `FK_209AA41D1AB947A4` FOREIGN KEY (`taxe_id`) REFERENCES `taxe` (`id`),
  CONSTRAINT `FK_209AA41D4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variant`
--

LOCK TABLES `product_variant` WRITE;
/*!40000 ALTER TABLE `product_variant` DISABLE KEYS */;
INSERT INTO `product_variant` VALUES (3,1,870,43,1),(4,1,799.99,40,1),(5,2,220,40,1),(6,2,199.99,38,1),(7,4,420,42,1),(8,5,189,43,1);
/*!40000 ALTER TABLE `product_variant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxe`
--

DROP TABLE IF EXISTS `taxe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taxe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  `enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxe`
--

LOCK TABLES `taxe` WRITE;
/*!40000 ALTER TABLE `taxe` DISABLE KEYS */;
INSERT INTO `taxe` VALUES (1,'Tva 20%',0.2,1);
/*!40000 ALTER TABLE `taxe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (13,'admin@test.com','[\"ROLE_ADMIN\"]','$2y$13$dN9Cj8YgMf8TXyvDxI9gpeheE01fujoAmlwrFU.iNh9YwZidQXFfW','Pierre','Bertrand',NULL,NULL,'2024-05-26 22:28:11',NULL),(14,'martin.paul@laposte.net','[]','$2y$13$oL.Gw1p.L82lqdzq/FOqw.iLOIchIxkcXpxFbKVEbJ9dwAG9ERGqW','Anne','Bouvier',NULL,NULL,'2024-05-26 22:28:12',NULL),(15,'isabelle06@gilbert.com','[]','$2y$13$N.xZ/IRjDtAGR0oBVoRqGe2i0.ltM58j7Otsn/TRt6iXD9s7nBAQm','Aurélie','Roger',NULL,NULL,'2024-05-26 22:28:12',NULL),(16,'aime.chevalier@lebon.org','[]','$2y$13$pXQmW/GgrreBfTRaxivXJO5pR4S6O9Basp.fQ7qYj4Fb0xUGeOT2K','Arthur','Regnier',NULL,NULL,'2024-05-26 22:28:13',NULL),(17,'xgaillard@laposte.net','[]','$2y$13$02UU3jSXX7uHrDeYw2.oK.We/gNTXKxntChUlDyMiOtvBQ/jALk3q','Véronique','Leroux',NULL,NULL,'2024-05-26 22:28:13',NULL),(18,'gantoine@wanadoo.fr','[]','$2y$13$xj8KCBBFMB.8vc9iwGsoiu6VujnRab6I/lfbqcopUFx9VlkBBFJDi','Emmanuel','Guibert',NULL,NULL,'2024-05-26 22:28:14',NULL),(19,'marc.jourdan@boulanger.com','[]','$2y$13$O1HZnwxO1T7BCYnF.vMDl.NzyXZE9cYz3UKKZG7f/ioEOyLUiKpnK','Étienne','Potier',NULL,NULL,'2024-05-26 22:28:14',NULL),(20,'andre.bouvet@free.fr','[]','$2y$13$GHYSr1uIh4gaGZGjjiwbauSjjsYCo9pWkD2nuycmsvl0jCy0mCWSa','Charlotte','Bourdon',NULL,NULL,'2024-05-26 22:28:14',NULL),(21,'camille63@arnaud.com','[]','$2y$13$HcC/f3pWZ9vuZNpbFgHYqePKtmpck3Pzhj7mWg3XO2aXWmAK20MzW','Thérèse','Schneider',NULL,NULL,'2024-05-26 22:28:15',NULL),(22,'millet.anastasie@noos.fr','[]','$2y$13$STBmIzbg0Z0SVk9VilhRKuBpyiq1Qg8JHg2mTu1WKo2GQgtEFE9e.','Susan','Dumas',NULL,NULL,'2024-05-26 22:28:15',NULL),(23,'auguste.paris@aubert.fr','[]','$2y$13$m6aI6r.scR3QhuFOX/HV0OsYiNgmoNEjlLOYc1r.LSbxmJF0r50Du','Michel','Paris',NULL,NULL,'2024-05-26 22:28:16',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-06 11:50:10
