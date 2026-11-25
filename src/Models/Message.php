<?php

namespace App\Models;

use App\Services\Database;

class Message
{
    // Récupérer les messages échangés entre deux utilisateurs.
    public static function conversation(int $userId, int $otherUserId): array
    {
        // Donner un nom différent à chaque paramètre pour PDO.
        $statement = Database::getConnection()->prepare(
            'SELECT m.expediteur_id, m.contenu, m.date_creation, expediteur.nom_utilisateur AS nom_expediteur
             FROM messages AS m
             JOIN utilisateurs AS expediteur ON expediteur.id = m.expediteur_id
             WHERE (m.expediteur_id = :expediteur_id AND m.destinataire_id = :destinataire_id)
                OR (m.expediteur_id = :expediteur_id_bis AND m.destinataire_id = :destinataire_id_bis)
             ORDER BY m.date_creation, m.id'
        );
        $statement->execute([
            'expediteur_id' => $userId,
            'destinataire_id' => $otherUserId,
            'expediteur_id_bis' => $otherUserId,
            'destinataire_id_bis' => $userId,
        ]);

        return $statement->fetchAll();
    }

    // Enregistrer un nouveau message.
    public static function send(int $senderId, int $recipientId, string $body): void
    {
        $statement = Database::getConnection()->prepare(
            'INSERT INTO messages (expediteur_id, destinataire_id, sujet, contenu)
             VALUES (:expediteur_id, :destinataire_id, :sujet, :contenu)'
        );
        $statement->execute([
            'expediteur_id' => $senderId,
            'destinataire_id' => $recipientId,
            'sujet' => 'Discussion privée',
            'contenu' => $body,
        ]);
    }
}
