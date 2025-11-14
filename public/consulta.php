<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
$primeiraLetra = strtoupper(substr($nomeUsuario, 0, 1));

require_once '../app/Models/Consulta.php';
$consultaModel = new Consulta(null, null, null, null, null, null, null);
$consultas = $consultaModel->listar();

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
        
        <div class="filter-bar">
            <input type="text" class="search-input" placeholder="Buscar por paciente, médico, status...">
        </div>

        <div class="data-section">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PACIENTE</th>
                            <th>MÉDICO</th>
                            <th>DATA/HORA INÍCIO</th>
                            <th>STATUS</th>
                            <th>SALA</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($consultas)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">Nenhuma consulta encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($consultas as $consulta): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($consulta['id']); ?></td>
                                    <td class="main-info"><?php echo htmlspecialchars($consulta['paciente_nome']); ?></td>
                                    <td><?php echo htmlspecialchars($consulta['medico_nome']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($consulta['inicio'])); ?></td>
                                    <td><span class="status-badge <?php echo htmlspecialchars($consulta['status']); ?>"><?php echo htmlspecialchars($consulta['status']); ?></span></td>
                                    <td><?php echo htmlspecialchars($consulta['sala']); ?></td>
                                    <td class="actions">
                                        <a href="atualizarConsulta.php?id=<?php echo $consulta['id']; ?>" class="action-icon edit-icon" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="deletarConsulta.php?id=<?php echo $consulta['id']; ?>" class="action-icon delete-consult-icon" title="Excluir"><i class="fas fa-trash-alt"></i></a>
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