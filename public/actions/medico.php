<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Medico.php';

$action = $_GET['action'] ?? '';
$redirect = '../medicos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();
    Auth::requireAdminFromActions();

    try {
        $status = ($_POST['status'] ?? '') === 'ativo' ? 'ativo' : 'inativo';

        switch ($action) {
            case 'create':
            case 'update':
                $nome = trim($_POST['nome'] ?? '');
                $crm = trim($_POST['crm'] ?? '');
                $telefone = trim($_POST['telefone'] ?? '');
                $especialidade = trim($_POST['especialidade'] ?? '');
                $email = trim($_POST['email'] ?? '');

                if (!Validator::required($nome, $crm, $telefone, $especialidade, $email)) {
                    Flash::error('Preencha todos os campos obrigatórios.');
                    break;
                }

                if (!Validator::email($email)) {
                    Flash::error('E-mail inválido.');
                    break;
                }

                $medico = new Medico($nome, $crm, $telefone, $especialidade, $email, $status);

                if ($action === 'create') {
                    $medico->inserir();
                    Flash::success('Médico cadastrado com sucesso.');
                } else {
                    $id = Validator::positiveInt($_POST['id'] ?? null);
                    if ($id === null) {
                        Flash::error('Médico inválido.');
                        break;
                    }
                    $medico->atualizar($id);
                    Flash::success('Médico atualizado com sucesso.');
                }
                break;

            case 'delete':
                $id = Validator::positiveInt($_POST['id'] ?? null);
                if ($id === null) {
                    Flash::error('Médico inválido.');
                    break;
                }
                $medico = new Medico(null, null, null, null, null, null);
                $medico->excluir($id);
                Flash::success('Médico excluído com sucesso.');
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
