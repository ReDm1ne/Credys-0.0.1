/**
 * CURP Manager
 * Maneja la generación y validación de CURP sin dependencias externas
 */

// Mapeo de estados a códigos para CURP
const estadoMap = {
    Aguascalientes: "AS",
    "Baja California": "BC",
    "Baja California Sur": "BS",
    Campeche: "CC",
    Coahuila: "CL",
    Colima: "CM",
    Chiapas: "CS",
    Chihuahua: "CH",
    "Distrito Federal": "DF",
    CDMX: "DF",
    Durango: "DG",
    Guanajuato: "GT",
    Guerrero: "GR",
    Hidalgo: "HG",
    Jalisco: "JC",
    "Estado de México": "MC",
    "No especificado": "NE",
    Michoacán: "MN",
    Morelos: "MS",
    Nayarit: "NT",
    "Nuevo León": "NL",
    Oaxaca: "OC",
    Puebla: "PL",
    Querétaro: "QT",
    "Quintana Roo": "QR",
    "San Luis Potosí": "SP",
    Sinaloa: "SL",
    Sonora: "SR",
    Tabasco: "TC",
    Tamaulipas: "TS",
    Tlaxcala: "TL",
    Veracruz: "VZ",
    Yucatán: "YN",
    Zacatecas: "ZS",
}

// Variable para controlar si ya se inicializó
let initialized = false

// Implementación propia de generación de CURP
function generarCURP(datos) {
    try {
        // Extraer datos
        let { nombre, apellidoPaterno, apellidoMaterno, genero, estado, fechaNacimiento } = datos

        // Validar datos
        if (!nombre || !apellidoPaterno || !genero || !estado || !fechaNacimiento) {
            throw new Error("Faltan datos requeridos para generar CURP")
        }

        // Asegurar que apellidoMaterno tenga un valor
        apellidoMaterno = apellidoMaterno || "X"

        // Formatear fecha de nacimiento (de YYYY-MM-DD a YYMMDD)
        const fechaPartes = fechaNacimiento.split("-")
        if (fechaPartes.length !== 3) {
            throw new Error("Formato de fecha incorrecto. Use YYYY-MM-DD")
        }

        const anio = fechaPartes[0].substring(2) // Últimos dos dígitos del año
        const mes = fechaPartes[1]
        const dia = fechaPartes[2]
        const fechaFormateada = anio + mes + dia

        // 1. Primera letra del primer apellido
        let curp = apellidoPaterno.charAt(0).toUpperCase()

        // 2. Primera vocal interna del primer apellido
        const vocales = apellidoPaterno.substring(1).match(/[AEIOU]/i)
        curp += vocales ? vocales[0].toUpperCase() : "X"

        // 3. Primera letra del segundo apellido o X si no tiene
        curp += apellidoMaterno.charAt(0).toUpperCase()

        // 4. Primera letra del nombre
        curp += nombre.charAt(0).toUpperCase()

        // 5. Fecha de nacimiento en formato AAMMDD
        curp += fechaFormateada

        // 6. Género (H o M)
        curp += genero.toUpperCase()

        // 7. Código del estado
        curp += estado

        // 8. Primera consonante interna del primer apellido
        let consonantes = apellidoPaterno.substring(1).match(/[BCDFGHJKLMNPQRSTVWXYZ]/i)
        curp += consonantes ? consonantes[0].toUpperCase() : "X"

        // 9. Primera consonante interna del segundo apellido
        consonantes = apellidoMaterno.substring(1).match(/[BCDFGHJKLMNPQRSTVWXYZ]/i)
        curp += consonantes ? consonantes[0].toUpperCase() : "X"

        // 10. Primera consonante interna del nombre
        consonantes = nombre.substring(1).match(/[BCDFGHJKLMNPQRSTVWXYZ]/i)
        curp += consonantes ? consonantes[0].toUpperCase() : "X"

        // 11. Dígito para personas nacidas antes del 2000 (0) o después (A)
        const anioCompleto = Number.parseInt(fechaPartes[0])
        curp += anioCompleto < 2000 ? "0" : "A"

        // 12. Dígito verificador (algoritmo simplificado)
        curp += "1"

        return curp
    } catch (error) {
        console.error("Error generando CURP:", error)
        throw error
    }
}

// Validar CURP (implementación mejorada)
function validarCURP(curp) {
    // Expresión regular para validar el formato básico de CURP
    const curpRegex = /^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A][0-9]$/

    if (!curpRegex.test(curp)) {
        return false
    }

    // Validaciones adicionales
    // 1. Verificar que la fecha sea válida
    const anio = Number.parseInt(curp.substring(4, 6))
    const mes = Number.parseInt(curp.substring(6, 8))
    const dia = Number.parseInt(curp.substring(8, 10))

    // Determinar el siglo (19xx o 20xx)
    const siglo = curp.charAt(16) === "0" ? 1900 : 2000
    const anioCompleto = siglo + anio

    // Validar fecha
    if (mes < 1 || mes > 12) return false

    // Días por mes (considerando años bisiestos)
    const diasPorMes = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
    if ((anioCompleto % 4 === 0 && anioCompleto % 100 !== 0) || anioCompleto % 400 === 0) {
        diasPorMes[2] = 29 // Febrero en año bisiesto
    }

    if (dia < 1 || dia > diasPorMes[mes]) return false

    // 2. Verificar que el código de estado sea válido
    const estadoCodigo = curp.substring(11, 13)
    const estadosValidos = Object.values(estadoMap)
    if (!estadosValidos.includes(estadoCodigo)) return false

    // Si pasa todas las validaciones
    return true
}

// Función para verificar si la CURP ya existe en la misma sucursal
async function verificarCURPUnica(curp) {
    try {
        const response = await fetch(`/api/verificar-curp?curp=${curp}`)

        // Verificar si la respuesta es JSON válido
        const contentType = response.headers.get("content-type")
        if (!contentType || !contentType.includes("application/json")) {
            console.error("La respuesta no es JSON válido:", await response.text())
            return true // En caso de error, permitir continuar
        }

        const data = await response.json()
        return data.disponible
    } catch (error) {
        console.error("Error verificando CURP:", error)
        return true // En caso de error, permitir continuar
    }
}

// Función para generar CURP desde el formulario
async function generarCurpHandler() {
    console.log("Función generarCurp ejecutada (implementación propia)")
    try {
        const nombre = document.getElementById("nombre")?.value || ""
        const apellidoPaterno = document.getElementById("apellido_paterno")?.value || ""
        const apellidoMaterno = document.getElementById("apellido_materno")?.value || ""
        const genero = document.querySelector('input[name="sexo"]:checked')?.value || ""
        const estado = document.getElementById("lugar_nacimiento")?.value || ""
        const fechaNacimiento = document.getElementById("fecha_nacimiento")?.value || ""

        // Verificar si los campos requeridos están llenos
        if (!nombre || !apellidoPaterno || !genero || !estado || !fechaNacimiento) {
            // Mostrar modal en lugar de alert
            const curpModal = document.getElementById("curp-modal")
            const curpModalContent = document.getElementById("curp-modal-content")
            const curpModalTitle = document.getElementById("curp-modal-title")
            const curpModalMessage = document.getElementById("curp-modal-message")
            const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

            if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                curpModalTitle.textContent = "Datos Incompletos"
                curpModalMessage.textContent =
                    "Por favor completa los campos de nombre, apellido paterno, sexo, lugar de nacimiento y fecha de nacimiento para generar la CURP."

                // Ocultar palomita
                if (curpModalCheckIcon) {
                    curpModalCheckIcon.classList.add("hidden")
                }

                curpModal.classList.remove("hidden")
                setTimeout(() => {
                    curpModal.classList.add("opacity-100")
                    curpModalContent.classList.remove("scale-95", "opacity-0")
                    curpModalContent.classList.add("scale-100", "opacity-100")
                }, 10)
            }
            return
        }

        // Mostrar indicador de carga
        const generarCurpBtn = document.getElementById("generarCurpBtn")
        generarCurpBtn.disabled = true
        generarCurpBtn.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'

        // Crear objeto de datos para la generación de CURP
        const datos = {
            nombre: nombre,
            apellidoPaterno: apellidoPaterno,
            apellidoMaterno: apellidoMaterno || "X",
            genero: genero === "Hombre" ? "H" : "M",
            estado: estadoMap[estado] || "NE",
            fechaNacimiento: fechaNacimiento,
        }

        console.log("Datos para generar CURP:", datos)

        // Generar CURP usando nuestra implementación
        const curpGenerado = generarCURP(datos)
        console.log("CURP generado:", curpGenerado)

        document.getElementById("curp").value = curpGenerado

        // Validar la CURP generada
        const esValida = validarCURP(curpGenerado)
        const validationSuccessMessage = document.getElementById("validationSuccessMessage")
        const validationMessage = document.getElementById("validationMessage")

        if (esValida) {
            validationSuccessMessage.classList.remove("hidden")
            validationMessage.classList.add("hidden")

            // Verificar si la CURP ya existe en la misma sucursal
            const esCURPUnica = await verificarCURPUnica(curpGenerado)
            if (!esCURPUnica) {
                validationSuccessMessage.classList.add("hidden")
                validationMessage.textContent = "Esta CURP ya existe en esta sucursal"
                validationMessage.classList.remove("hidden")

                // Mostrar modal
                const curpModal = document.getElementById("curp-modal")
                const curpModalContent = document.getElementById("curp-modal-content")
                const curpModalTitle = document.getElementById("curp-modal-title")
                const curpModalMessage = document.getElementById("curp-modal-message")
                const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

                if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                    curpModalTitle.textContent = "CURP Duplicada"
                    curpModalMessage.textContent =
                        "Esta CURP ya existe en esta sucursal. No es posible continuar con el registro."

                    // Ocultar palomita
                    if (curpModalCheckIcon) {
                        curpModalCheckIcon.classList.add("hidden")
                    }

                    curpModal.classList.remove("hidden")
                    setTimeout(() => {
                        curpModal.classList.add("opacity-100")
                        curpModalContent.classList.remove("scale-95", "opacity-0")
                        curpModalContent.classList.add("scale-100", "opacity-100")
                    }, 10)
                }
            } else {
                // Mostrar modal con palomita cuando la CURP es válida y única
                const curpModal = document.getElementById("curp-modal")
                const curpModalContent = document.getElementById("curp-modal-content")
                const curpModalTitle = document.getElementById("curp-modal-title")
                const curpModalMessage = document.getElementById("curp-modal-message")
                const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

                if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                    curpModalTitle.textContent = "CURP Generada Correctamente"
                    curpModalMessage.textContent = "La CURP ha sido generada correctamente y está disponible para su uso."

                    // Mostrar palomita
                    if (curpModalCheckIcon) {
                        curpModalCheckIcon.classList.remove("hidden")
                    }

                    curpModal.classList.remove("hidden")
                    setTimeout(() => {
                        curpModal.classList.add("opacity-100")
                        curpModalContent.classList.remove("scale-95", "opacity-0")
                        curpModalContent.classList.add("scale-100", "opacity-100")
                    }, 10)
                }
            }
        } else {
            validationSuccessMessage.classList.add("hidden")
            validationMessage.classList.remove("hidden")

            // Mostrar modal
            const curpModal = document.getElementById("curp-modal")
            const curpModalContent = document.getElementById("curp-modal-content")
            const curpModalTitle = document.getElementById("curp-modal-title")
            const curpModalMessage = document.getElementById("curp-modal-message")
            const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

            if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                curpModalTitle.textContent = "CURP Inválida"
                curpModalMessage.textContent = "La CURP generada no es válida. Por favor verifique los datos ingresados."

                // Ocultar palomita
                if (curpModalCheckIcon) {
                    curpModalCheckIcon.classList.add("hidden")
                }

                curpModal.classList.remove("hidden")
                setTimeout(() => {
                    curpModal.classList.add("opacity-100")
                    curpModalContent.classList.remove("scale-95", "opacity-0")
                    curpModalContent.classList.add("scale-100", "opacity-100")
                }, 10)
            }
        }
    } catch (error) {
        console.error("Error al generar CURP:", error)

        // Mostrar modal en lugar de alert
        const curpModal = document.getElementById("curp-modal")
        const curpModalContent = document.getElementById("curp-modal-content")
        const curpModalTitle = document.getElementById("curp-modal-title")
        const curpModalMessage = document.getElementById("curp-modal-message")
        const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

        if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
            curpModalTitle.textContent = "Error"
            curpModalMessage.textContent = "Error al generar CURP: " + error.message

            // Ocultar palomita
            if (curpModalCheckIcon) {
                curpModalCheckIcon.classList.add("hidden")
            }

            curpModal.classList.remove("hidden")
            setTimeout(() => {
                curpModal.classList.add("opacity-100")
                curpModalContent.classList.remove("scale-95", "opacity-0")
                curpModalContent.classList.add("scale-100", "opacity-100")
            }, 10)
        }
    } finally {
        // Restaurar botón
        const generarCurpBtn = document.getElementById("generarCurpBtn")
        generarCurpBtn.disabled = false
        generarCurpBtn.textContent = "Generar CURP"
    }
}

// Función para validar CURP desde el formulario
async function validarCurpHandler() {
    console.log("Función validarCurp ejecutada (implementación propia)")
    try {
        const curpInput = document.getElementById("curp")
        const validationMessage = document.getElementById("validationMessage")
        const validationSuccessMessage = document.getElementById("validationSuccessMessage")
        const curpValue = curpInput.value.trim()

        if (!curpValue) {
            // Mostrar modal en lugar de alert
            const curpModal = document.getElementById("curp-modal")
            const curpModalContent = document.getElementById("curp-modal-content")
            const curpModalTitle = document.getElementById("curp-modal-title")
            const curpModalMessage = document.getElementById("curp-modal-message")
            const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

            if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                curpModalTitle.textContent = "CURP Vacía"
                curpModalMessage.textContent = "Por favor ingrese una CURP para validar."

                // Ocultar palomita
                if (curpModalCheckIcon) {
                    curpModalCheckIcon.classList.add("hidden")
                }

                curpModal.classList.remove("hidden")
                setTimeout(() => {
                    curpModal.classList.add("opacity-100")
                    curpModalContent.classList.remove("scale-95", "opacity-0")
                    curpModalContent.classList.add("scale-100", "opacity-100")
                }, 10)
            }
            return
        }

        // Mostrar indicador de carga
        const validarCurpBtn = document.getElementById("validarCurpBtn")
        validarCurpBtn.disabled = true
        validarCurpBtn.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'

        // Validar CURP usando nuestra implementación
        const isValid = validarCURP(curpValue)
        console.log("CURP válido:", isValid)

        if (isValid) {
            // Verificar si la CURP ya existe en la misma sucursal
            const esCURPUnica = await verificarCURPUnica(curpValue)

            if (esCURPUnica) {
                validationMessage.classList.add("hidden")
                validationSuccessMessage.classList.remove("hidden")
                validationSuccessMessage.textContent = "CURP válido"

                // Mostrar modal con palomita
                const curpModal = document.getElementById("curp-modal")
                const curpModalContent = document.getElementById("curp-modal-content")
                const curpModalTitle = document.getElementById("curp-modal-title")
                const curpModalMessage = document.getElementById("curp-modal-message")
                const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

                if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                    curpModalTitle.textContent = "CURP Válida"
                    curpModalMessage.textContent = "La CURP ingresada es válida y está disponible para su uso."

                    // Mostrar palomita
                    if (curpModalCheckIcon) {
                        curpModalCheckIcon.classList.remove("hidden")
                    }

                    curpModal.classList.remove("hidden")
                    setTimeout(() => {
                        curpModal.classList.add("opacity-100")
                        curpModalContent.classList.remove("scale-95", "opacity-0")
                        curpModalContent.classList.add("scale-100", "opacity-100")
                    }, 10)
                }
            } else {
                validationMessage.textContent = "Esta CURP ya existe en esta sucursal"
                validationMessage.classList.remove("hidden")
                validationSuccessMessage.classList.add("hidden")

                // Mostrar modal
                const curpModal = document.getElementById("curp-modal")
                const curpModalContent = document.getElementById("curp-modal-content")
                const curpModalTitle = document.getElementById("curp-modal-title")
                const curpModalMessage = document.getElementById("curp-modal-message")
                const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

                if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                    curpModalTitle.textContent = "CURP Duplicada"
                    curpModalMessage.textContent =
                        "Esta CURP ya está registrada en esta sucursal. No es posible continuar con el registro."

                    // Ocultar palomita
                    if (curpModalCheckIcon) {
                        curpModalCheckIcon.classList.add("hidden")
                    }

                    curpModal.classList.remove("hidden")
                    setTimeout(() => {
                        curpModal.classList.add("opacity-100")
                        curpModalContent.classList.remove("scale-95", "opacity-0")
                        curpModalContent.classList.add("scale-100", "opacity-100")
                    }, 10)
                }
            }
        } else {
            validationMessage.textContent = "CURP no válido"
            validationMessage.classList.remove("hidden")
            validationSuccessMessage.classList.add("hidden")

            // Mostrar modal
            const curpModal = document.getElementById("curp-modal")
            const curpModalContent = document.getElementById("curp-modal-content")
            const curpModalTitle = document.getElementById("curp-modal-title")
            const curpModalMessage = document.getElementById("curp-modal-message")
            const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

            if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
                curpModalTitle.textContent = "CURP Inválida"
                curpModalMessage.textContent =
                    "El formato de la CURP ingresada no es válido. Por favor verifique e intente nuevamente."

                // Ocultar palomita
                if (curpModalCheckIcon) {
                    curpModalCheckIcon.classList.add("hidden")
                }

                curpModal.classList.remove("hidden")
                setTimeout(() => {
                    curpModal.classList.add("opacity-100")
                    curpModalContent.classList.remove("scale-95", "opacity-0")
                    curpModalContent.classList.add("scale-100", "opacity-100")
                }, 10)
            }
        }
    } catch (error) {
        console.error("Error al validar CURP:", error)

        // Mostrar modal en lugar de alert
        const curpModal = document.getElementById("curp-modal")
        const curpModalContent = document.getElementById("curp-modal-content")
        const curpModalTitle = document.getElementById("curp-modal-title")
        const curpModalMessage = document.getElementById("curp-modal-message")
        const curpModalCheckIcon = document.getElementById("curp-modal-check-icon")

        if (curpModal && curpModalContent && curpModalTitle && curpModalMessage) {
            curpModalTitle.textContent = "Error"
            curpModalMessage.textContent = "Error al validar CURP: " + error.message

            // Ocultar palomita
            if (curpModalCheckIcon) {
                curpModalCheckIcon.classList.add("hidden")
            }

            curpModal.classList.remove("hidden")
            setTimeout(() => {
                curpModal.classList.add("opacity-100")
                curpModalContent.classList.remove("scale-95", "opacity-0")
                curpModalContent.classList.add("scale-100", "opacity-100")
            }, 10)
        }
    } finally {
        // Restaurar botón
        const validarCurpBtn = document.getElementById("validarCurpBtn")
        validarCurpBtn.disabled = false
        validarCurpBtn.textContent = "Validar CURP"
    }
}

// Inicializar manejadores de CURP
function initCurpManager() {
    // Evitar inicialización múltiple
    if (initialized) return

    console.log("Inicializando manejadores de CURP (implementación propia)")

    // Agregar event listeners a los botones
    const generarCurpBtn = document.getElementById("generarCurpBtn")
    const validarCurpBtn = document.getElementById("validarCurpBtn")
    const curpInput = document.getElementById("curp")
    const curpModalClose = document.getElementById("curp-modal-close")
    const curpModal = document.getElementById("curp-modal")
    const curpModalConfirm = document.getElementById("curp-modal-confirm")

    if (generarCurpBtn) {
        console.log("Agregando event listener a generarCurpBtn")
        // Eliminar event listeners anteriores
        generarCurpBtn.removeEventListener("click", generarCurpHandler)
        // Agregar nuevo event listener
        generarCurpBtn.addEventListener("click", generarCurpHandler)
    }

    if (validarCurpBtn) {
        console.log("Agregando event listener a validarCurpBtn")
        // Eliminar event listeners anteriores
        validarCurpBtn.removeEventListener("click", validarCurpHandler)
        // Agregar nuevo event listener
        validarCurpBtn.addEventListener("click", validarCurpHandler)
    }

    // Configurar el cierre del modal
    if (curpModalClose && curpModal) {
        curpModalClose.addEventListener("click", () => {
            const curpModalContent = document.getElementById("curp-modal-content")
            if (curpModalContent) {
                curpModalContent.classList.remove("scale-100", "opacity-100")
                curpModalContent.classList.add("scale-95", "opacity-0")
                setTimeout(() => {
                    curpModal.classList.add("hidden")
                }, 300)
            }
        })

        // Cerrar modal al hacer clic fuera
        curpModal.addEventListener("click", (e) => {
            if (e.target === curpModal) {
                const curpModalContent = document.getElementById("curp-modal-content")
                if (curpModalContent) {
                    curpModalContent.classList.remove("scale-100", "opacity-100")
                    curpModalContent.classList.add("scale-95", "opacity-0")
                    setTimeout(() => {
                        curpModal.classList.add("hidden")
                    }, 300)
                }
            }
        })
    }

    // Configurar el botón de confirmación del modal
    if (curpModalConfirm && curpModal) {
        curpModalConfirm.addEventListener("click", () => {
            const curpModalContent = document.getElementById("curp-modal-content")
            if (curpModalContent) {
                curpModalContent.classList.remove("scale-100", "opacity-100")
                curpModalContent.classList.add("scale-95", "opacity-0")
                setTimeout(() => {
                    curpModal.classList.add("hidden")
                }, 300)
            }
        })
    }

    // Exponer la función validarCURP globalmente para que form-handlers.js pueda usarla
    window.validarCURP = validarCURP

    initialized = true
}

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    // Solo inicializar si estamos en la página correcta
    if (document.getElementById("curp")) {
        initCurpManager()
    }
})

// Exportar funciones para uso externo
export { initCurpManager, generarCURP, validarCURP, verificarCURPUnica }
