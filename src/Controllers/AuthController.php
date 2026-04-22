<?php
/**
 * Contrôleur d'authentification.
 *
 * @package App\Controllers
 */

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Employe;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLogin(): void
    {
        // Si déjà connecté, redirige vers l'accueil
        if (Session::isAuthenticated()) {
            $this->redirect('/');
        }

        $this->view('auth/login');
    }

    /**
     * Traite le formulaire de connexion.
     */
    public function login(): void
    {
        $email    = $this->input('email');
        $password = $this->input('password');

        // Vérification des champs
        if (!$email || !$password) {
            $this->redirectWithError('/login', 'Veuillez remplir tous les champs.');
            return;
        }

        // Recherche de l'employé par email
        $employe = Employe::findByEmail($email);

        if (!$employe || !password_verify($password, $employe['mot_de_passe'])) {
            $this->redirectWithError('/login', 'Email ou mot de passe incorrect.');
            return;
        }

        // Connexion réussie
        Session::login($employe);

        // Redirection selon le rôle
        if ($employe['role'] === 'admin') {
            $this->redirect('/admin');
        } else {
            $this->redirect('/');
        }
    }

    /**
     * Déconnexion.
     */
    public function logout(): void
    {
        Session::destroy();
        $this->redirectWithSuccess('/login', 'Vous êtes déconnecté.');
    }
}