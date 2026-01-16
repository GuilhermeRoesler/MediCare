<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Consulta</title>
    <link rel="stylesheet" href="css/deletar.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <div class="logo-circle"></div>
            <h1>Excluir Consulta</h1>
            <p>Informe o ID da Consulta</p>
        </div>

        <form class="form active" method="POST" action="../app/Http/Controllers/consultaController.php?action=delete" onsubmit="return confirmarExclusao()">
            <label for="idConsulta">ID:</label>
            <input type="number" id="idConsulta" name="id" placeholder="Digite o ID da consulta" required>

            <button type="submit" class="submit-btn">Excluir</button>

            <button type="button" class="cancel-btn" 
                    onclick="window.location.href='consulta.php'">
                Cancelar
            </button>
        </form>
    </div>
</div>

<script>
function confirmarExclusao() {
    return confirm("⚠ Tem certeza que deseja excluir esta consulta de forma permanente?");
}
</script>

</body>
</html>