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
    const progressBar = document.getElementById("progress-bar")
    const progressText = document.getElementById("progress-text")
    const validationError = document.getElementById("validation-error")
    const validationErrorMessage = document.getElementById("validation-error-message")
    const curpModal = document.getElementById("curp-modal")
    const curpModalContent = document.getElementById("curp-modal-content")
    const curpModalTitle = document.getElementById("curp-modal-title")
    const curpModalMessage = document.getElementById("curp-modal-message")
    const curpModalClose = document.getElementById("curp-modal-close")
    const curpInput = document.getElementById("curp")
    const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

    if (!tabButtons.length || !tabContents.length) return

    // Función para mostrar el modal de CURP
    function showCurpModal(title, message, isSuccess = false) {
        if (!curpModal || !curpModalTitle || !curpModalMessage || !curpModalContent) return

        curpModalTitle.textContent = title
        curpModalMessage.textContent = message

        // Mostrar el icono de palomita si es éxito
        const checkIcon = document.getElementById("curp-modal-check-icon")
        if (checkIcon) {
            if (isSuccess) {
                checkIcon.classList.remove("hidden")
            } else {
                checkIcon.classList.add("hidden")
            }
        }

        curpModal.classList.remove("hidden")
        setTimeout(() => {
            curpModalContent.classList.remove("scale-95", "opacity-0")
            curpModalContent.classList.add("scale-100", "opacity-100")
        }, 10)
    }

    // Función para cerrar el modal de CURP
    function closeCurpModal() {
        if (!curpModal || !curpModalContent) return

        curpModalContent.classList.remove("scale-100", "opacity-100")
        curpModalContent.classList.add("scale-95", "opacity-0")
        setTimeout(() => {
            curpModal.classList.add("hidden")
        }, 300)
    }

    // Evento para cerrar el modal de CURP
    if (curpModalClose) {
        curpModalClose.addEventListener("click", closeCurpModal)
    }
    if (curpModal) {
        curpModal.addEventListener("click", (e) => {
            if (e.target === curpModal) {
                closeCurpModal()
            }
        })
    }

    // Evento para el botón de confirmación del modal
    const curpModalConfirm = document.getElementById("curp-modal-confirm")
    if (curpModalConfirm) {
        curpModalConfirm.addEventListener("click", closeCurpModal)
    }

    // Validar CURP
    async function validateCurp() {
        if (!curpInput) return true

        const curpValue = curpInput.value.trim()
        const validationMessage = document.getElementById("validationMessage")
        const validationSuccessMessage = document.getElementById("validationSuccessMessage")

        if (!curpValue) {
            showCurpModal("CURP Vacía", "Por favor ingrese una CURP para continuar.")
            return false
        }

        // Usar la función validarCURP del curp-manager.js si está disponible
        let isValidFormat = true
        if (typeof window.validarCURP === "function") {
            isValidFormat = window.validarCURP(curpValue)
        } else {
            // Fallback si la función no está disponible
            const curpRegex = /^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A][0-9]$/
            isValidFormat = curpRegex.test(curpValue)
        }

        if (!isValidFormat) {
            if (validationMessage) validationMessage.classList.remove("hidden")
            if (validationSuccessMessage) validationSuccessMessage.classList.add("hidden")
            showCurpModal(
                "CURP Inválida",
                "El formato de la CURP ingresada no es válido. Por favor verifique e intente nuevamente.",
            )
            return false
        }

        // Verificar si la CURP ya existe en la misma sucursal
        try {
            const response = await fetch(`/api/verificar-curp?curp=${curpValue}`)

            // Verificar si la respuesta es JSON válido
            const contentType = response.headers.get("content-type")
            if (!contentType || !contentType.includes("application/json")) {
                console.error("La respuesta no es JSON válido:", await response.text())
                showCurpModal("Error de Verificación", "Ocurrió un error al verificar la CURP. Por favor intente nuevamente.")
                return false
            }

            const data = await response.json()

            if (!data.disponible) {
                if (validationMessage) validationMessage.classList.remove("hidden")
                if (validationSuccessMessage) validationSuccessMessage.classList.add("hidden")
                showCurpModal(
                    "CURP Duplicada",
                    "Esta CURP ya está registrada en esta sucursal. No es posible continuar con el registro.",
                )
                return false
            }

            if (validationMessage) validationMessage.classList.add("hidden")
            if (validationSuccessMessage) validationSuccessMessage.classList.remove("hidden")
            showCurpModal(
                "CURP Válida",
                "La CURP ingresada es válida y está disponible para su uso.",
                true, // Indicar que es un éxito para mostrar la palomita
            )
            return true
        } catch (error) {
            console.error("Error al verificar CURP:", error)
            showCurpModal("Error de Verificación", "Ocurrió un error al verificar la CURP. Por favor intente nuevamente.")
            return false
        }
    }

    // Agregar evento para validar CURP manualmente
    const validarCurpBtn = document.getElementById("validarCurpBtn")
    if (validarCurpBtn) {
        validarCurpBtn.addEventListener("click", validateCurp)
    }

    tabButtons.forEach((button) => {
        button.addEventListener("click", async (e) => {
            e.preventDefault()

            // Obtener el tab actual que está visible
            const currentTabContent = document.querySelector(".tab-content:not(.hidden)")
            if (!currentTabContent) return

            const currentTab = currentTabContent.id
            const targetTab = button.getAttribute("data-tab")

            // Si estamos en la pestaña general y queremos ir a otra, validar la CURP primero
            if (currentTab === "general" && targetTab !== "general") {
                const curpValid = await validateCurp()
                if (!curpValid) return
            }

            // Validar los campos del tab actual antes de cambiar
            if (validateTabFields(currentTab)) {
                changeTab(targetTab)
            }
        })
    })

    // Botones de navegación
    const nextBtn1 = document.getElementById("next-btn-1")
    const nextBtn2 = document.getElementById("next-btn-2")
    const nextBtn3 = document.getElementById("next-btn-3")
    const nextBtn4 = document.getElementById("next-btn-4")
    const prevBtn2 = document.getElementById("prev-btn-2")
    const prevBtn3 = document.getElementById("prev-btn-3")
    const prevBtn4 = document.getElementById("prev-btn-4")
    const prevBtn5 = document.getElementById("prev-btn-5")

    if (nextBtn1) {
        nextBtn1.addEventListener("click", async () => {
            // Validar CURP primero
            const curpValid = await validateCurp()
            if (!curpValid) return

            if (validateTabFields("general")) {
                changeTab("referencias")
            }
        })
    }

    if (nextBtn2) {
        nextBtn2.addEventListener("click", () => {
            if (validateTabFields("referencias")) {
                changeTab("financiera")
            }
        })
    }

    if (nextBtn3) {
        nextBtn3.addEventListener("click", () => {
            if (validateTabFields("financiera")) {
                changeTab("laboral")
            }
        })
    }

    if (nextBtn4) {
        nextBtn4.addEventListener("click", () => {
            if (validateTabFields("laboral")) {
                changeTab("documentacion")
            }
        })
    }

    if (prevBtn2) {
        prevBtn2.addEventListener("click", () => {
            changeTab("general")
        })
    }

    if (prevBtn3) {
        prevBtn3.addEventListener("click", () => {
            changeTab("referencias")
        })
    }

    if (prevBtn4) {
        prevBtn4.addEventListener("click", () => {
            changeTab("financiera")
        })
    }

    if (prevBtn5) {
        prevBtn5.addEventListener("click", () => {
            changeTab("laboral")
        })
    }

    function changeTab(targetTab) {
        tabContents.forEach((content) => {
            content.classList.add("hidden")
        })

        tabButtons.forEach((btn) => {
            btn.classList.remove("active", "border-blue-600", "text-blue-600")
            btn.classList.add("border-transparent", "text-gray-500", "hover:text-gray-700", "hover:border-gray-300")
        })

        const tabContent = document.getElementById(targetTab)
        tabContent.classList.remove("hidden")

        const tabButton = document.querySelector(`[data-tab="${targetTab}"]`)
        tabButton.classList.add("active", "border-blue-600", "text-blue-600")
        tabButton.classList.remove("border-transparent", "text-gray-500", "hover:text-gray-700", "hover:border-gray-300")

        const step = Number.parseInt(tabContent.dataset.step)
        updateProgress(step)
    }

    function updateProgress(step) {
        if (!progressBar || !progressText) return

        const totalSteps = 5
        const percentage = (step / totalSteps) * 100
        progressBar.style.width = `${percentage}%`
        progressText.textContent = `Paso ${step} de ${totalSteps}`
    }

    function validateTabFields(tabId) {
        const tab = document.getElementById(tabId)
        if (!tab) return true

        // Solo validar los campos visibles en la pestaña actual
        const requiredFields = tab.querySelectorAll(
            "input[required]:not([type='hidden']), select[required], textarea[required]",
        )
        let isValid = true
        let firstInvalidField = null
        const errorMessages = []

        requiredFields.forEach((field) => {
            // Verificar si el campo o su contenedor padre está oculto
            if (
                field.offsetParent === null ||
                field.closest(".hidden") !== null ||
                window.getComputedStyle(field).display === "none"
            ) {
                return // Saltar campos ocultos
            }

            const fieldLabel = field.previousElementSibling ? field.previousElementSibling.textContent.trim() : field.name
            const fieldName = fieldLabel.replace(" *", "")

            if (field.type === "radio") {
                const name = field.name
                const checkedRadio = tab.querySelector(`input[name="${name}"]:checked`)
                if (!checkedRadio) {
                    isValid = false
                    errorMessages.push(`El campo "${fieldName}" es obligatorio.`)
                    if (!firstInvalidField) {
                        firstInvalidField = field
                    }
                }
            } else if (field.value.trim() === "") {
                isValid = false
                field.classList.add("border-red-500")
                errorMessages.push(`El campo "${fieldName}" es obligatorio.`)
                if (!firstInvalidField) {
                    firstInvalidField = field
                }
            } else {
                field.classList.remove("border-red-500")
            }
        })

        if (!isValid && validationError && validationErrorMessage) {
            validationError.classList.remove("hidden")
            validationErrorMessage.innerHTML = errorMessages.map((msg) => `<li>${msg}</li>`).join("")
            if (firstInvalidField) {
                firstInvalidField.focus()
                firstInvalidField.scrollIntoView({ behavior: "smooth", block: "center" })
            }
            setTimeout(() => {
                validationError.classList.add("hidden")
            }, 5000)
        }

        return isValid
    }

    // Manejar envío del formulario
    const form = document.getElementById("cliente-form")
    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault()

            // Validar la pestaña actual
            const currentTabContent = document.querySelector(".tab-content:not(.hidden)")
            if (!currentTabContent) return

            const currentTab = currentTabContent.id
            if (!validateTabFields(currentTab)) {
                return
            }

            // Validar CURP una última vez
            const curpValid = await validateCurp()
            if (!curpValid) {
                return
            }

            // Mostrar indicador de carga
            const submitBtn = document.getElementById("crearClienteBtn")
            const loading = document.getElementById("loading")
            if (submitBtn) submitBtn.disabled = true
            if (loading) loading.classList.remove("hidden")

            // Enviar el formulario
            form.submit()
        })
    }
}

// Función para manejar la sección de cónyuge
function initConyugeSection() {
    const estadoCivilSelect = document.getElementById("estado_civil")
    const conyugeSection = document.getElementById("conyuge_section")

    if (!estadoCivilSelect || !conyugeSection) return

    estadoCivilSelect.addEventListener("change", () => {
        const value = estadoCivilSelect.value
        if (value === "Casado" || value === "Union Libre") {
            conyugeSection.classList.remove("hidden")
        } else {
            conyugeSection.classList.add("hidden")
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
