/**
 * Google Maps Loader
 * Carga la API de Google Maps de manera asíncrona y configura el mapa
 */

// Variable para evitar cargar el script múltiples veces
let googleMapsLoaded = false

// Función para cargar la API de Google Maps
function loadGoogleMapsApi() {
    // Check if the API is already loaded
    if (window.google && window.google.maps) {
        console.log("Google Maps API already loaded, initializing map")
        if (document.getElementById("map")) {
            initMap()
        }
        return Promise.resolve()
    }

    // Check if the script is already being loaded
    if (document.getElementById("google-maps-script")) {
        console.log("Google Maps API script is already loading")
        return new Promise((resolve) => {
            const checkLoaded = () => {
                if (window.google && window.google.maps) {
                    resolve()
                } else {
                    setTimeout(checkLoaded, 100)
                }
            }
            checkLoaded()
        })
    }

    return new Promise((resolve, reject) => {
        // Create a new script element with async attribute
        const script = document.createElement("script")
        script.id = "google-maps-script"
        script.async = true
        script.defer = true

        // Define the callback function before setting the src
        window.initGoogleMaps = () => {
            console.log("Google Maps API loaded successfully")
            googleMapsLoaded = true
            resolve()
            // Initialize the map if we're on the correct page
            if (document.getElementById("map")) {
                setTimeout(() => {
                    initMap()
                }, 100) // Small delay to ensure DOM is ready
            }
        }

        // Set the source with the callback and loading=async parameter
        script.src =
            "https://maps.googleapis.com/maps/api/js?key=AIzaSyD0r1QIkUR4Jn1JSRG9rMd0gjYSKDV7TLE&libraries=places,marker&v=weekly&callback=initGoogleMaps&loading=async"

        // Handle errors
        script.onerror = () => {
            reject(new Error("No se pudo cargar Google Maps API"))
        }

        // Add the script to the document
        document.head.appendChild(script)
    })
}

// Función para inicializar el mapa
function initMap() {
    try {
        const mapElement = document.getElementById("map")
        const inputElement = document.getElementById("direccion")

        if (!mapElement || !inputElement) {
            console.log("Map or input element not found")
            return
        }

        if (!window.google || !window.google.maps) {
            console.error("Google Maps API not loaded yet")
            return
        }

        const initialLatLng = { lat: 19.432608, lng: -99.133209 } // Ciudad de México como punto inicial

        // Crear el mapa con un ID único para el contenedor
        const map = new google.maps.Map(mapElement, {
            center: initialLatLng,
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true,
            mapId: "DEMO_MAP_ID", // Proporcionar un ID de mapa para habilitar AdvancedMarkerElement
        })

        let marker

        // Usar AdvancedMarkerElement si está disponible
        if (window.google.maps.marker && window.google.maps.marker.AdvancedMarkerElement) {
            console.log("Using AdvancedMarkerElement")
            // Crear un elemento para el marcador
            const markerElement = document.createElement("div")
            markerElement.innerHTML = `
       <div style="cursor: move;">
         <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="#E53935" stroke="#FFFFFF" stroke-width="2">
           <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
         </svg>
       </div>
     `

            // Crear el marcador avanzado
            marker = new google.maps.marker.AdvancedMarkerElement({
                map,
                position: initialLatLng,
                content: markerElement,
                draggable: true,
            })

            // Manejar el evento de arrastrar y soltar
            marker.addListener("dragend", () => {
                const position = marker.position
                const geocoder = new google.maps.Geocoder()

                geocoder
                    .geocode({ location: position })
                    .then((response) => {
                        if (response.results[0]) {
                            inputElement.value = response.results[0].formatted_address
                            console.log("Dirección actualizada:", response.results[0].formatted_address)
                        } else {
                            console.warn("No se encontró dirección para la ubicación seleccionada")
                        }
                    })
                    .catch((error) => {
                        console.error("Error en geocodificación inversa:", error)
                    })
            })
        } else {
            // Fallback a Marker tradicional si AdvancedMarkerElement no está disponible
            console.warn("AdvancedMarkerElement no está disponible, usando Marker tradicional")
            marker = new google.maps.Marker({
                position: initialLatLng,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                icon: {
                    url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                },
            })

            // Manejar el evento de arrastrar y soltar
            marker.addListener("dragend", () => {
                const position = marker.getPosition().toJSON()
                const geocoder = new google.maps.Geocoder()

                geocoder
                    .geocode({ location: position })
                    .then((response) => {
                        if (response.results[0]) {
                            inputElement.value = response.results[0].formatted_address
                            console.log("Dirección actualizada:", response.results[0].formatted_address)
                        } else {
                            console.warn("No se encontró dirección para la ubicación seleccionada")
                        }
                    })
                    .catch((error) => {
                        console.error("Error en geocodificación inversa:", error)
                    })
            })
        }

        const autocomplete = new google.maps.places.Autocomplete(inputElement, {
            types: ["address"],
        })

        autocomplete.bindTo("bounds", map)

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace()

            if (!place.geometry) {
                return
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport)
            } else {
                map.setCenter(place.geometry.location)
                map.setZoom(17)
            }

            // Actualizar la posición del marcador
            if (window.google.maps.marker && window.google.maps.marker.AdvancedMarkerElement) {
                marker.position = place.geometry.location
            } else {
                marker.setPosition(place.geometry.location)
            }

            inputElement.value = place.formatted_address
        })

        // Agregar evento de clic en el mapa para mover el marcador
        map.addListener("click", (event) => {
            // Actualizar la posición del marcador
            if (window.google.maps.marker && window.google.maps.marker.AdvancedMarkerElement) {
                marker.position = event.latLng
            } else {
                marker.setPosition(event.latLng)
            }

            // Obtener la dirección de la ubicación
            const geocoder = new google.maps.Geocoder()
            geocoder
                .geocode({ location: event.latLng.toJSON() })
                .then((response) => {
                    if (response.results[0]) {
                        inputElement.value = response.results[0].formatted_address
                        console.log("Dirección actualizada:", response.results[0].formatted_address)
                    } else {
                        console.warn("No se encontró dirección para la ubicación seleccionada")
                    }
                })
                .catch((error) => {
                    console.error("Error en geocodificación inversa:", error)
                })
        })

        console.log("Map initialized successfully")
    } catch (error) {
        console.error("Error initializing map:", error)
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    // Solo cargar Google Maps si estamos en la página correcta
    if (document.getElementById("map")) {
        loadGoogleMapsApi().catch((error) => {
            console.error("Error al cargar Google Maps:", error)
        })
    }
})

// Exportar funciones para uso externo
export { loadGoogleMapsApi, initMap }

