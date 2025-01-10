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

Route::post('/register', function (){
    $dados = $_POST; 
    
    return (new UserController())->create($dados);
});

