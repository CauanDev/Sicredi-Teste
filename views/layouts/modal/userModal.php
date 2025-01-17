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
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="electronicsigner" class="form-label">Electronic Signer</label>
                        <input type="checkbox" class="form-check-input" id="electronicsigner" name="electronicsigner">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Admin</label>
                        <input type="checkbox" class="form-check-input" id="type" name="type">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <!-- Form button to trigger form submission -->
                <button type="submit" class="btn btn-success" form="updateUserForm">Salvar alterações</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let originalData = {};
        let userId = null;

        $('.edit-user').on('click', function() {
            userId = $(this).data('id');
            $('#updateUserForm')[0].reset();

            $.ajax({
                url: '/usuario',
                method: 'POST',
                data: { userId },
                dataType: 'json',
                success: function(response) {
                    const data = response.dados[0];
                    if (data) {
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#cpf').val(data.cpf);
                        $('#electronicsigner').prop('checked', data.electronicsigner === true);     
                        $('#type').prop('checked', data.type === true);

                        originalData = {
                            name: data.name,
                            email: data.email,
                            cpf: data.cpf,
                            electronicsigner: data.electronicsigner,
                            type: data.type
                        };

                        $('#updateUserModal').modal('show');
                    } else {
                        alert('Usuário não encontrado.');
                    }
                },
                error: function() {
                    alert('Erro ao carregar os dados do usuário.');
                },
            });
        });

        $('#updateUserForm').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serializeArray();
            const updatedFields = {};

            formData.forEach(({ name, value }) => {
                if (name === 'password' && value.trim() === '') {
                    return;
                } else {
                    if (originalData[name] !== value) {
                        updatedFields[name] = value;
                    }
                }
            });

            updatedFields.electronicsigner = $('#electronicsigner').prop('checked') ? true : false;
            updatedFields.type = $('#type').prop('checked') ? true : false;

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
                success: function(response) {
                    if (response.success) {
                        alert('Usuário atualizado com sucesso!');
                        $('#updateUserModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response.message || 'Erro ao atualizar o usuário.');
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert(response?.message || 'Erro ao salvar as alterações.');
                },
            });
        });
    });
</script>
