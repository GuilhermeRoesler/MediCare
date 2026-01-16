<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Médico</title>
    <link rel="stylesheet" href="css/gerenciamento.css"> 
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="form-card-container">
        
        <form action="../app/Http/Controllers/medicoController.php?action=create" method="post" class="form-card">
            <div class="form-header">
                <i class="fas fa-user-md form-icon"></i>
                <h2>Novo Cadastro de Médico</h2>
                <p>Insira os dados profissionais para registrar um novo médico no sistema.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Dados Profissionais</legend>
                
                <div class="form-field full-width-field">
                    <label for="nome">Nome Completo</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nome" name="nome" required placeholder="Nome e sobrenome do médico">
                    </div>
                </div>

                <div class="form-field">
                    <label for="crm">CRM</label>
                    <div class="input-with-icon">
                        <i class="fas fa-id-badge"></i>
                        <input type="text" id="crm" name="crm" required placeholder="CRM/UF XXXXXX">
                    </div>
                </div>

                <div class="form-field">
                    <label for="especialidade">Especialidade</label>
                    <div class="input-with-icon">
                        <i class="fas fa-stethoscope"></i>
                        <input type="text" id="especialidade" name="especialidade" required placeholder="Ex: Cardiologia">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Contato e Status</legend>
                
                <div class="form-field">
                    <label for="telefone">Telefone</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="telefone" name="telefone" required placeholder="(99) 99999-9999">
                    </div>
                </div>

                <div class="form-field">
                    <label for="email">E-mail</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder="nome@exemplo.com">
                    </div>
                </div>
                
                <div class="form-field">
                    <label for="ativo">Status</label>
                    <div class="input-with-icon">
                        <i class="fas fa-power-off"></i>
                        <select id="status" name="status" required>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Salvar Médico</button>
                <a href="dashboard.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>
</body>
</html>