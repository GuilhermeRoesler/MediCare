<?php
require_once __DIR__ . '/../../Models/Pagamento.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'create':
            $pagamento = new Pagamento($_POST['idConsulta'], $_POST['valor'], $_POST['dataPagamento'], $_POST['metodo'], $_POST['status']);
            $pagamento->registrar();
            header('Location: ../../../public/pagamento.php');
            break;

        case 'update':
            $pagamento = new Pagamento($_POST['idConsulta'], $_POST['valor'], $_POST['dataPagamento'], $_POST['metodo'], $_POST['status']);
            $pagamento->atualizar($_POST['idPagamento']);
            header('Location: ../../../public/pagamento.php');
            break;

        case 'delete':
            $pagamento = new Pagamento(null, null, null, null, null);
            $pagamento->excluir($_POST['id']);
            header('Location: ../../../public/pagamento.php');
            break;
    }
}
exit();
?>