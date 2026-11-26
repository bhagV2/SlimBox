SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS slimbox CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE slimbox;

-- Réinitialiser les tables avec ce script. Créer le compte MySQL avec create-user.sql.
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS amities;
DROP TABLE IF EXISTS utilisateurs;

CREATE TABLE utilisateurs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe_hash VARCHAR(255) NOT NULL,
    type_compte ENUM('utilisateur', 'administrateur') NOT NULL DEFAULT 'utilisateur',
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE amities (
    utilisateur_un_id INT UNSIGNED NOT NULL,
    utilisateur_deux_id INT UNSIGNED NOT NULL,
    demandeur_id INT UNSIGNED NOT NULL,
    statut ENUM('en_attente', 'acceptee') NOT NULL DEFAULT 'en_attente',
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (utilisateur_un_id, utilisateur_deux_id),
    INDEX idx_amities_utilisateur_deux_statut (utilisateur_deux_id, statut),
    INDEX idx_amities_demandeur_statut (demandeur_id, statut),
    CONSTRAINT fk_amities_utilisateur_un FOREIGN KEY (utilisateur_un_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    CONSTRAINT fk_amities_utilisateur_deux FOREIGN KEY (utilisateur_deux_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    CONSTRAINT fk_amities_demandeur FOREIGN KEY (demandeur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    expediteur_id INT UNSIGNED NOT NULL,
    destinataire_id INT UNSIGNED NOT NULL,
    sujet VARCHAR(150) NOT NULL,
    contenu TEXT NOT NULL,
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_expediteur FOREIGN KEY (expediteur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    CONSTRAINT fk_messages_destinataire FOREIGN KEY (destinataire_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    INDEX idx_messages_destinataire (destinataire_id, date_creation)
);

-- Utiliser ce mot de passe pour tous les comptes de démonstration : slimbox123
INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe_hash, type_compte) VALUES
('admin', '$2y$12$c3V4x0MK.636Lsmb9iyTPeP8cc81pB7SHOVZqWbb2cJgGcUlge5Pm', 'administrateur'),
('alice', '$2y$12$c3V4x0MK.636Lsmb9iyTPeP8cc81pB7SHOVZqWbb2cJgGcUlge5Pm', 'utilisateur'),
('bob', '$2y$12$c3V4x0MK.636Lsmb9iyTPeP8cc81pB7SHOVZqWbb2cJgGcUlge5Pm', 'utilisateur');

INSERT INTO amities (utilisateur_un_id, utilisateur_deux_id, demandeur_id, statut) VALUES
(2, 3, 2, 'acceptee');

INSERT INTO messages (expediteur_id, destinataire_id, sujet, contenu) VALUES
(1, 2, 'Bienvenue sur SlimBox', 'Salut Alice, ton compte est prêt.'),
(1, 3, 'Bienvenue sur SlimBox', 'Salut Bob, ton compte est prêt.'),
(2, 3, 'Premier message', 'Salut Bob, ça marche ?'),
(3, 2, 'Re: Premier message', 'Oui, tout fonctionne !');