<?php
/**
 * Gestion de la session et des messages flash.
 *
 * @package App\Core
 */

declare(strict_types=1);

namespace App\Core;

class Session
{
    /**
     * Démarre la session PHP si pas déjà active.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Stocke une valeur en session.
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Récupère une valeur de la session.
     *
     * @param mixed $default Valeur par défaut si la clé n'existe pas
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Vérifie si une clé existe en session.
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Supprime une clé de la session.
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Détruit la session (déconnexion).
     */
    public static function destroy(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    // -----------------------------------------------------------------
    // Authentification
    // -----------------------------------------------------------------

    /**
     * Connecte un utilisateur.
     *
     * @param array<string,mixed> $user Données de l'employé
     */
    public static function login(array $user): void
    {
        session_regenerate_id(true);
        self::set('user', $user);
    }

    /**
     * Vérifie si un utilisateur est connecté.
     */
    public static function isAuthenticated(): bool
    {
        return self::has('user');
    }

    /**
     * Vérifie si l'utilisateur connecté est admin.
     */
    public static function isAdmin(): bool
    {
        $user = self::get('user');
        return is_array($user) && ($user['role'] ?? '') === 'admin';
    }

    /**
     * Retourne l'utilisateur connecté ou null.
     *
     * @return array<string,mixed>|null
     */
    public static function user(): ?array
    {
        $user = self::get('user');
        return is_array($user) ? $user : null;
    }

    // -----------------------------------------------------------------
    // Messages flash
    // -----------------------------------------------------------------

    /**
     * Enregistre un message flash.
     *
     * @param string $type    'success', 'error', 'info'
     * @param string $message Le message à afficher
     */
    public static function flash(string $type, string $message): void
    {
        $_SESSION['_flash'][$type][] = $message;
    }

    /**
     * Récupère et supprime les messages flash.
     *
     * @return array<string,string[]>
     */
    public static function consumeFlash(): array
    {
        $messages = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $messages;
    }
}