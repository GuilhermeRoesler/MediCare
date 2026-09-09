<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

require_once '../app/Models/Consulta.php';
require_once '../app/Models/Medico.php';
require_once '../app/Models/Paciente.php';

function toDatetimeLocal(?string $dt): string {
    if (!$dt) return '';
    return date('Y-m-d\TH:i', strtotime($dt));
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: consulta.php');
    exit();
}
$consultaModel = new Consulta(null, null, null, null, null, null, null);
$consulta = $consultaModel->buscarPorId($id);
if (!$consulta) {
    header('Location: consulta.php');
    exit();
}

$medicoModel = new Medico(null, null, null, null, null, null);
$pacienteModel = new Paciente(null, null, null, null, null);
$medicos = $medicoModel->listar();
$pacientes = $pacienteModel->listar();

$pageTitle = 'Atualizar Consulta';
$currentPage = 'consulta';
$headerTitle = 'Atualizar Consulta';
$headerSubtitle = 'Edite as informações da consulta';
$pageStyles = ['formulario.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <form action="actions/consulta.php?action=update" method="post" class="form-card">
            <?php echo Csrf::field(); ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($consulta['id']); ?>">
            <div class="form-header">
                <i class="fas fa-edit form-icon"></i>
                <h2>Atualizar Consulta</h2>
                <p>Insira as informações atualizadas da consulta abaixo.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Informações da Consulta</legend>

                <div class="form-field">
                    <label for="idMedico">Médico</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-md"></i>
                        <select id="idMedico" name="idMedico" required>
                            <?php foreach ($medicos as $medico): ?>
                                <option value="<?php echo (int) $medico['id']; ?>" <?php echo (int) $consulta['id_medico'] === (int) $medico['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($medico['nome_completo'] . ' — ' . $medico['especialidade']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-field">
                    <label for="idPaciente">Paciente</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-injured"></i>
                        <select id="idPaciente" name="idPaciente" required>
                            <?php foreach ($pacientes as $paciente): ?>
                                <option value="<?php echo (int) $paciente['id']; ?>" <?php echo (int) $consulta['id_paciente'] === (int) $paciente['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($paciente['nome_completo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-field">
                    <label for="inicio">Início da Consulta</label>
                    <div class="input-with-icon">
                        <i class="far fa-clock"></i>
                        <input type="datetime-local" id="inicio" name="inicio" required value="<?php echo htmlspecialchars(toDatetimeLocal($consulta['inicio'])); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="fim">Fim da Consulta</label>
                    <div class="input-with-icon">
                        <i class="far fa-clock"></i>
                        <input type="datetime-local" id="fim" name="fim" required value="<?php echo htmlspecialchars(toDatetimeLocal($consulta['fim'])); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="sala">Sala</label>
                    <div class="input-with-icon">
                        <i class="fas fa-door-open"></i>
                        <input type="text" id="sala" name="sala" required placeholder="Número ou nome da sala" value="<?php echo htmlspecialchars($consulta['sala']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="status">Status</label>
                    <div class="input-with-icon">
                        <i class="fas fa-check-circle"></i>
                        <select id="status" name="status" required>
                            <option value="agendada" <?php echo $consulta['status'] === 'agendada' ? 'selected' : ''; ?>>Agendada</option>
                            <option value="confirmada" <?php echo $consulta['status'] === 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                            <option value="cancelada" <?php echo $consulta['status'] === 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                            <option value="finalizada" <?php echo $consulta['status'] === 'finalizada' ? 'selected' : ''; ?>>Finalizada</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Detalhes da Consulta</legend>
                <div class="form-field full-width-field">
                    <label for="motivo">Motivo</label>
                    <div class="input-with-icon">
                        <i class="fas fa-pencil-alt"></i>
                        <input type="text" id="motivo" name="motivo" required placeholder="Motivo da atualização da consulta" value="<?php echo htmlspecialchars($consulta['motivo']); ?>">
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sync-alt"></i> Atualizar Consulta
                </button>
                <a href="consulta.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php include 'partials/_footer.php'; ?>
