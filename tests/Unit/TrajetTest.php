<?php
/**
 * Tests unitaires pour les opérations d'écriture sur les trajets.
 */

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class TrajetTest extends TestCase
{
    /**
     * Test de création d'un trajet.
     */
    public function testCreateTrajet(): void
    {
        $this->seedBase();

        self::$pdo->exec(
            "INSERT INTO trajet (date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee)
             VALUES ('2026-12-01 08:00:00', '2026-12-01 13:00:00', 4, 3, 1, 1, 2)"
        );

        $stmt = self::$pdo->query("SELECT * FROM trajet WHERE id_trajet = 1");
        $trajet = $stmt->fetch();

        $this->assertNotFalse($trajet);
        $this->assertEquals(4, $trajet['nb_places_total']);
        $this->assertEquals(3, $trajet['nb_places_disponibles']);
    }

    /**
     * Test de modification d'un trajet.
     */
    public function testUpdateTrajet(): void
    {
        $this->seedBase();

        self::$pdo->exec(
            "INSERT INTO trajet (id_trajet, date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee)
             VALUES (1, '2026-12-01 08:00:00', '2026-12-01 13:00:00', 4, 3, 1, 1, 2)"
        );

        self::$pdo->exec("UPDATE trajet SET nb_places_disponibles = 2 WHERE id_trajet = 1");

        $stmt = self::$pdo->query("SELECT * FROM trajet WHERE id_trajet = 1");
        $trajet = $stmt->fetch();

        $this->assertEquals(2, $trajet['nb_places_disponibles']);
    }

    /**
     * Test de suppression d'un trajet.
     */
    public function testDeleteTrajet(): void
    {
        $this->seedBase();

        self::$pdo->exec(
            "INSERT INTO trajet (id_trajet, date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee)
             VALUES (1, '2026-12-01 08:00:00', '2026-12-01 13:00:00', 4, 3, 1, 1, 2)"
        );

        self::$pdo->exec("DELETE FROM trajet WHERE id_trajet = 1");

        $stmt = self::$pdo->query("SELECT * FROM trajet WHERE id_trajet = 1");
        $this->assertFalse($stmt->fetch());
    }

    /**
     * Test qu'on ne peut pas créer un trajet avec la même agence départ et arrivée.
     */
    public function testAgencesDifferentes(): void
    {
        $this->seedBase();

        $this->expectException(\PDOException::class);
        self::$pdo->exec(
            "INSERT INTO trajet (date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee)
             VALUES ('2026-12-01 08:00:00', '2026-12-01 13:00:00', 4, 3, 1, 1, 1)"
        );
    }

    /**
     * Test qu'on ne peut pas arriver avant de partir.
     */
    public function testDatesCoherentes(): void
    {
        $this->seedBase();

        $this->expectException(\PDOException::class);
        self::$pdo->exec(
            "INSERT INTO trajet (date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee)
             VALUES ('2026-12-01 13:00:00', '2026-12-01 08:00:00', 4, 3, 1, 1, 2)"
        );
    }

    /**
     * Test que les places disponibles ne dépassent pas le total.
     */
    public function testPlacesCoherentes(): void
    {
        $this->seedBase();

        $this->expectException(\PDOException::class);
        self::$pdo->exec(
            "INSERT INTO trajet (date_heure_depart, date_heure_arrivee, nb_places_total, nb_places_disponibles, id_employe, id_agence_depart, id_agence_arrivee)
             VALUES ('2026-12-01 08:00:00', '2026-12-01 13:00:00', 4, 5, 1, 1, 2)"
        );
    }
}