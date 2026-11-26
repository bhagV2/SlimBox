# SlimBox

SlimBox est un projet scolaire de messagerie réalisé avec PHP 8.1, Slim 4 et MySQL.
Il met en pratique les routes, les contrôleurs, les modèles et les vues d’une
application web.

## Fonctionnalités

- Création de compte, connexion et modification du compte.
- Demandes d’amis et conversations privées entre amis acceptés.
- Gestion des comptes par un administrateur.

## Lancer avec Docker sous Windows

Prérequis : Docker Desktop avec Docker Compose activé.

1. Créez le fichier `.env` depuis PowerShell, à la racine du projet :

   ```powershell
   Copy-Item .\config\env\.env.conf .\.env
   ```

2. Dans `.env`, remplacez `DB_PASS` et `MYSQL_ROOT_PASSWORD` par des mots de
   passe locaux. Laissez `APP_BASE_PATH` non défini pour accéder à l’application
   à la racine du site Docker.

3. Démarrez les conteneurs :

   ```powershell
   docker compose up --build -d
   ```

4. Ouvrez <http://localhost:8080>.

Compose démarre PHP/Apache et MySQL, et configure automatiquement la connexion
de l’application à la base. Les tables et comptes de démonstration sont créés
au premier démarrage. `create-user.sql` sert à une installation MySQL manuelle
et n’est pas utilisé par Docker.

Pour arrêter l’application, lancez `docker compose down`. Les données MySQL
restent conservées dans un volume. La commande `docker compose down -v` supprime
aussi ce volume et réinitialise la base au prochain démarrage.

## Comptes de démonstration

| Identifiant | Mot de passe | Rôle |
| --- | --- | --- |
| `admin` | `slimbox123` | Administrateur |
| `alice` | `slimbox123` | Utilisateur |
| `bob` | `slimbox123` | Utilisateur |

## Organisation

- `src/Routes/` : routes de l’application.
- `src/Controllers/` : traitement des requêtes.
- `src/Models/` : accès aux données.
- `src/Views/` : pages HTML.
- `public/` : point d’entrée, images et feuilles de style.
- `config/` : configuration et scripts SQL.

Les mots de passe sont hachés et les requêtes SQL utilisent PDO. Ce projet est
prévu pour une démonstration locale dans un cadre scolaire.
