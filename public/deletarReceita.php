<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Receita</title>
    <link rel="stylesheet" href="css/deletar.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <div class="logo-circle"></div>
            <h1>Excluir Receita</h1>
            <p>Informe o ID da Receita</p>
        </div>

        <form class="form active" method="POST" action="../app/Http/Controllers/receitaController.php?action=delete">
            <label for="idReceita">ID:</label>
            <input type="number" id="idReceita" name="id" placeholder="Digite o ID da receita" required>

            <button type="submit" class="submit-btn">Excluir</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='receitas.php'">Cancelar</button>
        </form>
    </div>
</div>

</body>
</html>