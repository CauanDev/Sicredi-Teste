<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Atualizar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateUserForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf">
                    </div>
        
                    <div class="mb-3">
                        <label for="electronicSigner" class="form-label">Electronic Signer</label>
                        <input type="checkbox" class="form-check-input" id="electronicSigner" name="electronicSigner">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Salvar alterações</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    let originalData = {};

    $('.edit-user').on('click', function () {
        const userId = $(this).data('id');
        $('#updateUserForm')[0].reset();

        $.ajax({
            url: '/usuario',
            method: 'POST',
            data: { userId },
            dataType: 'json',
            success: function (response) {
                const data = response.dados[0];
                if (data) {
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#cpf').val(data.cpf);
                    $('#type').val(data.type);
                    $('#electronicSigner').prop('checked', data.electronicSigner);

                    // Salvar os valores originais para comparação
                    originalData = {
                        name: data.name,
                        email: data.email,
                        cpf: data.cpf,
                        type: String(data.type),
                        electronicSigner: data.electronicSigner ? 'on' : '',
                    };

                    $('#updateUserModal').modal('show');
                } else {
                    alert('Usuário não encontrado.');
                }
            },
            error: function () {
                alert('Erro ao carregar os dados do usuário.');
            },
        });
    });

    $('#updateUserForm').on('submit', function (e) {
        e.preventDefault();

        const userId = $('.edit-user').data('id');
        const formData = $(this).serializeArray();
        const updatedFields = {};

        // Comparar os valores atuais com os originais e enviar apenas os alterados
        formData.forEach(({ name, value }) => {
            if (originalData[name] !== value) {
                updatedFields[name] = value;
            }
        });

        if (Object.keys(updatedFields).length === 0) {
            alert('Nenhuma alteração foi feita.');
            return;
        }

        updatedFields.id = userId;

        $.ajax({
            url: '/usuario/atualizar',
            method: 'POST',
            data: updatedFields,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert('Usuário atualizado com sucesso!');
                    $('#updateUserModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Erro ao atualizar o usuário.');
                }
            },
            error: function (xhr) {
                const response = xhr.responseJSON;
                alert(response?.message || 'Erro ao salvar as alterações.');
            },
        });
    });
});

</script>
