<?php
require_once "Paciente.php";

$nomeCompleto = $_POST['nome'] ?? '';
$dataNascimento = $_POST['dataNascimento'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';

$paciente = new Paciente($nomeCompleto, $dataNascimento, $cpf, $telefone, $email);
$paciente->inserir();

header('Location: ../html/pacientes.php');
exit();
?>