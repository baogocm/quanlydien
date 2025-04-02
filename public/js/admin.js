// Toggle Sidebar
document.addEventListener('DOMContentLoaded', function () {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');

    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // Responsive sidebar behavior
    function checkWidth() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('active');
        } else {
            sidebar.classList.remove('active');
        }
    }

    // Check width on page load
    checkWidth();

    // Check width on window resize
    window.addEventListener('resize', checkWidth);

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Add active class to current menu item
    const currentLocation = location.pathname;
    const menuItems = document.querySelectorAll('#sidebar .nav-item a');
    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentLocation) {
            item.parentElement.classList.add('active');
        }
    });
}); 