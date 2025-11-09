<?php
require_once "Pagamento.php";

$idConsulta = $_POST['idConsulta'] ;
$valor = $_POST['valor'];
$dataPagamento = $_POST['dataPagamento'];
$formaPagamento = $_POST['metodo'];
$status = $_POST['status'];

$pagamento = new Pagamento($idConsulta, $valor, $dataPagamento, $formaPagamento, $status);
try {
    $pagamento->registrar();
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/pagamento.php');
exit();
?>