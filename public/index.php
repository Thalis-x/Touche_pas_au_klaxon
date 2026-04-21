<?php
/**
 * Front Controller - point d'entrée unique de l'application.
 *
 * Toutes les requêtes HTTP sont redirigées ici via .htaccess.
 *
 * @author Sarri
 */

declare(strict_types=1);

use App\Core\Session;
use Buki\Router\Router;

// Autoloader Composer
require __DIR__ . '/../vendor/autoload.php';

// Gestion des erreurs selon l'environnement
$config = require __DIR__ . '/../config/app.php';

if ($config['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Démarrage de la session
Session::start();

// Routeur
$router = new Router([
    'namespace' => 'App\\Controllers',
]);

require __DIR__ . '/../src/routes.php';

$router->run();