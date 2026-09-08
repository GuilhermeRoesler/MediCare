<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Pagamento.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    switch ($action) {
        case 'create':
            $pagamento = new Pagamento($_POST['idConsulta'], $_POST['valor'], $_POST['dataPagamento'], $_POST['metodo'], $_POST['status']);
            $pagamento->registrar();
            break;

        case 'update':
            $pagamento = new Pagamento($_POST['idConsulta'], $_POST['valor'], $_POST['dataPagamento'], $_POST['metodo'], $_POST['status']);
            $pagamento->atualizar($_POST['idPagamento']);
            break;

        case 'delete':
            $pagamento = new Pagamento(null, null, null, null, null);
            $pagamento->excluir($_POST['id']);
            break;
    }
}

header('Location: ../pagamento.php');
exit();
