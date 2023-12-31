<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->resource('users');
$routes->post('api/login', 'Login::auth',['filter' =>'cors']);
$routes->get('api/getuser', 'Login::getUser',['filter' =>'cors']);
$routes->post('api/logout', 'Login::logout',['filter' =>'cors']);

$routes->get('api/users', 'Users::index', ['filter' => 'cors']);
$routes->post('api/users', 'Users::create', ['filter' => 'cors']);
$routes->get('api/users/(:num)', 'Users::show/$1', ['filter' => 'cors']);
$routes->post('api/users/(:num)', 'Users::update/$1', ['filter' => 'cors']);
$routes->get('api/users/delete/(:num)', 'Users::delete/$1', ['filter' => 'cors']);

$routes->get('api/menu', 'Menu::index', ['filter' => 'cors']);
$routes->get('api/food', 'Menu::menuLanding', ['filter' => 'cors']);
$routes->post('api/menu', 'Menu::create', ['filter' => 'cors']);
$routes->get('api/menu/(:num)', 'Menu::show/$1', ['filter' => 'cors']);
$routes->post('api/menu/(:num)', 'Menu::update/$1', ['filter' => 'cors']);
$routes->get('api/menu/delete/(:num)', 'Menu::delete/$1', ['filter' => 'cors']);

$routes->get('api/restaurants', 'Restaurant::index', ['filter' => 'cors']);
$routes->post('api/restaurants', 'Restaurant::create', ['filter' => 'cors']);
$routes->get('api/restaurants/(:num)', 'Restaurant::show/$1', ['filter' => 'cors']);
$routes->post('api/restaurants/(:num)', 'Restaurant::update/$1', ['filter' => 'cors']);
$routes->get('api/restaurants/delete/(:num)', 'Restaurant::delete/$1', ['filter' => 'cors']);

$routes->get('api/reviews', 'Review::index', ['filter' => 'cors']);
$routes->post('api/reviews', 'Review::create', ['filter' => 'cors']);
$routes->get('api/reviews/(:num)', 'Review::show/$1', ['filter' => 'cors']);
$routes->post('api/reviews/(:num)', 'Review::update/$1', ['filter' => 'cors']);
$routes->get('api/reviews/delete/(:num)', 'Review::delete/$1', ['filter' => 'cors']);

$routes->get('api/reservation', 'Reservation::index', ['filter' => 'cors']);
$routes->post('api/reservation', 'Reservation::create', ['filter' => 'cors']);
$routes->post('api/reserv-order', 'Reservation::createOrder', ['filter' => 'cors']);
$routes->get('api/reservation/(:num)', 'Reservation::show/$1', ['filter' => 'cors']);
$routes->post('api/reservation/(:num)', 'Reservation::update/$1', ['filter' => 'cors']);
$routes->get('api/reservation/delete/(:num)', 'Reservation::delete/$1', ['filter' => 'cors']);

$routes->get('api/chef', 'Chef::index', ['filter' => 'cors']);
$routes->post('api/chef', 'Chef::create', ['filter' => 'cors']);
$routes->get('api/chef/(:num)', 'Chef::show/$1', ['filter' => 'cors']);
$routes->post('api/chef/(:num)', 'Chef::update/$1', ['filter' => 'cors']);
$routes->get('api/chef/delete/(:num)', 'Chef::delete/$1', ['filter' => 'cors']);

$routes->get('api/contact', 'Contact::index', ['filter' => 'cors']);
$routes->post('api/contact', 'Contact::create', ['filter' => 'cors']);
$routes->get('api/contact/(:num)', 'Contact::show/$1', ['filter' => 'cors']);
$routes->post('api/contact/(:num)', 'Contact::update/$1', ['filter' => 'cors']);
$routes->get('api/contact/delete/(:num)', 'Contact::delete/$1', ['filter' => 'cors']);