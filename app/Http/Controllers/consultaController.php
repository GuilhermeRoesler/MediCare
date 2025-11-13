<?php
require_once __DIR__ . '/../../Models/Consulta.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'create':
            $consulta = new Consulta($_POST['idMedico'], $_POST['idPaciente'], $_POST['inicio'], $_POST['fim'], $_POST['status'], $_POST['sala'], $_POST['motivo']);
            $consulta->marcar();
            header('Location: ../../../public/consulta.php');
            break;

        case 'update':
            $consulta = new Consulta($_POST['idMedico'], $_POST['idPaciente'], $_POST['inicio'], $_POST['fim'], $_POST['status'], $_POST['sala'], $_POST['motivo']);
            $consulta->atualizar($_POST['id']);
            header('Location: ../../../public/consulta.php');
            break;

        case 'delete':
            $consulta = new Consulta(null, null, null, null, null, null, null);
            $consulta->cancelar($_POST['id']);
            header('Location: ../../../public/consulta.php');
            break;
    }
}
exit();
?>