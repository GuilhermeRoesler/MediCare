<?php
$pageTitle = 'Relatórios';
$currentPage = 'relatorios';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Acompanhe métricas e relatórios do sistema';
$pageStyles = ['relatorios.css'];
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
            <button class="btn-secondary">
                <i class="fas fa-download"></i> Exportar Dados
            </button>
        </div>
        
        <div class="filter-options">
            <select>
                <option>Período: Últimos 30 dias</option>
                <option>Período: Últimos 7 dias</option>
                <option>Período: Mês Atual</option>
            </select>
            <select>
                <option>Médico: Todos</option>
                <option>Dr. João Santos</option>
                <option>Dra. Ana Lima</option>
            </select>
        </div>

        <div class="reports-grid">
            <div class="report-block">
                <h4><i class="fas fa-calendar-check"></i> Consultas Agendadas vs. Realizadas</h4>
                <div class="chart-placeholder">Gráfico de Linha ou Barras</div>
                <p>Taxa de comparecimento: **92%**</p>
            </div>

            <div class="report-block">
                <h4><i class="fas fa-file-invoice-dollar"></i> Faturamento por Período</h4>
                <div class="chart-placeholder">Gráfico de Barras - Recebimento</div>
                <p>Total Recebido: **R$ 89.450**</p>
            </div>

            <div class="report-block">
                <h4><i class="fas fa-user-md"></i> Consultas por Especialidade</h4>
                <div class="chart-placeholder">Gráfico de Pizza</div>
                <p>Cardiologia: 35%, Dermatologia: 25%, Neurologia: 20%</p>
            </div>

            <div class="report-block">
                <h4><i class="fas fa-user-injured"></i> Novos Pacientes (Mês)</h4>
                <div class="chart-placeholder">Gráfico de Área</div>
                <p>Aumento de **+12%** no cadastro de pacientes novos.</p>
            </div>
        </div>
    </section>
<?php include 'partials/_footer.php'; ?>