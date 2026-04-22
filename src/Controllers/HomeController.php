<?php
/**
 * Contrôleur de la page d'accueil.
 *
 * @package App\Controllers
 */

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Trajet;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec les trajets disponibles.
     */
    public function index(): void
    {
        // Si l'utilisateur est connecté, on charge les détails (employé inclus)
        if (Session::isAuthenticated()) {
            $trajets = Trajet::findDisponiblesWithDetails();
        } else {
            $trajets = Trajet::findDisponibles();
        }

        $this->view('home/index', [
            'trajets' => $trajets,
        ]);
    }
}