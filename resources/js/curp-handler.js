/**
 * CURP Handler - Funciones para generar y validar CURP
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

// Inicializar manejadores de CURP
function initCurpHandler() {
    console.log("Inicializando manejadores de CURP")

    const generarCurpBtn = document.getElementById("generarCurpBtn")
    const validarCurpBtn = document.getElementById("validarCurpBtn")

    if (generarCurpBtn) {
        console.log("Botón generar CURP encontrado, agregando event listener")
        generarCurpBtn.addEventListener("click", generarCurp)
    } else {
        console.warn("Botón generar CURP no encontrado")
    }

    if (validarCurpBtn) {
        console.log("Botón validar CURP encontrado, agregando event listener")
        validarCurpBtn.addEventListener("click", validarCurp)
    } else {
        console.warn("Botón validar CURP no encontrado")
    }
}

// Función para generar CURP
async function generarCurp() {
    console.log("Función generarCurp ejecutada")
    try {
        const nombre = document.getElementById("nombre")?.value || ""
        const apellidoPaterno = document.getElementById("apellido_paterno")?.value || ""
        const apellidoMaterno = document.getElementById("apellido_materno")?.value || ""
        const genero = document.querySelector('input[name="sexo"]:checked')?.value || ""
        const estado = document.getElementById("lugar_nacimiento")?.value || ""
        const fechaNacimiento = document.getElementById("fecha_nacimiento")?.value || ""

        // Verificar si los campos requeridos están llenos
        if (!nombre || !apellidoPaterno || !genero || !estado || !fechaNacimiento) {
            alert(
                "Por favor completa los campos de nombre, apellido paterno, sexo, lugar de nacimiento y fecha de nacimiento para generar la CURP.",
            )
            return
        }

        // Mostrar indicador de carga
        const generarCurpBtn = document.getElementById("generarCurpBtn")
        generarCurpBtn.disabled = true
        generarCurpBtn.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'

        // Cargar la librería CURP desde CDN
        await loadCurpLibrary()

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

        // Generar CURP usando la librería
        const curpGenerado = window.curp.generar(datos)
        console.log("CURP generado:", curpGenerado)

        document.getElementById("curp").value = curpGenerado

        // Mostrar mensaje de éxito
        const validationSuccessMessage = document.getElementById("validationSuccessMessage")
        const validationMessage = document.getElementById("validationMessage")
        validationSuccessMessage.classList.remove("hidden")
        validationMessage.classList.add("hidden")
    } catch (error) {
        console.error("Error al generar CURP:", error)
        alert("Error al generar CURP: " + error.message)
    } finally {
        // Restaurar botón
        const generarCurpBtn = document.getElementById("generarCurpBtn")
        generarCurpBtn.disabled = false
        generarCurpBtn.textContent = "Generar CURP"
    }
}

// Función para validar CURP
async function validarCurp() {
    console.log("Función validarCurp ejecutada")
    try {
        const curpInput = document.getElementById("curp")
        const validationMessage = document.getElementById("validationMessage")
        const validationSuccessMessage = document.getElementById("validationSuccessMessage")
        const curpValue = curpInput.value.trim()

        if (!curpValue) {
            alert("Por favor ingrese una CURP para validar.")
            return
        }

        // Mostrar indicador de carga
        const validarCurpBtn = document.getElementById("validarCurpBtn")
        validarCurpBtn.disabled = true
        validarCurpBtn.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'

        // Cargar la librería CURP
        await loadCurpLibrary()

        // Validar CURP usando la librería
        const isValid = window.curp.validar(curpValue)
        console.log("CURP válido:", isValid)

        if (isValid) {
            validationMessage.classList.add("hidden")
            validationSuccessMessage.classList.remove("hidden")
        } else {
            validationMessage.classList.remove("hidden")
            validationSuccessMessage.classList.add("hidden")
        }
    } catch (error) {
        console.error("Error al validar CURP:", error)
        alert("Error al validar CURP: " + error.message)
    } finally {
        // Restaurar botón
        const validarCurpBtn = document.getElementById("validarCurpBtn")
        validarCurpBtn.disabled = false
        validarCurpBtn.textContent = "Validar CURP"
    }
}

// Cargar la librería CURP desde CDN
function loadCurpLibrary() {
    console.log("Cargando librería CURP")
    return new Promise((resolve, reject) => {
        // Verificar si ya está cargada
        if (window.curp) {
            console.log("Librería CURP ya cargada")
            resolve(window.curp)
            return
        }

        const script = document.createElement("script")
        script.src = "https://cdn.jsdelivr.net/npm/curp@1.3.0/lib/index.js"
        script.async = true
        document.head.appendChild(script)

        script.onload = () => {
            console.log("Librería CURP cargada exitosamente")
            resolve(window.curp)
        }

        script.onerror = (error) => {
            console.error("Error al cargar la librería CURP:", error)
            reject(new Error("Failed to load CURP library"))
        }
    })
}

// Exportar funciones
export { initCurpHandler, generarCurp, validarCurp }

