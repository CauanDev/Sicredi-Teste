<?php

function export($caminho)
{
    $arquivo = __DIR__ . "/" . $caminho.".php";
    
    if (file_exists($arquivo)) {
        require_once $arquivo;
    } else {
        echo ("Arquivo não encontrado: " . $arquivo);
    }
}

function loadEnv()
{
    
    $lines = file(__DIR__ ."/../.env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        putenv("$key=$value");
    }
}

function renderLayout($caminho, $data = [])
{
    $arquivo = __DIR__ . "/" . $caminho . ".php";

    if (file_exists($arquivo)) {
        extract($data);
        require_once $arquivo;
    } else {
        echo ("Arquivo não encontrado: " . $arquivo);
    }
}


