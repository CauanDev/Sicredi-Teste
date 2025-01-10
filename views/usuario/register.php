<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
</head>
<body>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro!</strong> <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Registro de Usuário</h3>
            <form action="/register" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        placeholder="Digite seu e-mail" 
                        required>
                </div>

                <div class="mb-3">
                    <label for="email_confirm" class="form-label">Confirme seu E-mail</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="email_confirm" 
                        name="email_confirm" 
                        placeholder="Digite seu e-mail novamente" 
                        required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="name" 
                        name="name" 
                        placeholder="Digite seu Nome" 
                        required>
                </div>

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

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
</body>
</html>
