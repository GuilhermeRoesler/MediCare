<?php
$pageTitle = 'Consultas';
$currentPage = 'consulta';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Agende e gerencie consultas médicas';
$pageStyles = ['consulta.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Gerenciar Consultas</h2>
                <p>Agende e gerencie consultas médicas</p>
            </div>
            <a href="cadastroConsulta.php" class="btn-primary new-item-btn">
                <i class="fas fa-plus"></i> Nova Consulta
            </a>
        </div>
        
        <div class="data-section">
            <h3>Lista de Consultas</h3>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar por paciente, médico ou sala...">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PACIENTE</th>
                            <th>MÉDICO</th>
                            <th>DATA/HORA INÍCIO</th>
                            <th>DATA/HORA FIM</th>
                            <th>STATUS</th>
                            <th>SALA</th>
                            <th>MOTIVO</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="main-info">Maria Silva Santos</td>
                            <td>Dr. João Santos</td>
                            <td>15/09/2024, 09:30</td>
                            <td>15/09/2024, 09:30</td>
                            <td><span class="status-badge confirmed">confirmada</span></td>
                            <td>Sala 1</td>
                            <td>Consulta de rotina</td>
                             <td class="actions">
                                <a href="atualizarConsulta.php" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarConsulta.php" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="main-info">João Pedro Costa</td>
                            <td>Dra. Ana Lima</td>
                            <td>15/09/2024, 10:30</td>
                            <td>15/09/2024, 11:00</td>
                            <td><span class="status-badge agendada">agendada</span></td>
                            <td>Sala 2</td>
                            <td>Acompanhamento dermatológico</td>
                             <td class="actions">
                                <a href="atualizarConsulta.php" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarConsulta.php" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php include 'partials/_footer.php'; ?>