# Sistema de Gerenciamento de Usuários e Documentos

Este projeto é um sistema de gerenciamento de usuários e documentos, desenvolvido com **PHP puro**. Ele permite que os usuários se cadastrem, façam login e gerenciem documentos para assinatura de maneira segura e eficiente.

---

## 🚀 Funcionalidades

- **Cadastro e Login de Usuários**: Criação e autenticação de contas com validação de e-mail.
- **Gerenciamento de Usuários**: Atualização, exclusão e visualização de informações de usuários registrados.
- **Uploads de Documentos**: Envio de arquivos para o sistema, com controle de tempo para uso.
- **Criação de Documentos**: Associação de uploads a documentos, incluindo seleção de usuários para assinaturas.
- **Assinaturas de Documentos**: Links individuais para cada assinante.
- **Painel Administrativo**: Visualização de estatísticas, como número de uploads e assinaturas por usuários.

---

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 8.2+
- **Banco de Dados**: PostgreSQL
- **Frontend**: Bootstrap e jQuery
- **Validação de E-mail**: Integração com [Emailable](https://emailable.com)
- **Controle de Versão**: Git

---

## ⚙️ Instalação

### Pré-requisitos
- **PHP 8.2 ou superior**
- **PostgreSQL**

### Passo a Passo

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/CauanDev/Sicredi-Teste.git
   cd Sicredi-Teste
2. **Configure o ambiente**:
   Copie o arquivo de exemplo para criar o arquivo .env:
   ```bash
   cp .env.example .env
3. **Configure o banco de dados**: 
    No arquivo .env, preencha as informações do banco de dados:
   ```bash
   DB_CONNECTION=pgsql
   DB_HOST=localhost
   DB_PORT=5432
   DB_NAME=nome_do_banco
   DB_USER=usuario_do_banco
   DB_PASSWORD=senha_do_banco

4. **Configure a API do Portal de Assinaturas**:
  Adicione os dados no .env:
   ```bash
   PORTAL_API_TOKEN=sua_chave_api
   PORTAL_API_URL=https://url-do-portal.com

5. **Configure a API do Emailable**:
   ```bash
   EMAILABLE_API_TOKEN=sua_chave_api
   EMAILABLE_API_URL=https://api.emailable.com
   
7. **Criação das tabelas:**:
Descomente a linha de migrações no arquivo index.php.
Inicie o servidor local:
   ```bash
   php -S localhost:8000
Acesse o projeto pelo navegador para executar as migrações.
Após a criação das tabelas, comente novamente a linha de migrações no index.php.

👥 Acesso ao Sistema
Credenciais de Administrador:

    E-mail: admin@admin.com
    Senha: admin10

🎯 Uso do Sistema

Registro e Login:
        Acesse a página de registro para criar uma conta.
        Use um e-mail válido, pois ele será verificado.
        Faça login com as credenciais registradas.

Painel do Usuário:
        Visualize documentos relacionados para assinatura.
        Assine documentos usando links individuais enviados por e-mail.

Painel Administrativo:
        Gerencie usuários: edite ou exclua informações.
        Faça uploads de documentos.
        Crie documentos e associe usuários para assinatura.
        Acompanhe estatísticas, como número de uploads e assinaturas.
