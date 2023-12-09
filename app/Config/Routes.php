<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->resource('users');
$routes->get('api/users', 'Users::index', ['filter' => 'cors']);
$routes->post('api/users', 'Users::create', ['filter' => 'cors']);
$routes->get('api/users/(:num)', 'Users::show/$1', ['filter' => 'cors']);
$routes->post('api/users/(:num)', 'Users::update/$1', ['filter' => 'cors']);
$routes->get('api/users/delete/(:num)', 'Users::delete/$1', ['filter' => 'cors']);
$routes->post('api/login', 'Login::auth',['filter' =>'cors']);
$routes->resource('menu');
