<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

$pageTitle = 'Cadastro de Paciente';
$currentPage = 'pacientes';
$headerTitle = 'Novo Paciente';
$headerSubtitle = 'Registre um novo paciente no sistema';
$pageStyles = ['formulario.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <form action="actions/paciente.php?action=create" method="post" class="form-card">
            <?php echo Csrf::field(); ?>
            <div class="form-header">
                <i class="fas fa-user-plus form-icon"></i>
                <h2>Novo Cadastro de Paciente</h2>
                <p>Insira todas as informações necessárias para registrar um novo paciente.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Dados Pessoais</legend>

                <div class="form-field full-width-field">
                    <label for="nome">Nome Completo</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nome" name="nome" required placeholder="Nome e sobrenome do paciente">
                    </div>
                </div>

                <div class="form-field">
                    <label for="cpf">CPF</label>
                    <div class="input-with-icon">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00">
                    </div>
                </div>

                <div class="form-field">
                    <label for="dataNascimento">Data de Nascimento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" id="dataNascimento" name="dataNascimento" required>
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Contato</legend>

                <div class="form-field">
                    <label for="telefone">Telefone</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="text" id="telefone" name="telefone" required placeholder="(99) 99999-9999">
                    </div>
                </div>

                <div class="form-field">
                    <label for="email">E-mail</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="nome@exemplo.com">
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Salvar Paciente</button>
                <a href="pacientes.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php include 'partials/_footer.php'; ?>
