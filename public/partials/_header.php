<header class="page-header">
    <div class="header-text">
        <h1><?php echo $headerTitle ?? 'Painel Administrativo'; ?></h1>
        <p><?php echo $headerSubtitle ?? 'Bem-vindo ao sistema MediCare'; ?></p>
    </div>
    <div class="header-profile">
        <!-- <span class="notification-badge">2</span> -->
        <div class="profile-details">
            <div class="profile-avatar"><?php echo $primeiraLetra; ?></div>
            <div class="profile-info">
                <span><?php echo htmlspecialchars($nomeUsuario); ?></span>
                <small>Admin</small>
            </div>
        </div>
    </div>
</header>