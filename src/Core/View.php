<?php
/**
 * Moteur de rendu des vues.
 *
 * @package App\Core
 */

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class View
{
    /** Chemin vers le dossier des vues. */
    private const VIEWS_PATH = __DIR__ . '/../../views/';

    /**
     * Affiche une vue dans un layout.
     *
     * @param string $view   Chemin relatif (ex: 'home/index')
     * @param array<string,mixed> $data   Variables pour la vue
     * @param string $layout Layout à utiliser
     */
    public static function render(
        string $view,
        array $data = [],
        string $layout = 'layouts/main'
    ): void {
        $content = self::renderPartial($view, $data);

        $config = require __DIR__ . '/../../config/app.php';
        $data['content']   = $content;
        $data['appName']   = $config['name'];
        $data['copyright'] = $config['copyright'];
        $data['user']      = Session::user();
        $data['flash']     = Session::consumeFlash();

        self::renderPartial($layout, $data, false);
    }

    /**
     * Rend une vue partielle (retourne ou affiche le HTML).
     *
     * @param string $view   Chemin relatif
     * @param array<string,mixed> $data   Variables
     * @param bool   $return true = retourne le HTML, false = l'affiche
     *
     * @return string
     * @throws RuntimeException Si la vue n'existe pas
     */
    public static function renderPartial(
        string $view,
        array $data = [],
        bool $return = true
    ): string {
        $path = self::VIEWS_PATH . $view . '.php';

        if (!is_file($path)) {
            throw new RuntimeException("Vue introuvable : $view");
        }

        extract($data, EXTR_SKIP);

        if ($return) {
            ob_start();
            include $path;
            return (string) ob_get_clean();
        }

        include $path;
        return '';
    }

    /**
     * Échappe une valeur pour l'affichage HTML (anti-XSS).
     *
     * Usage dans les vues : <?= View::e($variable) ?>
     */
    public static function e(mixed $value): string
    {
        return htmlspecialchars(
            (string) $value,
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );
    }
}