<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
$primeiraLetra = strtoupper(substr($nomeUsuario, 0, 1));

require_once '../app/Models/Receita.php';
require_once '../app/Core/Conexao.php';

$receitaModel = new Receita(null, null, null, null, null, null, null);
$receitas = $receitaModel->listar();

$pdo = Conexao::getConexao();
$totalReceitas = count($receitas);
$receitasVencendo = $pdo->query("SELECT COUNT(*) FROM receitas WHERE validade BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->fetchColumn();
$receitasVencidas = $pdo->query("SELECT COUNT(*) FROM receitas WHERE validade < CURDATE()")->fetchColumn();

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
            <a href="cadastroReceita.php" class="btn-primary new-item-btn">
                <i class="fas fa-plus"></i> Nova Receita
            </a>
        </div>

        <div class="payment-summary-grid recipe-summary-grid">
            <div class="summary-card">
                <div class="card-content">
                    <h4>Total de Receitas</h4>
                    <span class="summary-value primary"><?php echo $totalReceitas; ?></span>
                </div>
                <div class="card-icon blue"><i class="fas fa-file-alt"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Vencendo em 7 dias</h4>
                    <span class="summary-value pending"><?php echo $receitasVencendo; ?></span>
                </div>
                <div class="card-icon yellow"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
            <div class="summary-card">
                <div class="card-content">
                    <h4>Vencidas</h4>
                    <span class="summary-value error"><?php echo $receitasVencidas; ?></span>
                </div>
                <div class="card-icon red"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>

        <div class="filter-bar">
            <input type="text" class="search-input" placeholder="Buscar por paciente, médico, medicamento...">
        </div>

        <div class="data-section">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PACIENTE</th>
                            <th>MÉDICO</th>
                            <th>MEDICAMENTO</th>
                            <th>EMISSÃO</th>
                            <th>VALIDADE</th>
                            <th>STATUS</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($receitas)): ?>
                            <tr>
                                <td colspan="8" style="text-align: center;">Nenhuma receita encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($receitas as $receita): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($receita['id']); ?></td>
                                    <td class="main-info"><?php echo htmlspecialchars($receita['paciente_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($receita['medico_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($receita['medicamento']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($receita['data_emissao'])); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($receita['validade'])); ?></td>
                                    <td><span class="status-badge <?php echo $receita['status'] === 'Vencida' ? 'vencida' : 'ativo'; ?>"><?php echo htmlspecialchars($receita['status']); ?></span></td>
                                    <td class="actions">
                                        <a href="atualizarReceita.php?id=<?php echo $receita['id']; ?>" class="action-icon edit-icon" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="deletarReceita.php?id=<?php echo $receita['id']; ?>" class="action-icon delete-consult-icon" title="Excluir"><i class="fas fa-trash-alt"></i></a>
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