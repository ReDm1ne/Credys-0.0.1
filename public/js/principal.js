document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("open-sidebar-button")
    const closeSidebarBtn = document.getElementById("close-sidebar-button")
    const sidebar = document.getElementById("mobile-menu")
    const submenuToggles = document.querySelectorAll(".sidebar-dropdown-toggle")
    const userMenuButton = document.getElementById("user-menu-button")
    const userMenu = document.getElementById("user-menu")

    function toggleSidebar() {
        sidebar.classList.toggle("hidden")
    }

    if (toggleBtn) {
        toggleBtn.addEventListener("click", toggleSidebar)
    }

    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener("click", toggleSidebar)
    }

    // Submenu toggle - Actualizado para usar las nuevas clases
    submenuToggles.forEach((toggle) => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault()
            const submenu = this.nextElementSibling
            submenu.classList.toggle("hidden")

            // Rotar el icono de flecha
            const arrow = this.querySelector(".fa-chevron-down")
            if (arrow) {
                arrow.classList.toggle("rotate-180")
            }

            // Cerrar otros submenús
            submenuToggles.forEach((otherToggle) => {
                if (otherToggle !== this) {
                    const otherSubmenu = otherToggle.nextElementSibling
                    if (otherSubmenu && !otherSubmenu.classList.contains("hidden")) {
                        otherSubmenu.classList.add("hidden")
                        const otherArrow = otherToggle.querySelector(".fa-chevron-down")
                        if (otherArrow) {
                            otherArrow.classList.remove("rotate-180")
                        }
                    }
                }
            })
        })
    })

    // User menu toggle
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener("click", (e) => {
            e.preventDefault()
            userMenu.classList.toggle("hidden")

            // Posicionar el menú debajo del botón
            const buttonRect = userMenuButton.getBoundingClientRect()
            userMenu.style.top = `${buttonRect.bottom + window.scrollY}px`
            userMenu.style.right = `${window.innerWidth - buttonRect.right}px`
        })
    }

    // Close user menu when clicking outside
    document.addEventListener("click", (event) => {
        if (userMenuButton && userMenu && !userMenu.classList.contains("hidden")) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add("hidden")
            }
        }
    })

    // Close the sidebar when clicking outside on mobile devices
    document.addEventListener("click", (e) => {
        if (
            window.innerWidth <= 1024 &&
            !sidebar.classList.contains("hidden") &&
            !sidebar.contains(e.target) &&
            e.target !== toggleBtn
        ) {
            toggleSidebar()
        }
    })

    // Hammer.js for touch gestures
    let Hammer
    if (typeof Hammer !== "undefined") {
        const hammer = new Hammer(document.body)

        hammer.on("swiperight", (e) => {
            if (window.innerWidth <= 1024 && sidebar.classList.contains("hidden")) {
                toggleSidebar()
            }
        })

        hammer.on("swipeleft", (e) => {
            if (window.innerWidth <= 1024 && !sidebar.classList.contains("hidden")) {
                toggleSidebar()
            }
        })
    }

    // Prevent text selection during swipe on mobile devices
    document.body.addEventListener(
        "touchstart",
        (e) => {
            // Solo prevenir el comportamiento predeterminado si estamos en un gesto de deslizamiento
            if (e.touches.length === 1) {
                const touch = e.touches[0]
                const startX = touch.clientX

                // Solo prevenir si el toque está cerca del borde izquierdo (para abrir el sidebar)
                // o si el sidebar está abierto (para cerrarlo)
                if (startX < 30 || !sidebar.classList.contains("hidden")) {
                    e.preventDefault()
                }
            }
        },
        { passive: false },
    )

    // Add touch-action-none class to body when sidebar is open
    function updateBodyClass() {
        if (window.innerWidth <= 1024 && !sidebar.classList.contains("hidden")) {
            document.body.classList.add("touch-action-none")
        } else {
            document.body.classList.remove("touch-action-none")
        }
    }

    // Call updateBodyClass initially and on sidebar toggle
    updateBodyClass()
    if (toggleBtn) {
        toggleBtn.addEventListener("click", updateBodyClass)
    }
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener("click", updateBodyClass)
    }

    // Update body class on window resize
    window.addEventListener("resize", updateBodyClass)

    // Inicializar componentes de Flowbite si está disponible
    let flowbite
    if (typeof flowbite !== "undefined") {
        // Inicializar dropdowns, collapses, etc.
        flowbite.initDropdowns()
        flowbite.initCollapses()
    }
})

