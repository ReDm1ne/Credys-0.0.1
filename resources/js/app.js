import "./bootstrap"
import "flowbite"
import { initCurpHandler } from "./curp-handler"

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM cargado completamente")

    // Inicializar componentes de Flowbite
    const drawer = document.getElementById("logo-sidebar")
    const drawerToggleButtons = document.querySelectorAll('[data-drawer-toggle="logo-sidebar"]')

    // Manejar el toggle del sidebar en móvil
    if (drawerToggleButtons.length > 0 && drawer) {
        drawerToggleButtons.forEach((button) => {
            button.addEventListener("click", () => {
                drawer.classList.toggle("-translate-x-full")
            })
        })
    }

    // Cerrar sidebar cuando se hace clic fuera en dispositivos móviles
    document.addEventListener("click", (event) => {
        const isSmallScreen = window.innerWidth < 640 // sm breakpoint
        if (
            isSmallScreen &&
            drawer &&
            !drawer.contains(event.target) &&
            !event.target.hasAttribute("data-drawer-toggle") &&
            !drawer.classList.contains("-translate-x-full")
        ) {
            drawer.classList.add("-translate-x-full")
        }
    })

    // Manejar los submenús
    const dropdownButtons = document.querySelectorAll("[data-collapse-toggle]")
    dropdownButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const targetId = this.getAttribute("data-collapse-toggle")
            const targetElement = document.getElementById(targetId)

            // Cerrar todos los otros submenús
            dropdownButtons.forEach((otherButton) => {
                const otherId = otherButton.getAttribute("data-collapse-toggle")
                if (otherId !== targetId) {
                    const otherElement = document.getElementById(otherId)
                    if (otherElement && !otherElement.classList.contains("hidden")) {
                        otherElement.classList.add("hidden")
                        otherButton.setAttribute("aria-expanded", "false")
                    }
                }
            })

            // Alternar el submenú actual
            if (targetElement) {
                targetElement.classList.toggle("hidden")
                this.setAttribute("aria-expanded", targetElement.classList.contains("hidden") ? "false" : "true")
            }
        })
    })

    // Inicializar manejador de CURP si estamos en la página de clientes
    if (document.getElementById("curp")) {
        console.log("Elemento CURP encontrado, inicializando manejador")
        initCurpHandler()
    }
})

