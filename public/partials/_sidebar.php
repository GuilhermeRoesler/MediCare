<aside class="sidebar" id="sidebar" aria-label="Navegação principal">
    <div class="logo-section">
        <a href="dashboard.php" class="logo-text-link">
            <i class="fas fa-notes-medical logo-icon" aria-hidden="true"></i>
            <div class="logo-text"><span>MediCare</span><small>Sistema Médico</small></div>
        </a>
        <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Fechar menu">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
    </div>
    <nav class="main-nav">
        <ul>
            <li class="nav-item <?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>">
                <a href="dashboard.php"><i class="fas fa-tachometer-alt" aria-hidden="true"></i> Dashboard</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'pacientes') ? 'active' : ''; ?>">
                <a href="pacientes.php"><i class="fas fa-user-injured" aria-hidden="true"></i> Pacientes</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'medicos') ? 'active' : ''; ?>">
                <a href="medicos.php"><i class="fas fa-user-md" aria-hidden="true"></i> Médicos</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'consulta') ? 'active' : ''; ?>">
                <a href="consulta.php"><i class="fas fa-calendar-check" aria-hidden="true"></i> Consultas</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'pagamento') ? 'active' : ''; ?>">
                <a href="pagamento.php"><i class="fas fa-file-invoice-dollar" aria-hidden="true"></i> Pagamentos</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'receitas') ? 'active' : ''; ?>">
                <a href="receitas.php"><i class="fas fa-file-prescription" aria-hidden="true"></i> Receitas</a>
            </li>
            <li class="nav-item <?php echo ($currentPage === 'relatorios') ? 'active' : ''; ?>">
                <a href="relatorios.php"><i class="fas fa-chart-line" aria-hidden="true"></i> Relatórios</a>
            </li>
        </ul>
    </nav>
    <div class="user-footer">
        <div class="user-info">
            <div class="user-avatar"><?php echo htmlspecialchars($primeiraLetra); ?></div>
            <div>
                <span class="username"><?php echo htmlspecialchars($nomeUsuario); ?></span>
                <small class="role"><?php echo htmlspecialchars($perfilUsuario ?? 'Admin'); ?></small>
            </div>
        </div>
        <form action="actions/auth.php?action=logout" method="post" class="logout-form">
            <?php echo Csrf::field(); ?>
            <button type="submit" class="logout-btn">Sair</button>
        </form>
    </div>
</aside>
