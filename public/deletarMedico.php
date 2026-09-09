<?php
require_once '../app/Core/bootstrap.php';
Auth::requireAdmin();
extract(Auth::viewLocals());

$pageTitle = 'Excluir Médico';
$currentPage = 'medicos';
$headerTitle = 'Excluir Médico';
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
                <h1>Excluir Médico</h1>
                <p>Informe o ID do Médico</p>
            </div>

            <form class="form active" method="POST" action="actions/medico.php?action=delete">
                <?php echo Csrf::field(); ?>
                <label for="idMedico">ID:</label>
                <input type="number" id="idMedico" name="id" placeholder="Digite o ID do médico" required value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">

                <button type="submit" class="submit-btn">Excluir</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='medicos.php'">Cancelar</button>
            </form>
        </div>
    </div>
<?php include 'partials/_footer.php'; ?>
