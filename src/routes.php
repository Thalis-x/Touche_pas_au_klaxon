<?php
/**
 * Déclaration des routes de l'application.
 *
 * @var \Buki\Router\Router $router
 */

declare(strict_types=1);

// Pages publiques
$router->get('/', 'HomeController@index');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Zone utilisateur connecté
$router->get('/trajet/create', 'TrajetController@showCreate');
$router->post('/trajet/create', 'TrajetController@create');
$router->get('/trajet/edit/:id', 'TrajetController@showEdit');
$router->post('/trajet/edit/:id', 'TrajetController@update');
$router->post('/trajet/delete/:id', 'TrajetController@delete');
$router->get('/trajet/details/:id', 'TrajetController@details');

// Zone administrateur
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/employes', 'AdminController@listEmployes');
$router->get('/admin/agences', 'AgenceController@index');
$router->get('/admin/agences/create', 'AgenceController@showCreate');
$router->post('/admin/agences/create', 'AgenceController@create');
$router->get('/admin/agences/edit/:id', 'AgenceController@showEdit');
$router->post('/admin/agences/edit/:id', 'AgenceController@update');
$router->post('/admin/agences/delete/:id', 'AgenceController@delete');
$router->get('/admin/trajets', 'AdminController@listTrajets');
$router->post('/admin/trajets/delete/:id', 'AdminController@deleteTrajet');

// Page 404
$router->notFound(function () {
    http_response_code(404);
    \App\Core\View::render('errors/404');
});