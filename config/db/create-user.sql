CREATE DATABASE IF NOT EXISTS slimbox CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Remplacer YOUR_STRONG_PASSWORD ici et dans DB_PASS du fichier .env.
CREATE USER IF NOT EXISTS 'slimboxUser'@'localhost' IDENTIFIED BY 'YOUR_STRONG_PASSWORD';
ALTER USER 'slimboxUser'@'localhost' IDENTIFIED BY 'YOUR_STRONG_PASSWORD';
GRANT SELECT, INSERT, UPDATE, DELETE ON slimbox.* TO 'slimboxUser'@'localhost';
