-- =====================================================================
-- TOUCHE PAS AU KLAXON - Création du schéma
-- =====================================================================

DROP DATABASE IF EXISTS touche_pas_au_klaxon;
CREATE DATABASE touche_pas_au_klaxon
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE touche_pas_au_klaxon;

-- Table AGENCE
CREATE TABLE agence (
    id_agence   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom_ville   VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Table EMPLOYE
CREATE TABLE employe (
    id_employe      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(80)  NOT NULL,
    prenom          VARCHAR(80)  NOT NULL,
    email           VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(255) NOT NULL,
    telephone       VARCHAR(20)  NOT NULL,
    role            ENUM('utilisateur','admin') NOT NULL DEFAULT 'utilisateur'
) ENGINE=InnoDB;

-- Table TRAJET
CREATE TABLE trajet (
    id_trajet               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date_heure_depart       DATETIME    NOT NULL,
    date_heure_arrivee      DATETIME    NOT NULL,
    nb_places_total         TINYINT UNSIGNED NOT NULL,
    nb_places_disponibles   TINYINT UNSIGNED NOT NULL,
    id_employe              INT UNSIGNED NOT NULL,
    id_agence_depart        INT UNSIGNED NOT NULL,
    id_agence_arrivee       INT UNSIGNED NOT NULL,

    CONSTRAINT fk_trajet_employe
        FOREIGN KEY (id_employe) REFERENCES employe(id_employe)
        ON DELETE CASCADE,
    CONSTRAINT fk_trajet_agence_depart
        FOREIGN KEY (id_agence_depart) REFERENCES agence(id_agence)
        ON DELETE RESTRICT,
    CONSTRAINT fk_trajet_agence_arrivee
        FOREIGN KEY (id_agence_arrivee) REFERENCES agence(id_agence)
        ON DELETE RESTRICT,

    CONSTRAINT chk_agences_differentes
        CHECK (id_agence_depart <> id_agence_arrivee),
    CONSTRAINT chk_dates_coherentes
        CHECK (date_heure_arrivee > date_heure_depart),
    CONSTRAINT chk_places_coherentes
        CHECK (nb_places_disponibles <= nb_places_total AND nb_places_total > 0)
) ENGINE=InnoDB;

CREATE INDEX idx_trajet_depart ON trajet(date_heure_depart);