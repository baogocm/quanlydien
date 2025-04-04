document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const tableRows = document.querySelectorAll("table tbody tr");

    function filterData() {
        const roleValue = roleFilter.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const roleCell = row.cells[3].textContent.toLowerCase();
            const shouldShow = (roleValue === "" || roleCell === roleValue) && 
                             Array.from(row.cells).some(cell => 
                                 cell.textContent.toLowerCase().includes(searchValue)
                             );
            
            row.style.display = shouldShow ? "" : "none";
        });
    }

    // Thêm event listeners
    roleFilter.addEventListener("change", filterData);
    searchInput.addEventListener("input", filterData);
});
