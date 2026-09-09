/**
 * Comportamento global do layout (menu mobile).
 */
(function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const openBtn = document.getElementById('menuToggle');
    const closeBtn = document.getElementById('sidebarClose');

    if (!sidebar || !overlay) return;

    function openSidebar() {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');
        document.body.classList.add('sidebar-open');
        if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        document.body.classList.remove('sidebar-open');
        if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
    }

    if (openBtn) openBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSidebar();
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) closeSidebar();
    });
})();
