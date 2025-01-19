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
        header("Location: /"); 
        exit;
    }
}



export('/routes/web');
export('/routes/uploads');
export('/routes/documents');


