<?php
/**
 * Classe de base pour les tests avec accès BDD.
 */

declare(strict_types=1);

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected static PDO $pdo;

    /**
     * Connexion à la base de test avant tous les tests.
     */
    public static function setUpBeforeClass(): void
    {
        $config = require __DIR__ . '/../config/database.test.php';

        self::$pdo = new PDO(
            sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['host'], $config['dbname'], $config['charset']),
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    /**
     * Nettoie les tables avant chaque test.
     */
    protected function setUp(): void
    {
        self::$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
        self::$pdo->exec('TRUNCATE TABLE trajet');
        self::$pdo->exec('TRUNCATE TABLE employe');
        self::$pdo->exec('TRUNCATE TABLE agence');
        self::$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Insère des données de base pour les tests.
     */
    protected function seedBase(): void
    {
        // 2 agences
        self::$pdo->exec("INSERT INTO agence (id_agence, nom_ville) VALUES (1, 'Paris'), (2, 'Lyon')");

        // 1 employé
        $hash = password_hash('password123', PASSWORD_BCRYPT);
        self::$pdo->exec(
            "INSERT INTO employe (id_employe, nom, prenom, email, mot_de_passe, telephone, role)
             VALUES (1, 'Dupont', 'Jean', 'jean@test.fr', '$hash', '0612345678', 'utilisateur')"
        );
    }
}