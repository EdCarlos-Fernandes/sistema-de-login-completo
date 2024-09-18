<?php
// Iniciar sessão
session_start();

// Conexão com o banco de dados
include('../_config/database.php');

// Remover o token de sessão do banco de dados
if (isset($_SESSION['user_id']) && isset($_SESSION['session_token'])) {
    $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE user_id = :user_id AND session_token = :session_token");
    $stmt->execute(['user_id' => $_SESSION['user_id'], 'session_token' => $_SESSION['session_token']]);
}

// Destruir a sessão
session_unset();
session_destroy();

header('Location: login/login.php');
exit;
?>
