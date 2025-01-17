<?php

Route::get('/dashboard', function () {
    return (new UserController())->dashboard();
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
    header('Location:/');
    exit();
});

Route::post('/register', function (){
    $dados = $_POST; 
    
    return (new UserController())->store($dados);
});

Route::post('/usuario/atualizar',function(){
    $dados = $_POST; 

    return (new UserController())->atualizarUsuario($dados);
});

Route::post('/usuario',function(){
    $dados = $_POST; 

    return (new UserController())->getUser($dados);
});

Route::get('/usuarios',function(){
    return (new AdminController())->usuarios();
});

Route::get('/',function(){
    return (new UserController())->home();
});
