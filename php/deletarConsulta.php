<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../Consulta.php';

$idConsulta = $_POST['id'];

$consulta = new Consulta(null, null, null, null, null, null, null);
try {
    $consulta->cancelar($idConsulta);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/consulta.php');
exit();
?>