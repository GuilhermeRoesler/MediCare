<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Medico.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$crm = $_POST['crm'];
$especialidade = $_POST['especialidade'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$status = $_POST['status'] == 'ativo' ? 1 : 0;

$medico = new Medico($nome, $crm, $telefone, $especialidade, $email, $status);

try {
    $medico->atualizar($id);
    echo "Médico atualizado com sucesso.";
} catch (Exception $e) {
    echo "Erro ao atualizar médico: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare - Dashboard</title>
    <link rel="stylesheet" href="../css/gerenciamento.css"> 
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="app-container">
        <aside class="sidebar">
            <div class="logo-section">
                <a href="dashboard.html" class="logo-text-link">
                    <i class="fas fa-notes-medical logo-icon"></i>
                    <div class="logo-text">
                        <span>MediCare</span>
                        <small>Sistema Médico</small>
                    </div>
                </a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li class="nav-item active">
                        <a href="../html/dashboard.html"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="../html/pacientes.html"><i class="fas fa-user-injured"></i> Pacientes</a>
                    </li>
                    <li class="nav-item">
                        <a href="../html/medicos.html"><i class="fas fa-user-md"></i> Médicos</a>
                    </li>
                    <li class="nav-item">
                        <a href="../html/consulta.html"><i class="fas fa-calendar-check"></i> Consultas</a>
                    </li>
                    <li class="nav-item">
                        <a href="../html/pagamento.html"><i class="fas fa-file-invoice-dollar"></i> Pagamentos</a>
                    </li>
                    <li class="nav-item">
                        <a href="../html/receitas.html"><i class="fas fa-file-prescription"></i> Receitas</a>
                    </li>
                    <li class="nav-item">
                        <a href="../html/relatorios.html"><i class="fas fa-chart-line"></i> Relatórios</a>
                    </li>
                </ul>
            </nav>
            <div class="user-footer">
                <div class="user-info">
                    <div class="user-avatar">Y</div>
                    <div>
                        <span class="username">ygor</span>
                        <small class="role">Admin</small>
                    </div>
                </div>
                <a href="../html/autenticacao.html" class="logout-btn">Sair</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <div class="header-text">
                    <h1>Painel Administrativo</h1>
                    <p>Gerencie consultas, pacientes e médicos</p>
                </div>
                <div class="header-profile">
                    <span class="notification-badge">2</span>
                    <div class="profile-details">
                        <div class="profile-avatar">Y</div>
                        <div class="profile-info">
                            <span>ygor</span>
                            <small>Admin</small>
                        </div>
                    </div>
                </div>
            </header>

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
                    <a href="../html/consulta.html" class="btn-primary full-width">Ver Todas as Consultas</a>
                </div>
            </section>

            <section class="quick-actions-section">
                <h3><i class="fas fa-bolt"></i> Ações Rápidas</h3>
                <div class="quick-actions-grid">
                    <a href="../html/cadastroPaciente.html" class="action-btn full-row">Novo Paciente </a>
                    <a href="../html/cadastroMedico.html" class="action-btn full-row">Novo Médico </a>
                    <a href="../html/cadastroConsulta.html" class="action-btn full-row">Nova Consulta </a>
                    <a href="../html/cadastroReceita.html" class="action-btn full-row">Nova Receita </a>
                    <a href="../html/cadastroPagamento.html" class="action-btn full-row">Novo Pagamento </a>
                    <a href="../html/relatorios.html" class="action-btn full-row">Ver Relatórios </a>
                </div>
            </section>
        </main>
    </div>

</body>
</html>