<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="https://logospng.org/download/sicredi/logo-sicredi-icon-1024.png">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"></body>
  <style>
    .card-form {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80vh;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/a/ab/Sicredi-logo.png" style="width: 160px;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- Usuário Logado -->
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="/dashboard">Dashboard</a>
            </li>
            <!-- Menu de Administrador -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Área de Administrador
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/documentos">Documentos</a></li>
                  <li><a class="dropdown-item" href="/uploads">Uploads</a></li>
                  <li><a class="dropdown-item" href="/uploads/create">Upload de Documentos</a></li>
                  <li><a class="dropdown-item" href="/documentos/create">Criar Documentos</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="/usuarios">Usuarios</a></li>
                </ul>
              </li>

            <?php endif; ?>

            <li class="nav-item">
              <a class="nav-link" href="/logout">Logout</a>
            </li>
            <li>



            <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/register">Registro</a>
            </li>



          <?php endif; ?>



        </ul>
      </div>
    </div>
  </nav>

  <div id="alertContainer"></div>
  <div id="spinnerContainer">
    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 9999; width: 3rem; height: 3rem; display: none">
      <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="/js/functions.js"></script>
</html>