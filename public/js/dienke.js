document.addEventListener("DOMContentLoaded", function () {
    const searchInputDK = document.querySelector("input[placeholder='Nhập mã điện kế...']"); // Mã điện kế
    const searchInputKH = document.querySelector("input[placeholder='Tên hoặc mã khách hàng...']"); // Mã hoặc tên khách hàng
    const statusSelect = document.querySelector("select"); // Trạng thái
    const tableRows = document.querySelectorAll(".custom-table tbody tr"); // Các hàng trong bảng

    function filterTable() {
        const dkSearchText = searchInputDK.value.trim().toLowerCase(); // Lấy giá trị tìm kiếm cho mã điện kế
        const khSearchText = searchInputKH.value.trim().toLowerCase(); // Lấy giá trị tìm kiếm cho khách hàng
        const selectedStatus = statusSelect.value; // Lấy giá trị trạng thái chọn

        tableRows.forEach(row => {
            const maDK = row.cells[0].textContent.toLowerCase(); // Cột Mã Điện Kế
            const maKH = row.cells[1].textContent.toLowerCase(); // Cột Mã Khách Hàng
            const tenKH = row.cells[2].textContent.toLowerCase(); // Cột Tên Khách Hàng
            const trangThai = row.cells[7].textContent.trim().toLowerCase(); // Trạng thái

            // Kiểm tra các điều kiện lọc
            const matchesDK = !dkSearchText || maDK.includes(dkSearchText);
            const matchesKH = !khSearchText || maKH.includes(khSearchText) || tenKH.includes(khSearchText);
            const matchesStatus = selectedStatus === "Tất cả" || (selectedStatus === "Đang hoạt động" && trangThai === 'đang hoạt động') || (selectedStatus === "Ngưng hoạt động" && trangThai === 'ngưng hoạt động');

            // Ẩn/Hiện hàng theo kết quả lọc
            if (matchesDK && matchesKH && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Thêm sự kiện lắng nghe vào các trường tìm kiếm và trạng thái
    searchInputDK.addEventListener("input", filterTable);
    searchInputKH.addEventListener("input", filterTable);
    statusSelect.addEventListener("change", filterTable);
});
