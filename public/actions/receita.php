<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Receita.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    switch ($action) {
        case 'create':
            $receita = new Receita($_POST['idConsulta'], $_POST['idPaciente'], $_POST['medicamento'], $_POST['quantidade'], $_POST['posologia'], $_POST['dataEmissao'], $_POST['dataValidade']);
            $receita->emitir();
            break;

        case 'update':
            $receita = new Receita($_POST['idConsulta'], $_POST['idPaciente'], $_POST['medicamento'], $_POST['quantidade'], $_POST['posologia'], $_POST['dataEmissao'], $_POST['dataValidade']);
            $receita->atualizar($_POST['idReceita']);
            break;

        case 'delete':
            $receita = new Receita(null, null, null, null, null, null, null);
            $receita->excluir($_POST['id']);
            break;
    }
}

header('Location: ../receitas.php');
exit();
