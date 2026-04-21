<?php
/**
 * Contrôleur abstrait.
 *
 * @package App\Core
 */

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    /**
     * Affiche une vue avec le layout.
     *
     * @param array<string,mixed> $data
     */
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    /**
     * Redirige vers une URL.
     */
    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    /**
     * Redirige avec un message flash de succès.
     */
    protected function redirectWithSuccess(string $path, string $message): void
    {
        Session::flash('success', $message);
        $this->redirect($path);
    }

    /**
     * Redirige avec un message flash d'erreur.
     */
    protected function redirectWithError(string $path, string $message): void
    {
        Session::flash('error', $message);
        $this->redirect($path);
    }

    /**
     * Exige que l'utilisateur soit connecté.
     */
    protected function requireAuth(): void
    {
        if (!Session::isAuthenticated()) {
            Session::flash('error', 'Vous devez être connecté pour accéder à cette page.');
            $this->redirect('/login');
        }
    }

    /**
     * Exige que l'utilisateur soit administrateur.
     */
    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (!Session::isAdmin()) {
            http_response_code(403);
            View::render('errors/403');
            exit;
        }
    }

    /**
     * Récupère une valeur POST nettoyée.
     */
    protected function input(string $key): ?string
    {
        $value = $_POST[$key] ?? null;
        return is_string($value) ? trim($value) : null;
    }
}