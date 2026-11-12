CREATE DATABASE IF NOT EXISTS slimbox CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE slimbox;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_id INT UNSIGNED NOT NULL,
    recipient_id INT UNSIGNED NOT NULL,
    subject VARCHAR(150) NOT NULL,
    body TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_messages_recipient FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_messages_recipient (recipient_id, created_at)
);

-- Mot de passe de démo pour tous les comptes : slimbox123
INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@slimbox.local', '$2y$12$c3V4x0MK.636Lsmb9iyTPeP8cc81pB7SHOVZqWbb2cJgGcUlge5Pm', 'admin'),
('alice', 'alice@slimbox.local', '$2y$12$c3V4x0MK.636Lsmb9iyTPeP8cc81pB7SHOVZqWbb2cJgGcUlge5Pm', 'user'),
('bob',   'bob@slimbox.local',   '$2y$12$c3V4x0MK.636Lsmb9iyTPeP8cc81pB7SHOVZqWbb2cJgGcUlge5Pm', 'user');

INSERT INTO messages (sender_id, recipient_id, subject, body, is_read) VALUES
(1, 2, 'Bienvenue sur SlimBox', 'Salut Alice, ton compte est prêt.', 0),
(1, 3, 'Bienvenue sur SlimBox', 'Salut Bob, ton compte est prêt.', 0),
(2, 3, 'Premier message', 'Salut Bob, ça marche ?', 0),
(3, 2, 'Re: Premier message', 'Oui, tout fonctionne !', 1);