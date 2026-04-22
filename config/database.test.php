<?php
/**
 * Configuration BDD pour les tests.
 * Utilise une base séparée pour ne pas polluer les données de dev.
 */

return [
    'host'     => 'localhost',
    'dbname'   => 'touche_pas_au_klaxon_test',
    'user'     => 'root',
    'password' => '',
    'charset'  => 'utf8mb4',
];