<?php

// Charger les paramètres du fichier .env à la racine du projet.
Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2))->safeLoad();
