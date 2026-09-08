<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();

require_once '../app/Core/Conexao.php';
$pdo = Conexao::getConexao();

$periodo = $_GET['periodo'] ?? '6m';
$medicoId = isset($_GET['medico']) && $_GET['medico'] !== '' ? (int) $_GET['medico'] : null;

if (!in_array($periodo, ['6m', '30d', 'mes'], true)) {
    $periodo = '6m';
}

if ($periodo === '6m') {
    $inicioFiltro = 'DATE_SUB(NOW(), INTERVAL 6 MONTH)';
} elseif ($periodo === '30d') {
    $inicioFiltro = 'DATE_SUB(NOW(), INTERVAL 30 DAY)';
} else {
    $inicioFiltro = "DATE_FORMAT(NOW(), '%Y-%m-01')";
}

$medicoSql = $medicoId ? ' AND c.id_medico = :medico_id' : '';

$filename = 'relatorio_consultas_' . date('Y-m-d') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');
fputs($output, "\xEF\xBB\xBF");

fputcsv($output, [
    'ID Consulta',
    'Nome do Paciente',
    'Nome do Médico',
    'Data de Início',
    'Data de Fim',
    'Status',
    'Sala',
    'Motivo',
]);

$sql = "
    SELECT
        c.id,
        p.nome_completo as paciente_nome,
        m.nome_completo as medico_nome,
        c.inicio,
        c.fim,
        c.status,
        c.sala,
        c.motivo
    FROM consultas c
    JOIN pacientes p ON c.id_paciente = p.id
    JOIN medicos m ON c.id_medico = m.id
    WHERE c.inicio >= $inicioFiltro $medicoSql
    ORDER BY c.inicio DESC
";

$stmt = $pdo->prepare($sql);
if ($medicoId) {
    $stmt->bindValue(':medico_id', $medicoId, PDO::PARAM_INT);
}
$stmt->execute();
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($consultas as $consulta) {
    fputcsv($output, [
        $consulta['id'],
        $consulta['paciente_nome'],
        $consulta['medico_nome'],
        date('d/m/Y H:i', strtotime($consulta['inicio'])),
        date('d/m/Y H:i', strtotime($consulta['fim'])),
        ucfirst($consulta['status']),
        $consulta['sala'],
        $consulta['motivo'],
    ]);
}

fclose($output);
exit();
