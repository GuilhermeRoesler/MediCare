<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

$pageTitle = 'Emissão de Receita';
$currentPage = 'receitas';
$headerTitle = 'Nova Receita';
$headerSubtitle = 'Emita uma nova receita médica';
$pageStyles = ['formulario.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <form action="actions/receita.php?action=create" method="post" class="form-card">
            <?php echo Csrf::field(); ?>
            <div class="form-header">
                <i class="fas fa-file-prescription form-icon"></i>
                <h2>Emitir Nova Receita</h2>
                <p>Detalhes da medicação prescrita ao paciente.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Dados da Prescrição</legend>

                <div class="form-field">
                    <label for="idPaciente">ID Paciente</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-injured"></i>
                        <input type="number" id="idPaciente" name="idPaciente" required placeholder="ID da Consulta">
                    </div>
                </div>

                <div class="form-field">
                    <label for="idMedico">ID Consulta</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-md"></i>
                        <input type="number" id="idConsulta" name="idConsulta" required placeholder="ID do Médico prescritor">
                    </div>
                </div>

                <div class="form-field full-width-field">
                    <label for="medicamento">Nome do Medicamento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-capsules"></i>
                        <input type="text" id="medicamento" name="medicamento" required placeholder="Ex: Amoxicilina 500mg">
                    </div>
                </div>

                <div class="form-field">
                    <label for="quantidade">Quantidade</label>
                    <div class="input-with-icon">
                        <i class="fas fa-sort-numeric-up"></i>
                        <input type="number" id="quantidade" name="quantidade" required placeholder="Quantidade de caixas/frascos">
                    </div>
                </div>

                <div class="form-field">
                    <label for="posologia">Posologia (Dose e Frequência)</label>
                    <div class="input-with-icon">
                        <i class="fas fa-notes-medical"></i>
                        <input type="text" id="posologia" name="posologia" required placeholder="Ex: 1 cápsula a cada 8 horas por 7 dias">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Datas</legend>

                <div class="form-field">
                    <label for="dataEmissao">Data de Emissão</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" id="dataEmissao" name="dataEmissao" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="dataValidade">Data de Validade</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-check"></i>
                        <input type="date" id="dataValidade" name="dataValidade" required>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="fas fa-print"></i> Emitir Receita</button>
                <a href="receitas.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php include 'partials/_footer.php'; ?>
