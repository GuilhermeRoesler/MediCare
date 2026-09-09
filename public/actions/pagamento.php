<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Pagamento.php';
require_once __DIR__ . '/../../app/Models/Consulta.php';

$action = $_GET['action'] ?? '';
$redirect = '../pagamento.php';
$metodos = ['cartao', 'pix', 'dinheiro', 'transferencia'];
$statusPermitidos = ['pago', 'pendente', 'cancelado'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    try {
        switch ($action) {
            case 'create':
            case 'update':
                $idConsulta = Validator::positiveInt($_POST['idConsulta'] ?? null);
                $valor = Validator::nonNegativeNumber($_POST['valor'] ?? null);
                $dataPagamento = trim($_POST['dataPagamento'] ?? '');
                $metodo = trim($_POST['metodo'] ?? '');
                $status = trim($_POST['status'] ?? '');

                if ($idConsulta === null || $valor === null || !Validator::required($dataPagamento, $metodo, $status)) {
                    Flash::error('Preencha todos os campos obrigatórios.');
                    break;
                }

                if (!Validator::inList($metodo, $metodos) || !Validator::inList($status, $statusPermitidos)) {
                    Flash::error('Método ou status de pagamento inválido.');
                    break;
                }

                $consultaModel = new Consulta(null, null, null, null, null, null, null);
                if (!$consultaModel->buscarPorId($idConsulta)) {
                    Flash::error('Consulta selecionada não existe.');
                    break;
                }

                $pagamento = new Pagamento($idConsulta, $valor, $dataPagamento, $metodo, $status);

                if ($action === 'create') {
                    $pagamento->registrar();
                    Flash::success('Pagamento registrado com sucesso.');
                } else {
                    $id = Validator::positiveInt($_POST['idPagamento'] ?? null);
                    if ($id === null) {
                        Flash::error('Pagamento inválido.');
                        break;
                    }
                    $pagamento->atualizar($id);
                    Flash::success('Pagamento atualizado com sucesso.');
                }
                break;

            case 'delete':
                Auth::requireAdminFromActions();
                $id = Validator::positiveInt($_POST['id'] ?? null);
                if ($id === null) {
                    Flash::error('Pagamento inválido.');
                    break;
                }
                $pagamento = new Pagamento(null, null, null, null, null);
                $pagamento->excluir($id);
                Flash::success('Pagamento excluído com sucesso.');
                break;

            default:
                Flash::error('Ação inválida.');
                break;
        }
    } catch (Throwable $e) {
        Flash::error('Não foi possível concluir a operação. Verifique os dados e vínculos existentes.');
    }
}

header('Location: ' . $redirect);
exit();
