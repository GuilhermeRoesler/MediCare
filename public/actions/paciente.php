<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Paciente.php';

$action = $_GET['action'] ?? '';
$redirect = '../pacientes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    try {
        switch ($action) {
            case 'create':
            case 'update':
                $nome = trim($_POST['nome'] ?? '');
                $dataNascimento = trim($_POST['dataNascimento'] ?? '');
                $cpf = trim($_POST['cpf'] ?? '');
                $telefone = trim($_POST['telefone'] ?? '');
                $email = trim($_POST['email'] ?? '');

                if (!Validator::required($nome, $dataNascimento, $cpf, $telefone)) {
                    Flash::error('Preencha todos os campos obrigatórios.');
                    break;
                }

                if (!Validator::cpf($cpf)) {
                    Flash::error('CPF inválido. Informe 11 dígitos.');
                    break;
                }

                if ($email !== '' && !Validator::email($email)) {
                    Flash::error('E-mail inválido.');
                    break;
                }

                $paciente = new Paciente($nome, $dataNascimento, $cpf, $telefone, $email);

                if ($action === 'create') {
                    $paciente->inserir();
                    Flash::success('Paciente cadastrado com sucesso.');
                } else {
                    $id = Validator::positiveInt($_POST['id'] ?? null);
                    if ($id === null) {
                        Flash::error('Paciente inválido.');
                        break;
                    }
                    $paciente->atualizar($id);
                    Flash::success('Paciente atualizado com sucesso.');
                }
                break;

            case 'delete':
                Auth::requireAdminFromActions();
                $id = Validator::positiveInt($_POST['id'] ?? null);
                if ($id === null) {
                    Flash::error('Paciente inválido.');
                    break;
                }
                $paciente = new Paciente(null, null, null, null, null);
                $paciente->excluir($id);
                Flash::success('Paciente excluído com sucesso.');
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
