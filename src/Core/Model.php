<?php
/**
 * Modèle abstrait avec CRUD générique.
 *
 * Les classes filles doivent définir les constantes TABLE et PRIMARY_KEY.
 *
 * @package App\Core
 */

declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Model
{
    /** @var string Nom de la table SQL. */
    protected const TABLE = '';

    /** @var string Nom de la clé primaire. */
    protected const PRIMARY_KEY = 'id';

    /**
     * Retourne la connexion PDO.
     */
    protected static function db(): PDO
    {
        return Database::getInstance();
    }

    /**
     * Récupère toutes les lignes.
     *
     * @return array<int,array<string,mixed>>
     */
    public static function findAll(): array
    {
        $sql = 'SELECT * FROM ' . static::TABLE;
        return self::db()->query($sql)->fetchAll();
    }

    /**
     * Récupère une ligne par son ID.
     *
     * @return array<string,mixed>|null
     */
    public static function findById(int $id): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE %s = :id LIMIT 1',
            static::TABLE,
            static::PRIMARY_KEY
        );
        $stmt = self::db()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    /**
     * Supprime une ligne par son ID.
     */
    public static function deleteById(int $id): bool
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s = :id',
            static::TABLE,
            static::PRIMARY_KEY
        );
        $stmt = self::db()->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Insère une ligne et retourne l'ID généré.
     *
     * @param array<string,mixed> $data Colonnes => valeurs
     */
    protected static function insert(array $data): int
    {
        $columns      = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            static::TABLE,
            $columns,
            $placeholders
        );
        $stmt = self::db()->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();

        return (int) self::db()->lastInsertId();
    }

    /**
     * Met à jour une ligne par son ID.
     *
     * @param array<string,mixed> $data Colonnes => valeurs
     */
    protected static function update(int $id, array $data): bool
    {
        $assignments = [];
        foreach (array_keys($data) as $key) {
            $assignments[] = "$key = :$key";
        }

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = :_pk',
            static::TABLE,
            implode(', ', $assignments),
            static::PRIMARY_KEY
        );
        $stmt = self::db()->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':_pk', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}