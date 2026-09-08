<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

require_once '../app/Models/Medico.php';
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: medicos.php');
    exit();
}
$medicoModel = new Medico(null, null, null, null, null, null);
$medico = $medicoModel->buscarPorId($id);
if (!$medico) {
    header('Location: medicos.php');
    exit();
}

$pageTitle = 'Atualizar Médico';
$currentPage = 'medicos';
$headerTitle = 'Atualizar Médico';
$headerSubtitle = 'Edite as informações do médico';
$pageStyles = ['formulario.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <form action="actions/medico.php?action=update" method="post" class="form-card">
            <?php echo Csrf::field(); ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($medico['id']); ?>">
            <div class="form-header">
                <i class="fas fa-user-edit form-icon"></i>
                <h2>Atualizar Médico</h2>
                <p>Modifique as informações necessárias para atualizar o cadastro do médico.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Identificação e Dados Profissionais</legend>

                <div class="form-field full-width-field">
                    <label for="nome">Nome Completo</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nome" name="nome" required placeholder="Nome e sobrenome do médico" value="<?php echo htmlspecialchars($medico['nome_completo']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="crm">CRM</label>
                    <div class="input-with-icon">
                        <i class="fas fa-id-badge"></i>
                        <input type="text" id="crm" name="crm" required placeholder="CRM/UF XXXXXX" value="<?php echo htmlspecialchars($medico['crm']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="especialidade">Especialidade</label>
                    <div class="input-with-icon">
                        <i class="fas fa-stethoscope"></i>
                        <input type="text" id="especialidade" name="especialidade" required placeholder="Ex: Cardiologia" value="<?php echo htmlspecialchars($medico['especialidade']); ?>">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Contato e Status</legend>

                <div class="form-field">
                    <label for="telefone">Telefone</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="telefone" name="telefone" required placeholder="(99) 99999-9999" value="<?php echo htmlspecialchars($medico['telefone']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="email">E-mail</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder="nome@exemplo.com" value="<?php echo htmlspecialchars($medico['email']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="status">Status</label>
                    <div class="input-with-icon">
                        <i class="fas fa-power-off"></i>
                        <select id="status" name="status" required>
                            <option value="ativo" <?php echo $medico['status'] === 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                            <option value="inativo" <?php echo $medico['status'] === 'inativo' ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sync-alt"></i> Atualizar Médico
                </button>
                <a href="medicos.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php include 'partials/_footer.php'; ?>
