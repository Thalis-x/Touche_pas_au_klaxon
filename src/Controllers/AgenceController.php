<?php
/**
 * Contrôleur CRUD des agences.
 *
 * @package App\Controllers
 */

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Agence;

class AgenceController extends Controller
{
    /**
     * Liste des agences.
     */
    public function index(): void
    {
        $this->requireAdmin();

        $agences = Agence::findAllSorted();

        $this->view('admin/agence/index', [
            'agences' => $agences,
        ]);
    }

    /**
     * Affiche le formulaire de création d'une agence.
     */
    public function showCreate(): void
    {
        $this->requireAdmin();

        $this->view('admin/agence/create');
    }

    /**
     * Traite la création d'une agence.
     */
    public function create(): void
    {
        $this->requireAdmin();

        $nomVille = $this->input('nom_ville');

        if (!$nomVille) {
            $this->redirectWithError('/admin/agences/create', 'Le nom de la ville est obligatoire.');
            return;
        }

        Agence::create($nomVille);

        $this->redirectWithSuccess('/admin/agences', "L'agence a été créée.");
    }

    /**
     * Affiche le formulaire de modification d'une agence.
     */
    public function showEdit(int $id): void
    {
        $this->requireAdmin();

        $agence = Agence::findById($id);

        if (!$agence) {
            $this->redirectWithError('/admin/agences', 'Agence introuvable.');
            return;
        }

        $this->view('admin/agence/edit', [
            'agence' => $agence,
        ]);
    }

    /**
     * Traite la modification d'une agence.
     */
    public function update(int $id): void
    {
        $this->requireAdmin();

        $nomVille = $this->input('nom_ville');

        if (!$nomVille) {
            $this->redirectWithError('/admin/agences/edit/' . $id, 'Le nom de la ville est obligatoire.');
            return;
        }

        Agence::updateNom($id, $nomVille);

        $this->redirectWithSuccess('/admin/agences', "L'agence a été modifiée.");
    }

    /**
     * Supprime une agence.
     */
    public function delete(int $id): void
    {
        $this->requireAdmin();

        try {
            Agence::deleteById($id);
            $this->redirectWithSuccess('/admin/agences', "L'agence a été supprimée.");
        } catch (\Exception $e) {
            $this->redirectWithError('/admin/agences', "Impossible de supprimer cette agence (des trajets y sont liés).");
        }
    }
}