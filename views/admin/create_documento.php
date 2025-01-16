<!DOCTYPE html>

<head>
    <title>Criar Documento</title>
</head>

<body class="bg-light">

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 600px;">
            <h3 class="text-center mb-4 text-dark">Criar Documento</h3>

            <form id="uploadForm" enctype="multipart/form-data">

                <div class="form-group mb-3">
                    <label for="fileName" class="font-weight-bold">Nome do Arquivo</label>
                    <input type="text" class="form-control" id="fileName" name="fileName" required>
                </div>

                <div class="form-group mb-3">
                    <label for="uploadSelect" class="font-weight-bold">Selecione um Upload</label>
                    <?php
                    renderLayout('../views/layouts/select_form', [
                        "options" => $uploads,
                        "title" => "uploads",
                        "placeholder" => "Selecione um Upload"
                    ]);
                    ?>
                    <div id="error-container-uploads" class="invalid-feedback" style="display: none;"></div>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Selecione Usuários</label>
                    <?php
                    renderLayout('../views/layouts/checkbox_form', [
                        "options" => $users,
                        "title" => "users",
                    ]);
                    ?>
                    <div id="error-container-users" class="invalid-feedback" style="display: none;"></div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Enviar</button>
            </form>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#fileName').on('input', function () {
                var sanitizedFileName = $(this).val().replace(/[^a-zA-Z0-9]/g, '');
                $(this).val(sanitizedFileName);
            });

            $('#uploadForm').on('submit', function (e) {
                e.preventDefault();

                $('.invalid-feedback').hide();

                var formData = new FormData(this);
                let hasError = false;

                var selectId = '#select-' + 'uploads';
                var uploadId = $(selectId).val();
                var uploadTarget = $(selectId).find('option:selected').data('target'); 
                if (!uploadId) {
                    $('#error-container-uploads').text('Por favor, selecione um upload.').show();
                    hasError = true;
                }

                var selectedUsers = [];
                $('input[type="checkbox"]:checked').each(function () {
                    var userValue = $(this).val(); 
                    var userTarget = $(this).data('target'); 
                    var userLabel = $(this).data('value'); 
                    var userStatus = $(this).data('status'); 
                    var userId =  $(this).data('id'); 
                    selectedUsers.push({
                        email: userValue,
                        cpf: userTarget,
                        name: userLabel,
                        electronicSigner: userStatus? true: false,
                        id: userId
                    });
                });

                if (selectedUsers.length === 0) {
                    $('#error-container-users').text('Selecione ao menos um usuário.').show();
                    hasError = true;
                }

                if (hasError) {
                    return;
                }

                formData.append('users', JSON.stringify(selectedUsers)); 
                formData.append('name_upload', uploadTarget); 

                console.log(formData);
                // Envia os dados via AJAX
                $.ajax({
                    url: '/documentos/create',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                        } else {
                            showAlert(response.message, 'danger');
                        }
                    },
                    error: function (error) {
                        showAlert(error, 'danger');
                    }
                });
            });
        });
    </script>

</body>

</html>
