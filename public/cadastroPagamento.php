<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

$pageTitle = 'Registro de Pagamento';
$currentPage = 'pagamento';
$headerTitle = 'Novo Pagamento';
$headerSubtitle = 'Registre um novo pagamento no sistema';
$pageStyles = ['formulario.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <form action="actions/pagamento.php?action=create" method="post" class="form-card">
            <?php echo Csrf::field(); ?>
            <div class="form-header">
                <i class="fas fa-file-invoice-dollar form-icon"></i>
                <h2>Registrar Novo Pagamento</h2>
                <p>Preencha os dados do pagamento referente a uma consulta ou serviço.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Detalhes da Transação</legend>

                <div class="form-field">
                    <label for="idConsulta">ID Consulta</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-check"></i>
                        <input type="number" id="idConsulta" name="idConsulta" required placeholder="ID da consulta relacionada">
                    </div>
                </div>

                <div class="form-field">
                    <label for="valor">Valor (R$)</label>
                    <div class="input-with-icon">
                        <i class="fas fa-dollar-sign"></i>
                        <input type="number" id="valor" name="valor" required placeholder="Ex: 150.00">
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-group-grid">
                <legend>Método e Status</legend>

                <div class="form-field">
                    <label for="dataPagamento">Data do Pagamento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" id="dataPagamento" name="dataPagamento" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="metodo">Método de Pagamento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-credit-card"></i>
                        <select type="text" id="metodo" name="metodo" required>
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
                        <select type="text" id="status" name="status" required>
                            <option value="pago">Pago</option>
                            <option value="pendente">Pendente</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Registrar Pagamento</button>
                <a href="pagamento.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php include 'partials/_footer.php'; ?>
