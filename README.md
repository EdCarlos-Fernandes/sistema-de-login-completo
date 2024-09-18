# Sistema de Login

## Descrição

Este projeto é um sistema de login básico com autenticação de usuários. Permite que os usuários se registrem, façam login e acessem uma área protegida por senha.

## Estrutura do Projeto

- **_config/**
  - `auth_check.php`: Verifica a autenticação do usuário e valida tokens de sessão.
  - `config.php`: Configurações de conexão com o banco de dados.
  - `database.php`: Conexão com o banco de dados usando PDO.

- **public/**
  - **login/**
    - `login.php`: Formulário de login.
    - `login_process.php`: Processamento do login e validação de credenciais.
  - **register/**
    - `register.php`: Formulário de registro.
    - `register_process.php`: Processamento do registro e validação de dados.
  - `dashboard.php`: Página principal acessada após o login.
  - `logout.php`: Finaliza a sessão do usuário e redireciona para a página de login.

## Segurança

- **Sessões Seguras**: Utiliza parâmetros de cookie de sessão seguros (`secure`, `httponly`, `samesite`).
- **Validação CSRF**: Protege contra ataques CSRF utilizando tokens CSRF em formulários.
- **Senhas**: Armazena senhas de forma segura usando hashing com bcrypt.
- **Autenticação de Sessão**: Valida sessões de usuário com tokens únicos armazenados no banco de dados.

## Uso

1. **Instalação**
   - Clone o repositório: `git clone https://github.com/EdCarlos-Fernandes/sistema-de-login-completo.git`
   - Importe o arquivo SQL `database.sql` para seu banco de dados MySQL.
   - Configure as credenciais no arquivo `_config/config.php`.

2. **Acesso**
   - Acesse `public/login/login.php` para fazer login ou `public/register/register.php` para criar uma nova conta.

3. **Logout**
   - Para sair, acesse `public/logout.php`.

## Contribuições

Sinta-se à vontade para contribuir com melhorias ou correções. Abra uma issue ou um pull request com suas sugestões.

## Licença

Este projeto é licenciado sob a MIT License.
