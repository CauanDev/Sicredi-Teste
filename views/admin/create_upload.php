<!DOCTYPE html>

<head>
    <title>Upload do Documento</title>
</head>

<body>

    <div class="card-form d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow" style="width: 60%;">
            <h3 class="text-center mb-4">Upload do Documento</h3>

            <form id="uploadForm" enctype="multipart/form-data">

                <div class="form-group mb-3">
                    <label for="fileName">Nome do Arquivo (opcional)</label>
                    <input type="text" class="form-control" id="fileName" name="fileName">
                </div>

                <div class="form-group mb-3">
                    <label for="file">Arquivo</label>
                    <input type="file" class="form-control" id="file" name="file">
                    <div class="invalid-feedback">Selecione um arquivo no formato correto.</div>
                </div>

                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#fileName').on('input', function() {
                var sanitizedFileName = $(this).val().replace(/[^a-zA-Z0-9]/g, '');
                $(this).val(sanitizedFileName);
            });

            $('#uploadForm').on('submit', function(e) {
                e.preventDefault(); 

                $('.invalid-feedback').hide(); 

                var formData = new FormData(this);
                let hasError = false;

                if ($('#file')[0].files.length === 0) {
                    $('.invalid-feedback').text('O upload do arquivo é obrigatório.').show(); // Exibe erro se não houver arquivo
                    hasError = true;
                }

                // Verifica se o tipo de arquivo é PDF
                var file = $('#file')[0].files[0];
                var fileType = file ? file.type : '';
                if (fileType && fileType !== 'application/pdf') {
                    $('.invalid-feedback').text('O arquivo deve ser no formato PDF.').show(); // Exibe erro se não for PDF
                    hasError = true;
                }

                if (hasError) return;

                // Envia o arquivo via AJAX
                $.ajax({
                    url: '/documentos/upload',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.sucess) {
                            showAlert(response.message, 'success');
                        } else {
                            showAlert(response.message, 'danger');
                        }
                    },
                    error: function(error) {
                        showAlert(error, 'danger');
                    }
                });
            });
        });
    </script>

</body>

</html>
