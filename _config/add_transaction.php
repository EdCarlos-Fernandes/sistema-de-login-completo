<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include('../_config/auth_check.php');

header('Content-Type: application/json'); // Garantir que o retorno seja JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $transaction_date = $_POST['transaction_date'];
    $type = $_POST['transaction_type'];
    $value = $_POST['transaction_value'];
    $description = $_POST['transaction_description'];

    // Validação dos dados
    if (empty($transaction_date) || empty($type) || empty($value)) {
        echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos obrigatórios.']);
        exit;
    }

    try {
        // Inserindo a transação no banco de dados
        $sql = "INSERT INTO transactions (user_id, transaction_date, type, value, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssd", $user_id, $transaction_date, $type, $value, $description);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Transação adicionada com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar a transação.']);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido.']);
}
?>
