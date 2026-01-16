<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="css/gerenciamento.css"> 
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="form-card-container">
        
        <form action="../app/Http/Controllers/pacienteController.php?action=create" method="post" class="form-card">
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
                <a href="dashboard.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>
</body>
</html>