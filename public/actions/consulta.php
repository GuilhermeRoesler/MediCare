<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Consulta.php';
require_once __DIR__ . '/../../app/Models/Medico.php';
require_once __DIR__ . '/../../app/Models/Paciente.php';

$action = $_GET['action'] ?? '';
$redirect = '../consulta.php';
$statusPermitidos = ['agendada', 'confirmada', 'cancelada', 'finalizada'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    try {
        switch ($action) {
            case 'create':
            case 'update':
                $idMedico = Validator::positiveInt($_POST['idMedico'] ?? null);
                $idPaciente = Validator::positiveInt($_POST['idPaciente'] ?? null);
                $inicio = trim($_POST['inicio'] ?? '');
                $fim = trim($_POST['fim'] ?? '');
                $status = trim($_POST['status'] ?? '');
                $sala = trim($_POST['sala'] ?? '');
                $motivo = trim($_POST['motivo'] ?? '');

                if ($idMedico === null || $idPaciente === null || !Validator::required($inicio, $fim, $status, $sala, $motivo)) {
                    Flash::error('Preencha todos os campos obrigatórios.');
                    break;
                }

                if (!Validator::inList($status, $statusPermitidos)) {
                    Flash::error('Status de consulta inválido.');
                    break;
                }

                if (!Validator::datetimeRange($inicio, $fim)) {
                    Flash::error('O horário de início deve ser anterior ao de fim.');
                    break;
                }

                $medicoModel = new Medico(null, null, null, null, null, null);
                $pacienteModel = new Paciente(null, null, null, null, null);
                if (!$medicoModel->buscarPorId($idMedico) || !$pacienteModel->buscarPorId($idPaciente)) {
                    Flash::error('Médico ou paciente selecionado não existe.');
                    break;
                }

                $inicioDb = date('Y-m-d H:i:s', strtotime($inicio));
                $fimDb = date('Y-m-d H:i:s', strtotime($fim));
                $consulta = new Consulta($idMedico, $idPaciente, $inicioDb, $fimDb, $status, $sala, $motivo);

                if ($action === 'create') {
                    $consulta->marcar();
                    Flash::success('Consulta agendada com sucesso.');
                } else {
                    $id = Validator::positiveInt($_POST['id'] ?? null);
                    if ($id === null) {
                        Flash::error('Consulta inválida.');
                        break;
                    }
                    $consulta->atualizar($id);
                    Flash::success('Consulta atualizada com sucesso.');
                }
                break;

            case 'delete':
                Auth::requireAdminFromActions();
                $id = Validator::positiveInt($_POST['id'] ?? null);
                if ($id === null) {
                    Flash::error('Consulta inválida.');
                    break;
                }
                $consulta = new Consulta(null, null, null, null, null, null, null);
                $consulta->cancelar($id);
                Flash::success('Consulta excluída com sucesso.');
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
