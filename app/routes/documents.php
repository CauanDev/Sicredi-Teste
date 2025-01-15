<?php


Route::get('/documentos/create', function () {
    return (new DocumentosController())->documento();
});


Route::get('/documentos', function () {
    return (new DocumentosController())->index();
});

Route::post('/documentos/create', function () {
    $dados = $_POST;

    return (new DocumentosController())->documentoStore($dados);
});

Route::post('/documentos', function () {
    $dados = $_POST;

    return (new DocumentosController())->getDocumentos($dados);
});

Route::post('/documentos/verificarStatus', function (){
    $dados = $_POST;
   
    return (new DocumentosController())->verificarStatus($dados);
});

Route::post('/documentos/verificarAssinatura', function (){
    $dados = $_POST;
   
    return (new DocumentosController())->verificarAssinatura($dados);
});

Route::post('/documentos/delete', function (){
    $dados = $_POST;
   
    return (new DocumentosController())->deleteDocumentos($dados);
});