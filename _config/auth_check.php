<?php
// Conexão com o banco de dados
include('../_config/database.php');

// parâmetros do cookie de sessão
session_set_cookie_params([
    'lifetime' => 0, // A sessão expira quando o navegador é fechado
    'secure' => true, // O cookie só será enviado sobre HTTPS
    'httponly' => true, // O cookie não é acessível via JavaScript
    'samesite' => 'Strict' // Previne o envio do cookie em solicitações cross-site
]);

// Iniciar sessão
session_start();

// Verificar se o usuário está logado e se o token de sessão está presente
if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_token'])) {
    header('Location: login/login.php');
    exit;
}

// Verificar a validade do token de sessão
$stmt = $pdo->prepare("SELECT * FROM user_sessions WHERE user_id = :user_id AND session_token = :session_token");
$stmt->execute(['user_id' => $_SESSION['user_id'], 'session_token' => $_SESSION['session_token']]);
$session = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$session) {
    // Se o token de sessão não for válido, deslogar o usuário
    session_unset();
    session_destroy();
    header('Location: login/login.php');
    exit;
}

// Buscar o nome do usuário para exibição
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$username = $user ? htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') : 'Usuário';
?>
