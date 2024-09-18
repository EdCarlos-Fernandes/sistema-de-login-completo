<?php
// Conexão com o banco de dados
include('../../_config/database.php');

// parâmetros do cookie de sessão
session_set_cookie_params([
    'lifetime' => 0, // A sessão expira quando o navegador é fechado
    'secure' => true, // O cookie só será enviado sobre HTTPS
    'httponly' => true, // O cookie não é acessível via JavaScript
    'samesite' => 'Strict' // Previne o envio do cookie em solicitações cross-site
]);

// Iniciar sessão
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar e validar os dados de entrada
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Gerar um token de sessão aleatório
            $session_token = bin2hex(random_bytes(32));
            
            // Armazenar o token de sessão no banco de dados
            $stmt = $pdo->prepare("INSERT INTO user_sessions (user_id, session_token) VALUES (:user_id, :session_token)");
            $stmt->execute(['user_id' => $user['id'], 'session_token' => $session_token]);
            
            // Armazenar o token na sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['session_token'] = $session_token;

            // Redirecionar para a página do dashboard
            header('Location: ../dashboard.php');
            exit;
        } else {
            $_SESSION['login_error'] = 'Usuário ou senha incorretos.';
            header('Location: login.php');
            exit;
        }
    } else {
        $_SESSION['login_error'] = 'Por favor, preencha todos os campos.';
        header('Location: login.php');
        exit;
    }
}
?>
