<?php
$pageTitle = 'Pagamentos';
$currentPage = 'pagamento';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Controle pagamentos de consultas';
$pageStyles = ['pagamentos.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Gerenciar Pagamentos</h2>
                <p>Controle pagamentos de consultas</p>
            </div>
            <a href="cadastroPagamento.html" class="btn-primary new-item-btn">
                <i class="fas fa-plus"></i> Novo Pagamento
            </a>
        </div>
        
        <div class="payment-summary-grid">
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total Recebido</h4>
                    <span class="summary-value success">R$ 150.00</span>
                </div>
                <div class="card-icon green"><i class="fas fa-money-bill-wave"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total Pendente</h4>
                    <span class="summary-value pending">R$ 200.00</span>
                </div>
                <div class="card-icon yellow"><i class="fas fa-wallet"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total de Pagamentos</h4>
                    <span class="summary-value primary">2</span>
                </div>
                <div class="card-icon blue"><i class="fas fa-receipt"></i></div>
            </div>
        </div>

        <div class="data-section">
            <h3>Lista de Pagamentos</h3>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar por paciente, médico ou forma...">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CONSULTA</th>
                            <th>PACIENTE</th>
                            <th>MÉDICO</th>
                            <th>VALOR</th>
                            <th>DATA PAGAMENTO</th>
                            <th>FORMA PAGAMENTO</th>
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
                            <td>R$ 150.00</td>
                            <td>14/09/2024</td>
                            <td>Cartão</td>
                            <td><span class="status-badge pago">pago</span></td>
                            <td class="actions">
                                <a href="atualizarPagamento.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarPagamento.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>#2</td>
                            <td class="main-info">João Pedro Costa</td>
                            <td>Dra. Ana Lima</td>
                            <td>R$ 200.00</td>
                            <td>14/09/2024</td>
                            <td>PIX</td>
                            <td><span class="status-badge pendente">pendente</span></td>
                           <td class="actions">
                                <a href="atualizarPagamento.html" class="action-icon info-icon"><i class="fas fa-pencil-alt"></i></a>
                                <a href="deletarPagamento.html" class="action-icon edit-icon"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php include 'partials/_footer.php'; ?>