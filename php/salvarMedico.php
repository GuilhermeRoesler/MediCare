<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Medico.php";

$nomeCompleto = $_POST['nome'] ?? '';
$crm = $_POST['crm'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$especialidade = $_POST['especialidade'] ?? '';
$email = $_POST['email'] ?? '';
$status = $_POST['status'] == 'ativo' ? 1 : 0;

$medico = new Medico($nomeCompleto, $crm, $telefone, $especialidade, $email, $status);
$medico->inserir();

header('Location: ../html/medicos.php');
exit();
?>