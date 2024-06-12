-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: storyteller
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

-- ------------------------------------------------------
-- Configuration Initiale
-- ------------------------------------------------------
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

-- ------------------------------------------------------
-- Structure des Tables
-- ------------------------------------------------------

-- Structure de la table `character`
DROP TABLE IF EXISTS `character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `character` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `sprite` TEXT,
  `story_id` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`),
  CONSTRAINT `character_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Structure de la table `choice`
DROP TABLE IF EXISTS `choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `choice` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `body` VARCHAR(255) NOT NULL,
  `scene_id` INT NOT NULL,
  `next_scene_id` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scene_id` (`scene_id`),
  CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`scene_id`) REFERENCES `scene` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Structure de la table `dialogue_line`
DROP TABLE IF EXISTS `dialogue_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dialogue_line` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `body` VARCHAR(255) NOT NULL,
  `character_id` INT NOT NULL,
  `scene_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `scene_id` (`scene_id`),
  KEY `character_id` (`character_id`),
  CONSTRAINT `dialogue_line_ibfk_1` FOREIGN KEY (`scene_id`) REFERENCES `scene` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dialogue_line_ibfk_2` FOREIGN KEY (`character_id`) REFERENCES `character` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Structure de la table `history`
DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  `choice_id` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `choice_id` (`choice_id`),
  CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `history_ibfk_2` FOREIGN KEY (`choice_id`) REFERENCES `choice` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Structure de la table `scene`
DROP TABLE IF EXISTS `scene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scene` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `background` TEXT,
  `story_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`),
  CONSTRAINT `scene_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Structure de la table `story`
DROP TABLE IF EXISTS `story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `story` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Structure de la table `user`
DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `fontsize` INT DEFAULT NULL,
  `textspeed` INT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- ------------------------------------------------------
-- Insertion des Données
-- ------------------------------------------------------

-- Insertion des données dans `character`
LOCK TABLES `character` WRITE;
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
INSERT INTO `character` VALUES
  (1,'Alice','sprite_alice.png',1),
  (2,'Le Gardien','sprite_guardian.png',1),
  (3,'L\'Ancien','sprite_ancient.png',1),
  (4,'Léa','sprite_lea.png',2),
  (5,'Le Guide','sprite_guide.png',2),
  (6,'Le Sage','sprite_sage.png',2);
/*!40000 ALTER TABLE `character` ENABLE KEYS */;
UNLOCK TABLES;

-- Insertion des données dans `choice`
LOCK TABLES `choice` WRITE;
/*!40000 ALTER TABLE `choice` DISABLE KEYS */;
INSERT INTO `choice` VALUES
  (1,'Avancer dans la forêt',1,2),
  (2,'Retourner en arrière',1,1),
  (3,'Prendre le chemin de droite',2,3),
  (4,'Prendre le chemin de gauche',2,5),
  (5,'Parler à l\'Ancien',3,4),
  (6,'Ignorer l\'Ancien',3,5),
  (7,'Entrer dans la cité',6,7),
  (8,'Retourner en arrière',6,6),
  (9,'Explorer la place',7,8),
  (10,'Suivre le chemin ombragé',7,10),
  (11,'Parler au Sage',8,9),
  (12,'Ignorer le Sage',8,10);
/*!40000 ALTER TABLE `choice` ENABLE KEYS */;
UNLOCK TABLES;

-- Insertion des données dans `dialogue_line`
LOCK TABLES `dialogue_line` WRITE;
/*!40000 ALTER TABLE `dialogue_line` DISABLE KEYS */;
INSERT INTO `dialogue_line` VALUES
  (1,'Alice entre dans la forêt, curieuse mais prudente.',1,1),
  (2,'Le Gardien apparaît soudainement : "Bienvenue, jeune aventurière."',2,1),
  (3,'"Pour continuer, tu devras résoudre une énigme."',2,1),
  (4,'Alice arrive à un carrefour mystérieux.',1,2),
  (5,'L\'Ancien apparaît et dit : "Le choix que tu fais ici déterminera ton destin."',3,3),
  (6,'Alice fait son choix et trouve la paix.',1,4),
  (7,'Alice fait son choix et disparaît dans l\'oubli.',1,5),
  (8,'Léa arrive à l\'entrée de la cité perdue, émerveillée par ce qu\'elle voit.',4,6),
  (9,'Le Guide l\'accueille : "Bienvenue dans la cité perdue."',5,6),
  (10,'"Pour découvrir ses secrets, tu devras faire preuve de sagesse."',5,6),
  (11,'Léa atteint la place centrale.',4,7),
  (12,'Le Sage apparaît et dit : "Le choix que tu fais ici changera ton avenir."',6,8),
  (13,'Léa choisit le bon chemin et découvre un trésor caché.',4,9),
  (14,'Léa fait un choix erroné et se perd dans les mystères de la cité.',4,10);
/*!40000 ALTER TABLE `dialogue_line` ENABLE KEYS */;
UNLOCK TABLES;

-- Insertion des données dans `history`
LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

-- Insertion des données dans `scene`
LOCK TABLES `scene` WRITE;
/*!40000 ALTER TABLE `scene` DISABLE KEYS */;
INSERT INTO `scene` VALUES
  (0,'[Work In Progress]','background_wip.png',0),
  (1,'Entrée de la forêt','background_forest_entrance.png',1),
  (2,'Carrefour mystérieux','background_crossroad.png',1),
  (3,'Rencontre avec l\'Ancien','background_ancient_meeting.png',1),
  (4,'Fin heureuse','background_happy_end.png',1),
  (5,'Fin tragique','background_tragic_end.png',1),
  (6,'Entrée de la cité','background_city_entrance.png',2),
  (7,'Place centrale','background_central_square.png',2),
  (8,'Temple abandonné','background_abandoned_temple.png',2),
  (9,'Trésor découvert','background_treasure_discovered.png',2),
  (10,'Fin mystérieuse','background_mysterious_end.png',2);
/*!40000 ALTER TABLE `scene` ENABLE KEYS */;
UNLOCK TABLES;

-- Insertion des données dans `story`
LOCK TABLES `story` WRITE;
/*!40000 ALTER TABLE `story` DISABLE KEYS */;
INSERT INTO `story` VALUES
  (1,'L\'énigme de la forêt enchantée'),
  (2,'Le secret de la cité perdue');
/*!40000 ALTER TABLE `story` ENABLE KEYS */;
UNLOCK TABLES;

-- Insertion des données dans `user`
LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

-- ------------------------------------------------------
-- Configuration Finale
-- ------------------------------------------------------
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-06 16:43:07
