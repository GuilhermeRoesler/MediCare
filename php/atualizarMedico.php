<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Medico.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$crm = $_POST['crm'];
$especialidade = $_POST['especialidade'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$status = $_POST['status'] == 'ativo' ? 1 : 0;

$medico = new Medico($nome, $crm, $telefone, $especialidade, $email, $status);

try {
    $medico->atualizar($id);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/medicos.php');
exit();
?>