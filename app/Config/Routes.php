<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController::index');
$routes->post('/api/login', 'UserController::login');
$routes->post('/api/create-user', 'UserController::createUser');
$routes->get('/api/read-user', 'UserController::readUser', ['filter' => 'authMiddleware']);
$routes->get('/api/get-user', 'UserController::getUser',['filter' => 'auth']);