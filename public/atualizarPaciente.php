<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: autenticacao.php');
    exit();
}
require_once '../app/Models/Paciente.php';
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: pacientes.php');
    exit();
}
$pacienteModel = new Paciente(null, null, null, null, null);
$paciente = $pacienteModel->buscarPorId($id);
if (!$paciente) {
    header('Location: pacientes.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Dados do Paciente</title>

    <link rel="stylesheet" href="css/gerenciamento.css">
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="form-card-container">

        <form action="../app/Http/Controllers/pacienteController.php?action=update" method="post" class="form-card">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($paciente['id']); ?>">
            <div class="form-header">
                <i class="fas fa-user-edit form-icon"></i>
                <h2>Atualizar Paciente</h2>
                <p>Edite as informações abaixo para atualizar o cadastro do paciente.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Dados Pessoais</legend>

                <div class="form-field full-width-field">
                    <label for="nome">Nome Completo</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nome" name="nome" required placeholder="Nome e sobrenome do paciente" value="<?php echo htmlspecialchars($paciente['nome_completo']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="cpf">CPF</label>
                    <div class="input-with-icon">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00" value="<?php echo htmlspecialchars($paciente['cpf']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="dataNascimento">Data de Nascimento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" id="dataNascimento" name="dataNascimento" required value="<?php echo htmlspecialchars($paciente['data_nascimento']); ?>">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Contato</legend>

                <div class="form-field">
                    <label for="telefone">Telefone</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="text" id="telefone" name="telefone" required placeholder="(99) 99999-9999" value="<?php echo htmlspecialchars($paciente['telefone']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="email">E-mail</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="nome@exemplo.com" value="<?php echo htmlspecialchars($paciente['email']); ?>">
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sync-alt"></i> Atualizar Paciente
                </button>
                <a href="pacientes.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>

</body>

</html>