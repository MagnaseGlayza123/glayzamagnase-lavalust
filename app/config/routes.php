<?php

$router->get('/', 'Welcome::index');

$router->get('/student', 'StudentController::index');
$router->get('/student/profile', 'StudentController::profile')->middleware('student');

$router->get('/users', 'UsersController::index');

$router->get('/login', 'AuthController::login');
$router->post('/login', 'AuthController::authenticate');
$router->get('/logout', 'AuthController::logout');

$router->get('/products', 'ProductsController::index')->middleware('auth');
$router->get('/products/create', 'ProductsController::create')->middleware('auth');
$router->post('/products/store', 'ProductsController::store')->middleware('auth');
$router->get('/products/edit/{id}', 'ProductsController::edit')->middleware('auth');
$router->post('/products/update/{id}', 'ProductsController::update')->middleware('auth');
$router->get('/products/delete/{id}', 'ProductsController::delete')->middleware('auth');

?>