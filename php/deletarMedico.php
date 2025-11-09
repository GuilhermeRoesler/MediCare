<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../Medico.php';

$idMedico = $_POST['id'];

$medico = new Medico(null, null, null, null, null, null);

try {
    $medico->excluir($idMedico);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/medicos.php');
exit();
?>