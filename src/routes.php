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

// Zone utilisateur connecté
$router->get('/trajet/create', function () {
    (new App\Controllers\TrajetController())->showCreate();
});
$router->post('/trajet/create', function () {
    (new App\Controllers\TrajetController())->create();
});
$router->get('/trajet/edit/:id', function ($id) {
    (new App\Controllers\TrajetController())->showEdit((int) $id);
});
$router->post('/trajet/edit/:id', function ($id) {
    (new App\Controllers\TrajetController())->update((int) $id);
});
$router->post('/trajet/delete/:id', function ($id) {
    (new App\Controllers\TrajetController())->delete((int) $id);
});