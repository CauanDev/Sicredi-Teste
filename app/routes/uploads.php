<?php


Route::get('/uploads', function (){
    return (new UploadsController())->uploads();
});

Route::get('/uploads/create', function (){
    return (new UploadsController())->upload();
});

Route::post('/uploads/create', function (){
    $dados = $_POST; 

    return (new UploadsController())->uploadStore($dados);
});