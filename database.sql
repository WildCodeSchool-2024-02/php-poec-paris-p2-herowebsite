-- Début de la transaction
START TRANSACTION;

-- Suppression des tables existantes si elles existent déjà
DROP TABLE IF EXISTS `history`;
DROP TABLE IF EXISTS `dialogue_line`;
DROP TABLE IF EXISTS `choice`;
DROP TABLE IF EXISTS `scene`;
DROP TABLE IF EXISTS `story`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `character`;


-- Création de la table 'story'
CREATE TABLE IF NOT EXISTS `story` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL
);

-- Création de la table 'scene'
CREATE TABLE IF NOT EXISTS `scene` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `background` TEXT,
  `story_id` INT NOT NULL
);

-- Création de la table 'choice'
CREATE TABLE IF NOT EXISTS `choice` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `body` VARCHAR(30) NOT NULL,
  `scene_id` INT NOT NULL,
  `next_scene_id` INT
);

-- Création de la table 'dialogue_line'
CREATE TABLE IF NOT EXISTS `dialogue_line` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `body` VARCHAR(255) NOT NULL,
  `character_id` INT NOT NULL,
  `scene_id` INT NOT NULL
);

-- Création de la table 'character'
CREATE TABLE IF NOT EXISTS `character` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `sprite` TEXT,
  `story_id` INT
);

-- Création de la table 'user'
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(30) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `fontsize` INT,
  `textspeed` INT
);

-- Création de la table 'history'
CREATE TABLE IF NOT EXISTS `history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP ,
  `user_id` INT NOT NULL,
  `choice_id` INT
);

-- Ajout des clés étrangères
ALTER TABLE `scene` ADD FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE;
ALTER TABLE `choice` ADD FOREIGN KEY (`scene_id`) REFERENCES `scene` (`id`) ON DELETE CASCADE;
ALTER TABLE `dialogue_line` ADD FOREIGN KEY (`scene_id`) REFERENCES `scene` (`id`) ON DELETE CASCADE;
ALTER TABLE `dialogue_line` ADD FOREIGN KEY (`character_id`) REFERENCES `character` (`id`) ON DELETE CASCADE;
ALTER TABLE `history` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
ALTER TABLE `history` ADD FOREIGN KEY (`choice_id`) REFERENCES `choice` (`id`) ON DELETE CASCADE;
ALTER TABLE `character` ADD FOREIGN KEY (`story_id`) REFERENCES `story` (`id`) ON DELETE CASCADE;

-- Commit de la transaction
COMMIT;
