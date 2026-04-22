<?php
/**
 * Crée la base de données de test.
 */

$pdo = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$pdo->exec('DROP DATABASE IF EXISTS touche_pas_au_klaxon_test');
$pdo->exec('CREATE DATABASE touche_pas_au_klaxon_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
$pdo->exec('USE touche_pas_au_klaxon_test');

// Créer les tables directement
$pdo->exec("
    CREATE TABLE agence (
        id_agence   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nom_ville   VARCHAR(100) NOT NULL UNIQUE
    ) ENGINE=InnoDB
");

$pdo->exec("
    CREATE TABLE employe (
        id_employe      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nom             VARCHAR(80)  NOT NULL,
        prenom          VARCHAR(80)  NOT NULL,
        email           VARCHAR(150) NOT NULL UNIQUE,
        mot_de_passe    VARCHAR(255) NOT NULL,
        telephone       VARCHAR(20)  NOT NULL,
        role            ENUM('utilisateur','admin') NOT NULL DEFAULT 'utilisateur'
    ) ENGINE=InnoDB
");

$pdo->exec("
    CREATE TABLE trajet (
        id_trajet               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        date_heure_depart       DATETIME    NOT NULL,
        date_heure_arrivee      DATETIME    NOT NULL,
        nb_places_total         TINYINT UNSIGNED NOT NULL,
        nb_places_disponibles   TINYINT UNSIGNED NOT NULL,
        id_employe              INT UNSIGNED NOT NULL,
        id_agence_depart        INT UNSIGNED NOT NULL,
        id_agence_arrivee       INT UNSIGNED NOT NULL,
        CONSTRAINT fk_test_trajet_employe
            FOREIGN KEY (id_employe) REFERENCES employe(id_employe) ON DELETE CASCADE,
        CONSTRAINT fk_test_trajet_agence_depart
            FOREIGN KEY (id_agence_depart) REFERENCES agence(id_agence) ON DELETE RESTRICT,
        CONSTRAINT fk_test_trajet_agence_arrivee
            FOREIGN KEY (id_agence_arrivee) REFERENCES agence(id_agence) ON DELETE RESTRICT,
        CONSTRAINT chk_test_agences_differentes
            CHECK (id_agence_depart <> id_agence_arrivee),
        CONSTRAINT chk_test_dates_coherentes
            CHECK (date_heure_arrivee > date_heure_depart),
        CONSTRAINT chk_test_places_coherentes
            CHECK (nb_places_disponibles <= nb_places_total AND nb_places_total > 0)
    ) ENGINE=InnoDB
");

echo "Base de test créée avec succès.\n";