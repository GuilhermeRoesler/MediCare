<?php
require_once '../app/Core/bootstrap.php';
Auth::requireAdmin();
extract(Auth::viewLocals());

$pageTitle = 'Excluir Consulta';
$currentPage = 'consulta';
$headerTitle = 'Excluir Consulta';
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
                <h1>Excluir Consulta</h1>
                <p>Informe o ID da Consulta</p>
            </div>

            <form class="form active" method="POST" action="actions/consulta.php?action=delete" onsubmit="return confirmarExclusao()">
                <?php echo Csrf::field(); ?>
                <label for="idConsulta">ID:</label>
                <input type="number" id="idConsulta" name="id" placeholder="Digite o ID da consulta" required value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">

                <button type="submit" class="submit-btn">Excluir</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='consulta.php'">Cancelar</button>
            </form>
        </div>
    </div>
<script>
function confirmarExclusao() {
    return confirm("⚠ Tem certeza que deseja excluir esta consulta de forma permanente?");
}
</script>
<?php include 'partials/_footer.php'; ?>
