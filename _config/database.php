<?php
// Arquivo de configuração
$configPath = __DIR__ . '/config.php';
if (!file_exists($configPath)) {
    die("Arquivo de configuração não encontrado.");
}

$config = include($configPath);

// Verificar se as configurações foram carregadas corretamente
if (!is_array($config)) {
    die("Erro ao carregar configurações.");
}

// Conexão com o banco de dados usando PDO
try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['username'],
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage()); // Registrando o erro no log
    die("Ocorreu um erro ao tentar conectar ao banco de dados.");
}
?>
