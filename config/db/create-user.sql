CREATE DATABASE IF NOT EXISTS slimbox CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'slimboxUser'@'localhost' IDENTIFIED BY 'SuperSlimbox';
ALTER USER 'slimboxUser'@'localhost' IDENTIFIED BY 'SuperSlimbox';
GRANT SELECT, INSERT, UPDATE, DELETE ON slimbox.* TO 'slimboxUser'@'localhost';
