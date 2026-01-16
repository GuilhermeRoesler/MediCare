<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Paciente</title>
    <link rel="stylesheet" href="css/deletar.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <div class="auth-header">
            <div class="logo-circle"></div>
            <h1>Confirmar Exclusão</h1>
            <p>Tem certeza que deseja excluir este paciente?</p>
        </div>

        <form class="form active" method="POST" action="../app/Http/Controllers/pacienteController.php?action=delete">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
            
            <p style="margin-bottom: 1.5rem; color: #4b5563;">Esta ação não pode ser desfeita. Todos os dados associados (consultas, pagamentos, etc) a este paciente serão removidos permanentemente.</p>

            <button type="submit" class="submit-btn">Sim, Excluir</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='pacientes.php'">Cancelar</button>
        </form>
    </div>
</div>

</body>
</html>