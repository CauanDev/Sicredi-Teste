<!DOCTYPE html>
<head>
    <title>Uploads</title>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4 text-dark">Uploads</h1>

        <div class="card mb-4">
            <div class="card-body">
                <?php
                if(!empty($body)){
                    renderLayout('../views/layouts/dataTable', [
                        "headers" => $headers,
                        "body" => $body,
                        "keys" => $keys
                    ]);
                }
                else{
                    echo" 
                    <div>
                        <p>Não há dados disponíveis no momento.</p>
                        <a href='/uploads/create'>
                            <button class='btn btn-primary'>Adicionar Documento</button>
                        </a>
                    </div>
                ";
                }
        
                ?>
            </div>
        </div>

    </div>

</body>

</html>