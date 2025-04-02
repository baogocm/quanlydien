document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector("#searchInput"); // Lấy ô tìm kiếm
    const tableRows = document.querySelectorAll(".custom-table tbody tr"); // Lấy các hàng của bảng

    function filterTable() {
        const searchText = searchInput.value.trim().toLowerCase(); // Lấy giá trị nhập vào

        tableRows.forEach(row => {
            const maKH = row.cells[0].textContent.toLowerCase(); // Cột Mã KH
            const tenKH = row.cells[1].textContent.toLowerCase(); // Cột Tên KH

            const matchesSearch = !searchText || maKH.includes(searchText) || tenKH.includes(searchText);

            row.style.display = matchesSearch ? "" : "none"; // Ẩn/Hiện hàng theo điều kiện
        });
    }

    searchInput.addEventListener("input", filterTable); // Gắn sự kiện khi nhập
});
