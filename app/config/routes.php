
<?php

$router->get('/', 'Welcome::index');


// ==============================
// STUDENT ROUTES
// ==============================

$router->get('/student', 'StudentController::index');

$router->get('/student/profile', 'StudentController::profile')
    ->middleware('student');


// ==============================
// USER MANAGEMENT
// ==============================

$router->get('/users', 'UsersController::index');


// ==============================
// LAB 5 AUTHENTICATION
// ==============================

$router->get('/login', 'AuthController::login');

$router->post('/login', 'AuthController::authenticate');

$router->get('/logout', 'AuthController::logout');


// ==============================
// LAB 5 WEB CRUD ROUTES
// ==============================

$router->get('/products', 'ProductsController::index')
    ->middleware('auth');

$router->get('/products/create', 'ProductsController::create')
    ->middleware('auth');

$router->post('/products/store', 'ProductsController::store')
    ->middleware('auth');

$router->get('/products/edit/{id}', 'ProductsController::edit')
    ->middleware('auth');

$router->post('/products/update/{id}', 'ProductsController::update')
    ->middleware('auth');

$router->get('/products/delete/{id}', 'ProductsController::delete')
    ->middleware('auth');


// ==============================
// LAB 6 API AUTHENTICATION
// ==============================

// Login
$router->post('/api/login', 'ApiAuthController::login');

// CORS preflight for login
$router->options('/api/login', 'ApiAuthController::login')
    ->middleware('cors');


// Logout
$router->post('/api/logout', 'ApiAuthController::logout');

// CORS preflight for logout
$router->options('/api/logout', 'ApiAuthController::logout')
    ->middleware('cors');


// ==============================
// LAB 6 PRODUCT API
// ==============================
//
// Authentication will be handled inside
// ProductController instead of api_auth
// middleware.
//
// This avoids the unsupported
// get_instance() / Database approach.
//

// GET all products
$router->get('/api/products', 'ProductController::index');

// OPTIONS for GET all products
$router->options('/api/products', 'ProductController::index')
    ->middleware('cors');


// GET single product
$router->get('/api/products/{id}', 'ProductController::show');

// OPTIONS for single product
$router->options('/api/products/{id}', 'ProductController::show')
    ->middleware('cors');


// POST create product
$router->post('/api/products', 'ProductController::store');


// PUT update product
$router->put('/api/products/{id}', 'ProductController::update');

// OPTIONS for PUT
$router->options('/api/products/{id}', 'ProductController::update')
    ->middleware('cors');


// PATCH update product
$router->patch('/api/products/{id}', 'ProductController::patch');


// DELETE product
$router->delete('/api/products/{id}', 'ProductController::delete');


// ==============================
// MIGRATION ROUTES
// ==============================

$router->get(
    'create-migration/{migration_class}',
    'MigrationController::create_migration'
);

$router->get(
    'migrate',
    'MigrationController::migrate'
);

$router->get(
    'rollback',
    'MigrationController::rollback'
);

$router->get(
    'rollback-all',
    'MigrationController::rollback_all'
);

$router->get(
    'refresh',
    'MigrationController::refresh'
);

$router->get(
    'status',
    'MigrationController::status'
);

?>
