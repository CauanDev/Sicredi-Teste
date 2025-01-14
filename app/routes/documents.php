<?php

// Route::get('/documentos', function (){
//     return (new AdminController())->index();
// });

Route::get('/documentos/create',function(){
    return (new DocumentosController())->documento();

});

Route::post('/documentos/create',function(){
    $dados = $_POST; 
    
    return (new DocumentosController())->documentoStore($dados);
});

Route::post('/documentos',function(){
    return (new DocumentosController())->documento();
});