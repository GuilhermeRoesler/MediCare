<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
$primeiraLetra = strtoupper(substr($nomeUsuario, 0, 1));

require_once '../app/Core/Conexao.php';
$pdo = Conexao::getConexao();

$pageTitle = 'Relatórios';
$currentPage = 'relatorios';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Acompanhe métricas e relatórios do sistema';
$pageStyles = ['relatorios.css'];

// --- DADOS PARA GRÁFICOS ---
$mesesPt = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];

// Gráfico 1: Consultas Agendadas vs. Realizadas
$consultasRealizadasStmt = $pdo->query("
    SELECT DATE_FORMAT(inicio, '%Y-%m') as mes, 
           SUM(CASE WHEN status = 'Finalizada' THEN 1 ELSE 0 END) as realizadas,
           SUM(CASE WHEN status IN ('Agendada', 'Confirmada') THEN 1 ELSE 0 END) as agendadas
    FROM consultas WHERE inicio >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY mes ORDER BY mes ASC
");
$consultasRealizadasData = $consultasRealizadasStmt->fetchAll(PDO::FETCH_ASSOC);
$relatorio1_labels = []; $relatorio1_data_realizadas = []; $relatorio1_data_agendadas = [];
foreach ($consultasRealizadasData as $data) {
    $mesNum = explode('-', $data['mes'])[1];
    $relatorio1_labels[] = $mesesPt[$mesNum];
    $relatorio1_data_realizadas[] = $data['realizadas'];
    $relatorio1_data_agendadas[] = $data['agendadas'];
}

// Gráfico 2: Faturamento por Período
$faturamentoStmt = $pdo->query("
    SELECT DATE_FORMAT(data_pagamento, '%Y-%m') as mes, SUM(valor) as total
    FROM pagamentos WHERE status = 'pago' AND data_pagamento >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY mes ORDER BY mes ASC
");
$faturamentoData = $faturamentoStmt->fetchAll(PDO::FETCH_ASSOC);
$relatorio2_labels = []; $relatorio2_data = [];
foreach ($faturamentoData as $data) {
    $mesNum = explode('-', $data['mes'])[1];
    $relatorio2_labels[] = $mesesPt[$mesNum];
    $relatorio2_data[] = $data['total'];
}

// Gráfico 3: Consultas por Especialidade
$especialidadeStmt = $pdo->query("
    SELECT m.especialidade, COUNT(c.id) as total FROM consultas c JOIN medicos m ON c.id_medico = m.id GROUP BY m.especialidade ORDER BY total DESC
");
$especialidadeData = $especialidadeStmt->fetchAll(PDO::FETCH_ASSOC);
$relatorio3_labels = []; $relatorio3_data = [];
foreach ($especialidadeData as $data) {
    $relatorio3_labels[] = $data['especialidade'];
    $relatorio3_data[] = $data['total'];
}

// Gráfico 4: Novos Pacientes (Mês) - Assumindo que a tabela `pacientes` tem a coluna `criado_em`
$novosPacientesStmt = $pdo->query("
    SELECT DATE_FORMAT(criado_em, '%Y-%m') as mes, COUNT(id) as total FROM pacientes WHERE criado_em >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY mes ORDER BY mes ASC
");
$novosPacientesData = $novosPacientesStmt->fetchAll(PDO::FETCH_ASSOC);
$relatorio4_labels = []; $relatorio4_data = [];
foreach ($novosPacientesData as $data) {
    $mesNum = explode('-', $data['mes'])[1];
    $relatorio4_labels[] = $mesesPt[$mesNum];
    $relatorio4_data[] = $data['total'];
}

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
            <a href="exportar_relatorio.php" class="btn-secondary">
                <i class="fas fa-download"></i> Exportar Dados
            </a>
        </div>
        
        <div class="filter-options">
            <select>
                <option>Período: Últimos 6 meses</option>
                <option>Período: Últimos 30 dias</option>
                <option>Período: Mês Atual</option>
            </select>
            <select>
                <option>Médico: Todos</option>
            </select>
        </div>

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
        
        new Chart(document.getElementById('consultasRealizadasChart'), {
            type: 'bar',
            data: { labels: <?php echo json_encode($relatorio1_labels); ?>, datasets: [ { label: 'Agendadas', data: <?php echo json_encode($relatorio1_data_agendadas); ?>, backgroundColor: 'rgba(245, 158, 11, 0.8)', }, { label: 'Realizadas', data: <?php echo json_encode($relatorio1_data_realizadas); ?>, backgroundColor: 'rgba(16, 185, 129, 0.8)', } ] },
            options: { ...chartOptions, plugins: { legend: { display: true } } }
        });

        new Chart(document.getElementById('faturamentoChart'), {
            type: 'line',
            data: { labels: <?php echo json_encode($relatorio2_labels); ?>, datasets: [{ label: 'Faturamento (R$)', data: <?php echo json_encode($relatorio2_data); ?>, borderColor: 'rgba(37, 99, 235, 1)', backgroundColor: 'rgba(37, 99, 235, 0.1)', fill: true, tension: 0.3 }] },
            options: chartOptions
        });

        new Chart(document.getElementById('especialidadeChart'), {
            type: 'pie',
            data: { labels: <?php echo json_encode($relatorio3_labels); ?>, datasets: [{ data: <?php echo json_encode($relatorio3_data); ?>, backgroundColor: ['#2563eb', '#10b981', '#ef4444', '#f59e0b', '#6b7280'] }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } } }
        });

        new Chart(document.getElementById('novosPacientesChart'), {
            type: 'bar',
            data: { labels: <?php echo json_encode($relatorio4_labels); ?>, datasets: [{ label: 'Novos Pacientes', data: <?php echo json_encode($relatorio4_data); ?>, backgroundColor: 'rgba(16, 185, 129, 0.8)' }] },
            options: chartOptions
        });
    </script>
<?php include 'partials/_footer.php'; ?>