<!DOCTYPE html>

<head>
    <title>Uploads</title>
</head>

<body>
    <div class="container mt-2">
        <h1>Uploads</h1>

        <div class="container table-responsive d-flex justify-content-center">
            <?php
            renderLayout('../views/layouts/dataTable', [
                "headers" => $headers,
                "body" => $body,
                "keys" => $keys
            ]);
            ?>
        </div>
    </div>

</body>

</html>