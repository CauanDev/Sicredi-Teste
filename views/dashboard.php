<!DOCTYPE html>
<head>
    <title>Dashboard</title>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4 text-dark">Dashboard</h1>
        <p class="text-center text-muted mb-5">Documentos referentes a <?php echo $_SESSION['user_name']; ?> </p>

        <!-- Tabela -->
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

        <!-- Gráficos -->
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        renderLayout('../views/layouts/charts/pizzaChart', [
                            "title" => "Upload dos Usuarios",
                            "data" => $uploads,
                        ]);
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        renderLayout('../views/layouts/charts/lineChart', [
                            "documents" => $documents,
                            "uploads" => $uploads,
                            "title" => "Upload e Documentos por Dia"
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
