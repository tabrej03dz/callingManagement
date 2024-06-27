document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.querySelector('.menu-icon');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.overlay'); // Define overlay here

    menuIcon.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
        const target = event.target;
        const isMenuIconClicked = target.classList.contains('menu-icon');
        const isSidebarClicked = target.closest('#sidebar');

        if (!isMenuIconClicked && !isSidebarClicked && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }
    });
});
