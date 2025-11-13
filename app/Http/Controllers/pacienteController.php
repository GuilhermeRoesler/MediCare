<?php
require_once __DIR__ . '/../../Models/Paciente.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'create':
            $paciente = new Paciente($_POST['nome'], $_POST['dataNascimento'], $_POST['cpf'], $_POST['telefone'], $_POST['email']);
            $paciente->inserir();
            header('Location: ../../../public/pacientes.php');
            break;

        case 'update':
            $paciente = new Paciente($_POST['nome'], $_POST['dataNascimento'], $_POST['cpf'], $_POST['telefone'], $_POST['email']);
            $paciente->atualizar($_POST['id']);
            header('Location: ../../../public/pacientes.php');
            break;

        case 'delete':
            $paciente = new Paciente(null, null, null, null, null);
            $paciente->excluir($_POST['id']);
            header('Location: ../../../public/pacientes.php');
            break;
    }
}
exit();
?>