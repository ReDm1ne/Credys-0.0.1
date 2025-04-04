/**
 * Form Handlers
 * Maneja las funcionalidades de formularios como tabs y cálculos financieros
 */

// Variable para controlar si ya se inicializó
let initialized = false

// Función para manejar las tabs
function initTabHandler() {
    const tabButtons = document.querySelectorAll(".tab-btn")
    const tabContents = document.querySelectorAll(".tab-content")

    if (!tabButtons.length || !tabContents.length) return

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            // Desactivar todas las tabs
            tabButtons.forEach((btn) => {
                btn.classList.remove("active")
                btn.classList.remove("border-blue-600")
                btn.classList.remove("text-blue-600")
                btn.classList.add("border-transparent")
                btn.classList.add("text-gray-500")
                btn.classList.add("hover:text-gray-700")
                btn.classList.add("hover:border-gray-300")
            })

            // Ocultar todos los contenidos
            tabContents.forEach((content) => {
                content.classList.add("hidden")
            })

            // Activar la tab seleccionada
            button.classList.add("active")
            button.classList.add("border-blue-600")
            button.classList.add("text-blue-600")
            button.classList.remove("border-transparent")
            button.classList.remove("text-gray-500")
            button.classList.remove("hover:text-gray-700")
            button.classList.remove("hover:border-gray-300")

            // Mostrar el contenido seleccionado
            const tabId = button.getAttribute("data-tab")
            const tabContent = document.getElementById(tabId)
            if (tabContent) {
                tabContent.classList.remove("hidden")
            }
        })
    })
}

// Función para manejar la sección de cónyuge
function initConyugeSection() {
    const estadoCivilSelect = document.getElementById("estado_civil")
    const conyugeSection = document.getElementById("conyuge_section")
    const conyugeFotoInput = document.getElementById("conyuge_foto")
    const conyugeCredencialInput = document.getElementById("conyuge_credencial")

    if (!estadoCivilSelect || !conyugeSection) return

    estadoCivilSelect.addEventListener("change", () => {
        const value = estadoCivilSelect.value
        if (value === "Casado" || value === "Union Libre") {
            conyugeSection.classList.remove("hidden")
            // No hacemos requeridos los campos de foto y credencial, son opcionales
        } else {
            conyugeSection.classList.add("hidden")
            // Limpiar los campos de archivo cuando se oculta la sección
            if (conyugeFotoInput) conyugeFotoInput.value = ""
            if (conyugeCredencialInput) conyugeCredencialInput.value = ""
        }
    })
}

// Función para manejar la sección de vehículo
function initVehiculoSection() {
    const vehiculoSelect = document.getElementById("vehiculo")
    const vehiculoDetails = document.getElementById("vehiculo_details")

    if (!vehiculoSelect || !vehiculoDetails) return

    vehiculoSelect.addEventListener("change", () => {
        const value = vehiculoSelect.value
        if (value === "1") {
            vehiculoDetails.classList.remove("hidden")
        } else {
            vehiculoDetails.classList.add("hidden")
        }
    })
}

// Función para calcular los totales financieros
function initFinancialCalculations() {
    // Elementos de ingreso
    const ingresoMensualPromedio = document.getElementById("ingreso_mensual_promedio")
    const otrosIngresosMensuales = document.getElementById("otros_ingresos_mensuales")
    const ingresoPromedioMensualTotal = document.getElementById("ingreso_promedio_mensual_total")

    // Elementos de gasto
    const gastoAlimento = document.getElementById("gasto_alimento")
    const gastoLuz = document.getElementById("gasto_luz")
    const gastoTelefono = document.getElementById("gasto_telefono")
    const gastoTransporte = document.getElementById("gasto_transporte")
    const gastoRenta = document.getElementById("gasto_renta")
    const gastoInversionNegocio = document.getElementById("gasto_inversion_negocio")
    const gastoOtrosCreditos = document.getElementById("gasto_otros_creditos")
    const gastoOtros = document.getElementById("gasto_otros")
    const totalGastoMensual = document.getElementById("total_gasto_mensual")
    const totalDisponibleMensual = document.getElementById("total_disponible_mensual")

    // Verificar que existan los elementos
    const ingresoElements = [ingresoMensualPromedio, otrosIngresosMensuales, ingresoPromedioMensualTotal]
    const gastoElements = [
        gastoAlimento,
        gastoLuz,
        gastoTelefono,
        gastoTransporte,
        gastoRenta,
        gastoInversionNegocio,
        gastoOtrosCreditos,
        gastoOtros,
        totalGastoMensual,
        totalDisponibleMensual,
    ]

    // Si no estamos en la página financiera, salir
    if (!ingresoElements.every((el) => el) || !gastoElements.every((el) => el)) return

    // Función para calcular el total de ingresos
    const calcularTotalIngresos = () => {
        const ingreso = Number.parseFloat(ingresoMensualPromedio.value) || 0
        const otrosIngresos = Number.parseFloat(otrosIngresosMensuales.value) || 0
        const total = ingreso + otrosIngresos
        ingresoPromedioMensualTotal.value = total.toFixed(2)
        return total
    }

    // Función para calcular el total de gastos
    const calcularTotalGastos = () => {
        const alimento = Number.parseFloat(gastoAlimento.value) || 0
        const luz = Number.parseFloat(gastoLuz.value) || 0
        const telefono = Number.parseFloat(gastoTelefono.value) || 0
        const transporte = Number.parseFloat(gastoTransporte.value) || 0
        const renta = Number.parseFloat(gastoRenta.value) || 0
        const inversionNegocio = Number.parseFloat(gastoInversionNegocio.value) || 0
        const otrosCreditos = Number.parseFloat(gastoOtrosCreditos.value) || 0
        const otros = Number.parseFloat(gastoOtros.value) || 0

        const total = alimento + luz + telefono + transporte + renta + inversionNegocio + otrosCreditos + otros
        totalGastoMensual.value = total.toFixed(2)
        return total
    }

    // Función para calcular el total disponible
    const calcularTotalDisponible = () => {
        const totalIngresos = calcularTotalIngresos()
        const totalGastos = calcularTotalGastos()
        const disponible = totalIngresos - totalGastos
        totalDisponibleMensual.value = disponible.toFixed(2)
    }

    // Agregar event listeners a los campos de ingreso
    ingresoMensualPromedio.addEventListener("input", calcularTotalDisponible)
    otrosIngresosMensuales.addEventListener("input", calcularTotalDisponible)

    // Agregar event listeners a los campos de gasto
    gastoAlimento.addEventListener("input", calcularTotalDisponible)
    gastoLuz.addEventListener("input", calcularTotalDisponible)
    gastoTelefono.addEventListener("input", calcularTotalDisponible)
    gastoTransporte.addEventListener("input", calcularTotalDisponible)
    gastoRenta.addEventListener("input", calcularTotalDisponible)
    gastoInversionNegocio.addEventListener("input", calcularTotalDisponible)
    gastoOtrosCreditos.addEventListener("input", calcularTotalDisponible)
    gastoOtros.addEventListener("input", calcularTotalDisponible)

    // Calcular los totales iniciales
    calcularTotalDisponible()
}

// Función para manejar el botón de envío del formulario
function initSubmitButton() {
    const form = document.querySelector("form")
    const submitButton = document.getElementById("crearClienteBtn")
    const loadingIndicator = document.getElementById("loading")

    if (!form || !submitButton || !loadingIndicator) return

    form.addEventListener("submit", () => {
        submitButton.disabled = true
        loadingIndicator.classList.remove("hidden")
    })
}

// Función principal para inicializar todos los manejadores de formulario
function initFormHandlers() {
    // Evitar inicialización múltiple
    if (initialized) return

    console.log("Inicializando manejadores de formulario")

    initTabHandler()
    initConyugeSection()
    initVehiculoSection()
    initFinancialCalculations()
    initSubmitButton()

    initialized = true
}

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    // Solo inicializar si estamos en la página correcta (con tabs)
    if (document.querySelector(".tab-btn")) {
        initFormHandlers()
    }
})

// Exportar funciones para uso externo
export { initFormHandlers }

