<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Médico</title>
    <link rel="stylesheet" href="css/deletar.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <div class="logo-circle"></div>
            <h1>Excluir Médico</h1>
            <p>Informe o ID do Médico</p>
        </div>

        <form class="form active" method="POST" action="../app/Http/Controllers/medicoController.php?action=delete">
            <label for="idMedico">ID:</label>
            <input type="number" id="idMedico" name="id" placeholder="Digite o ID do médico" required>

            <button type="submit" class="submit-btn">Excluir</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='medicos.php'">Cancelar</button>
        </form>
    </div>
</div>

</body>
</html>