@extends('layouts.app') 
@section('title', 'Credys | Clientes  | Nuevo')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0r1QIkUR4Jn1JSRG9rMd0gjYSKDV7TLE&libraries=places"></script>
<style>
    .main-content {
        padding: 20px;
    }

    .top-bar {
        background-color: #fff;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        padding: 30px;
        margin-bottom: 30px;
    }

    .form-title {
        font-size: 28px;
        color: #3498db;
        margin-bottom: 30px;
        text-align: center;
        font-weight: 700;
    }

    .tabs {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #ddd;
    }

    .tab {
        padding: 15px 25px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
    }

    .tab.active {
        border-bottom: 3px solid #3498db;
        color: #3498db;
    }

    .tab-content {
        display: none; /* Ocultar por defecto */
    }

    .tab-content.active {
        display: block; /* Muestra solo el contenido activo */
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }

    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #3498db;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .checkbox-group label {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .checkbox-group input[type="checkbox"] {
        margin-right: 10px;
    }

    .button-group {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .alert i {
        margin-right: 10px;
    }

    .text-danger {
        color: #dc3545;
    }

    .text-success {
        color: green;
    }

    .text-danger, .text-success {
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .tabs {
            flex-direction: column;
        }
        .tab {
            width: 100%;
            text-align: center;
        }
        .form-container {
            padding: 20px;
        }
        .form-title {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 14px;
        }
        .button-group {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<main class="main-content">
    <header class="top-bar">
        <button id="mobileMenuToggle" class="mobile-toggle" aria-label="Toggle Mobile Menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <h2>Crear Cliente</h2>
        <div class="user-actions">
            <button class="notification-btn" aria-label="Notifications">
                <i class="fas fa-bell" aria-hidden="true"></i>
            </button>
            <button class="user-menu-btn" aria-label="User Menu">
                <img src="https://www.ecured.cu/images/a/a1/Ejemplo_de_Avatar.png" alt="User Avatar">
            </button>
        </div>
    </header>
    <div class="content-area">
        <div class="form-container">
            <h1 class="form-title">Formulario de Registro de Cliente</h1>
            
            {{-- Mostrar mensajes de error --}}
            @if ($errors->any())
            <div id="error-messages" class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <p>Algunos campos son requeridos o tienen errores. Por favor, verifica la información.</p>
            </div>
            @endif
            
            <div class="tabs">
                <div class="tab active" data-tab="general">Información General</div>
                <div class="tab" data-tab="referencias">Referencias</div>
                <div class="tab" data-tab="financiera">Información Financiera</div>
            </div>
            <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="general" class="tab-content active">
                    <div class="form-group">
                        <label for="nombre">Nombre(s)</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" data-required="true">
                        @if ($errors->has('nombre'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" value="{{ old('apellido_paterno') }}" data-required="true">
                        @if ($errors->has('apellido_paterno'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" value="{{ old('apellido_materno') }}" data-required="true">
                        @if ($errors->has('apellido_materno'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" data-required="true">
                        @if ($errors->has('email'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="telefono_oficina">Teléfono Oficina</label>
                        <input type="tel" id="telefono_oficina" name="telefono_oficina" class="form-control" value="{{ old('telefono_oficina') }}" data-required="true" pattern="[0-9]{10}">
                        @if ($errors->has('telefono_oficina'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="telefono_particular">Teléfono Particular</label>
                        <input type="tel" id="telefono_particular" name="telefono_particular" class="form-control" value="{{ old('telefono_particular') }}" data-required="true" pattern="[0-9]{10}">
                        @if ($errors->has('telefono_particular'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="telefono_celular">Teléfono Celular</label>
                        <input type="tel" id="telefono_celular" name="telefono_celular" class="form-control" value="{{ old('telefono_celular') }}" data-required="true" pattern="[0-9]{10}">
                        @if ($errors->has('telefono_celular'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Buscar Dirección" value="{{ old('direccion') }}" data-required="true">
                        @if ($errors->has('direccion'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                        <div id="map" style="height: 300px; margin-top: 20px;"></div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" data-required="true">
                        @if ($errors->has('fecha_nacimiento'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="lugar_nacimiento">Lugar de Nacimiento</label>
                        <select id="lugar_nacimiento" name="lugar_nacimiento" class="form-control" data-required="true">
                            <option value="">Seleccione un estado</option>
                            @foreach([
                                'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 
                                'Coahuila', 'Colima', 'Chiapas', 'Chihuahua', 'Distrito Federal', 
                                'CDMX', 'Durango', 'Guanajuato', 'Guerrero', 'Hidalgo', 
                                'Jalisco', 'Estado de México', 'No especificado', 'Michoacán', 
                                'Morelos', 'Nayarit', 'Nuevo León', 'Oaxaca', 'Puebla', 
                                'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa', 
                                'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz', 
                                'Yucatán', 'Zacatecas'
                            ] as $estado)
                                <option value="{{ $estado }}" {{ old('lugar_nacimiento') === $estado ? 'selected' : '' }}>{{ $estado }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('lugar_nacimiento'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="estado_civil">Estado Civil</label>
                        <select id="estado_civil" name="estado_civil" class="form-control" data-required="true">
                            <option value="">Seleccione estado civil</option>
                            <option value="Soltero" {{ old('estado_civil') === 'Soltero' ? 'selected' : '' }}>Soltero/a</option>
                            <option value="Casado" {{ old('estado_civil') === 'Casado' ? 'selected' : '' }}>Casado/a</option>
                            <option value="Divorciado" {{ old('estado_civil') === 'Divorciado' ? 'selected' : '' }}>Divorciado/a</option>
                            <option value="Viudo" {{ old('estado_civil') === 'Viudo' ? 'selected' : '' }}>Viudo/a</option>
                            <option value="Union Libre" {{ old('estado_civil') === 'Union Libre' ? 'selected' : '' }}>Unión Libre</option>
                        </select>
                        @if ($errors->has('estado_civil'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div id="conyuge_section" style="display: none;">
                        <h3>Datos del Cónyuge</h3>
                        <div class="form-group">
                            <label for="conyuge_nombre">Nombre del Cónyuge</label>
                            <input type="text" id="conyuge_nombre" name="conyuge_nombre" class="form-control" value="{{ old('conyuge_nombre') }}">
                            @if ($errors->has('conyuge_nombre'))
                            <span class="text-danger">Este campo es requerido.*</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="conyuge_telefono">Teléfono del Cónyuge</label>
                            <input type="tel" id="conyuge_telefono" name="conyuge_telefono" class="form-control" pattern="[0-9]{10}" value="{{ old('conyuge_telefono') }}">
                            @if ($errors->has('conyuge_telefono'))
                            <span class="text-danger">Este campo es requerido.*</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="conyuge_trabajo">Nombre del Trabajo del Cónyuge</label>
                            <input type="text" id="conyuge_trabajo" name="conyuge_trabajo" class="form-control" value="{{ old('conyuge_trabajo') }}">
                            @if ($errors->has('conyuge_trabajo'))
                            <span class="text-danger">Este campo es requerido.*</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="conyuge_direccion_trabajo">Dirección del Trabajo del Cónyuge</label>
                            <input type="text" id="conyuge_direccion_trabajo" name="conyuge_direccion_trabajo" class="form-control" value="{{ old('conyuge_direccion_trabajo') }}">
                            @if ($errors->has('conyuge_direccion_trabajo'))
                            <span class="text-danger">Este campo es requerido.*</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sexo</label>
                        <div>
                            <label><input type="radio" name="sexo" value="Mujer" data-required="true" {{ old('sexo') == 'Mujer' ? 'checked' : '' }}> Mujer</label>
                            <label><input type="radio" name="sexo" value="Hombre" data-required="true" {{ old('sexo') == 'Hombre' ? 'checked' : '' }}> Hombre</label>
                        </div>
                        @if ($errors->has('sexo'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="rfc">RFC</label>
                        <input type="text" id="rfc" name="rfc" class="form-control" value="{{ old('rfc') }}">
                        @if ($errors->has('rfc'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="curp">CURP</label>
                        <input type="text" id="curp" name="curp" class="form-control" value="{{ old('curp') }}" data-required="true" maxlength="18">
                        @if ($errors->has('curp'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                        <div class="button-group">
                            <button type="button" class="btn btn-primary" onclick="generarCURP()">Generar CURP</button>
                            <button type="button" class="btn btn-secondary" onclick="validarCURP()">Validar CURP</button>
                            <span id="validationMessage" class="text-danger" style="display: none;">CURP no válido</span>
                            <span id="validationSuccessMessage" class="text-success" style="display: none;">CURP válido</span>
                        </div>
                    </div>
                </div>
                <div id="referencias" class="tab-content">
                    <div class="form-group">
                        <label for="referencia1_nombre">Nombre de la Persona (1)</label>
                        <input type="text" id="referencia1_nombre" name="referencia1_nombre" class="form-control" value="{{ old('referencia1_nombre') }}" data-required="true">
                        @if ($errors->has('referencia1_nombre'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="referencia1_telefono">Teléfono (1)</label>
                        <input type="tel" id="referencia1_telefono" name="referencia1_telefono" class="form-control" value="{{ old('referencia1_telefono') }}" data-required="true" pattern="[0-9]{10}">
                        @if ($errors->has('referencia1_telefono'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="referencia1_domicilio">Domicilio (1)</label>
                        <input type="text" id="referencia1_domicilio" name="referencia1_domicilio" class="form-control" value="{{ old('referencia1_domicilio') }}" data-required="true">
                        @if ($errors->has('referencia1_domicilio'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="referencia2_nombre">Nombre de la Persona (2)</label>
                        <input type="text" id="referencia2_nombre" name="referencia2_nombre" class="form-control" value="{{ old('referencia2_nombre') }}" data-required="true">
                        @if ($errors->has('referencia2_nombre'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="referencia2_telefono">Teléfono (2)</label>
                        <input type="tel" id="referencia2_telefono" name="referencia2_telefono" class="form-control" value="{{ old('referencia2_telefono') }}" data-required="true" pattern="[0-9]{10}">
                        @if ($errors->has('referencia2_telefono'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="referencia2_domicilio">Domicilio (2)</label>
                        <input type="text" id="referencia2_domicilio" name="referencia2_domicilio" class="form-control" value="{{ old('referencia2_domicilio') }}" data-required="true">
                        @if ($errors->has('referencia2_domicilio'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                </div>
                <div id="financiera" class="tab-content">
                    <h3>Ingreso Mensual</h3>
                    <div class="form-group">
                        <label for="ingreso_mensual_promedio">Ingreso mensual promedio</label>
                        <input type="number" id="ingreso_mensual_promedio" name="ingreso_mensual_promedio" class="form-control" step="0.01" value="{{ old('ingreso_mensual_promedio') }}" data-required="true">
                        @if ($errors->has('ingreso_mensual_promedio'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="otros_ingresos_mensuales">Otros Ingresos mensuales</label>
                        <input type="number" id="otros_ingresos_mensuales" name="otros_ingresos_mensuales" class="form-control" step="0.01" value="{{ old('otros_ingresos_mensuales') }}" data-required="true">
                        @if ($errors->has('otros_ingresos_mensuales'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="ingreso_promedio_mensual_total">Ingreso promedio mensual total</label>
                        <input type="number" id="ingreso_promedio_mensual_total" name="ingreso_promedio_mensual_total" class="form-control" readonly>
                    </div>
                    <h3>Gasto promedio mensual</h3>
                    <div class="form-group">
                        <label for="gasto_alimento">Alimento</label>
                        <input type="number" id="gasto_alimento" name="gasto_alimento" class="form-control" step="0.01" value="{{ old('gasto_alimento') }}" data-required="true">
                        @if ($errors->has('gasto_alimento'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="gasto_luz">Luz</label>
                        <input type="number" id="gasto_luz" name="gasto_luz" class="form-control" step="0.01" value="{{ old('gasto_luz') }}" data-required="true">
                        @if ($errors->has('gasto_luz'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="gasto_telefono">Teléfono</label>
                        <input type="number" id="gasto_telefono" name="gasto_telefono" class="form-control" step="0.01" value="{{ old('gasto_telefono') }}" data-required="true">
                        @if ($errors->has('gasto_telefono'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="gasto_transporte">Transporte</label>
                        <input type="number" id="gasto_transporte" name="gasto_transporte" class="form-control" step="0.01" value="{{ old('gasto_transporte') }}" data-required="true">
                        @if ($errors->has('gasto_transporte'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="gasto_renta">Renta</label>
                        <input type="number" id="gasto_renta" name="gasto_renta" class="form-control" step="0.01" value="{{ old('gasto_renta') }}" data-required="true">
                        @if ($errors->has('gasto_renta'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="gasto_inversion_negocio">Inversión negocio</label>
                        <input type="number" id="gasto_inversion_negocio" name="gasto_inversion_negocio" class="form-control" step="0.01" value="{{ old('gasto_inversion_negocio') }}" data-required="true">
                        @if ($errors->has('gasto_inversion_negocio'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="gasto_otros_creditos">Otros Créditos</label>
                        <input type="number" id="gasto_otros_creditos" name="gasto_otros_creditos" class="form-control" step="0.01" value="{{ old('gasto_otros_creditos') }}" data-required="true">
                        @if ($errors->has('gasto_otros_creditos'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="gasto_otros">Otros</label>
                        <input type="number" id="gasto_otros" name="gasto_otros" class="form-control" step="0.01" value="{{ old('gasto_otros') }}" data-required="true">
                        @if ($errors->has('gasto_otros'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="total_gasto_mensual">Total gasto mensual</label>
                        <input type="number" id="total_gasto_mensual" name="total_gasto_mensual" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="total_disponible_mensual">Total Disponible mensual</label>
                        <input type="number" id="total_disponible_mensual" name="total_disponible_mensual" class="form-control" readonly>
                    </div>
                    <h3>Estudio Socioeconómico</h3>
                    <div class="form-group">
                        <label for="tipo_vivienda">Tipo de Vivienda</label>
                        <select id="tipo_vivienda" name="tipo_vivienda" class="form-control" data-required="true">
                            <option value="">Seleccione tipo de vivienda</option>
                            <option value="Familiar" {{ old('tipo_vivienda') === 'Familiar' ? 'selected' : '' }}>Familiar</option>
                            <option value="Propia" {{ old('tipo_vivienda') === 'Propia' ? 'selected' : '' }}>Propia</option>
                            <option value="Rentada" {{ old('tipo_vivienda') === 'Rentada' ? 'selected' : '' }}>Rentada</option>
                        </select>
                        @if ($errors->has('tipo_vivienda'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="refrigerador" value="1" {{ old('refrigerador') ? 'checked' : '' }}> Refrigerador</label>
                        <label><input type="checkbox" name="estufa" value="1" {{ old('estufa') ? 'checked' : '' }}> Estufa</label>
                        <label><input type="checkbox" name="lavadora" value="1" {{ old('lavadora') ? 'checked' : '' }}> Lavadora</label>
                        <label><input type="checkbox" name="television" value="1" {{ old('television') ? 'checked' : '' }}> Televisión</label>
                        <label><input type="checkbox" name="licuadora" value="1" {{ old('licuadora') ? 'checked' : '' }}> Licuadora</label>
                        <label><input type="checkbox" name="horno" value="1" {{ old('horno') ? 'checked' : '' }}> Horno</label>
                        <label><input type="checkbox" name="computadora" value="1" {{ old('computadora') ? 'checked' : '' }}> Computadora</label>
                        <label><input type="checkbox" name="sala" value="1" {{ old('sala') ? 'checked' : '' }}> Sala</label>
                        <label><input type="checkbox" name="celular" value="1" {{ old('celular') ? 'checked' : '' }}> Celular</label>
                    </div>
                    <div class="form-group">
                        <label for="vehiculo">Vehículo</label>
                        <select id="vehiculo" name="vehiculo" class="form-control" data-required="true">
                            <option value="0" {{ old('vehiculo') == "0" ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('vehiculo') == "1" ? 'selected' : '' }}>Sí</option>
                        </select>
                        @if ($errors->has('vehiculo'))
                        <span class="text-danger">Este campo es requerido.*</span>
                        @endif
                    </div>
                    <div id="vehiculo_details" style="{{ old('vehiculo') == '1' ? 'display:block;' : 'display:none;' }}">
                        <div class="form-group">
                            <label for="vehiculo_marca">Marca del Vehículo</label>
                            <input type="text" id="vehiculo_marca" name="vehiculo_marca" class="form-control" value="{{ old('vehiculo_marca') }}">
                            @if ($errors->has('vehiculo_marca'))
                            <span class="text-danger">Este campo es requerido.*</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="vehiculo_modelo">Modelo del Vehículo</label>
                            <input type="text" id="vehiculo_modelo" name="vehiculo_modelo" class="form-control" value="{{ old('vehiculo_modelo') }}">
                            @if ($errors->has('vehiculo_modelo'))
                            <span class="text-danger">Este campo es requerido.*</span>
                            @endif
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="crearClienteBtn">
                        Crear Cliente
                        <span id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                </button>
            </form>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-tab');

            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            contents.forEach(content => {
                if (content.id === target) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
        });
    });

    const initMap = () => {
        const mapElement = document.getElementById('map');
        const inputElement = document.getElementById('direccion');
        const initialLatLng = { lat: -34.397, lng: 150.644 };

        let map = new google.maps.Map(mapElement, {
            center: initialLatLng,
            zoom: 8
        });

        let marker = new google.maps.Marker({
            position: initialLatLng,
            map: map,
            draggable: true
        });

        const autocomplete = new google.maps.places.Autocomplete(inputElement);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            marker.setPosition(place.geometry.location);
        });

        marker.addListener('dragend', () => {
            const position = marker.getPosition();
            inputElement.value = `${position.lat()}, ${position.lng()}`;
        });
    };

    const validateForm = (form) => {
        const requiredFields = form.querySelectorAll('[data-required="true"]');
        const errorMessages = [];
        requiredFields.forEach(field => {
            const fieldType = field.type;
            if (
                ((fieldType === 'radio' && !document.querySelector(`input[name="${field.name}"]:checked`)) ||
                fieldType !== 'radio') && 
                !field.value.trim()
            ) {
                errorMessages.push(`- ${field.previousElementSibling.innerText}`);
            }
        });

        return errorMessages;
    };

    const displayErrors = (errors) => {
        const errorMessagesDiv = document.getElementById('error-messages');
        if (errors.length > 0) {
            const errorMessage = `Hace falta algunos datos:\n${errors.join('\n')}`;
            errorMessagesDiv.innerText = errorMessage;
            errorMessagesDiv.style.display = 'block';
        } else {
            errorMessagesDiv.innerText = '';
            errorMessagesDiv.style.display = 'none';
        }
    };

    const formElement = document.querySelector('form');
    formElement.addEventListener('submit', (event) => {
        const errors = validateForm(formElement);
        if (errors.length > 0) {
            event.preventDefault();
            displayErrors(errors);
            return false;
        }

        document.getElementById('crearClienteBtn').disabled = true;
        document.getElementById('loading').style.display = 'inline-block';
    });

    const estadoCivilSelect = document.getElementById('estado_civil');
    const conyugeSection = document.getElementById('conyuge_section');
    const conyugeFields = document.querySelectorAll('#conyuge_section input');

    const toggleConyugeSection = () => {
        const value = estadoCivilSelect.value;
        if (value === 'Casado' || value === 'Union Libre') {
            conyugeSection.style.display = 'block';
            conyugeFields.forEach(field => field.setAttribute('data-required', 'true'));
        } else {
            conyugeSection.style.display = 'none';
            conyugeFields.forEach(field => field.removeAttribute('data-required'));
        }
    };

    estadoCivilSelect.addEventListener('change', toggleConyugeSection);
    toggleConyugeSection(); // Llamar inicialmente en caso de que haya un valor seleccionado

    // Controlar la visibilidad de los detalles del vehículo
    const vehiculoSelect = document.getElementById('vehiculo');
    const vehiculoDetails = document.getElementById('vehiculo_details');

    vehiculoSelect.addEventListener('change', () => {
        if (vehiculoSelect.value === "1") {
            vehiculoDetails.style.display = 'block';
        } else {
            vehiculoDetails.style.display = 'none';
        }
    });

    toggleConyugeSection(); // Inicializa la sección del cónyuge

    initMap();

    const form = document.querySelector('form');
    let isSubmitting = false;

    form.addEventListener('submit', function () {
        isSubmitting = true;
        window.removeEventListener('beforeunload', beforeUnloadHandler);
    });

    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            isSubmitting = true;
            window.removeEventListener('beforeunload', beforeUnloadHandler);
        });
    });

    function beforeUnloadHandler(event) {
        if (isSubmitting) return;
        event.preventDefault();
        event.returnValue = '¿Estás seguro de que quieres salir? Los datos no guardados se perderán.';
    }

    window.addEventListener('beforeunload', beforeUnloadHandler);
});
</script>
<script src="{{ asset('js/crear-cliente.js') }}"></script>
@endsection