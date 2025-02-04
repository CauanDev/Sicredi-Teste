<?php

// Exports dos Controllers
export('Controllers/UserController');
export('Controllers/DashboardController');
export('Controllers/AdminController');
export('Controllers/DocumentosController');
export('Controllers/UploadsController');

class Controller
{
    public function __construct($checkLogin = false, $adminLogin = false)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($adminLogin && (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true)) {
            header('Location: /dashboard');
            exit();
        }
    }

    public static function render($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        ob_start();

        if ($view !== 'error_conexao') {
            include __DIR__ . "/../../views/layouts/navbar.php";
        }

        include __DIR__ . "/../../views/{$view}.php";

        $content = ob_get_clean();
        return $content;
    }
}
