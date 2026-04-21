<?php
/**
 * Modèle Trajet.
 *
 * @package App\Models
 */

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Trajet extends Model
{
    protected const TABLE = 'trajet';
    protected const PRIMARY_KEY = 'id_trajet';

    /**
     * Récupère les trajets disponibles (places > 0 et date future).
     * Triés par date de départ croissante.
     *
     * @return array<int,array<string,mixed>>
     */
    public static function findDisponibles(): array
    {
        $sql = '
            SELECT t.*,
                   dep.nom_ville AS ville_depart,
                   arr.nom_ville AS ville_arrivee
            FROM trajet t
            INNER JOIN agence dep ON t.id_agence_depart = dep.id_agence
            INNER JOIN agence arr ON t.id_agence_arrivee = arr.id_agence
            WHERE t.nb_places_disponibles > 0
              AND t.date_heure_depart > NOW()
            ORDER BY t.date_heure_depart ASC
        ';
        return self::db()->query($sql)->fetchAll();
    }

    /**
     * Récupère tous les trajets avec les noms des villes (pour l'admin).
     *
     * @return array<int,array<string,mixed>>
     */
    public static function findAllWithVilles(): array
    {
        $sql = '
            SELECT t.*,
                   dep.nom_ville AS ville_depart,
                   arr.nom_ville AS ville_arrivee,
                   e.nom AS employe_nom,
                   e.prenom AS employe_prenom
            FROM trajet t
            INNER JOIN agence dep ON t.id_agence_depart = dep.id_agence
            INNER JOIN agence arr ON t.id_agence_arrivee = arr.id_agence
            INNER JOIN employe e ON t.id_employe = e.id_employe
            ORDER BY t.date_heure_depart ASC
        ';
        return self::db()->query($sql)->fetchAll();
    }

    /**
     * Récupère un trajet avec toutes ses infos (villes + employé).
     *
     * @return array<string,mixed>|null
     */
    public static function findWithDetails(int $id): ?array
    {
        $sql = '
            SELECT t.*,
                   dep.nom_ville AS ville_depart,
                   arr.nom_ville AS ville_arrivee,
                   e.nom AS employe_nom,
                   e.prenom AS employe_prenom,
                   e.email AS employe_email,
                   e.telephone AS employe_telephone
            FROM trajet t
            INNER JOIN agence dep ON t.id_agence_depart = dep.id_agence
            INNER JOIN agence arr ON t.id_agence_arrivee = arr.id_agence
            INNER JOIN employe e ON t.id_employe = e.id_employe
            WHERE t.id_trajet = :id
            LIMIT 1
        ';
        $stmt = self::db()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    /**
     * Crée un nouveau trajet.
     *
     * @param array<string,mixed> $data
     */
    public static function create(array $data): int
    {
        return self::insert([
            'date_heure_depart'     => $data['date_heure_depart'],
            'date_heure_arrivee'    => $data['date_heure_arrivee'],
            'nb_places_total'       => $data['nb_places_total'],
            'nb_places_disponibles' => $data['nb_places_disponibles'],
            'id_employe'            => $data['id_employe'],
            'id_agence_depart'      => $data['id_agence_depart'],
            'id_agence_arrivee'     => $data['id_agence_arrivee'],
        ]);
    }

    /**
     * Met à jour un trajet.
     *
     * @param array<string,mixed> $data
     */
    public static function updateTrajet(int $id, array $data): bool
    {
        return self::update($id, [
            'date_heure_depart'     => $data['date_heure_depart'],
            'date_heure_arrivee'    => $data['date_heure_arrivee'],
            'nb_places_total'       => $data['nb_places_total'],
            'nb_places_disponibles' => $data['nb_places_disponibles'],
            'id_agence_depart'      => $data['id_agence_depart'],
            'id_agence_arrivee'     => $data['id_agence_arrivee'],
        ]);
    }
}