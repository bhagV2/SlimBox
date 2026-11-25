<?php

namespace App\Models;

use App\Services\Database;
use RuntimeException;

class User
{
    // Initialiser un utilisateur avec ses données.
    public function __construct(
        private int $id,
        private string $username,
        private string $passwordHash,
        private string $role = 'utilisateur'
    ) {
    }

    // Créer un utilisateur.
    public static function create(string $username, string $password, string $role = 'utilisateur'): void
    {
        $pdo = Database::getConnection();
        $passwordHash = self::hashPassword($password);
        $statement = $pdo->prepare(
            'INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe_hash, type_compte)
             VALUES (:nom_utilisateur, :mot_de_passe_hash, :type_compte)'
        );
        $statement->execute([
            'nom_utilisateur' => $username,
            'mot_de_passe_hash' => $passwordHash,
            'type_compte' => $role,
        ]);

    }

    // Récupérer tous les utilisateurs.
    public static function all(): array
    {
        $rows = Database::getConnection()->query('SELECT * FROM utilisateurs ORDER BY id')->fetchAll();
        $users = [];

        foreach ($rows as $row) {
            $users[] = self::fromRow($row);
        }

        return $users;
    }

    // Rechercher un utilisateur par son identifiant.
    public static function find(int $id): ?self
    {
        $statement = Database::getConnection()->prepare('SELECT * FROM utilisateurs WHERE id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return self::fromRow($row);
    }

    // Rechercher un utilisateur par son nom d’utilisateur.
    public static function findByUsername(string $username): ?self
    {
        $statement = Database::getConnection()->prepare(
            'SELECT * FROM utilisateurs WHERE nom_utilisateur = :nom_utilisateur'
        );
        $statement->execute(['nom_utilisateur' => $username]);
        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return self::fromRow($row);
    }

    // Modifier un utilisateur.
    public function update(string $username, ?string $password = null): void
    {
        $passwordHash = $this->passwordHash;

        if ($password !== null) {
            $passwordHash = self::hashPassword($password);
        }

        $statement = Database::getConnection()->prepare(
            'UPDATE utilisateurs
             SET nom_utilisateur = :nom_utilisateur,
                 mot_de_passe_hash = :mot_de_passe_hash
             WHERE id = :id'
        );
        $statement->execute([
            'nom_utilisateur' => $username,
            'mot_de_passe_hash' => $passwordHash,
            'id' => $this->id,
        ]);

        if ($statement->rowCount() === 0) {
            $user = self::find($this->id);

            if ($user === null) {
                throw new RuntimeException('Utilisateur introuvable.');
            }
        }

        $this->username = $username;
        $this->passwordHash = $passwordHash;
    }

    // Supprimer un utilisateur.
    public function delete(): bool
    {
        $statement = Database::getConnection()->prepare('DELETE FROM utilisateurs WHERE id = :id');
        $statement->execute(['id' => $this->id]);

        return $statement->rowCount() > 0;
    }

    // Vérifier le mot de passe fourni.
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    // Récupérer l’identifiant de l’utilisateur.
    public function getId(): int
    {
        return $this->id;
    }

    // Récupérer le nom d’utilisateur.
    public function getUsername(): string
    {
        return $this->username;
    }

    // Récupérer le rôle de l’utilisateur.
    public function getRole(): string
    {
        return $this->role;
    }

    // Construire un utilisateur à partir d’une ligne de la base de données.
    private static function fromRow(array $row): self
    {
        return new self(
            (int) $row['id'],
            $row['nom_utilisateur'],
            $row['mot_de_passe_hash'],
            $row['type_compte']
        );
    }

    // Hacher le mot de passe avant son enregistrement.
    private static function hashPassword(string $password): string
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if ($hash === false) {
            throw new RuntimeException('Impossible de sécuriser le mot de passe.');
        }

        return $hash;
    }
}
