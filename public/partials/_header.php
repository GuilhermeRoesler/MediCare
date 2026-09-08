<header class="page-header">
    <div class="header-left">
        <button type="button" class="menu-toggle" id="menuToggle" aria-label="Abrir menu" aria-controls="sidebar" aria-expanded="false">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <div class="header-text">
            <h1><?php echo htmlspecialchars($headerTitle ?? 'Painel Administrativo'); ?></h1>
            <p><?php echo htmlspecialchars($headerSubtitle ?? 'Bem-vindo ao sistema MediCare'); ?></p>
        </div>
    </div>
    <div class="header-profile">
        <div class="profile-details">
            <div class="profile-avatar"><?php echo htmlspecialchars($primeiraLetra); ?></div>
            <div class="profile-info">
                <span><?php echo htmlspecialchars($nomeUsuario); ?></span>
                <small><?php echo htmlspecialchars($perfilUsuario ?? 'Admin'); ?></small>
            </div>
        </div>
    </div>
</header>
