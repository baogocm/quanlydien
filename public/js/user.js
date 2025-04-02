document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector("input[placeholder='Mã nhân viên, chức vụ...']");
    const roleFilter = document.querySelector("select");
    const tableRows = document.querySelectorAll(".custom-table tbody tr");

    function filterTable() {
        const searchText = searchInput.value.trim().toLowerCase();
        const selectedRole = roleFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const maNV = row.cells[0].textContent.toLowerCase();
            const chucVu = row.cells[2].textContent.toLowerCase();

            const matchesSearch = searchText === "" || maNV.includes(searchText) || chucVu.includes(searchText);
            const matchesRole = selectedRole === "tất cả" || chucVu === selectedRole;

            row.style.display = matchesSearch && matchesRole ? "" : "none";
        });
    }

    // Lắng nghe sự kiện nhập và thay đổi bộ lọc
    searchInput.addEventListener("input", filterTable);
    roleFilter.addEventListener("change", filterTable);
});
