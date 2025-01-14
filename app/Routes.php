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



export('/routes/web');
export('/routes/uploads');
export('/routes/documents');




// Route::get('/uploads', function (){
//     return (new AdminController())->uploads();
// });


// Route::get('/uploads/create', function (){
//     return (new AdminController())->upload();
// });

// Route::post('/uploads/create', function (){
//     $dados = $_POST; 

//     return (new AdminController())->uploadStore($dados);
// });



// Route::get('/documentos/create',function(){
//     return (new AdminController())->documento();

// });

// Route::post('/documentos/create',function(){
//     $dados = $_POST; 
    
//     return (new AdminController())->documentoStore($dados);

// });
// Route::get('/documentos', function (){
//     return (new AdminController())->index();
// });