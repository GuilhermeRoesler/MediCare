<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Pagamento</title>
    <link rel="stylesheet" href="css/deletar.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <div class="logo-circle"></div>
            <h1>Excluir Pagamento</h1>
            <p>Informe o ID do Pagamento</p>
        </div>

        <form class="form active" method="POST" action="../app/Http/Controllers/pagamentoController.php?action=delete">
            <label for="idPagamento">ID:</label>
            <input type="number" id="idPagamento" name="id" placeholder="Digite o ID do pagamento" required>

            <button type="submit" class="submit-btn">Excluir</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='pagamento.php'">Cancelar</button>
        </form>
    </div>
</div>

</body>
</html>