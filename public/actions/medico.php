<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Medico.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    $status = ($_POST['status'] ?? '') === 'ativo' ? 'ativo' : 'inativo';

    switch ($action) {
        case 'create':
            $medico = new Medico($_POST['nome'], $_POST['crm'], $_POST['telefone'], $_POST['especialidade'], $_POST['email'], $status);
            $medico->inserir();
            break;

        case 'update':
            $medico = new Medico($_POST['nome'], $_POST['crm'], $_POST['telefone'], $_POST['especialidade'], $_POST['email'], $status);
            $medico->atualizar($_POST['id']);
            break;

        case 'delete':
            $medico = new Medico(null, null, null, null, null, null);
            $medico->excluir($_POST['id']);
            break;
    }
}

header('Location: ../medicos.php');
exit();
