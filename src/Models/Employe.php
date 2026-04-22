<?php
/**
 * Modèle Employe.
 *
 * @package App\Models
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Employe extends Model
{
    protected const TABLE = 'employe';
    protected const PRIMARY_KEY = 'id_employe';

    /**
     * Recherche un employé par son email.
     *
     * @return array<string,mixed>|null
     */
    public static function findByEmail(string $email): ?array
    {
        $stmt = self::db()->prepare(
            'SELECT * FROM employe WHERE email = :email LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }
}