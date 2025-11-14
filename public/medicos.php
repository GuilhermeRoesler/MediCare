<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
$primeiraLetra = strtoupper(substr($nomeUsuario, 0, 1));

require_once '../app/Models/Medico.php';
$medicoModel = new Medico(null, null, null, null, null, null);
$medicos = $medicoModel->listar();
$totalMedicos = count($medicos);

$pageTitle = 'Médicos';
$currentPage = 'medicos';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Cadastre e gerencie médicos';
$pageStyles = ['medicos.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Lista de Médicos</h2>
                <p>Total de <?php echo $totalMedicos; ?> médicos registrados</p>
            </div>
            <a href="cadastroMedico.php" class="btn-primary new-item-btn">
                <i class="fas fa-user-plus"></i> Novo Médico
            </a>
        </div>
        
        <div class="filter-bar">
            <input type="text" class="search-input" placeholder="Buscar por nome, CRM, especialidade...">
        </div>

        <div class="data-section">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>CRM</th>
                            <th>ESPECIALIDADE</th>
                            <th>TELEFONE</th>
                            <th>STATUS</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($medicos)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">Nenhum médico encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($medicos as $medico): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($medico['id']); ?></td>
                                    <td class="main-info"><?php echo htmlspecialchars($medico['nome_completo']); ?></td>
                                    <td><?php echo htmlspecialchars($medico['crm']); ?></td>
                                    <td><?php echo htmlspecialchars($medico['especialidade']); ?></td>
                                    <td><?php echo htmlspecialchars($medico['telefone']); ?></td>
                                    <td><span class="status-badge <?php echo $medico['status']; ?>"><?php echo htmlspecialchars($medico['status']); ?></span></td>
                                    <td class="actions">
                                        <a href="atualizarMedico.php?id=<?php echo $medico['id']; ?>" class="action-icon edit-icon" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="deletarMedico.php?id=<?php echo $medico['id']; ?>" class="action-icon delete-consult-icon" title="Excluir"><i class="fas fa-trash-alt"></i></a>
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