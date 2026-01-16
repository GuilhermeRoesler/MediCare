<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
$primeiraLetra = strtoupper(substr($nomeUsuario, 0, 1));

require_once '../app/Models/Paciente.php';
$pacienteModel = new Paciente(null, null, null, null, null);
$pacientes = $pacienteModel->listar();
$totalPacientes = count($pacientes);

$pageTitle = 'Pacientes';
$currentPage = 'pacientes';
$headerTitle = 'Painel Administrativo';
$headerSubtitle = 'Gerencie informações dos pacientes';
$pageStyles = ['pacientes.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>

    <section class="management-card">
        <div class="management-header">
            <div class="title-section">
                <h2>Lista de Pacientes</h2>
                <p>Total de <?php echo $totalPacientes; ?> pacientes registrados</p>
            </div>
            <a href="cadastroPaciente.php" class="btn-primary new-item-btn">
                <i class="fas fa-user-plus"></i> Novo Paciente
            </a>
        </div>
        
        <div class="filter-bar">
            <input type="text" class="search-input" placeholder="Buscar por nome, CPF, telefone...">
        </div>

        <div class="data-section">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>DATA NASC.</th>
                            <th>TELEFONE</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pacientes)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">Nenhum paciente encontrado.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pacientes as $paciente): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($paciente['id']); ?></td>
                                    <td class="main-info"><?php echo htmlspecialchars($paciente['nome_completo']); ?></td>
                                    <td><?php echo htmlspecialchars($paciente['cpf']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($paciente['data_nascimento'])); ?></td>
                                    <td><?php echo htmlspecialchars($paciente['telefone']); ?></td>
                                    <td class="actions">
                                        <a href="atualizarPaciente.php?id=<?php echo $paciente['id']; ?>" class="action-icon info-icon" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="deletarPaciente.php?id=<?php echo $paciente['id']; ?>" class="action-icon delete-consult-icon" title="Excluir"><i class="fas fa-trash-alt"></i></a>
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