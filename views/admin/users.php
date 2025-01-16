<!DOCTYPE html>
<head>
    <title>Usuários</title>
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h1 class="text-center mb-4 text-dark">Gestão de Usuários</h1>

        <div class="d-flex justify-content-center mb-4">
            <?php renderLayout('../views/layouts/modal/userModal'); ?>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <?php
                renderLayout('../views/layouts/dataTable', [
                    "headers" => $headers,
                    "body" => $body,
                    "keys" => $keys
                ]);
                ?>
            </div>
        </div>

    </div>


</body>

</html>