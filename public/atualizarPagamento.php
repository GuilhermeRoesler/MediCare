<?php
require_once '../app/Core/bootstrap.php';
Auth::requireLogin();
extract(Auth::viewLocals());

require_once '../app/Models/Pagamento.php';
require_once '../app/Models/Consulta.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: pagamento.php');
    exit();
}
$pagamentoModel = new Pagamento(null, null, null, null, null);
$pagamento = $pagamentoModel->buscarPorId($id);
if (!$pagamento) {
    header('Location: pagamento.php');
    exit();
}

$consultaModel = new Consulta(null, null, null, null, null, null, null);
$consultas = $consultaModel->listar();

$pageTitle = 'Atualizar Pagamento';
$currentPage = 'pagamento';
$headerTitle = 'Atualizar Pagamento';
$headerSubtitle = 'Edite as informações do pagamento';
$pageStyles = ['formulario.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <form action="actions/pagamento.php?action=update" method="post" class="form-card">
            <?php echo Csrf::field(); ?>
            <input type="hidden" name="idPagamento" value="<?php echo htmlspecialchars($pagamento['id']); ?>">
            <div class="form-header">
                <i class="fas fa-file-invoice-dollar form-icon"></i>
                <h2>Atualizar Pagamento</h2>
                <p>Informe os novos dados para atualizar o registro.</p>
            </div>

            <fieldset class="form-group-grid">
                <legend>Detalhes da Transação</legend>

                <div class="form-field">
                    <label for="idConsulta">Consulta</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-check"></i>
                        <select id="idConsulta" name="idConsulta" required>
                            <?php foreach ($consultas as $consulta): ?>
                                <option value="<?php echo (int) $consulta['id']; ?>" <?php echo (int) $pagamento['id_consulta'] === (int) $consulta['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(
                                        '#' . $consulta['id'] . ' — ' . $consulta['paciente_nome'] . ' / ' . $consulta['medico_nome'] . ' — ' . date('d/m/Y H:i', strtotime($consulta['inicio']))
                                    ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                            min="0"
                            placeholder="Ex: 150.00"
                            value="<?php echo htmlspecialchars($pagamento['valor']); ?>">
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
                            required
                            value="<?php echo htmlspecialchars($pagamento['data_pagamento']); ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label for="metodo">Método de Pagamento</label>
                    <div class="input-with-icon">
                        <i class="fas fa-credit-card"></i>
                        <select id="metodo" name="metodo" required>
                            <option value="cartao" <?php echo $pagamento['forma_pagamento'] === 'cartao' ? 'selected' : ''; ?>>Cartão de Crédito/Débito</option>
                            <option value="pix" <?php echo $pagamento['forma_pagamento'] === 'pix' ? 'selected' : ''; ?>>PIX</option>
                            <option value="dinheiro" <?php echo $pagamento['forma_pagamento'] === 'dinheiro' ? 'selected' : ''; ?>>Dinheiro</option>
                            <option value="transferencia" <?php echo $pagamento['forma_pagamento'] === 'transferencia' ? 'selected' : ''; ?>>Transferência Bancária</option>
                        </select>
                    </div>
                </div>

                <div class="form-field full-width-field">
                    <label for="status">Status</label>
                    <div class="input-with-icon">
                        <i class="fas fa-check-circle"></i>
                        <select id="status" name="status" required>
                            <option value="pago" <?php echo $pagamento['status'] === 'pago' ? 'selected' : ''; ?>>Pago</option>
                            <option value="pendente" <?php echo $pagamento['status'] === 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="cancelado" <?php echo $pagamento['status'] === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sync-alt"></i> Atualizar Pagamento
                </button>
                <a href="pagamento.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<?php include 'partials/_footer.php'; ?>
