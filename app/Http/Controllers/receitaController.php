<?php
require_once __DIR__ . '/../../Models/Receita.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'create':
            $receita = new Receita($_POST['idConsulta'], $_POST['idPaciente'], $_POST['medicamento'], $_POST['quantidade'], $_POST['posologia'], $_POST['dataEmissao'], $_POST['dataValidade']);
            $receita->emitir();
            header('Location: ../../../public/receitas.php');
            break;

        case 'update':
            $receita = new Receita($_POST['idConsulta'], $_POST['idPaciente'], $_POST['medicamento'], $_POST['quantidade'], $_POST['posologia'], $_POST['dataEmissao'], $_POST['dataValidade']);
            $receita->atualizar($_POST['idReceita']);
            header('Location: ../../../public/receitas.php');
            break;

        case 'delete':
            $receita = new Receita(null, null, null, null, null, null, null);
            $receita->excluir($_POST['id']);
            header('Location: ../../../public/receitas.php');
            break;
    }
}
exit();
?>