<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro de Conexão!</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f8f6;
            color: #333;
            overflow: hidden; 
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 3.5rem;
            text-align: center;
            color: #d9534f;
            animation: fadeInUp 1s ease-out;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #d9534f;
        }

        .card-body {
            padding: 40px;
            text-align: center;
        }

        .btn-custom {
            background-color: #d9534f;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 36px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #c9302c;
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            margin-top: 23vh;
            padding: 1px;
            background-color: #d9534f;
            color: white;
            font-size: 1.2rem;
            border-top: 4px solid #c9302c;
        }

        .footer a {
            color: white;
            transition: color 0.3s ease;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 1s ease-out;
        }
    </style>
</head>

<body>

    <div class="container text-center">
        <h1 data-aos="fade-up">Erro de Conexão com o Banco de Dados!</h1>

        <div class="col-md-4 mb-4" data-aos="zoom-in-up" data-aos-delay="200">
            <div class="card shadow-lg rounded-lg">
                <div class="card-body">
                    <h5 class="card-title text-primary">Ajuda Técnica</h5>
                    <p>Não conseguimos estabelecer conexão com o banco de dados. Por favor, verifique sua configuração ou entre em contato com o administrador do sistema.</p>
                    <p>Para mais detalhes sobre como configurar a conexão com o banco de dados e solucionar problemas, consulte nossa documentação abaixo.</p>
                    <a href="https://docs.google.com/document/d/1RZoqPBlDl_L8o-95MeiPmNQp7kY6APp42UAq9NKNpw0/edit?usp=sharing" class="btn btn-custom d-flex align-items-center" target='_blank'>
                        <span>Ver Documentação</span>
                        <i class="bi bi-book-half ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="footer">
        <p>&copy; Desenvolvido por Kelvin Cauan <a href="https://www.linkedin.com/in/kelvin-cauan/" target='_blank'>
                <i class="bi bi-linkedin" style="font-size: 1.5rem;"></i>
            </a><br>
            <i class="bi bi-filetype-css" style="font-size: 1.5rem;"></i> <i class="bi bi-filetype-php" style="font-size: 1.5rem;"></i> <i class="bi bi-filetype-js" style="font-size: 1.5rem;"></i><br>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>

</body>
</html>
