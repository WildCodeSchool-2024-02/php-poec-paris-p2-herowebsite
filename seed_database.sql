-- Début de la transaction
START TRANSACTION;
-- Insertion de l'histoire
INSERT INTO `story` (`name`)
VALUES ('Le secret de la cité perdue');
-- Récupération de l'ID de l'histoire insérée
SET @story_id = LAST_INSERT_ID();
-- Insertion des personnages
INSERT INTO `character` (`name`, `sprite`)
VALUES ('Léa', 'sprite_lea.png'),
    ('Le Guide', 'sprite_guide.png'),
    ('Le Sage', 'sprite_sage.png');
-- Récupération des IDs des personnages
SET @lea_id = (
        SELECT id
        FROM `character`
        WHERE `name` = 'Léa'
    );
SET @guide_id = (
        SELECT id
        FROM `character`
        WHERE `name` = 'Le Guide'
    );
SET @sage_id = (
        SELECT id
        FROM `character`
        WHERE `name` = 'Le Sage'
    );
-- Insertion des scènes
INSERT INTO `scene` (`name`, `background`, `story_id`)
VALUES (
        'Entrée de la cité',
        'background_city_entrance.png',
        @story_id
    ),
    (
        'Place centrale',
        'background_central_square.png',
        @story_id
    ),
    (
        'Temple abandonné',
        'background_abandoned_temple.png',
        @story_id
    ),
    (
        'Trésor découvert',
        'background_treasure_discovered.png',
        @story_id
    ),
    (
        'Fin mystérieuse',
        'background_mysterious_end.png',
        @story_id
    );
-- Récupération des IDs des scènes
SET @scene1_id = (
        SELECT id
        FROM `scene`
        WHERE `name` = 'Entrée de la cité'
    );
SET @scene2_id = (
        SELECT id
        FROM `scene`
        WHERE `name` = 'Place centrale'
    );
SET @scene3_id = (
        SELECT id
        FROM `scene`
        WHERE `name` = 'Temple abandonné'
    );
SET @scene4_id = (
        SELECT id
        FROM `scene`
        WHERE `name` = 'Trésor découvert'
    );
SET @scene5_id = (
        SELECT id
        FROM `scene`
        WHERE `name` = 'Fin mystérieuse'
    );
-- Insertion des lignes de dialogue
INSERT INTO `dialogue_line` (`body`, `character_id`, `scene_id`)
VALUES (
        'Léa arrive à l\'entrée de la cité perdue, émerveillée par ce qu\'elle voit.',
        @lea_id,
        @scene1_id
    ),
    (
        'Le Guide l\'accueille : "Bienvenue dans la cité perdue."',
        @guide_id,
        @scene1_id
    ),
    (
        '"Pour découvrir ses secrets, tu devras faire preuve de sagesse."',
        @guide_id,
        @scene1_id
    ),
    (
        'Léa atteint la place centrale.',
        @lea_id,
        @scene2_id
    ),
    (
        'Le Sage apparaît et dit : "Le choix que tu fais ici changera ton avenir."',
        @sage_id,
        @scene3_id
    ),
    (
        'Léa choisit le bon chemin et découvre un trésor caché.',
        @lea_id,
        @scene4_id
    ),
    (
        'Léa fait un choix erroné et se perd dans les mystères de la cité.',
        @lea_id,
        @scene5_id
    );
-- Insertion des choix
INSERT INTO `choice` (`body`, `scene_id`, `next_scene_id`)
VALUES ('Entrer dans la cité', @scene1_id, @scene2_id),
    ('Retourner en arrière', @scene1_id, @scene1_id),
    -- Ajouté pour fournir un deuxième choix
    ('Explorer la place', @scene2_id, @scene3_id),
    (
        'Suivre le chemin ombragé',
        @scene2_id,
        @scene5_id
    ),
    ('Parler au Sage', @scene3_id, @scene4_id),
    -- Exemple de choix pour la scène 3
    ('Ignorer le Sage', @scene3_id, @scene5_id);
-- Exemple de deuxième choix pour la scène 3
-- Commit de la transaction
COMMIT;
