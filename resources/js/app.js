import "./bootstrap"
import "flowbite"
import { initCurpManager } from "./curp-manager"
import { loadGoogleMapsApi } from "./google-maps-loader"
import { initFormHandlers } from "./form-handlers"
import "./sidebar-manager" // Importar el archivo de sidebar
import { initTiposTrabajoModal } from "./tipos-trabajo-modal" // Importar el módulo de tipos de trabajo

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM cargado completamente")

    // Inicializar manejador de CURP si estamos en la página de clientes
    if (document.getElementById("curp")) {
        console.log("Elemento CURP encontrado, inicializando manejador")
        initCurpManager()
    }

    // Inicializar Google Maps si estamos en la página con mapa
    if (document.getElementById("map")) {
        console.log("Map element found, loading Google Maps API")
        loadGoogleMapsApi().catch((error) => {
            console.error("Error al cargar Google Maps:", error)
        })
    }

    // Inicializar manejadores de formulario si estamos en una página con tabs
    if (document.querySelector(".tab-btn")) {
        console.log("Tabs encontrados, inicializando manejadores de formulario")
        initFormHandlers()
    }

    // Inicializar modal de tipos de trabajo si existe el botón
    if (document.getElementById("gestionarTiposTrabajoBtn")) {
        console.log("Botón de gestionar tipos de trabajo encontrado, inicializando modal")
        initTiposTrabajoModal()
    }

    // Código adicional para forzar el cierre del sidebar en móviles
    const forceMobileSidebarClose = () => {
        const sidebar = document.getElementById("logo-sidebar")
        const overlay = document.getElementById("sidebar-overlay")

        if (window.innerWidth < 768 && sidebar && !sidebar.classList.contains("-translate-x-full")) {
            console.log("Forzando cierre del sidebar en móvil")
            sidebar.classList.add("-translate-x-full")
            if (overlay) {
                overlay.classList.add("hidden")
            }
            document.body.classList.remove("bg-gray-100")
        }
    }

    // Ejecutar al cargar y en cada cambio de tamaño
    forceMobileSidebarClose()
    window.addEventListener("resize", forceMobileSidebarClose)
})

