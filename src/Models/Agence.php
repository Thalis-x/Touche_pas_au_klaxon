<?php
/**
 * Modèle Agence.
 *
 * @package App\Models
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Agence extends Model
{
    protected const TABLE = 'agence';
    protected const PRIMARY_KEY = 'id_agence';

    /**
     * Récupère toutes les agences triées par nom.
     *
     * @return array<int,array<string,mixed>>
     */
    public static function findAllSorted(): array
    {
        return self::db()
            ->query('SELECT * FROM agence ORDER BY nom_ville ASC')
            ->fetchAll();
    }

    /**
     * Crée une nouvelle agence.
     */
    public static function create(string $nomVille): int
    {
        return self::insert(['nom_ville' => $nomVille]);
    }

    /**
     * Met à jour le nom d'une agence.
     */
    public static function updateNom(int $id, string $nomVille): bool
    {
        return self::update($id, ['nom_ville' => $nomVille]);
    }
}