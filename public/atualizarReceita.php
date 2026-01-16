<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Receita</title>
    <link rel="stylesheet" href="css/gerenciamento.css"> 
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="form-card-container">
        
        <form action="../app/Http/Controllers/receitaController.php?action=update" method="post" class="form-card">
            <div class="form-header">
                <i class="fas fa-file-prescription form-icon"></i>
                <h2>Atualizar Receita</h2>
                <p>Informe o ID da receita e os novos dados para atualização.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Identificação</legend>
                
                <div class="form-field full-width-field">
                    <label for="idReceita">ID da Receita</label>
                    <div class="input-with-icon">
                        <i class="fas fa-hashtag"></i>
                        <input type="number" id="idReceita" name="idReceita" required placeholder="Digite o ID da receita que deseja atualizar">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Dados da Prescrição</legend>
                
                <div class="form-field">
                    <label for="idPaciente">ID Paciente</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-injured"></i>
                        <input type="number" id="idPaciente" name="idPaciente" required placeholder="ID do paciente">
                    </div>
                </div>

                <div class="form-field">
                    <label for="idConsulta">ID Consulta</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user-md"></i>
                        <input type="number" id="idConsulta" name="idConsulta" required placeholder="ID da consulta relacionada">
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
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sync-alt"></i> Atualizar Receita
                </button>
                <a href="dashboard.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>
</body>
</html>