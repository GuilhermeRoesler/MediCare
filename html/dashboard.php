<?php
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
            <span class="stat-value">1,247</span>
            <p class="stat-comparison success">+12% vs mês anterior</p>
        </div>
        <div class="stat-card">
            <div class="card-icon green"><i class="fas fa-user-md"></i></div>
            <h4>Médicos Ativos</h4>
            <span class="stat-value">23</span>
            <p class="stat-comparison success">+2% vs mês anterior</p>
        </div>
        <div class="stat-card">
            <div class="card-icon red"><i class="fas fa-calendar-alt"></i></div>
            <h4>Consultas (30 dias)</h4>
            <span class="stat-value">342</span>
            <p class="stat-comparison neutral">+0% vs mês anterior</p>
        </div>
        <div class="stat-card">
            <div class="card-icon yellow"><i class="fas fa-file-invoice-dollar"></i></div>
            <h4>Faturamento</h4>
            <span class="stat-value">R$ 89,450</span>
            <p class="stat-comparison success">+15% vs mês anterior</p>
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
                <div class="ranking-item">
                    <div class="rank-badge gold">1</div>
                    <div class="doctor-details">
                        <strong>Dr. João Santos</strong>
                        <small>Cardiologia</small>
                    </div>
                    <div class="consult-count">
                        <span>45 consultas</span>
                        <span class="change success">+12%</span>
                    </div>
                </div>
                <div class="ranking-item">
                    <div class="rank-badge silver">2</div>
                    <div class="doctor-details">
                        <strong>Dra. Ana Lima</strong>
                        <small>Dermatologia</small>
                    </div>
                    <div class="consult-count">
                        <span>38 consultas</span>
                        <span class="change success">+8%</span>
                    </div>
                </div>
                <div class="ranking-item">
                    <div class="rank-badge bronze">3</div>
                    <div class="doctor-details">
                        <strong>Dr. Carlos Rocha</strong>
                        <small>Neurologia</small>
                    </div>
                    <div class="consult-count">
                        <span>32 consultas</span>
                        <span class="change success">+5%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="next-appointments-card">
            <h4><i class="far fa-calendar-alt"></i> Próximas Consultas</h4>
            <div class="appointments-list">
                <div class="appointment-item">
                    <div>
                        <strong>Maria Silva Santos</strong>
                        <small>Dr. João Santos</small>
                        <small>02/12/2024 - 09:00</small>
                    </div>
                    <div class="status-badge confirmed">Sala 1<br>Confirmada</div>
                </div>
                <div class="appointment-item">
                    <div>
                        <strong>Pedro Costa Lima</strong>
                        <small>Dra. Ana Lima</small>
                        <small>02/12/2024 - 10:30</small>
                    </div>
                    <div class="status-badge scheduled">Sala 2<br>Agendada</div>
                </div>
                <div class="appointment-item">
                    <div>
                        <strong>José Oliveira Silva</strong>
                        <small>Dr. Carlos Rocha</small>
                        <small>02/12/2024 - 14:00</small>
                    </div>
                    <div class="status-badge confirmed">Sala 3<br>Confirmada</div>
                </div>
            </div>
            <a href="consulta.php" class="btn-primary full-width">Ver Todas as Consultas</a>
        </div>
    </section>

    <section class="quick-actions-section">
        <h3><i class="fas fa-bolt"></i> Ações Rápidas</h3>
        <div class="quick-actions-grid">
            <a href="cadastroPaciente.html" class="action-btn full-row">Novo Paciente </a>
            <a href="cadastroMedico.html" class="action-btn full-row">Novo Médico </a>
            <a href="cadastroConsulta.html" class="action-btn full-row">Nova Consulta </a>
            <a href="cadastroReceita.html" class="action-btn full-row">Nova Receita </a>
            <a href="cadastroPagamento.html" class="action-btn full-row">Novo Pagamento </a>
            <a href="relatorios.php" class="action-btn full-row">Ver Relatórios </a>
        </div>
    </section>

<?php include 'partials/_footer.php'; ?>