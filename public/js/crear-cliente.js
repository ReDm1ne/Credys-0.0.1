document.addEventListener('DOMContentLoaded', function () {
    console.log('crear-cliente.js ha sido cargado correctamente.');

    // Manejo de tabs
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabId = tab.getAttribute('data-tab');

            // Remover la clase active de todas las tabs y contenidos
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Agregar la clase active a la tab seleccionada y su contenido correspondiente
            tab.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Cálculos financieros
    const ingresoMensualPromedio = document.getElementById('ingreso_mensual_promedio');
    const otrosIngresosMensuales = document.getElementById('otros_ingresos_mensuales');
    const ingresoPromedioMensualTotal = document.getElementById('ingreso_promedio_mensual_total');
    const gastoInputs = document.querySelectorAll('#financiera input[type="number"]:not([readonly])');
    const totalGastoMensual = document.getElementById('total_gasto_mensual');
    const totalDisponibleMensual = document.getElementById('total_disponible_mensual');

    function updateFinancials() {
        const ingresoTotal = parseFloat(ingresoMensualPromedio.value || 0) + parseFloat(otrosIngresosMensuales.value || 0);
        ingresoPromedioMensualTotal.value = ingresoTotal.toFixed(2);

        let gastoTotal = 0;
        gastoInputs.forEach(input => {
            if (input.id !== 'ingreso_mensual_promedio' && input.id !== 'otros_ingresos_mensuales') {
                gastoTotal += parseFloat(input.value || 0);
            }
        });
        totalGastoMensual.value = gastoTotal.toFixed(2);

        const disponible = ingresoTotal - gastoTotal;
        totalDisponibleMensual.value = disponible.toFixed(2);
    }

    gastoInputs.forEach(input => input.addEventListener('input', updateFinancials));

    // Desplegar detalles de vehículo
    const vehiculoSelect = document.getElementById('vehiculo');
    const vehiculoDetails = document.getElementById('vehiculo_details');

    vehiculoSelect.addEventListener('change', function () {
        vehiculoDetails.style.display = this.value === '1' ? 'block' : 'none';
    });

    // Generación de CURP (función de ejemplo)
    window.generarCURP = function () {
        const nombre = document.getElementById('nombre')?.value || '';
        const apellidoPaterno = document.getElementById('apellido_paterno')?.value || '';
        const apellidoMaterno = document.getElementById('apellido_materno')?.value || '';
        const genero = document.querySelector('input[name="sexo"]:checked')?.value || '';
        const estado = document.getElementById('lugar_nacimiento')?.value || '';
        const fechaNacimiento = document.getElementById('fecha_nacimiento')?.value || '';

        // Verificar si los campos requeridos están llenos
        if (!nombre || !apellidoPaterno || !genero || !estado || !fechaNacimiento) {
            alert('Por favor completa todos los campos requeridos.');
            return;
        }

        const persona = new Persona(
            nombre,
            apellidoPaterno,
            apellidoMaterno,
            genero === 'Hombre' ? GENERO.MASCULINO : GENERO.FEMENINO,
            mapEstadoToCode(estado),
            fechaNacimiento
        );

        try {
            const curpGenerado = curp.generar(persona);
            document.getElementById('curp').value = curpGenerado;
        } catch (error) {
            console.error('Error generando la CURP:', error.message);
        }
    };
    // Validación de CURP
    window.validarCURP = function() {
        const curpInput = document.getElementById('curp');
        const validationMessage = document.getElementById('validationMessage');
        const validationSuccessMessage = document.getElementById('validationSuccessMessage');
        const curpValue = curpInput.value.trim();

        if (curp.validar(curpValue)) {
            validationMessage.style.display = 'none';
            validationSuccessMessage.style.display = 'inline';
        } else {
            validationMessage.style.display = 'inline';
            validationSuccessMessage.style.display = 'none';
        }
    };
});
// Mapper para Estados
function mapEstadoToCode(estado) {
    const estadoMap = {
        "Aguascalientes": "AS",
        "Baja California": "BC",
        "Baja California Sur": "BS",
        "Campeche": "CC",
        "Coahuila": "CL",
        "Colima": "CM",
        "Chiapas": "CS",
        "Chihuahua": "CH",
        "Distrito Federal": "DF",
        "CDMX": "DF",
        "Durango": "DG",
        "Guanajuato": "GT",
        "Guerrero": "GR",
        "Hidalgo": "HG",
        "Jalisco": "JC",
        "Estado de México": "MC",
        "No especificado": "NE",
        "Michoacán": "MN",
        "Morelos": "MS",
        "Nayarit": "NT",
        "Nuevo León": "NL",
        "Oaxaca": "OC",
        "Puebla": "PL",
        "Querétaro": "QT",
        "Quintana Roo": "QR",
        "San Luis Potosí": "SP",
        "Sinaloa": "SL",
        "Sonora": "SR",
        "Tabasco": "TC",
        "Tamaulipas": "TS",
        "Tlaxcala": "TL",
        "Veracruz": "VZ",
        "Yucatán": "YN",
        "Zacatecas": "ZS"
    };

    return estadoMap[estado];
}

// Inicia código de generación de CURP

const curp = {};

const GENERO = {
    MASCULINO: 'H',
    FEMENINO: 'M',
};

const comunes = [
  'MARIA DEL ', 'MARIA DE LOS ', 'MARIA ', 'JOSE DE ', 'JOSE ', 'MA. ', 'MA ', 'M. ', 'J. ', 'J ', 'M ',
];

const malasPalabras = {
    BACA: 'BXCA',
    BAKA: 'BXKA',
    BUEI: 'BXEI',
    BUEY: 'BXEY',
    CACA: 'CXCA',
    CACO: 'CXCO',
    CAGA: 'CXGA',
    CAGO: 'CXGO',
    CAKA: 'CXKA',
    CAKO: 'CXKO',
    COGE: 'CXGE',
    COGI: 'CXGI',
    COJA: 'CXJA',
    COJE: 'CXJE',
    COJI: 'CXJI',
    COJO: 'CXJO',
    COLA: 'CXLA',
    CULO: 'CXLO',
    FALO: 'FXLO',
    FETO: 'FXTO',
    GETA: 'GXTA',
    GUEI: 'GXEI',
    GUEY: 'GXEY',
    JETA: 'JXTA',
    JOTO: 'JXTO',
    KACA: 'KXCA',
    KACO: 'KXCO',
    KAGA: 'KXGA',
    KAGO: 'KXGO',
    KAKA: 'KXKA',
    KAKO: 'KXKO',
    KOGE: 'KXGE',
    KOGI: 'KXGI',
    KOJA: 'KXJA',
    KOJE: 'KXJE',
    KOJI: 'KXJI',
    KOJO: 'KXJO',
    KOLA: 'KXLA',
    KULO: 'KXLO',
    LILO: 'LXLO',
    LOCA: 'LXCA',
    LOCO: 'LXCO',
    LOKA: 'LXKA',
    LOKO: 'LXKO',
    MAME: 'MXME',
    MAMO: 'MXMO',
    MEAR: 'MXAR',
    MEAS: 'MXAS',
    MEON: 'MXON',
    MIAR: 'MXAR',
    MION: 'MXON',
    MOCO: 'MXCO',
    MOKO: 'MXKO',
    MULA: 'MXLA',
    MULO: 'MXLO',
    NACA: 'NXCA',
    NACO: 'NXCO',
    PEDA: 'PXDA',
    PEDO: 'PXDO',
    PENE: 'PXNE',
    PIPI: 'PXPI',
    PITO: 'PXTO',
    POPO: 'PXPO',
    PUTA: 'PXTA',
    PUTO: 'PXTO',
    QULO: 'QXLO',
    RATA: 'RXTA',
    ROBA: 'RXBA',
    ROBE: 'RXBE',
    ROBO: 'RXBO',
    RUIN: 'RXIN',
    SENO: 'SXNO',
    TETA: 'TXTA',
    VACA: 'VXCA',
    VAGA: 'VXGA',
    VAGO: 'VXGO',
    VAKA: 'VXKA',
    VUEI: 'VXEI',
    VUEY: 'VXEY',
    WUEI: 'WXEI',
    WUEY: 'WXEY',
};

class Persona {
    constructor(nombre, apellidoPaterno, apellidoMaterno, genero, estado, fechaNacimiento) {
        this.nombre = nombre;
        this.apellidoPaterno = apellidoPaterno;
        this.apellidoMaterno = apellidoMaterno;
        this.genero = genero;
        this.estado = estado;
        this.fechaNacimiento = fechaNacimiento;
    }
}

function getPersona() {
    return new Persona();
}

function generar(persona) {
    validaDatos(persona);
    let curp = '';
    const pad = zeropad.bind(null, 2);

    const nombre = ajustaCompuesto(normalizaString(persona.nombre.toUpperCase())).trim();
    const apellidoPaterno = ajustaCompuesto(normalizaString(persona.apellidoPaterno.toUpperCase())).trim();
    let apellidoMaterno = persona.apellidoMaterno || '';
    apellidoMaterno = ajustaCompuesto(normalizaString(apellidoMaterno.toUpperCase())).trim();

    const nombreUsar = obtenerNombreUsar(nombre);
    const inicialNombre = nombreUsar.substring(0, 1);

    let vocalApellido = apellidoPaterno.substring(1).replace(/[BCDFGHJKLMNÑPQRSTVWXYZ]/g, '').substring(0, 1).trim();
    vocalApellido = vocalApellido === '' ? 'X' : vocalApellido;

    let primeraLetraPaterno = apellidoPaterno.substring(0, 1);
    primeraLetraPaterno = primeraLetraPaterno === 'Ñ' ? 'X' : primeraLetraPaterno;

    let primeraLetraMaterno = '';
    if (!apellidoMaterno || apellidoMaterno === '') {
        primeraLetraMaterno = 'X';
    } else {
        primeraLetraMaterno = apellidoMaterno.substring(0, 1);
        primeraLetraMaterno = primeraLetraMaterno === 'Ñ' ? 'X' : primeraLetraMaterno;
    }

    let posicionUnoCuatro = `${primeraLetraPaterno}${vocalApellido}${primeraLetraMaterno}${inicialNombre}`;
    posicionUnoCuatro = removerMalasPalabras(filtraCaracteres(posicionUnoCuatro));

    const posicionCatorceDieciseis = `${primerConsonante(apellidoPaterno)}${primerConsonante(apellidoMaterno)}${primerConsonante(nombreUsar)}`;

    const fechaNacimiento = persona.fechaNacimiento.split('-');

    curp = `${posicionUnoCuatro}${pad(fechaNacimiento[0] - 1900)}${pad(fechaNacimiento[1])}${pad(fechaNacimiento[2])}${persona.genero}${persona.estado}${filtraCaracteres(posicionCatorceDieciseis)}`;

    curp += getSpecialChar(fechaNacimiento[0]);
    curp += agregaDigitoVerificador(curp);

    return curp;
}

function ajustaCompuesto(str) {
    const compuestos = [
        /\bDA\b/,
        /\bDAS\b/,
        /\bDE\b/,
        /\bDEL\b/,
        /\bDER\b/,
        /\bDI\b/,
        /\bDIE\b/,
        /\bDD\b/,
        /\bEL\b/,
        /\bLA\b/,
        /\bLOS\b/,
        /\bLAS\b/,
        /\bLE\b/,
        /\bLES\b/,
        /\bMAC\b/,
        /\bMC\b/,
        /\bVAN\b/,
        /\bVON\b/,
        /\bY\b/,
    ];

    compuestos.forEach((compuesto) => {
        if (compuesto.test(str)) {
            str = str.replace(compuesto, '');
        }
    });

    return str;
}

function zeropad(ancho, num) {
    const pad = Array.apply(0, Array.call(0, ancho))
        .map(() => 0)
        .join('');

    return (pad + num).replace(new RegExp('^.*([0-9]{' + ancho + '})$'), '$1');
}

function primerConsonante(str) {
    str = str.substring(1).replace(/[AEIOU]/gi, '').substring(0, 1).trim();
    return str === '' || str === 'Ñ' ? 'X' : str;
}

function filtraCaracteres(str) {
    return str.toUpperCase().replace(/[\d_\-./\\,]/g, 'X');
}

function normalizaString(str) {
    const origen = [
        'Ã', 'À', 'Á', 'Ä', 'Â', 'È', 'É', 'Ë', 'Ê',
        'Ì', 'Í', 'Ï', 'Î', 'Ò', 'Ó', 'Ö', 'Ô',
        'Ù', 'Ú', 'Ü', 'Û', 'ã', 'à', 'á', 'ä',
        'â', 'è', 'é', 'ë', 'ê', 'ì', 'í', 'ï',
        'î', 'ò', 'ó', 'ö', 'ô', 'ù', 'ú', 'ü',
        'û', 'Ç', 'ç',
    ];
    const destino = [
        'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E',
        'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O',
        'U', 'U', 'U', 'U', 'a', 'a', 'a', 'a',
        'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i',
        'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u',
        'u', 'c', 'c',
    ];
    str = str.split('');
    const salida = str.map((char) => {
        const pos = origen.indexOf(char);
        return pos > -1 ? destino[pos] : char;
    });
    return salida.join('');
}

function agregaDigitoVerificador(incompleteCurp) {
    const dictionary = '0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
    let lnSum = 0.0;
    for (let i = 0; i < 17; i++) {
        lnSum += dictionary.indexOf(incompleteCurp.charAt(i)) * (18 - i);
    }
    const lnDigt = 10 - (lnSum % 10);
    return lnDigt === 10 ? 0 : lnDigt;
}

function getSpecialChar(bornYear) {
    return bornYear[0] === '1' ? '0' : 'A';
}

function obtenerNombreUsar(nombre) {
    const nombres = nombre.trim().split(/\s+/);
    if (nombres.length === 1) return nombres[0];

    const esNombreComun = comunes.some(
        (nombreComun) => nombre.indexOf(nombreComun) === 0
    );
    return esNombreComun ? nombres[1] : nombres[0];
}

function removerMalasPalabras(palabra) {
    return malasPalabras[palabra] || palabra;
}

function validaDatos(persona) {
    if (!persona.nombre) throw new Error('Nombre es requerido');
    if (!persona.apellidoPaterno) throw new Error('Apellido Paterno es requerido');
    if (!persona.fechaNacimiento) throw new Error('Fecha de nacimiento es requerido');
    if (!persona.genero) throw new Error('Genero es requerido');
    if (!persona.estado) throw new Error('Estado es requerido');
}

function validar(curpToValidate) {
    const regex =
        /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/;
    const validado = curpToValidate.match(regex);
    return (
        validado &&
        parseInt(validado[2], 10) === agregaDigitoVerificador(validado[1])
    );
}

curp.validar = validar;
curp.getPersona = getPersona;
curp.generar = generar;
curp.GENERO = GENERO;