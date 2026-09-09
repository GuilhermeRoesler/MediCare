<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';
Auth::requireLoginFromActions();

require_once __DIR__ . '/../../app/Models/Receita.php';
require_once __DIR__ . '/../../app/Models/Consulta.php';
require_once __DIR__ . '/../../app/Models/Paciente.php';

$action = $_GET['action'] ?? '';
$redirect = '../receitas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::validate();

    try {
        switch ($action) {
            case 'create':
            case 'update':
                $idConsulta = Validator::positiveInt($_POST['idConsulta'] ?? null);
                $idPaciente = Validator::positiveInt($_POST['idPaciente'] ?? null);
                $medicamento = trim($_POST['medicamento'] ?? '');
                $quantidade = Validator::positiveInt($_POST['quantidade'] ?? null);
                $posologia = trim($_POST['posologia'] ?? '');
                $dataEmissao = trim($_POST['dataEmissao'] ?? '');
                $dataValidade = trim($_POST['dataValidade'] ?? '');

                if ($idConsulta === null || $idPaciente === null || $quantidade === null
                    || !Validator::required($medicamento, $posologia, $dataEmissao, $dataValidade)) {
                    Flash::error('Preencha todos os campos obrigatórios.');
                    break;
                }

                if (!Validator::dateOrder($dataEmissao, $dataValidade)) {
                    Flash::error('A validade deve ser igual ou posterior à data de emissão.');
                    break;
                }

                $consultaModel = new Consulta(null, null, null, null, null, null, null);
                $pacienteModel = new Paciente(null, null, null, null, null);
                $consulta = $consultaModel->buscarPorId($idConsulta);
                if (!$consulta || !$pacienteModel->buscarPorId($idPaciente)) {
                    Flash::error('Consulta ou paciente selecionado não existe.');
                    break;
                }

                if ((int) $consulta['id_paciente'] !== $idPaciente) {
                    Flash::error('O paciente deve corresponder à consulta selecionada.');
                    break;
                }

                $receita = new Receita($idConsulta, $idPaciente, $medicamento, $quantidade, $posologia, $dataEmissao, $dataValidade);

                if ($action === 'create') {
                    $receita->emitir();
                    Flash::success('Receita emitida com sucesso.');
                } else {
                    $id = Validator::positiveInt($_POST['idReceita'] ?? null);
                    if ($id === null) {
                        Flash::error('Receita inválida.');
                        break;
                    }
                    $receita->atualizar($id);
                    Flash::success('Receita atualizada com sucesso.');
                }
                break;

            case 'delete':
                Auth::requireAdminFromActions();
                $id = Validator::positiveInt($_POST['id'] ?? null);
                if ($id === null) {
                    Flash::error('Receita inválida.');
                    break;
                }
                $receita = new Receita(null, null, null, null, null, null, null);
                $receita->excluir($id);
                Flash::success('Receita excluída com sucesso.');
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
