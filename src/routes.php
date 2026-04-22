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

// Zone administrateur
$router->get('/admin', function () {
    (new App\Controllers\AdminController())->dashboard();
});
$router->get('/admin/employes', function () {
    (new App\Controllers\AdminController())->listEmployes();
});
$router->get('/admin/agences', function () {
    (new App\Controllers\AgenceController())->index();
});
$router->get('/admin/agences/create', function () {
    (new App\Controllers\AgenceController())->showCreate();
});
$router->post('/admin/agences/create', function () {
    (new App\Controllers\AgenceController())->create();
});
$router->get('/admin/agences/edit/:id', function ($id) {
    (new App\Controllers\AgenceController())->showEdit((int) $id);
});
$router->post('/admin/agences/edit/:id', function ($id) {
    (new App\Controllers\AgenceController())->update((int) $id);
});
$router->post('/admin/agences/delete/:id', function ($id) {
    (new App\Controllers\AgenceController())->delete((int) $id);
});
$router->get('/admin/trajets', function () {
    (new App\Controllers\AdminController())->listTrajets();
});
$router->post('/admin/trajets/delete/:id', function ($id) {
    (new App\Controllers\AdminController())->deleteTrajet((int) $id);
});