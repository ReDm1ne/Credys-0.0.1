/**
 * Módulo para gestionar el modal de tipos de trabajo
 */

/**
 * Inicializa el gestor del modal de tipos de trabajo
 */
export function initTiposTrabajoModal() {
    // Elementos del DOM
    const modal = document.getElementById("tiposTrabajoModal")
    const modalContent = document.getElementById("modal-content")
    const gestionarBtn = document.getElementById("gestionarTiposTrabajoBtn")
    const cerrarBtn = document.getElementById("cerrarModalBtn")
    const agregarBtn = document.getElementById("agregarTipoTrabajoBtn")
    const cancelarEdicionBtn = document.getElementById("cancelarEdicionBtn")
    const listaTiposTrabajo = document.getElementById("lista-tipos-trabajo")
    const mensajeError = document.getElementById("mensaje-error")
    const mensajeExito = document.getElementById("mensaje-exito")
    const formTitle = document.getElementById("form-title")
    const tipoTrabajoIdInput = document.getElementById("tipo_trabajo_id")
    const nuevoTipoNombre = document.getElementById("nuevo_tipo_nombre")
    const nuevoTipoDescripcion = document.getElementById("nuevo_tipo_descripcion")
    const tipoTrabajoSelect = document.getElementById("tipo_de_trabajo")

    // Variable para controlar si estamos en modo edición
    let modoEdicion = false

    // Verificar si los elementos existen
    if (!modal || !gestionarBtn) {
        console.log("No se encontraron los elementos necesarios para el modal de tipos de trabajo")
        return
    }

    // Función para recargar los tipos de trabajo en el select
    function recargarTiposTrabajo() {
        fetch("/api/tipos-trabajo")
            .then((response) => response.json())
            .then((data) => {
                // Guardar el valor seleccionado actualmente
                const valorSeleccionado = tipoTrabajoSelect.value

                // Limpiar opciones actuales excepto la primera
                while (tipoTrabajoSelect.options.length > 1) {
                    tipoTrabajoSelect.remove(1)
                }

                // Agregar nuevas opciones
                data.forEach((tipo) => {
                    const option = document.createElement("option")
                    option.value = tipo.nombre
                    option.textContent = tipo.nombre
                    if (tipo.nombre === valorSeleccionado) {
                        option.selected = true
                    }
                    tipoTrabajoSelect.appendChild(option)
                })
            })
            .catch((error) => console.error("Error al cargar tipos de trabajo:", error))
    }

    // Función para mostrar el modal
    function mostrarModal() {
        modal.classList.remove("hidden")
        // Pequeño retraso para permitir que la transición se vea
        setTimeout(() => {
            modal.classList.add("opacity-100")
            modalContent.classList.remove("scale-95", "opacity-0")
            modalContent.classList.add("scale-100", "opacity-100")
        }, 10)
        cargarTiposTrabajo()
    }

    // Función para cerrar el modal
    function cerrarModal(e) {
        if (e) {
            e.preventDefault()
            e.stopPropagation()
        }

        modalContent.classList.remove("scale-100", "opacity-100")
        modalContent.classList.add("scale-95", "opacity-0")
        setTimeout(() => {
            modal.classList.add("hidden")
        }, 300)
        // Resetear el formulario al cerrar
        resetearFormulario()
    }

    // Función para resetear el formulario
    function resetearFormulario() {
        modoEdicion = false
        tipoTrabajoIdInput.value = ""
        nuevoTipoNombre.value = ""
        nuevoTipoDescripcion.value = ""
        formTitle.textContent = "Agregar Nuevo Tipo"
        agregarBtn.textContent = "Agregar"
        cancelarEdicionBtn.classList.add("hidden")
    }

    // Función para cargar los tipos de trabajo en el modal
    function cargarTiposTrabajo() {
        fetch("/api/tipos-trabajo")
            .then((response) => response.json())
            .then((data) => {
                listaTiposTrabajo.innerHTML = ""

                if (data.length === 0) {
                    listaTiposTrabajo.innerHTML = '<li class="py-3 px-2 text-gray-500">No hay tipos de trabajo registrados.</li>'
                    return
                }

                data.forEach((tipo) => {
                    const li = document.createElement("li")
                    li.className = "py-3 px-2 flex justify-between items-center hover:bg-gray-50 rounded-lg"

                    const infoDiv = document.createElement("div")
                    infoDiv.className = "flex-grow cursor-pointer"
                    infoDiv.onclick = (e) => {
                        e.preventDefault()
                        e.stopPropagation()
                        seleccionarTipoTrabajo(tipo)
                    }

                    const nombre = document.createElement("p")
                    nombre.className = "font-medium text-gray-900"
                    nombre.textContent = tipo.nombre

                    const descripcion = document.createElement("p")
                    descripcion.className = "text-sm text-gray-500"
                    descripcion.textContent = tipo.descripcion || "Sin descripción"

                    infoDiv.appendChild(nombre)
                    infoDiv.appendChild(descripcion)

                    const botonesDiv = document.createElement("div")
                    botonesDiv.className = "flex space-x-2"

                    const editBtn = document.createElement("button")
                    editBtn.type = "button" // Agregar type="button" explícito
                    editBtn.className = "text-blue-600 hover:text-blue-800 focus:outline-none"
                    editBtn.innerHTML =
                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>'
                    editBtn.addEventListener("click", (e) => {
                        e.preventDefault()
                        e.stopPropagation()
                        editarTipoTrabajo(tipo)
                    })

                    const deleteBtn = document.createElement("button")
                    deleteBtn.type = "button" // Agregar type="button" explícito
                    deleteBtn.className = "text-red-600 hover:text-red-800 focus:outline-none"
                    deleteBtn.innerHTML =
                        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>'
                    deleteBtn.addEventListener("click", (e) => {
                        e.preventDefault()
                        e.stopPropagation()
                        eliminarTipoTrabajo(tipo.id, tipo.nombre)
                    })

                    botonesDiv.appendChild(editBtn)
                    botonesDiv.appendChild(deleteBtn)

                    li.appendChild(infoDiv)
                    li.appendChild(botonesDiv)

                    listaTiposTrabajo.appendChild(li)
                })
            })
            .catch((error) => console.error("Error al cargar tipos de trabajo:", error))
    }

    // Función para seleccionar un tipo de trabajo
    function seleccionarTipoTrabajo(tipo) {
        // Prevenir cualquier comportamiento predeterminado
        event.preventDefault()
        event.stopPropagation()

        if (tipoTrabajoSelect) {
            tipoTrabajoSelect.value = tipo.nombre
            cerrarModal()
        }
    }

    // Función para editar un tipo de trabajo
    function editarTipoTrabajo(tipo) {
        // Prevenir cualquier comportamiento predeterminado
        event.preventDefault()
        event.stopPropagation()

        modoEdicion = true
        tipoTrabajoIdInput.value = tipo.id
        nuevoTipoNombre.value = tipo.nombre
        nuevoTipoDescripcion.value = tipo.descripcion || ""
        formTitle.textContent = "Editar Tipo de Trabajo"
        agregarBtn.textContent = "Actualizar"
        cancelarEdicionBtn.classList.remove("hidden")

        // Hacer scroll al formulario
        document.querySelector(".bg-gray-50.rounded-xl").scrollIntoView({ behavior: "smooth" })
    }

    // Función para mostrar mensajes
    function mostrarMensaje(elemento, mensaje) {
        elemento.textContent = mensaje
        elemento.classList.remove("hidden")

        // Ocultar el mensaje después de 3 segundos
        setTimeout(() => {
            elemento.classList.add("hidden")
        }, 3000)
    }

    // Función para agregar o actualizar un tipo de trabajo
    function agregarOActualizarTipoTrabajo() {
        const nombre = nuevoTipoNombre.value.trim()
        const descripcion = nuevoTipoDescripcion.value.trim()
        const id = tipoTrabajoIdInput.value

        if (!nombre) {
            mostrarMensaje(mensajeError, "El nombre del tipo de trabajo es obligatorio.")
            return
        }

        // Mostrar indicador de carga
        agregarBtn.disabled = true
        agregarBtn.innerHTML =
            '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>'

        // Obtener token CSRF
        let csrfToken
        const metaTag = document.querySelector('meta[name="csrf-token"]')
        if (metaTag) {
            csrfToken = metaTag.getAttribute("content")
        } else {
            // Fallback: obtener el token del formulario si existe
            const tokenInput = document.querySelector('input[name="_token"]')
            if (tokenInput) {
                csrfToken = tokenInput.value
            } else {
                console.error("No se pudo encontrar el token CSRF")
                mostrarMensaje(mensajeError, "Error de seguridad: No se pudo encontrar el token CSRF.")
                agregarBtn.disabled = false
                agregarBtn.textContent = modoEdicion ? "Actualizar" : "Agregar"
                return
            }
        }

        // Usar FormData
        const formData = new FormData()
        formData.append("nombre", nombre)
        formData.append("descripcion", descripcion)
        formData.append("activo", "1")
        formData.append("_token", csrfToken)

        let url = "/tipos-trabajo"
        const method = "POST"

        // Si estamos en modo edición, usar PUT
        if (modoEdicion) {
            url = `/tipos-trabajo/${id}`
            formData.append("_method", "PUT")
        }

        fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "X-Requested-With": "XMLHttpRequest",
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    if (response.headers.get("content-type")?.includes("text/html")) {
                        // Si la respuesta es HTML, probablemente sea una página de error
                        return response.text().then((html) => {
                            console.error("Respuesta HTML recibida:", html.substring(0, 500) + "...")
                            throw new Error(
                                "El servidor devolvió una página HTML en lugar de JSON. Posible error de autenticación o ruta.",
                            )
                        })
                    }
                    throw new Error(`Error HTTP: ${response.status} ${response.statusText}`)
                }
                return response.json()
            })
            .then((data) => {
                // Limpiar campos y resetear formulario
                resetearFormulario()

                // Mostrar mensaje de éxito
                mostrarMensaje(
                    mensajeExito,
                    modoEdicion ? "Tipo de trabajo actualizado exitosamente." : "Tipo de trabajo creado exitosamente.",
                )

                // Recargar la lista de tipos de trabajo
                cargarTiposTrabajo()

                // Actualizar el select de tipos de trabajo
                recargarTiposTrabajo()
            })
            .catch((error) => {
                console.error("Error:", error)
                mostrarMensaje(
                    mensajeError,
                    `Error al ${modoEdicion ? "actualizar" : "crear"} el tipo de trabajo: ${error.message}`,
                )
            })
            .finally(() => {
                // Restaurar botón
                agregarBtn.disabled = false
                agregarBtn.textContent = modoEdicion ? "Actualizar" : "Agregar"
            })
    }

    // Función para eliminar un tipo de trabajo
    function eliminarTipoTrabajo(id, nombre) {
        // Prevenir cualquier comportamiento predeterminado
        event.preventDefault()
        event.stopPropagation()

        if (!confirm(`¿Está seguro que desea eliminar el tipo de trabajo "${nombre}"?`)) {
            return
        }

        // Obtener token CSRF
        let csrfToken
        const metaTag = document.querySelector('meta[name="csrf-token"]')
        if (metaTag) {
            csrfToken = metaTag.getAttribute("content")
        } else {
            // Fallback: obtener el token del formulario si existe
            const tokenInput = document.querySelector('input[name="_token"]')
            if (tokenInput) {
                csrfToken = tokenInput.value
            } else {
                console.error("No se pudo encontrar el token CSRF")
                mostrarMensaje(mensajeError, "Error de seguridad: No se pudo encontrar el token CSRF.")
                return
            }
        }

        // Usar FormData para enviar la solicitud DELETE
        const formData = new FormData()
        formData.append("_method", "DELETE")
        formData.append("_token", csrfToken)

        fetch(`/tipos-trabajo/${id}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "X-Requested-With": "XMLHttpRequest",
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    if (response.headers.get("content-type")?.includes("text/html")) {
                        // Si la respuesta es HTML, probablemente sea una página de error
                        return response.text().then((html) => {
                            console.error("Respuesta HTML recibida:", html.substring(0, 500) + "...")
                            throw new Error(
                                "El servidor devolvió una página HTML en lugar de JSON. Posible error de autenticación o ruta.",
                            )
                        })
                    }
                    throw new Error(`Error HTTP: ${response.status} ${response.statusText}`)
                }
                return response.json()
            })
            .then((data) => {
                // Mostrar mensaje de éxito
                mostrarMensaje(mensajeExito, "Tipo de trabajo eliminado exitosamente.")

                // Recargar la lista de tipos de trabajo
                cargarTiposTrabajo()

                // Actualizar el select de tipos de trabajo
                recargarTiposTrabajo()
            })
            .catch((error) => {
                console.error("Error:", error)
                mostrarMensaje(mensajeError, `Error al eliminar el tipo de trabajo: ${error.message}`)
            })
    }

    // Configurar recarga periódica (cada 5 minutos)
    if (tipoTrabajoSelect) {
        // Cargar tipos de trabajo al inicio
        recargarTiposTrabajo()
        setInterval(recargarTiposTrabajo, 300000)
    }

    // Eventos
    if (gestionarBtn) {
        gestionarBtn.addEventListener("click", mostrarModal)
    }

    if (cerrarBtn) {
        cerrarBtn.addEventListener("click", cerrarModal)
    }

    if (agregarBtn) {
        agregarBtn.addEventListener("click", agregarOActualizarTipoTrabajo)
    }

    if (cancelarEdicionBtn) {
        cancelarEdicionBtn.addEventListener("click", resetearFormulario)
    }

    // Cerrar modal al hacer clic fuera
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            cerrarModal(e)
        }
    })
}

// Exportar la función para inicializar el modal
export default initTiposTrabajoModal

