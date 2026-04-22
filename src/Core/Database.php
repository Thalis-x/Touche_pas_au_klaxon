<?php
/**
 * Classe d'accès à la base de données (Singleton).
 *
 * @package App\Core
 */

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    /** @var PDO|null Instance unique. */
    private static ?PDO $instance = null;

    /**
     * Constructeur privé (Singleton).
     */
    private function __construct()
    {
    }

    /**
     * Retourne l'instance PDO unique.
     *
     * @return PDO
     * @throws RuntimeException Si la connexion échoue
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/database.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['user'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                throw new RuntimeException(
                    'Échec de connexion à la base de données : ' . $e->getMessage()
                );
            }
        }

        return self::$instance;
    }

    /**
     * Empêche le clonage (Singleton).
     */
    private function __clone()
    {
    }
}