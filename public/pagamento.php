<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
$primeiraLetra = strtoupper(substr($nomeUsuario, 0, 1));

require_once '../app/Models/Pagamento.php';
require_once '../app/Core/Conexao.php';

$pagamentoModel = new Pagamento(null, null, null, null, null);
$pagamentos = $pagamentoModel->listar();

$pdo = Conexao::getConexao();
$totalRecebido = $pdo->query("SELECT SUM(valor) FROM pagamentos WHERE status = 'pago'")->fetchColumn();
$totalPendente = $pdo->query("SELECT SUM(valor) FROM pagamentos WHERE status = 'pendente'")->fetchColumn();
$totalPagamentos = count($pagamentos);

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
            <a href="cadastroPagamento.php" class="btn-primary new-item-btn">
                <i class="fas fa-plus"></i> Novo Pagamento
            </a>
        </div>
        
        <div class="payment-summary-grid">
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total Recebido</h4>
                    <span class="summary-value success">R$ <?php echo number_format($totalRecebido ?? 0, 2, ',', '.'); ?></span>
                </div>
                <div class="card-icon green"><i class="fas fa-money-bill-wave"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total Pendente</h4>
                    <span class="summary-value pending">R$ <?php echo number_format($totalPendente ?? 0, 2, ',', '.'); ?></span>
                </div>
                <div class="card-icon yellow"><i class="fas fa-wallet"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total de Pagamentos</h4>
                    <span class="summary-value primary"><?php echo $totalPagamentos; ?></span>
                </div>
                <div class="card-icon blue"><i class="fas fa-receipt"></i></div>
            </div>
        </div>

        <div class="filter-bar">
            <input type="text" class="search-input" placeholder="Buscar por paciente, médico, status...">
        </div>

        <div class="data-section">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CONSULTA</th>
                            <th>PACIENTE</th>
                            <th>MÉDICO</th>
                            <th>VALOR</th>
                            <th>DATA</th>
                            <th>FORMA</th>
                            <th>STATUS</th> 
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pagamentos)): ?>
                            <tr>
                                <td colspan="9" style="text-align: center;">Nenhum pagamento encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pagamentos as $pagamento): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pagamento['id']); ?></td>
                                    <td>#<?php echo htmlspecialchars($pagamento['id_consulta']); ?></td>
                                    <td class="main-info"><?php echo htmlspecialchars($pagamento['paciente_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($pagamento['medico_nome']); ?></td>
                                    <td>R$ <?php echo number_format($pagamento['valor'], 2, ',', '.'); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($pagamento['data_pagamento'])); ?></td>
                                    <td><?php echo htmlspecialchars($pagamento['forma_pagamento']); ?></td>
                                    <td><span class="status-badge <?php echo htmlspecialchars($pagamento['status']); ?>"><?php echo htmlspecialchars($pagamento['status']); ?></span></td>
                                    <td class="actions">
                                        <a href="atualizarPagamento.php?id=<?php echo $pagamento['id']; ?>" class="action-icon edit-icon" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="deletarPagamento.php?id=<?php echo $pagamento['id']; ?>" class="action-icon delete-consult-icon" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php include 'partials/_footer.php'; ?>