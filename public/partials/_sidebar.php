<aside class="sidebar">
    <div class="logo-section">
        <a href="dashboard.php" class="logo-text-link">
            <i class="fas fa-notes-medical logo-icon"></i>
            <div class="logo-text"><span>MediCare</span><small>Sistema Médico</small></div>
        </a>
    </div>
    <nav class="main-nav">
        <ul>
            <li class="nav-item <?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>">
                <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'pacientes') ? 'active' : ''; ?>">
                <a href="pacientes.php"><i class="fas fa-user-injured"></i> Pacientes</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'medicos') ? 'active' : ''; ?>">
                <a href="medicos.php"><i class="fas fa-user-md"></i> Médicos</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'consulta') ? 'active' : ''; ?>">
                <a href="consulta.php"><i class="fas fa-calendar-check"></i> Consultas</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'pagamento') ? 'active' : ''; ?>">
                <a href="pagamento.php"><i class="fas fa-file-invoice-dollar"></i> Pagamentos</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'receitas') ? 'active' : ''; ?>">
                <a href="receitas.php"><i class="fas fa-file-prescription"></i> Receitas</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'relatorios') ? 'active' : ''; ?>">
                <a href="relatorios.php"><i class="fas fa-chart-line"></i> Relatórios</a>
            </li>
        </ul>
    </nav>
    <div class="user-footer">
        <div class="user-info">
            <div class="user-avatar"><?php echo $primeiraLetra; ?></div>
            <div><span class="username"><?php echo htmlspecialchars($nomeUsuario); ?></span><small class="role">Admin</small></div>
        </div>
        <a href="../app/Http/Controllers/authController.php?action=logout" class="logout-btn">Sair</a>
    </div>
</aside>