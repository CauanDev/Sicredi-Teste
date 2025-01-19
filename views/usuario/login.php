<!DOCTYPE html>

<head>
    <title>Login</title>
</head>

<body>
    <div class="card-form d-flex justify-content-center align-items-center ">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Login de Usuário</h3>
            <form id="loginForm" action="/login" method="POST" novalidate>
                <!-- Campo para E-mail -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input
                        type="text"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Digite seu e-mail"
                        required
                        aria-required="true">
                    <div class="invalid-feedback">Por favor, insira um e-mail válido.</div>
                </div>

                <!-- Campo para Senha -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Digite sua senha"
                        required
                        aria-required="true">
                    <div class="invalid-feedback">A senha deve ter pelo menos 6 caracteres.</div>
                </div>

                <!-- Botão de Login -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); 

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();

                const formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                };

                let hasError = false;

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!formData.email || !emailRegex.test(formData.email)) {
                    $('#email').addClass('is-invalid');
                    $('#email').siblings('.invalid-feedback').show();
                    hasError = true;
                }

                if (!formData.password || formData.password.length < 6) {
                    $('#password').addClass('is-invalid');
                    $('#password').siblings('.invalid-feedback').show();
                    hasError = true;
                }

                if (hasError) {
                    return;
                }

                $.ajax({
                    url: '/login',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                            showSpinner();
                            setTimeout(function() {
                                window.location.href = '/dashboard';
                            }, 2000);
                        }
                        if (response.dados_invalidos) {
                            if (response.dados_invalidos.email) {
                                $('#email').addClass('is-invalid');
                                $('#email').siblings('.invalid-feedback').text(response.dados_invalidos.email).show();
                            }
                        }
                    },
                    error: function(error) {
                        showAlert('Tente novamente.', 'danger');
                    },
                });
            });
        });
    </script>

</body>

</html>
