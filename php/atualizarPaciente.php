<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Paciente.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$dataNascimento = $_POST['dataNascimento'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];

$paciente = new Paciente($nome, $dataNascimento, $cpf, $telefone, $email);

try {
    $paciente->atualizar($id);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/pacientes.php');
exit();
?>