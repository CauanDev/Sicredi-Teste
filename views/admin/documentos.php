<!DOCTYPE html>

<head>
    <title>Documentos</title>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4 text-dark">Documentos</h1>

        <!-- Modal -->
        <?php
        renderLayout('../views/layouts/modal/documentosModal');
        ?>

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

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const table = document.querySelector('.table');

                table.addEventListener('click', function(event) {
                    const clickedButton = event.target.closest('button');

                    if (clickedButton) {
                        const documentId = clickedButton.getAttribute('data-id');

                        if (clickedButton.classList.contains('btn-danger')) {
                            if (confirm("Tem certeza que deseja excluir este documento?")) {
                                // Requisição AJAX para deletar o documento
                                $.ajax({
                                    url: '/documentos/delete',
                                    method: 'POST',
                                    data: {
                                        documentId
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response)
                                        if (response.sucess) {
                                            showAlert(response.mensagem, 'success');
                                        } else {
                                            showAlert(response.mensagem, 'danger');
                                        }
                                    },
                                    error: function(error) {
                                        showAlert(error, 'danger');
                                    }
                                });
                            }
                        }
                    }
                });
            });
        </script>

</body>

</html>