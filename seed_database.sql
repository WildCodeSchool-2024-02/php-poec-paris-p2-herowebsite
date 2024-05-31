-- Début de la transaction
START TRANSACTION;

-- Insertion de l'histoire
INSERT INTO `story` (`name`)
VALUES ('L\'énigme de la forêt enchantée');

-- Récupération de l'ID de l'histoire insérée
SET @story_id = LAST_INSERT_ID();

-- Insertion des personnages
INSERT INTO `character` (`name`, `sprite`)
VALUES
    ('Alice', 'sprite_alice.png'),
    ('Le Gardien', 'sprite_guardian.png'),
    ('L\'Ancien', 'sprite_ancient.png');

-- Récupération des IDs des personnages
SET @alice_id = (SELECT id FROM `character` WHERE `name` = 'Alice');
SET @guardian_id = (SELECT id FROM `character` WHERE `name` = 'Le Gardien');
SET @ancient_id = (SELECT id FROM `character` WHERE `name` = 'L\'Ancien');

-- Insertion des scènes
INSERT INTO `scene` (`name`, `background`, `story_id`)
VALUES
    ('Entrée de la forêt', 'background_forest_entrance.png', @story_id),
    ('Carrefour mystérieux', 'background_crossroad.png', @story_id),
    ('Rencontre avec l\'Ancien', 'background_ancient_meeting.png', @story_id),
    ('Fin heureuse', 'background_happy_end.png', @story_id),
    ('Fin tragique', 'background_tragic_end.png', @story_id);

-- Récupération des IDs des scènes
SET @scene1_id = (SELECT id FROM `scene` WHERE `name` = 'Entrée de la forêt');
SET @scene2_id = (SELECT id FROM `scene` WHERE `name` = 'Carrefour mystérieux');
SET @scene3_id = (SELECT id FROM `scene` WHERE `name` = 'Rencontre avec l\'Ancien');
SET @scene4_id = (SELECT id FROM `scene` WHERE `name` = 'Fin heureuse');
SET @scene5_id = (SELECT id FROM `scene` WHERE `name` = 'Fin tragique');

-- Insertion des lignes de dialogue
INSERT INTO `dialogue_line` (`body`, `character_id`, `scene_id`)
VALUES
    ('Alice entre dans la forêt, curieuse mais prudente.', @alice_id, @scene1_id),
    ('Le Gardien apparaît soudainement : "Bienvenue, jeune aventurière."', @guardian_id, @scene1_id),
    ('"Pour continuer, tu devras résoudre une énigme."', @guardian_id, @scene1_id),
    ('Alice arrive à un carrefour mystérieux.', @alice_id, @scene2_id),
    ('L\'Ancien apparaît et dit : "Le choix que tu fais ici déterminera ton destin."', @ancient_id, @scene3_id),
    ('Alice fait son choix et trouve la paix.', @alice_id, @scene4_id),
    ('Alice fait son choix et disparaît dans l\'oubli.', @alice_id, @scene5_id);

-- Insertion des choix
INSERT INTO `choice` (`body`, `scene_id`, `next_scene_id`)
VALUES
    ('Avancer dans la forêt', @scene1_id, @scene2_id),
    ('Retourner en arrière', @scene1_id, @scene1_id), -- Ajouté pour fournir un deuxième choix
    ('Prendre le chemin de droite', @scene2_id, @scene3_id),
    ('Prendre le chemin de gauche', @scene2_id, @scene5_id),
    ('Parler à l\'Ancien', @scene3_id, @scene4_id), -- Exemple de choix pour la scène 3
    ('Ignorer l\'Ancien', @scene3_id, @scene5_id); -- Exemple de deuxième choix pour la scène 3

-- Commit de la transaction
COMMIT;
