<?php

class Route
{
    private static $routes = [];

    public static function get($uri, $callback)
    {
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback)
    {
        self::$routes['POST'][$uri] = $callback;
    }

    public static function handle($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset(self::$routes[$method][$uri])) {
            return call_user_func(self::$routes[$method][$uri]);
        }

        http_response_code(404);
        return "404 - Página não encontrada";
    }
}

Route::get('/', function () {
    return (new HomeController())->index();
});

Route::get('/sobre', function () {
    return (new AboutController())->index();
});

Route::get('/dashboard', function () {
    return (new DashboardController())->index();
});

Route::get('/login',function () {
    return (new UserController())->index();
});

Route::post('/login', function () {
    $dados = $_POST; 

    return (new UserController())->login($dados); 
});

Route::get('/register',function (){
    return (new UserController())->register();
});

Route::get('/logout',function (){
    session_unset();
    session_destroy();
    header('Location: /home');
    exit();
});

Route::post('/register', function (){
    $dados = $_POST; 
    
    return (new UserController())->store($dados);
});

Route::get('/documentos', function (){
    return (new AdminController())->index();
});

Route::get('/uploads', function (){
    return (new AdminController())->uploads();
});

Route::get('/documentos/upload', function (){
    return (new AdminController())->upload();
});


Route::post('/documentos/upload', function (){
    $dados = $_POST; 

    return (new AdminController())->store($dados);
});

