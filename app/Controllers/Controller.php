<?php

// Exports dos Controllers
export('Controllers/AboutController');
export('Controllers/HomeController');
export('Controllers/UserController');

class Controller
{
    public static function render($view, $data = [])
    {
        // Extrair os dados para variáveis
        if (!empty($data)) {
            extract($data);
        }

        // Iniciar o buffer de saída
        ob_start();


        // Adicionar o layout da navbar, caso a view não seja 'error_conexao'
        if ($view !== 'error_conexao') {
            include __DIR__ . "/../../views/layouts/navbar.php";
        }

        include __DIR__ . "/../../views/{$view}.php";

        $content = ob_get_clean();
        return $content;
    }
}
