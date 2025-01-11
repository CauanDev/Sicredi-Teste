<?php

// Exports dos Controllers
export('Controllers/AboutController');
export('Controllers/HomeController');
export('Controllers/UserController');
export('Controllers/DashboardController');

class Controller
{
    public function __construct($checkLogin = false)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function render($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

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
