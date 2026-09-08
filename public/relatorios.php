<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

require_once '../app/Core/Conexao.php';
$pdo = Conexao::getConexao();

$pageTitle = 'Relatórios';
$currentPage = 'relatorios';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Acompanhe métricas e relatórios do sistema';
$pageStyles = ['relatorios.css'];

$periodo = $_GET['periodo'] ?? '6m';
$medicoId = isset($_GET['medico']) && $_GET['medico'] !== '' ? (int) $_GET['medico'] : null;

$periodosValidos = ['6m' => 6, '30d' => null, 'mes' => null];
if (!array_key_exists($periodo, $periodosValidos)) {
    $periodo = '6m';
}

$mesesPt = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];

$meses_periodo = [];
$labels_finais_mes = [];

if ($periodo === '6m') {
    for ($i = 5; $i >= 0; $i--) {
        $date = new DateTime("first day of -$i month");
        $meses_periodo[$date->format('Y-m')] = 0;
    }
} elseif ($periodo === 'mes') {
    $date = new DateTime('first day of this month');
    $meses_periodo[$date->format('Y-m')] = 0;
} else {
    // 30 dias: agrupa por semana aproximada (rótulos diários reduzidos a buckets mensais se cruzar)
    for ($i = 1; $i >= 0; $i--) {
        $date = new DateTime("first day of -$i month");
        $meses_periodo[$date->format('Y-m')] = 0;
    }
}

foreach (array_keys($meses_periodo) as $mes_ano) {
    $mes_num = explode('-', $mes_ano)[1];
    $labels_finais_mes[] = $mesesPt[$mes_num];
}

if ($periodo === '6m') {
    $inicioFiltro = "DATE_SUB(NOW(), INTERVAL 6 MONTH)";
} elseif ($periodo === '30d') {
    $inicioFiltro = "DATE_SUB(NOW(), INTERVAL 30 DAY)";
} else {
    $inicioFiltro = "DATE_FORMAT(NOW(), '%Y-%m-01')";
}

$medicoFilterSql = $medicoId ? ' AND c.id_medico = :medico_id' : '';
$medicoFilterPag = $medicoId ? ' AND c.id_medico = :medico_id' : '';

$medicosLista = $pdo->query("SELECT id, nome_completo FROM medicos ORDER BY nome_completo")->fetchAll(PDO::FETCH_ASSOC);

// Gráfico 1
$sql1 = "
    SELECT DATE_FORMAT(c.inicio, '%Y-%m') as mes,
           SUM(CASE WHEN c.status = 'finalizada' THEN 1 ELSE 0 END) as realizadas,
           SUM(CASE WHEN c.status IN ('agendada', 'confirmada') THEN 1 ELSE 0 END) as agendadas
    FROM consultas c
    WHERE c.inicio >= $inicioFiltro $medicoFilterSql
    GROUP BY mes ORDER BY mes ASC
";
$stmt1 = $pdo->prepare($sql1);
if ($medicoId) {
    $stmt1->bindValue(':medico_id', $medicoId, PDO::PARAM_INT);
}
$stmt1->execute();
$consultasRealizadasData = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$relatorio1_data_realizadas = $meses_periodo;
$relatorio1_data_agendadas = $meses_periodo;
foreach ($consultasRealizadasData as $data) {
    if (isset($meses_periodo[$data['mes']])) {
        $relatorio1_data_realizadas[$data['mes']] = (int) $data['realizadas'];
        $relatorio1_data_agendadas[$data['mes']] = (int) $data['agendadas'];
    }
}

// Gráfico 2
$sql2 = "
    SELECT DATE_FORMAT(p.data_pagamento, '%Y-%m') as mes, SUM(p.valor) as total
    FROM pagamentos p
    JOIN consultas c ON c.id = p.id_consulta
    WHERE p.status = 'pago' AND p.data_pagamento >= $inicioFiltro $medicoFilterPag
    GROUP BY mes ORDER BY mes ASC
";
$stmt2 = $pdo->prepare($sql2);
if ($medicoId) {
    $stmt2->bindValue(':medico_id', $medicoId, PDO::PARAM_INT);
}
$stmt2->execute();
$faturamentoData = $stmt2->fetchAll(PDO::FETCH_KEY_PAIR);
$relatorio2_data = array_replace($meses_periodo, $faturamentoData);

// Gráfico 3
$sql3 = "
    SELECT m.especialidade, COUNT(c.id) as total
    FROM consultas c
    JOIN medicos m ON c.id_medico = m.id
    WHERE c.inicio >= $inicioFiltro $medicoFilterSql
    GROUP BY m.especialidade ORDER BY total DESC
";
$stmt3 = $pdo->prepare($sql3);
if ($medicoId) {
    $stmt3->bindValue(':medico_id', $medicoId, PDO::PARAM_INT);
}
$stmt3->execute();
$especialidadeData = $stmt3->fetchAll(PDO::FETCH_ASSOC);
$relatorio3_labels = [];
$relatorio3_data = [];
foreach ($especialidadeData as $data) {
    $relatorio3_labels[] = $data['especialidade'];
    $relatorio3_data[] = $data['total'];
}

// Gráfico 4 (não filtra por médico)
$sql4 = "
    SELECT DATE_FORMAT(criado_em, '%Y-%m') as mes, COUNT(id) as total
    FROM pacientes
    WHERE criado_em >= $inicioFiltro
    GROUP BY mes ORDER BY mes ASC
";
$novosPacientesData = $pdo->query($sql4)->fetchAll(PDO::FETCH_KEY_PAIR);
$relatorio4_data = array_replace($meses_periodo, $novosPacientesData);

$exportQuery = http_build_query(array_filter([
    'periodo' => $periodo,
    'medico' => $medicoId,
]));

include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card reports-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Relatórios Gerenciais</h2>
                <p>Filtre e visualize os principais indicadores</p>
            </div>
            <a href="exportar_relatorio.php?<?php echo htmlspecialchars($exportQuery); ?>" class="btn-secondary">
                <i class="fas fa-download"></i> Exportar Dados
            </a>
        </div>

        <form class="filter-options" method="get" action="relatorios.php">
            <label class="sr-only" for="periodo">Período</label>
            <select id="periodo" name="periodo" onchange="this.form.submit()">
                <option value="6m" <?php echo $periodo === '6m' ? 'selected' : ''; ?>>Período: Últimos 6 meses</option>
                <option value="30d" <?php echo $periodo === '30d' ? 'selected' : ''; ?>>Período: Últimos 30 dias</option>
                <option value="mes" <?php echo $periodo === 'mes' ? 'selected' : ''; ?>>Período: Mês atual</option>
            </select>

            <label class="sr-only" for="medico">Médico</label>
            <select id="medico" name="medico" onchange="this.form.submit()">
                <option value="">Médico: Todos</option>
                <?php foreach ($medicosLista as $medico): ?>
                    <option value="<?php echo (int) $medico['id']; ?>" <?php echo $medicoId === (int) $medico['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($medico['nome_completo']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <div class="reports-grid">
            <div class="report-block">
                <h4><i class="fas fa-calendar-check"></i> Consultas Agendadas vs. Realizadas</h4>
                <div class="chart-container"><canvas id="consultasRealizadasChart"></canvas></div>
            </div>

            <div class="report-block">
                <h4><i class="fas fa-file-invoice-dollar"></i> Faturamento por Período</h4>
                <div class="chart-container"><canvas id="faturamentoChart"></canvas></div>
            </div>

            <div class="report-block">
                <h4><i class="fas fa-user-md"></i> Consultas por Especialidade</h4>
                <div class="chart-container"><canvas id="especialidadeChart"></canvas></div>
            </div>

            <div class="report-block">
                <h4><i class="fas fa-user-injured"></i> Novos Pacientes (Mês)</h4>
                <div class="chart-container"><canvas id="novosPacientesChart"></canvas></div>
            </div>
        </div>
    </section>

    <script>
        const chartOptions = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } };
        const labelsMeses = <?php echo json_encode($labels_finais_mes); ?>;

        new Chart(document.getElementById('consultasRealizadasChart'), {
            type: 'bar',
            data: { labels: labelsMeses, datasets: [ { label: 'Agendadas', data: <?php echo json_encode(array_values($relatorio1_data_agendadas)); ?>, backgroundColor: 'rgba(245, 158, 11, 0.8)', }, { label: 'Realizadas', data: <?php echo json_encode(array_values($relatorio1_data_realizadas)); ?>, backgroundColor: 'rgba(16, 185, 129, 0.8)', } ] },
            options: { ...chartOptions, plugins: { legend: { display: true } } }
        });

        new Chart(document.getElementById('faturamentoChart'), {
            type: 'line',
            data: { labels: labelsMeses, datasets: [{ label: 'Faturamento (R$)', data: <?php echo json_encode(array_values($relatorio2_data)); ?>, borderColor: 'rgba(37, 99, 235, 1)', backgroundColor: 'rgba(37, 99, 235, 0.1)', fill: true, tension: 0.3 }] },
            options: chartOptions
        });

        new Chart(document.getElementById('especialidadeChart'), {
            type: 'pie',
            data: { labels: <?php echo json_encode($relatorio3_labels); ?>, datasets: [{ data: <?php echo json_encode($relatorio3_data); ?>, backgroundColor: ['#2563eb', '#10b981', '#ef4444', '#f59e0b', '#6b7280'] }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } } }
        });

        new Chart(document.getElementById('novosPacientesChart'), {
            type: 'bar',
            data: { labels: labelsMeses, datasets: [{ label: 'Novos Pacientes', data: <?php echo json_encode(array_values($relatorio4_data)); ?>, backgroundColor: 'rgba(16, 185, 129, 0.8)' }] },
            options: chartOptions
        });
    </script>
<?php include 'partials/_footer.php'; ?>
