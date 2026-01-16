<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Pagamento</title>
    <link rel="stylesheet" href="css/gerenciamento.css"> 
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="form-card-container">
        
        <form action="../app/Http/Controllers/pagamentoController.php?action=update" method="post" class="form-card">
            <div class="form-header">
                <i class="fas fa-file-invoice-dollar form-icon"></i>
                <h2>Atualizar Pagamento</h2>
                <p>Informe o ID do pagamento e os novos dados para atualizar o registro.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Identificação</legend>
                
                <div class="form-field full-width-field">
                    <label for="idPagamento">ID do Pagamento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-hashtag"></i>
                        <input 
                            type="number" 
                            id="idPagamento" 
                            name="idPagamento" 
                            required 
                            placeholder="Digite o ID do pagamento que deseja atualizar">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Detalhes da Transação</legend>
                
                <div class="form-field">
                    <label for="idConsulta">ID Consulta</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-check"></i>
                        <input 
                            type="number" 
                            id="idConsulta" 
                            name="idConsulta" 
                            required 
                            placeholder="ID da consulta relacionada">
                    </div>
                </div>

                <div class="form-field">
                    <label for="valor">Valor (R$)</label>
                    <div class="input-with-icon">
                        <i class="fas fa-dollar-sign"></i>
                        <input 
                            type="number" 
                            id="valor" 
                            name="valor" 
                            required 
                            step="0.01"
                            placeholder="Ex: 150.00">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Método e Status</legend>
                
                <div class="form-field">
                    <label for="dataPagamento">Data do Pagamento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-alt"></i>
                        <input 
                            type="date" 
                            id="dataPagamento" 
                            name="dataPagamento" 
                            required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="metodo">Método de Pagamento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-credit-card"></i>
                        <select id="metodo" name="metodo" required>
                            <option value="cartao">Cartão de Crédito/Débito</option>
                            <option value="pix">PIX</option>
                            <option value="dinheiro">Dinheiro</option>
                            <option value="transferencia">Transferência Bancária</option>
                        </select>
                    </div>
                </div>

                <div class="form-field full-width-field">
                    <label for="status">Status</label>
                    <div class="input-with-icon">
                        <i class="fas fa-check-circle"></i>
                        <select id="status" name="status" required>
                            <option value="pago">Pago</option>
                            <option value="pendente">Pendente</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sync-alt"></i> Atualizar Pagamento
                </button>
                <a href="dashboard.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>
</body>
</html>