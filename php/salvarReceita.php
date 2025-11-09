<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Receita.php";

$idConsulta = $_POST['idConsulta'];
$idPaciente = $_POST['idPaciente'];
$medicamento = $_POST['medicamento'];
$quantidade = $_POST['quantidade'];
$posologia = $_POST['posologia'];
$dataEmissao = $_POST['dataEmissao'];
$validade = $_POST['dataValidade'];

$receita = new Receita($idConsulta, $idPaciente, $medicamento, $quantidade, $posologia, $dataEmissao, $validade);
try {
    $receita->emitir();
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/receitas.php');
exit();
?>