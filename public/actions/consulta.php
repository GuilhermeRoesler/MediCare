<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Consulta.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    switch ($action) {
        case 'create':
            $consulta = new Consulta($_POST['idMedico'], $_POST['idPaciente'], $_POST['inicio'], $_POST['fim'], $_POST['status'], $_POST['sala'], $_POST['motivo']);
            $consulta->marcar();
            break;

        case 'update':
            $consulta = new Consulta($_POST['idMedico'], $_POST['idPaciente'], $_POST['inicio'], $_POST['fim'], $_POST['status'], $_POST['sala'], $_POST['motivo']);
            $consulta->atualizar($_POST['id']);
            break;

        case 'delete':
            $consulta = new Consulta(null, null, null, null, null, null, null);
            $consulta->cancelar($_POST['id']);
            break;
    }
}

header('Location: ../consulta.php');
exit();
