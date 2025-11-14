document.addEventListener('DOMContentLoaded', () => {
    const tables = document.querySelectorAll('.data-table');

    tables.forEach(table => {
        const managementCard = table.closest('.management-card');
        if (!managementCard) return;

        const searchInput = managementCard.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', () => {
                const query = searchInput.value.toLowerCase().trim();
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    // Ignora a linha de "Nenhum registro encontrado"
                    if (row.querySelector('td[colspan]')) return;
                    
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }

        const headers = table.querySelectorAll('thead th');
        headers.forEach((header, index) => {
            if (header.textContent.trim().toUpperCase() !== 'AÇÕES') {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    // Remove a classe de ordenação de outros cabeçalhos
                    headers.forEach(h => { if (h !== header) h.classList.remove('asc', 'desc'); });
                    
                    const isAsc = header.classList.contains('asc');
                    let direction;
                    if (isAsc) {
                        header.classList.remove('asc');
                        header.classList.add('desc');
                        direction = 'desc';
                    } else {
                        header.classList.remove('desc');
                        header.classList.add('asc');
                        direction = 'asc';
                    }
                    
                    sortTable(table, index, direction);
                });
            }
        });
    });

    const sortTable = (table, columnIndex, direction) => {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const isAsc = direction === 'asc';

        // Ignora a linha de "Nenhum registro encontrado"
        const dataRows = rows.filter(row => !row.querySelector('td[colspan]'));

        dataRows.sort((a, b) => {
            let valA = a.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();
            let valB = b.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();

            // Tratamento para números, moeda e datas
            const dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})/;
            if (dateRegex.test(valA) && dateRegex.test(valB)) {
                valA = valA.replace(dateRegex, '$3-$2-$1');
                valB = valB.replace(dateRegex, '$3-$2-$1');
            } else {
                const numA = parseFloat(valA.replace(/[^\d,.-]/g, '').replace('.', '').replace(',', '.'));
                const numB = parseFloat(valB.replace(/[^\d,.-]/g, '').replace('.', '').replace(',', '.'));
                if (!isNaN(numA) && !isNaN(numB)) {
                    valA = numA;
                    valB = numB;
                }
            }

            if (valA < valB) return isAsc ? -1 : 1;
            if (valA > valB) return isAsc ? 1 : -1;
            return 0;
        });

        dataRows.forEach(row => tbody.appendChild(row));
    };
});