/**
 * Sidebar Manager
 * Maneja la funcionalidad del sidebar y overlay
 */

// Función para inicializar el sidebar
function initSidebar() {
    console.log("Inicializando sidebar manager...")

    // Elementos DOM
    const sidebar = document.getElementById("logo-sidebar")
    const overlay = document.getElementById("sidebar-overlay")
    const closeButton = document.querySelector('[data-drawer-hide="logo-sidebar"]')
    const toggleButtons = document.querySelectorAll('[data-drawer-toggle="logo-sidebar"]')

    // Verificar que los elementos existan
    if (!sidebar) {
        console.error("Elemento sidebar no encontrado")
        return
    }

    if (!overlay) {
        console.error("Elemento overlay no encontrado")
        return
    }

    console.log("Elementos encontrados, configurando eventos...")

    // Función para mostrar el sidebar en móviles
    function showSidebar() {
        console.log("Abriendo sidebar")
        sidebar.classList.remove("-translate-x-full")
        sidebar.setAttribute("aria-hidden", "false")
        overlay.classList.remove("hidden")
        setTimeout(() => {
            overlay.classList.add("opacity-100")
            overlay.classList.remove("opacity-0")
        }, 10)
        // Prevenir scroll en el body
        document.body.style.overflow = "hidden"
        // Asegurarse de que el body no tenga la clase bg-gray-100
        document.body.classList.remove("bg-gray-100")
    }

    // Función para ocultar el sidebar en móviles
    function hideSidebar() {
        console.log("Cerrando sidebar")
        sidebar.classList.add("-translate-x-full")
        sidebar.setAttribute("aria-hidden", "true")
        overlay.classList.remove("opacity-100")
        overlay.classList.add("opacity-0")
        setTimeout(() => {
            overlay.classList.add("hidden")
        }, 300)
        // Restaurar scroll en el body
        document.body.style.overflow = ""
        // Forzar la eliminación de la clase bg-gray-100 del body
        document.body.classList.remove("bg-gray-100")
    }

    // Agregar eventos a los botones de toggle
    toggleButtons.forEach((button) => {
        console.log("Configurando botón toggle")
        button.addEventListener("click", (e) => {
            console.log("Botón toggle clickeado")
            e.preventDefault()
            e.stopPropagation() // Evitar propagación
            if (sidebar.classList.contains("-translate-x-full")) {
                showSidebar()
            } else {
                hideSidebar()
            }
        })
    })

    // Agregar evento al botón de cerrar
    if (closeButton) {
        console.log("Configurando botón cerrar")
        closeButton.addEventListener("click", (e) => {
            console.log("Botón cerrar clickeado")
            e.preventDefault()
            e.stopPropagation() // Evitar propagación
            hideSidebar()
        })
    }

    // Agregar evento al overlay
    overlay.addEventListener("click", (e) => {
        console.log("Overlay clickeado")
        e.preventDefault()
        e.stopPropagation() // Evitar propagación
        hideSidebar()
    })

    // Cerrar sidebar con la tecla Escape
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && !sidebar.classList.contains("-translate-x-full")) {
            hideSidebar()
        }
    })

    // Cerrar sidebar al hacer clic en un enlace (en móviles)
    const sidebarLinks = sidebar.querySelectorAll("a")
    sidebarLinks.forEach((link) => {
        link.addEventListener("click", () => {
            if (window.innerWidth < 768) {
                hideSidebar()
            }
        })
    })

    // Cerrar sidebar al hacer clic fuera (como respaldo)
    document.addEventListener("click", (e) => {
        // Solo si el sidebar está abierto y estamos en móvil
        if (
            window.innerWidth < 768 &&
            !sidebar.classList.contains("-translate-x-full") &&
            !sidebar.contains(e.target) &&
            !Array.from(toggleButtons).some((btn) => btn.contains(e.target))
        ) {
            hideSidebar()
        }
    })

    // Manejar cambios de tamaño de ventana
    window.addEventListener("resize", () => {
        if (window.innerWidth >= 768) {
            // En pantallas grandes, mostrar el sidebar y ocultar el overlay
            sidebar.classList.remove("-translate-x-full")
            overlay.classList.add("hidden")
            document.body.style.overflow = ""
        } else {
            // En pantallas pequeñas, ocultar el sidebar
            sidebar.classList.add("-translate-x-full")
        }
    })

    // Función para detectar si es un dispositivo móvil real
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
    }

    // Función específica para dispositivos móviles
    function handleMobileSpecific() {
        if (isMobileDevice()) {
            // Verificar periódicamente en dispositivos móviles
            setInterval(() => {
                if (sidebar.classList.contains("-translate-x-full")) {
                    document.body.classList.remove("bg-gray-100")
                }
            }, 100)
        }
    }

    // Iniciar manejo específico para móviles
    handleMobileSpecific()

    // Verificar y eliminar la clase al cargar la página
    if (sidebar.classList.contains("-translate-x-full")) {
        document.body.classList.remove("bg-gray-100")
    }

    console.log("Sidebar manager inicializado correctamente")
}

// Inicializar cuando el DOM esté completamente cargado
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initSidebar)
} else {
    // Si el DOM ya está cargado, inicializar inmediatamente
    initSidebar()
}

