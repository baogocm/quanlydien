document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const kyFilter = document.getElementById("kyFilter");
    const tableRows = document.querySelectorAll(".custom-table tbody tr");

    function filterData() {
        const kyValue = kyFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const kyCell = row.cells[2].textContent; // Cột kỳ
            const shouldShow = (kyValue === "" || kyCell === kyValue) && 
                             Array.from(row.cells).some(cell => 
                                 cell.textContent.toLowerCase().includes(searchValue)
                             );
            
            row.style.display = shouldShow ? "" : "none";
        });
    }

    // Thêm event listeners
    kyFilter.addEventListener("change", filterData);
    searchInput.addEventListener("input", filterData);
});
