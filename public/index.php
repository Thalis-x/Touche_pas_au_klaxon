<?php
/**
 * Front Controller - point d'entrée unique de l'application.
 *
 * @author Sarri
 */

declare(strict_types=1);

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', '1');

use App\Core\Session;

require __DIR__ . '/../vendor/autoload.php';

Session::start();

$router = new \Buki\Router\Router();

require __DIR__ . '/../src/routes.php';

$router->run();