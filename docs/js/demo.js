/**
 * Comportamento da demo estática (somente leitura).
 */
(function () {
    const toast = document.createElement('div');
    toast.className = 'demo-toast';
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', 'polite');
    document.body.appendChild(toast);

    let hideTimer;

    function showToast(message) {
        toast.textContent = message;
        toast.classList.add('is-visible');
        clearTimeout(hideTimer);
        hideTimer = setTimeout(() => toast.classList.remove('is-visible'), 3200);
    }

    window.MediCareDemo = { showToast };

    document.addEventListener('click', function (e) {
        const link = e.target.closest('a[data-demo-readonly], button[data-demo-readonly]');
        if (!link) return;
        e.preventDefault();
        showToast('Demo estática: cadastros e edições estão desabilitados. Use Docker local para a versão completa.');
    });

    document.querySelectorAll('form[data-demo-login]').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            window.location.href = 'dashboard.html';
        });
    });

    document.querySelectorAll('form[data-demo-filter]').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            showToast('Demo estática: filtros dinâmicos e exportação CSV exigem o backend PHP.');
        });
        form.querySelectorAll('select').forEach((select) => {
            select.addEventListener('change', function (e) {
                e.preventDefault();
                showToast('Demo estática: filtros dinâmicos exigem o backend PHP. Os gráficos abaixo usam dados fixos do seed.');
            });
        });
    });
})();
