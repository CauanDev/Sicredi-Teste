<!DOCTYPE html>
<html>

<head>
    <title>Criar Documento</title>
</head>

<body>
    <div class="card-form d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow" style="width: 60%;">
            <h3 class="text-center mb-4">Criar Documento</h3>

            <form id="uploadForm" enctype="multipart/form-data">

                <div class="form-group mb-3">
                    <label for="fileName">Nome do Arquivo</label>
                    <input type="text" class="form-control" id="fileName" name="fileName" required>
                </div>

                <div class="form-group mb-3">
                    <?php
                    renderLayout('../views/layouts/select_form', [
                        "options" => $uploads,
                        "title" => "uploads",
                        "placeholder" => "Selecione um Upload"
                    ]);
                    ?>
                </div>

                <div class="form-group mb-3">
                    <?php
                    renderLayout('../views/layouts/checkbox_form', [
                        "options" => $users,
                        "title" => "users",
                    ]);
                    ?>
                </div>

                <button type="submit" class="btn btn-primary">Enviar</button>
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
