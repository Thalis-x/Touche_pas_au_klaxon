<?php
/**
 * Contrôleur du tableau de bord administrateur.
 *
 * @package App\Controllers
 */

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Employe;
use App\Models\Trajet;

class AdminController extends Controller
{
    /**
     * Tableau de bord admin (redirige vers la liste des trajets).
     */
    public function dashboard(): void
    {
        $this->requireAdmin();
        $this->redirect('/admin/trajets');
    }

    /**
     * Liste des employés.
     */
    public function listEmployes(): void
    {
        $this->requireAdmin();

        $employes = Employe::findAll();

        $this->view('admin/employe/index', [
            'employes' => $employes,
        ]);
    }

    /**
     * Liste des trajets (tous, y compris passés et complets).
     */
    public function listTrajets(): void
    {
        $this->requireAdmin();

        $trajets = Trajet::findAllWithVilles();

        $this->view('admin/trajet/index', [
            'trajets' => $trajets,
        ]);
    }

    /**
     * Suppression d'un trajet par l'admin.
     */
    public function deleteTrajet(int $id): void
    {
        $this->requireAdmin();

        Trajet::deleteById($id);

        $this->redirectWithSuccess('/admin/trajets', 'Le trajet a été supprimé.');
    }
}