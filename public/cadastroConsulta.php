<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

require_once '../app/Models/Medico.php';
require_once '../app/Models/Paciente.php';

$medicoModel = new Medico(null, null, null, null, null, null);
$pacienteModel = new Paciente(null, null, null, null, null);
$medicos = $medicoModel->listar();
$pacientes = $pacienteModel->listar();

$pageTitle = 'Cadastro de Nova Consulta';
$currentPage = 'consulta';
$headerTitle = 'Nova Consulta';
$headerSubtitle = 'Agende uma nova consulta no sistema';
$pageStyles = ['formulario.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <form action="actions/consulta.php?action=create" method="post" class="form-card">
            <?php echo Csrf::field(); ?>
            <div class="form-header">
                <i class="fas fa-calendar-plus form-icon"></i>
                <h2>Agendar Nova Consulta</h2>
                <p>Preencha os detalhes para marcar a consulta no sistema.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Informações do Atendimento</legend>

                <div class="form-field">
                    <label for="idMedico">Médico</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-md"></i>
                        <select id="idMedico" name="idMedico" required>
                            <option value="">Selecione o médico</option>
                            <?php foreach ($medicos as $medico): ?>
                                <option value="<?php echo (int) $medico['id']; ?>">
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
                            <option value="">Selecione o paciente</option>
                            <?php foreach ($pacientes as $paciente): ?>
                                <option value="<?php echo (int) $paciente['id']; ?>">
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
                        <input type="datetime-local" id="inicio" name="inicio" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="fim">Fim da Consulta</label>
                    <div class="input-with-icon">
                        <i class="far fa-clock"></i>
                        <input type="datetime-local" id="fim" name="fim" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="sala">Sala</label>
                    <div class="input-with-icon">
                        <i class="fas fa-door-open"></i>
                        <input type="text" id="sala" name="sala" required placeholder="Ex: 3">
                    </div>
                </div>

                <div class="form-field">
                    <label for="status">Status</label>
                    <div class="input-with-icon">
                        <i class="fas fa-check-circle"></i>
                        <select id="status" name="status" required>
                            <option value="agendada">Agendada</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="cancelada">Cancelada</option>
                            <option value="finalizada">Finalizada</option>
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
                        <input type="text" id="motivo" name="motivo" required
                            placeholder="Breve descrição do motivo da consulta">
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Marcar Consulta
                </button>
                <a href="consulta.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php include 'partials/_footer.php'; ?>
