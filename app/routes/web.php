<?php

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
    header('Location: /login');
    exit();
});

Route::post('/register', function (){
    $dados = $_POST; 
    
    return (new UserController())->store($dados);
});

Route::get('/usuarios',function(){
    return (new AdminController())->index();
});

Route::post('/usuario',function(){
    $dados = $_POST; 

    return (new AdminController())->usuario($dados);
});

Route::post('/usuario/atualizar',function(){
    $dados = $_POST; 

    return (new AdminController())->atualizarUsuario($dados);
});