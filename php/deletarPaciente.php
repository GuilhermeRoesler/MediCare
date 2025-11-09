<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../Paciente.php';

$idPaciente = $_POST['id'];

$paciente = new Paciente(null, null, null, null, null);

try {
    $paciente->excluir($idPaciente);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/pacientes.php');
exit();
?>