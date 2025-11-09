<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Consulta.php";

$id = $_POST['id'];
$idMedico = $_POST['idMedico'];
$idPaciente = $_POST['idPaciente'];
$inicio = $_POST['inicio'];
$fim = $_POST['fim'];
$sala = $_POST['sala'];
$status = $_POST['status'];
$motivo = $_POST['motivo'];

$consulta = new Consulta($idMedico, $idPaciente, $inicio, $fim, $status, $sala, $motivo);

try {
    $consulta->atualizar($id);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/consulta.php');
exit();
?>