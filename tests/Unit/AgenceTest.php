<?php
/**
 * Tests unitaires pour les opérations d'écriture sur les agences.
 */

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class AgenceTest extends TestCase
{
    /**
     * Test de création d'une agence.
     */
    public function testCreateAgence(): void
    {
        self::$pdo->exec("INSERT INTO agence (nom_ville) VALUES ('Marseille')");

        $stmt = self::$pdo->query("SELECT * FROM agence WHERE nom_ville = 'Marseille'");
        $agence = $stmt->fetch();

        $this->assertNotFalse($agence);
        $this->assertEquals('Marseille', $agence['nom_ville']);
    }

    /**
     * Test de modification d'une agence.
     */
    public function testUpdateAgence(): void
    {
        self::$pdo->exec("INSERT INTO agence (id_agence, nom_ville) VALUES (1, 'Paris')");
        self::$pdo->exec("UPDATE agence SET nom_ville = 'Paris-Centre' WHERE id_agence = 1");

        $stmt = self::$pdo->query("SELECT * FROM agence WHERE id_agence = 1");
        $agence = $stmt->fetch();

        $this->assertEquals('Paris-Centre', $agence['nom_ville']);
    }

    /**
     * Test de suppression d'une agence.
     */
    public function testDeleteAgence(): void
    {
        self::$pdo->exec("INSERT INTO agence (id_agence, nom_ville) VALUES (1, 'Paris')");
        self::$pdo->exec("DELETE FROM agence WHERE id_agence = 1");

        $stmt = self::$pdo->query("SELECT * FROM agence WHERE id_agence = 1");
        $agence = $stmt->fetch();

        $this->assertFalse($agence);
    }

    /**
     * Test qu'on ne peut pas créer deux agences avec le même nom.
     */
    public function testUniqueNomVille(): void
    {
        self::$pdo->exec("INSERT INTO agence (nom_ville) VALUES ('Paris')");

        $this->expectException(\PDOException::class);
        self::$pdo->exec("INSERT INTO agence (nom_ville) VALUES ('Paris')");
    }
}