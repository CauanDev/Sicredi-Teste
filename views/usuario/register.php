<!DOCTYPE html>

<head>
    <title>Registro</title>
</head>

<body>
    <div class="card-form d-flex justify-content-center align-items-center mt-5">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Registro de Usuário</h3>
            <form id="registerForm" action="/register" method="POST" novalidate>
                <!-- Campo para E-mail -->
                <div class="mb-2">
                    <label for="email" class="form-label">E-mail</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Digite seu e-mail"
                        required
                        aria-required="true">
                    <div class="invalid-feedback">Por favor, insira um e-mail válido.</div>
                </div>

                <!-- Campo para Confirmação de E-mail -->
                <div class="mb-2">
                    <label for="email_confirm" class="form-label">Confirme seu E-mail</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email_confirm"
                        name="email_confirm"
                        placeholder="Digite seu e-mail novamente"
                        required
                        aria-required="true">
                    <div class="invalid-feedback">Os e-mails não coincidem.</div>
                </div>

                <!-- Campo para Nome -->
                <div class="mb-2">
                    <label for="name" class="form-label">Nome</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Digite seu Nome"
                        required
                        aria-required="true">
                    <div class="invalid-feedback">O nome é obrigatório.</div>
                </div>

                <!-- Campo para CPF -->
                <div class="mb-2">
                    <label for="cpf" class="form-label">CPF</label>
                    <input
                        type="text"
                        class="form-control"
                        id="cpf"
                        name="cpf"
                        placeholder="Digite seu CPF"
                        required
                        aria-required="true">
                    <div class="invalid-feedback">Por favor, insira um CPF válido.</div>
                </div>

                <!-- Campo para Senha -->
                <div class="mb-2">
                    <label for="password" class="form-label">Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Digite sua senha"
                        required
                        aria-required="true">
                    <div class="invalid-feedback">A senha é obrigatória e deve ter pelo menos 6 caracteres.</div>
                </div>

                <!-- Checkbox para Assinatura Eletrônica -->
                <div class="mb-3">
                    <div class="form-check">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="eletronicSigner"
                            name="eletronicSigner"
                            value="true">
                        <label class="form-check-label" for="eletronicSigner">
                            Marque se a assinatura será digital
                        </label>
                    </div>
                </div>

                <!-- Botão de Cadastro -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault(); // Evita o comportamento padrão do formulário

                // Limpa todas as mensagens de erro anteriores
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();

                const formData = {
                    email: $('#email').val(),
                    email_confirm: $('#email_confirm').val(),
                    name: $('#name').val(),
                    cpf: $('#cpf').val(),
                    password: $('#password').val(),
                    eletronicSigner: $('#eletronicSigner').prop('checked') ? 'true' : 'false', // Verifica se o checkbox está marcado
                };

                let hasError = false;

                // Verifica se os campos estão vazios
                if (!formData.email) {
                    $('#email').addClass('is-invalid');
                    $('#email').siblings('.invalid-feedback').show();
                    hasError = true;
                }

                // Verifica se o e-mail é válido (contém @ e .)
                if (formData.email && !formData.email.includes('@') || !formData.email.includes('.')) {
                    $('#email').addClass('is-invalid');
                    $('#email').siblings('.invalid-feedback').text('Por favor, insira um e-mail válido.').show();
                    hasError = true;
                }

                if (!formData.email_confirm) {
                    $('#email_confirm').addClass('is-invalid');
                    $('#email_confirm').siblings('.invalid-feedback').show();
                    hasError = true;
                }

                if (!formData.name) {
                    $('#name').addClass('is-invalid');
                    $('#name').siblings('.invalid-feedback').show();
                    hasError = true;
                }

                if (!formData.password || formData.password.length < 6) {
                    $('#password').addClass('is-invalid');
                    $('#password').siblings('.invalid-feedback').text('A senha é obrigatória e deve ter pelo menos 6 caracteres.').show();
                    hasError = true;
                }

                // Verifica se os e-mails coincidem
                if (formData.email !== formData.email_confirm) {
                    $('#email_confirm').addClass('is-invalid');
                    $('#email_confirm').siblings('.invalid-feedback').text('Os e-mails não coincidem.').show();
                    hasError = true;
                }

                // Verifica se o CPF é válido
                if (!isValidCPF(formData.cpf)) {
                    $('#cpf').addClass('is-invalid');
                    $('#cpf').siblings('.invalid-feedback').show();
                    hasError = true;
                }

                // Se houver erro, não envia o formulário
                if (hasError) {
                    return;
                }

                // Envia os dados via AJAX
                $.ajax({
                    url: '/register',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#registerForm')[0].reset();
                            showAlert(response.message, 'success');
                            showSpinner()
                            setTimeout(function() {
                                window.location.href = '/login';
                            }, 2000);
                        }
                        if (response.dados_invalidos.email) {
                            let texto = response.dados_invalidos.email;
                            $('#email_confirm').addClass('is-invalid');
                            $('#email_confirm').siblings('.invalid-feedback').text(texto).show();

                            $('#email').addClass('is-invalid');
                            $('#email').siblings('.invalid-feedback').text(texto).show();
                            hasError = true;
                        }
                    },
                    error: function() {
                        showAlert('Erro inesperado. Tente novamente.', 'danger');
                    },
                });
            });
        });

        // Função para validar o CPF
        function isValidCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, ''); // Remove tudo o que não é dígito

            if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
                return false; // CPF com todos os dígitos iguais (ex: 11111111111)
            }

            let sum = 0;
            let remainder;

            // Validação do primeiro dígito
            for (let i = 1; i <= 9; i++) {
                sum += parseInt(cpf.substring(i - 1, i)) * (11 - i);
            }
            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) {
                remainder = 0;
            }
            if (remainder !== parseInt(cpf.substring(9, 10))) {
                return false;
            }

            sum = 0;

            // Validação do segundo dígito
            for (let i = 1; i <= 10; i++) {
                sum += parseInt(cpf.substring(i - 1, i)) * (12 - i);
            }
            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) {
                remainder = 0;
            }
            if (remainder !== parseInt(cpf.substring(10, 11))) {
                return false;
            }

            return true;
        }
    </script>

</body>

</html>