<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
</head>

<body>
    <div class="container mt-2">
        <h1>Documentos</h1>

        <?php
        renderLayout('../views/layouts/modal/documentosModal');
        ?>
        <div class="table-responsive d-flex justify-content-center">
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
            // Captura o clique nos botões dentro da tabela
            const table = document.querySelector('.table'); // Seleciona a tabela com a classe 'table'

            table.addEventListener('click', function(event) {
                const clickedButton = event.target.closest('button'); // Captura o botão mais próximo

                if (clickedButton) {
                    const documentId = clickedButton.getAttribute('data-id'); // Obtém o ID do documento

                    if (clickedButton.classList.contains('btn-danger')) {
                        if (confirm("Tem certeza que deseja excluir este documento?")) {
                            // Faz a requisição AJAX para deletar
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