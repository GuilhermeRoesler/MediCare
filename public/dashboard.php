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

// Cards de Estatísticas
$totalPacientes = $pdo->query("SELECT COUNT(*) FROM pacientes")->fetchColumn();
$medicosAtivos = $pdo->query("SELECT COUNT(*) FROM medicos WHERE status = 'ativo'")->fetchColumn();
$consultas30dias = $pdo->query("SELECT COUNT(*) FROM consultas WHERE inicio >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn();
$faturamento = $pdo->query("SELECT SUM(valor) FROM pagamentos WHERE status = 'pago'")->fetchColumn();

// Próximas Consultas
$stmtProximasConsultas = $pdo->query("
    SELECT c.inicio, c.sala, c.status, p.nome_completo as paciente_nome, m.nome_completo as medico_nome
    FROM consultas c
    JOIN pacientes p ON c.id_paciente = p.id
    JOIN medicos m ON c.id_medico = m.id
    WHERE c.inicio >= NOW() AND c.status IN ('agendada', 'confirmada')
    ORDER BY c.inicio ASC
    LIMIT 3
");
$proximasConsultas = $stmtProximasConsultas->fetchAll(PDO::FETCH_ASSOC);

// Médicos Mais Ativos
$stmtMedicosAtivos = $pdo->query("
    SELECT m.nome_completo, m.especialidade, COUNT(c.id) as total_consultas
    FROM medicos m
    JOIN consultas c ON m.id = c.id_medico
    WHERE c.inicio >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    GROUP BY m.id
    ORDER BY total_consultas DESC
    LIMIT 3
");
$medicosMaisAtivos = $stmtMedicosAtivos->fetchAll(PDO::FETCH_ASSOC);


$pageTitle = 'Dashboard';
$currentPage = 'dashboard';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Gerencie consultas, pacientes e médicos';
$pageStyles = ['dashboard.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="stat-cards-grid">
        <div class="stat-card">
            <div class="card-icon blue"><i class="fas fa-user-injured"></i></div>
            <h4>Total de Pacientes</h4>
            <span class="stat-value"><?php echo $totalPacientes; ?></span>
            <p class="stat-comparison success">Registrados no sistema</p>
        </div>
        <div class="stat-card">
            <div class="card-icon green"><i class="fas fa-user-md"></i></div>
            <h4>Médicos Ativos</h4>
            <span class="stat-value"><?php echo $medicosAtivos; ?></span>
            <p class="stat-comparison success">Prontos para atender</p>
        </div>
        <div class="stat-card">
            <div class="card-icon red"><i class="fas fa-calendar-alt"></i></div>
            <h4>Consultas (30 dias)</h4>
            <span class="stat-value"><?php echo $consultas30dias; ?></span>
            <p class="stat-comparison neutral">Realizadas no último mês</p>
        </div>
        <div class="stat-card">
            <div class="card-icon yellow"><i class="fas fa-file-invoice-dollar"></i></div>
            <h4>Faturamento</h4>
            <span class="stat-value">R$ <?php echo number_format($faturamento ?? 0, 2, ',', '.'); ?></span>
            <p class="stat-comparison success">Total de pagamentos recebidos</p>
        </div>
    </section>

    <section class="charts-and-ranking-grid">
        <div class="chart-card">
            <h4>Consultas por Mês</h4>
            <div class="chart-area placeholder-chart">
                Gráfico de Barras - Consultas Mensais
            </div>
        </div>
        <div class="chart-card">
            <h4>Duração Média das Consultas</h4>
            <div class="chart-area placeholder-chart">
                Gráfico de Pizza - Duração por Médico
            </div>
        </div>

        <div class="ranking-card">
            <h4><i class="fas fa-medal"></i> Médicos Mais Ativos (30 dias)</h4>
            <div class="ranking-list">
                <?php 
                $badges = ['gold', 'silver', 'bronze'];
                foreach ($medicosMaisAtivos as $index => $medico): ?>
                <div class="ranking-item">
                    <div class="rank-badge <?php echo $badges[$index] ?? ''; ?>"><?php echo $index + 1; ?></div>
                    <div class="doctor-details">
                        <strong><?php echo htmlspecialchars($medico['nome_completo']); ?></strong>
                        <small><?php echo htmlspecialchars($medico['especialidade']); ?></small>
                    </div>
                    <div class="consult-count">
                        <span><?php echo $medico['total_consultas']; ?> consultas</span>
                    </div>
                </div>
                <?php endforeach; ?>
                 <?php if (empty($medicosMaisAtivos)): ?>
                    <p style="text-align: center; color: var(--secondary-color);">Nenhuma consulta nos últimos 30 dias.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="next-appointments-card">
            <h4><i class="far fa-calendar-alt"></i> Próximas Consultas</h4>
            <div class="appointments-list">
                <?php foreach ($proximasConsultas as $consulta): ?>
                <div class="appointment-item">
                    <div>
                        <strong><?php echo htmlspecialchars($consulta['paciente_nome']); ?></strong>
                        <small><?php echo htmlspecialchars($consulta['medico_nome']); ?></small>
                        <small><?php echo date('d/m/Y - H:i', strtotime($consulta['inicio'])); ?></small>
                    </div>
                    <div class="status-badge <?php echo $consulta['status'] === 'confirmada' ? 'confirmed' : 'scheduled'; ?>">
                        <?php echo htmlspecialchars($consulta['sala']); ?><br><?php echo htmlspecialchars($consulta['status']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($proximasConsultas)): ?>
                    <p style="text-align: center; color: var(--secondary-color);">Nenhuma consulta futura agendada.</p>
                <?php endif; ?>
            </div>
            <a href="consulta.php" class="btn-primary full-width">Ver Todas as Consultas</a>
        </div>
    </section>

    <section class="quick-actions-section">
        <h3><i class="fas fa-bolt"></i> Ações Rápidas</h3>
        <div class="quick-actions-grid">
            <a href="cadastroPaciente.php" class="action-btn full-row">Novo Paciente </a>
            <a href="cadastroMedico.php" class="action-btn full-row">Novo Médico </a>
            <a href="cadastroConsulta.php" class="action-btn full-row">Nova Consulta </a>
            <a href="cadastroReceita.php" class="action-btn full-row">Nova Receita </a>
            <a href="cadastroPagamento.php" class="action-btn full-row">Novo Pagamento </a>
            <a href="relatorios.php" class="action-btn full-row">Ver Relatórios </a>
        </div>
    </section>

<?php include 'partials/_footer.php'; ?>