async function fetchSalesData() {
    const response = await fetch(window.location.href);
    const parser = new DOMParser();
    const doc = parser.parseFromString(await response.text(), 'text/html');
    const rows = doc.querySelectorAll('#salesTableBody tr');
    const salesData = Array.from(rows).map(row => {
        const cells = row.querySelectorAll('td');
        return {
            sale_id: cells[0]?.textContent,
            movie_title: cells[1]?.textContent,
            date: cells[2]?.textContent,
            tickets_sold: cells[3]?.textContent,
            total_revenue: cells[4]?.textContent
        };
    });
    populateSalesTable(salesData);
    populateMovieDropdown(salesData);
}

function populateSalesTable(data) {
    const tableBody = document.getElementById('salesTableBody');
    tableBody.innerHTML = '';
    data.forEach(sale => {
        const row = `<tr>
            <td>${sale.sale_id}</td>
            <td>${sale.movie_title}</td>
            <td>${sale.date}</td>
            <td>${sale.tickets_sold}</td>
            <td>${sale.total_revenue}</td>
        </tr>`;
        tableBody.innerHTML += row;
    });
}

function populateMovieDropdown(data) {
    const movieDropdown = document.getElementById('movie');
    const uniqueMovies = [...new Set(data.map(sale => sale.movie_title))];
    uniqueMovies.forEach(movie => {
        const option = document.createElement('option');
        option.value = movie;
        option.textContent = movie;
        movieDropdown.appendChild(option);
    });
}

function filterSales() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const movie = document.getElementById('movie').value;

    fetch(`${window.location.href}?startDate=${startDate}&endDate=${endDate}&movie=${movie}`)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const rows = doc.querySelectorAll('#salesTableBody tr');
            const filteredData = Array.from(rows).map(row => {
                const cells = row.querySelectorAll('td');
                return {
                    sale_id: cells[0]?.textContent,
                    movie_title: cells[1]?.textContent,
                    date: cells[2]?.textContent,
                    tickets_sold: cells[3]?.textContent,
                    total_revenue: cells[4]?.textContent
                };
            });
            populateSalesTable(filteredData);
        });
}

// Fetch data on page load
fetchSalesData();
