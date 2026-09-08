<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Paciente.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    switch ($action) {
        case 'create':
            $paciente = new Paciente($_POST['nome'], $_POST['dataNascimento'], $_POST['cpf'], $_POST['telefone'], $_POST['email']);
            $paciente->inserir();
            break;

        case 'update':
            $paciente = new Paciente($_POST['nome'], $_POST['dataNascimento'], $_POST['cpf'], $_POST['telefone'], $_POST['email']);
            $paciente->atualizar($_POST['id']);
            break;

        case 'delete':
            $paciente = new Paciente(null, null, null, null, null);
            $paciente->excluir($_POST['id']);
            break;
    }
}

header('Location: ../pacientes.php');
exit();
