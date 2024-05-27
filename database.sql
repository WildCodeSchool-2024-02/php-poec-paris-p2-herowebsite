CREATE TABLE `story` (
  `id` integer PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `scene` (
  `id` integer PRIMARY KEY,
  `name` varchar(255),
  `story_id` integer,
  `background` image
);

CREATE TABLE `choice` (
  `id` integer PRIMARY KEY,
  `body` text,
  `scene_id` integer,
  `next_scene_id` integer
);

CREATE TABLE `dialogue` (
  `id` integer PRIMARY KEY,
  `speaker` varchar(255),
  `body` text,
  `scene_id` integer,
  `sprite` image
);

CREATE TABLE `user` (
  `id` integer PRIMARY KEY,
  `name` varchar(255),
  `password` varchar(255),
  `fontsize` integer,
  `textspeed` integer
);

CREATE TABLE `history` (
  `id` integer PRIMARY KEY,
  `updated_at` datetime,
  `user_id` integer,
  `choice_id` integer
);

ALTER TABLE `scene` ADD FOREIGN KEY (`story_id`) REFERENCES `story` (`id`);

ALTER TABLE `scene` ADD FOREIGN KEY (`id`) REFERENCES `choice` (`scene_id`);

ALTER TABLE `user` ADD FOREIGN KEY (`id`) REFERENCES `history` (`user_id`);

ALTER TABLE `choice` ADD FOREIGN KEY (`id`) REFERENCES `history` (`choice_id`);

ALTER TABLE `scene` ADD FOREIGN KEY (`id`) REFERENCES `dialogue` (`scene_id`);
