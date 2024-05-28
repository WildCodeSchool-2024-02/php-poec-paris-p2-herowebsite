CREATE TABLE `story` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL
);

CREATE TABLE `scene` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `background` TEXT
  `story_id` INT NOT NULL
);

CREATE TABLE `choice` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `body` VARCHAR(30),
  `scene_id` INT NOT NULL,
  `next_scene_id` INT
);

CREATE TABLE `dialogue_line` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `body` TEXT,
  `character_id` VARCHAR(30) NOT NULL,
  `scene_id` INT NOT NULL
);

CREATE TABLE `character` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(30) NOT NULL,
  `sprite` TEXT
);

CREATE TABLE `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(30) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `fontsize` INT,
  `textspeed` INT
);

CREATE TABLE `history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `updated_at` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  `choice_id` INT NOT NULL
);

ALTER TABLE `scene` ADD FOREIGN KEY (`story_id`) REFERENCES `story` (`id`);
ALTER TABLE `choice` ADD FOREIGN KEY (`scene_id`) REFERENCES `scene` (`id`);
ALTER TABLE `dialogue_line` ADD FOREIGN KEY (`scene_id`) REFERENCES `scene` (`id`);
ALTER TABLE `dialogue_line` ADD FOREIGN KEY (`character_id`) REFERENCES `character` (`id`);
ALTER TABLE `history` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
ALTER TABLE `history` ADD FOREIGN KEY (`choice_id`) REFERENCES `choice` (`id`);
