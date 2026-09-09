<?php
require_once '../app/Core/bootstrap.php';
Auth::requireAdmin();
extract(Auth::viewLocals());

$pageTitle = 'Excluir Pagamento';
$currentPage = 'pagamento';
$headerTitle = 'Excluir Pagamento';
$headerSubtitle = 'Confirme a exclusão do registro';
$pageStyles = ['deletar.css'];
include 'partials/_head.php';
include 'partials/_sidebar.php';
?>
<main class="main-content">
    <?php include 'partials/_header.php'; ?>
    <div class="form-card-container in-layout">
        <div class="auth-box">
            <div class="auth-header">
                <div class="logo-circle"></div>
                <h1>Excluir Pagamento</h1>
                <p>Informe o ID do Pagamento</p>
            </div>

            <form class="form active" method="POST" action="actions/pagamento.php?action=delete">
                <?php echo Csrf::field(); ?>
                <label for="idPagamento">ID:</label>
                <input type="number" id="idPagamento" name="id" placeholder="Digite o ID do pagamento" required value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">

                <button type="submit" class="submit-btn">Excluir</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='pagamento.php'">Cancelar</button>
            </form>
        </div>
    </div>
<?php include 'partials/_footer.php'; ?>
