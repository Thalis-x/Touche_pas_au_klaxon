<?php
/**
 * Déclaration des routes de l'application.
 *
 * @var \Buki\Router\Router $router
 */

declare(strict_types=1);

// Pages publiques
$router->get('/', function () {
    (new App\Controllers\HomeController())->index();
});
$router->get('/login', function () {
    (new App\Controllers\AuthController())->showLogin();
});
$router->post('/login', function () {
    (new App\Controllers\AuthController())->login();
});
$router->get('/logout', function () {
    (new App\Controllers\AuthController())->logout();
});

// Les autres routes seront ajoutées au fur et à mesure
// qu'on crée les contrôleurs correspondants.