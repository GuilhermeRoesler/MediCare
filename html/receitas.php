<?php
$pageTitle = 'Receitas';
$currentPage = 'receitas';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Gerencie receitas e prescrições';
$pageStyles = ['receitas.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Receitas Médicas</h2>
                <p>Gerencie receitas e prescrições</p>
            </div>
            <a href="cadastroReceita.html" class="btn-primary new-item-btn">
                <i class="fas fa-plus"></i> Nova Receita
            </a>
        </div>

        <div class="payment-summary-grid recipe-summary-grid">
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total de Receitas</h4>
                    <span class="summary-value primary">2</span>
                </div>
                <div class="card-icon blue"><i class="fas fa-file-alt"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Vencendo em 7 dias</h4>
                    <span class="summary-value pending">0</span>
                </div>
                <div class="card-icon yellow"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Vencidas</h4>
                    <span class="summary-value error">2</span>
                </div>
                <div class="card-icon red"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>

        <div class="data-section">
            <h3>Lista de Receitas</h3>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar por paciente, médico ou medi...">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CONSULTA</th>
                            <th>PACIENTE</th>
                            <th>MÉDICO</th>
                            <th>MEDICAMENTO</th>
                            <th>DATA EMISSÃO</th>
                            <th>VALIDADE</th>
                            <th>STATUS</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>#1</td>
                            <td class="main-info">Maria Silva Santos</td>
                            <td>Dr. João Santos</td>
                            <td>Losartana 50mg</td>
                            <td>14/09/2024</td>
                            <td>14/12/2024</td>
                            <td><span class="status-badge vencida">Vencida</span></td>
                            <td class="actions">
                                <a href="atualizarReceita.html" class="action-icon info-icon"><i
                                        class="fas fa-pencil-alt"></i></a>
                                <a href="deletarReceita.html" class="action-icon edit-icon"><i
                                        class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>#2</td>
                            <td class="main-info">João Pedro Costa</td>
                            <td>Dra. Ana Lima</td>
                            <td>Protetor Solar FPS 60</td>
                            <td>14/09/2024</td>
                            <td>14/10/2024</td>
                            <td><span class="status-badge vencida">Vencida</span></td>
                            <td class="actions">
                                <a href="atualizarPagamento.html" class="action-icon info-icon"><i
                                        class="fas fa-pencil-alt"></i></a>
                                <a href="deletarReceita.html" class="action-icon edit-icon"><i
                                        class="fas fa-times"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php include 'partials/_footer.php'; ?>