<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../Pagamento.php'; // Assuming Pagamento class exists

$idPagamento = $_POST['id'];

// Assuming a constructor that can be empty or a static method for deletion
$pagamento = new Pagamento(null, null, null, null, null);

try {
    $pagamento->excluir($idPagamento);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/pagamento.php');
exit();
?>