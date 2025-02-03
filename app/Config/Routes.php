<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// app/Config/Routes.php
$routes->get('/auth/login', 'Auth\LoginController::index');
$routes->post('/auth/login', 'Auth\LoginController::login');
$routes->get('/auth/logout', 'Auth\LoginController::logout');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'authGuard']); // Apply auth filter to dashboard



$routes->get('hr/employees', 'HR\EmployeeController::index', ['filter' => 'authGuard']);
$routes->get('hr/employees/create', 'HR\EmployeeController::create', ['filter' => 'authGuard']);
$routes->post('hr/employees/store', 'HR\EmployeeController::store', ['filter' => 'authGuard']);
$routes->get('hr/employees/edit/(:num)', 'HR\EmployeeController::edit/$1', ['filter' => 'authGuard']);
$routes->post('hr/employees/update', 'HR\EmployeeController::update', ['filter' => 'authGuard']);
$routes->get('hr/employees/delete/(:num)', 'HR\EmployeeController::delete/$1', ['filter' => 'authGuard']);

