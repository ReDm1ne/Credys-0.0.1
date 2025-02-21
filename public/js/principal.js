document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleSidebar');
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    const menuItems = document.querySelectorAll('.sidebar-menu a, .logout-btn');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', toggleMobileMenu);
    }

    if (submenuToggles.length) {
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', toggleSubmenu);
        });
    }

    if (mainContent) {
        mainContent.addEventListener('click', function() {
            if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                toggleMobileMenu();
            }
        });
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
            if (mobileToggle) {
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        }
        if (window.innerWidth <= 992) {
            sidebar.classList.add('collapsed');
            if (mainContent) {
                mainContent.style.marginLeft = 'var(--sidebar-collapsed-width)';
            }
        } else {
            sidebar.classList.remove('collapsed');
            if (mainContent) {
                mainContent.style.marginLeft = 'var(--sidebar-width)';
            }
        }
    });

    menuItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Asegúrate de que solo los elementos de submenú tienen comportamiento de desplegado
    function toggleSubmenu(e) {
        if (this.nextElementSibling && this.nextElementSibling.classList.contains('submenu')) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            const isCollapsed = sidebar.classList.contains('collapsed');

            if (isCollapsed) {
                sidebar.classList.remove('collapsed');
                if (toggleBtn) {
                    toggleBtn.setAttribute('aria-expanded', 'true');
                    const icon = toggleBtn.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-bars');
                    }
                }
                if (mainContent) {
                    mainContent.style.marginLeft = 'var(--sidebar-width)';
                }
            }

            if (submenu) {
                submenu.classList.toggle('active');
                this.setAttribute('aria-expanded', submenu.classList.contains('active'));
            }

            document.querySelectorAll('.submenu.active').forEach(otherSubmenu => {
                if (otherSubmenu !== submenu && otherSubmenu) {
                    otherSubmenu.classList.remove('active');
                    if (otherSubmenu.previousElementSibling) {
                        otherSubmenu.previousElementSibling.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }
    }

    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        const isCollapsed = sidebar.classList.contains('collapsed');
        if (toggleBtn) {
            toggleBtn.setAttribute('aria-expanded', !isCollapsed);
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-chevron-right');
            }
        }

        if (mainContent) {
            mainContent.style.marginLeft = isCollapsed ? 'var(--sidebar-collapsed-width)' : 'var(--sidebar-width)';
        }

        if (isCollapsed) {
            document.querySelectorAll('.submenu.active').forEach(submenu => {
                submenu.classList.remove('active');
            });
        }
    }

    function toggleMobileMenu() {
        sidebar.classList.toggle('active');
        const isActive = sidebar.classList.contains('active');
        if (mobileToggle) {
            mobileToggle.setAttribute('aria-expanded', isActive);
        }
    }
});