<!DOCTYPE html>

<head>
    <title>Bem-vindo à Home!</title>

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f8f6;
            color: #333;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 3.5rem;
            text-align: center;
            color: #3a8d3f;
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
            color: #3a8d3f;
        }

        .card-body {
            padding: 40px;
            text-align: center;
        }

        .btn-custom {
            background-color: #3a8d3f;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px 36px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #347f34;
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 1px;
            background-color: #3a8d3f;
            color: white;
            font-size: 1.2rem;
            border-top: 4px solid #347f34;
        }

        .footer a {
            color: white;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #0077B5;
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
        <h1 data-aos="fade-up">Bem-vindo ao Sistema Sicredi!</h1>

        <div class="row mt-5 d-flex justify-content-center">
            <div class="col-md-4 mb-4" data-aos="zoom-in-up">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">O que fazemos?</h5>
                        <p>Nosso sistema oferece uma plataforma robusta e segura para gerenciar usuários, documentos e processos de forma eficiente e moderna.</p>
                        <a href="/login" class="btn btn-custom">Acessar
                            <i class="bi bi-person-circle"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="zoom-in-up" data-aos-delay="200">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">Fácil Acesso</h5>
                        <p>O projeto foi completamente versionado, e você está convidado a explorar e contribuir. Acesse nosso repositório no GitHub e fique à vontade para colaborar!</p>
                        <a href="https://github.com/CauanDev/Sicredi-Teste" class="btn btn-custom" target='_blank'>Explorar
                            <i class="bi bi-github"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="zoom-in-up" data-aos-delay="400">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">Documentação</h5>
                        <p>Aqui você encontra a documentação completa e sobre como utilizar a plataforma, garantindo aproveitamento de todas as suas funcionalidades.</p>
                        <a href="https://docs.google.com/document/d/1RZoqPBlDl_L8o-95MeiPmNQp7kY6APp42UAq9NKNpw0/edit?usp=sharing" class="btn btn-custom" target='_blank'>Ver Documentação
                            <i class="bi bi-book-half"></i>
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

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>

</body>

</html>