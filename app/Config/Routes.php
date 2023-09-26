<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController::index');
$routes->post('/api/login', 'UserController::login');
$routes->post('/api/create-user', 'UserController::createUser');
$routes->get('/api/get-user', 'UserController::getUser',['filter' => 'auth']);
$routes->get('/api/get-todos', 'TodoController::index', ['filter' => 'auth']);
$routes->post('/api/create-todo' , 'TodoController::create',['filter' => 'auth']);
$routes->post('/api/change-status', 'TodoController::changeStatus', ['filter'=> 'auth']);