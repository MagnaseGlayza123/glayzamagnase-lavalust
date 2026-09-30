
<?php

$router->get('/', 'Welcome::index');

$router->get('/student', 'StudentController::index');
$router->get('/student/profile', 'StudentController::profile')->middleware('student');

$router->get('/users', 'UsersController::index');


// ==============================
// LAB 5 AUTHENTICATION ROUTES
// ==============================

$router->get('/login', 'AuthController::login');
$router->post('/login', 'AuthController::authenticate');
$router->get('/logout', 'AuthController::logout');


// ==============================
// LAB 5 WEB CRUD ROUTES
// ==============================

$router->get('/products', 'ProductsController::index')->middleware('auth');
$router->get('/products/create', 'ProductsController::create')->middleware('auth');
$router->post('/products/store', 'ProductsController::store')->middleware('auth');
$router->get('/products/edit/{id}', 'ProductsController::edit')->middleware('auth');
$router->post('/products/update/{id}', 'ProductsController::update')->middleware('auth');
$router->get('/products/delete/{id}', 'ProductsController::delete')->middleware('auth');


// ==============================
// LAB 6 API AUTHENTICATION ROUTES
// ==============================

$router->post('/api/login', 'ApiAuthController::login');
$router->post('/api/logout', 'ApiAuthController::logout');


// ==============================
// LAB 6 PRODUCT API ROUTES
// Protected by API authentication
// ==============================

$router->get('/api/products', 'ProductController::index')->middleware('api_auth');

$router->get('/api/products/{id}', 'ProductController::show')->midd

