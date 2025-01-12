<!DOCTYPE html>
<head>
    <title>Uploads</title>
</head>

<body>
    <h1>Uploads</h1>

    <?php

    renderLayout('../views/layouts/dataTable', [
        "headers" => $headers,
        "body" => $body
    ]);

    ?>
</body>

</html>