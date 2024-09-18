<?php
// parâmetros do cookie de sessão
session_set_cookie_params([
    'lifetime' => 0, // O cookie expira quando o navegador é fechado
    'secure' => true, // O cookie só será enviado sobre HTTPS
    'httponly' => true, // O cookie não é acessível via JavaScript
    'samesite' => 'Strict' // Previne o envio do cookie em solicitações cross-site
]);

session_start();
include('../../_config/database.php');

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar o token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['register_error'] = 'Token CSRF inválido.';
        header('Location: register.php');
        exit;
    }

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($username && $password && $email) {
        // Verificar se o usuário já existe
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $email]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['register_error'] = 'Usuário ou e-mail já cadastrado.';
            header('Location: register.php');
            exit;
        } else {
            // Inserir novo usuário
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password,
                'email' => $email
            ]);
            header('Location: ../login/login.php');
            exit();
        }
    } else {
        $_SESSION['register_error'] = 'Por favor, preencha todos os campos corretamente.';
        header('Location: register.php');
        exit();
    }
}
