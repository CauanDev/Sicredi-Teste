<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Login de Usuário</h3>
            <form action="/login" method="POST">
                <!-- Campo para E-mail/Usuário -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail ou Usuário</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        placeholder="Digite seu e-mail ou usuário" 
                        required>
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
                        required>
                </div>
                <!-- Botão de Login -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
                <!-- Link para Recuperar Senha -->
                <div class="text-center mt-3">
                    <a href="forgot_password.php" class="text-decoration-none">Esqueceu sua senha?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
