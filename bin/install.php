<?php
/**
 * Script d'installation de la base de données.
 *
 * Usage : php bin/install.php
 *
 * @author Sarri
 */

declare(strict_types=1);

$config = require __DIR__ . '/../config/database.php';

$dsnRoot = sprintf('mysql:host=%s;charset=utf8mb4', $config['host']);
$dsnDb   = sprintf(
    'mysql:host=%s;dbname=%s;charset=utf8mb4',
    $config['host'],
    $config['dbname']
);

$defaultPassword = 'password123';

// --- Étape 1 : Création du schéma ---
echo "[1/4] Création du schéma...\n";

try {
    $pdo = new PDO($dsnRoot, $config['user'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $schema = file_get_contents(__DIR__ . '/../sql/01_schema.sql');
    $pdo->exec($schema);
} catch (PDOException $e) {
    exit("Erreur : " . $e->getMessage() . "\n");
}

// --- Étape 2 : Insertion des agences ---
echo "[2/4] Insertion des agences...\n";

$pdo = new PDO($dsnDb, $config['user'], $config['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$seedAgences = file_get_contents(__DIR__ . '/../sql/02_seed_agences.sql');
$pdo->exec($seedAgences);

// --- Étape 3 : Import des employés ---
echo "[3/4] Import des employés...\n";

$csvPath = __DIR__ . '/../sql/data/employes.csv';
$handle  = fopen($csvPath, 'r');

$stmt = $pdo->prepare(
    'INSERT INTO employe (nom, prenom, telephone, email, mot_de_passe, role)
     VALUES (:nom, :prenom, :tel, :email, :mdp, :role)'
);

$hash  = password_hash($defaultPassword, PASSWORD_BCRYPT);
$index = 0;

while (($row = fgetcsv($handle)) !== false) {
    if (count($row) < 4) {
        continue;
    }
    [$nom, $prenom, $tel, $email] = $row;

    $role = ($index === 0) ? 'admin' : 'utilisateur';

    $stmt->execute([
        ':nom'    => $nom,
        ':prenom' => $prenom,
        ':tel'    => $tel,
        ':email'  => $email,
        ':mdp'    => $hash,
        ':role'   => $role,
    ]);
    $index++;
}
fclose($handle);

echo "  -> $index employés insérés (mot de passe : $defaultPassword)\n";

// --- Étape 4 : Trajets de test ---
echo "[4/4] Création des trajets de test...\n";

$stmt = $pdo->prepare(
    'INSERT INTO trajet
       (date_heure_depart, date_heure_arrivee, nb_places_total,
        nb_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee)
     VALUES (:dep, :arr, :total, :dispo, :emp, :ag_dep, :ag_arr)'
);

$trajets = [
    [2,  5, 4, 3, 2, 1, 2],
    [3,  7, 3, 2, 3, 1, 3],
    [5,  4, 4, 4, 4, 2, 4],
    [7,  3, 3, 1, 5, 9, 1],
    [10, 2, 2, 2, 2, 1, 10],
    [1,  3, 5, 0, 3, 6, 7],
    [-3, 5, 4, 2, 3, 1, 2],
];

foreach ($trajets as $t) {
    $depart  = (new DateTime())->modify("{$t[0]} days")->setTime(8, 0);
    $arrivee = (clone $depart)->modify("+{$t[1]} hours");

    $stmt->execute([
        ':dep'    => $depart->format('Y-m-d H:i:s'),
        ':arr'    => $arrivee->format('Y-m-d H:i:s'),
        ':total'  => $t[2],
        ':dispo'  => $t[3],
        ':emp'    => $t[4],
        ':ag_dep' => $t[5],
        ':ag_arr' => $t[6],
    ]);
}

echo "  -> " . count($trajets) . " trajets insérés\n";
echo "\nInstallation terminée !\n";
echo "Admin : alexandre.martin@email.fr / password123\n";
echo "User  : sophie.dubois@email.fr / password123\n";