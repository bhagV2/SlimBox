<?php

namespace App\Services;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $pdo = null;

    // Créer ou réutiliser la connexion à la base de données.
    public static function getConnection(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $host = $_ENV['DB_HOST'] ?? null;
        $name = $_ENV['DB_NAME'] ?? null;
        $user = $_ENV['DB_USER'] ?? null;
        $pass = $_ENV['DB_PASS'] ?? null;

        if ($host === null || $name === null || $user === null || $pass === null) {
            throw new RuntimeException('Variables DB_HOST, DB_NAME, DB_USER et DB_PASS manquantes dans l\'environnement.');
        }

        $dsn = 'mysql:host=' . $host . ';dbname=' . $name . ';charset=utf8mb4';

        try {
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            throw new RuntimeException('Impossible de se connecter à la base de données.', 0, $exception);
        }

        return self::$pdo;
    }
}
