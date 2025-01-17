<?php
require_once __DIR__ . '/../app/funcions.php';

export('Routes');
export('Controllers/Controller');
export('Models/Model');
export('Services/Service');

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    Model::getConnection();
    // Model::createTable();

} catch (PDOException $e) { 
    echo Controller::render('error_conexao');  
    die(); 
}

$response = Route::handle($requestUri);

echo $response;
