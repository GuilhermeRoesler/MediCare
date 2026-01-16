<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}

require_once '../app/Models/Consulta.php';

// Define o nome do arquivo que será baixado
$filename = 'relatorio_consultas_' . date('Y-m-d') . '.csv';

// Define os cabeçalhos HTTP para forçar o download do arquivo
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Cria um ponteiro de arquivo conectado ao fluxo de saída
$output = fopen('php://output', 'w');

// Adiciona um BOM (Byte Order Mark) para garantir a compatibilidade com UTF-8 no Excel
fputs($output, "\xEF\xBB\xBF");

// Escreve o cabeçalho do CSV
fputcsv($output, [
    'ID Consulta',
    'Nome do Paciente',
    'Nome do Médico',
    'Data de Início',
    'Data de Fim',
    'Status',
    'Sala',
    'Motivo'
]);

// Busca os dados das consultas
$consultaModel = new Consulta(null, null, null, null, null, null, null);
$consultas = $consultaModel->listar();

// Escreve os dados de cada consulta no arquivo CSV
if (!empty($consultas)) {
    foreach ($consultas as $consulta) {
        fputcsv($output, [
            $consulta['id'],
            $consulta['paciente_nome'],
            $consulta['medico_nome'],
            date('d/m/Y H:i', strtotime($consulta['inicio'])),
            date('d/m/Y H:i', strtotime($consulta['fim'])),
            ucfirst($consulta['status']),
            $consulta['sala'],
            $consulta['motivo']
        ]);
    }
}

// Fecha o ponteiro do arquivo
fclose($output);
exit();
?>