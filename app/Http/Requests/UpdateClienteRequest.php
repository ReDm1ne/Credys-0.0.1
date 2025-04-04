<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Campos principales del cliente
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono_celular' => 'required|string|regex:/^[0-9]{10}$/',
            'telefono_particular' => 'required|string|regex:/^[0-9]{10}$/',
            'fecha_nacimiento' => 'required|date',
            'lugar_nacimiento' => 'required|string|max:255',
            'estado_civil' => 'required|string|max:255',
            'sexo' => 'required|string|in:Hombre,Mujer',
            'rfc' => 'nullable|string|max:13',
            'curp' => [
                'required',
                'string',
                'size:18',
                'regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A][0-9]$/',
                Rule::unique('clientes')->where(function ($query) {
                    return $query->where('sucursal_id', auth()->user()->sucursal_id);
                })->ignore($this->route('cliente'))
            ],
            'direccion' => 'required|string|max:255',

            // Campos del cónyuge
            'conyuge_nombre' => 'nullable|string|max:255',
            'conyuge_telefono' => 'nullable|string|regex:/^[0-9]{10}$/',
            'conyuge_trabajo' => 'nullable|string|max:255',
            'conyuge_direccion_trabajo' => 'nullable|string|max:255',
            'conyuge_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'conyuge_identificacion' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Campos de documentación digital del cliente
            'foto_cliente' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'identificacion_frente_cliente' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'identificacion_reverso_cliente' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'comprobante_domicilio_cliente' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'acta_de_nacimiento_cliente' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'curp_cliente' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'comprobante_ingresos_cliente' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'fachada_casa_cliente' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fachada_negocio_cliente' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Campos de referencias
            'referencia1_nombre' => 'required|string|max:255',
            'referencia1_telefono' => 'required|string|regex:/^[0-9]{10}$/',
            'referencia1_domicilio' => 'required|string|max:255',
            'referencia2_nombre' => 'required|string|max:255',
            'referencia2_telefono' => 'required|string|regex:/^[0-9]{10}$/',
            'referencia2_domicilio' => 'required|string|max:255',

            // Campos Información laboral
            'tipo_de_trabajo' => 'required|string|max:255',
            'nombre_de_la_empresa' => 'required|string|max:255',
            'rfc_de_la_empresa' => 'nullable|string|max:13',
            'telefono_empresa' => 'nullable|string|regex:/^[0-9]{10}$/',
            'direccion_de_la_empresa' => 'required|string|max:255',
            'referencia_de_la_empresa' => 'nullable|string',

            // Campos Información financiera
            'ingreso_mensual_promedio' => 'required|numeric|min:0',
            'otros_ingresos_mensuales' => 'required|numeric|min:0',
            'total_ingreso_mensual' => 'nullable|numeric|min:0',
            'gasto_alimento' => 'required|numeric|min:0',
            'gasto_luz' => 'required|numeric|min:0',
            'gasto_telefono' => 'required|numeric|min:0',
            'gasto_transporte' => 'required|numeric|min:0',
            'gasto_renta' => 'required|numeric|min:0',
            'gasto_inversion_negocio' => 'required|numeric|min:0',
            'gasto_otros_creditos' => 'required|numeric|min:0',
            'gasto_otros' => 'required|numeric|min:0',
            'total_gasto_mensual' => 'nullable|numeric|min:0',
            'total_disponible_mensual' => 'nullable|numeric',
            'tipo_vivienda' => 'required|string|in:Familiar,Propia,Rentada',
            'refrigerador' => 'boolean',
            'estufa' => 'boolean',
            'lavadora' => 'boolean',
            'television' => 'boolean',
            'licuadora' => 'boolean',
            'horno' => 'boolean',
            'computadora' => 'boolean',
            'sala' => 'boolean',
            'celular' => 'boolean',
            'vehiculo' => 'required|boolean',
            'vehiculo_marca' => 'nullable|string|max:255',
            'vehiculo_modelo' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser una dirección de correo válida.',
            'regex' => 'El formato del campo :attribute no es válido.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'boolean' => 'El campo :attribute debe ser verdadero o falso.',
            'in' => 'El valor seleccionado para :attribute es inválido.',
            'mimes' => 'El archivo :attribute debe ser de tipo: :values.',
            'image' => 'El archivo :attribute debe ser una imagen.',
            'file' => 'El campo :attribute debe ser un archivo.',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres.',

            'curp.size' => 'La CURP debe tener exactamente 18 caracteres.',
            'curp.regex' => 'El formato de la CURP no es válido.',
            'curp.unique' => 'Ya existe un cliente con esta CURP en esta sucursal.',

            'telefono_celular.regex' => 'El teléfono celular debe tener 10 dígitos.',
            'telefono_particular.regex' => 'El teléfono particular debe tener 10 dígitos.',
            'referencia1_telefono.regex' => 'El teléfono de la referencia 1 debe tener 10 dígitos.',
            'referencia2_telefono.regex' => 'El teléfono de la referencia 2 debe tener 10 dígitos.',
            'conyuge_telefono.regex' => 'El teléfono del cónyuge debe tener 10 dígitos.',
            'telefono_empresa.regex' => 'El teléfono de la empresa debe tener 10 dígitos.',
        ];
    }

    public function attributes()
    {
        return [
            // Campos principales del cliente
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'email' => 'Correo Electrónico',
            'telefono_celular' => 'Teléfono Celular',
            'telefono_particular' => 'Teléfono Particular',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'lugar_nacimiento' => 'Lugar de Nacimiento',
            'estado_civil' => 'Estado Civil',
            'sexo' => 'Sexo',
            'rfc' => 'RFC',
            'curp' => 'CURP',
            'direccion' => 'Dirección',

            // Campos del cónyuge
            'conyuge_nombre' => 'Nombre del Cónyuge',
            'conyuge_telefono' => 'Teléfono del Cónyuge',
            'conyuge_trabajo' => 'Trabajo del Cónyuge',
            'conyuge_direccion_trabajo' => 'Dirección del Trabajo del Cónyuge',
            'conyuge_foto' => 'Foto del Cónyuge',
            'conyuge_identificacion' => 'Identificación del Cónyuge',

            // Campos de documentación digital del cliente
            'foto_cliente' => 'Fotografía del Cliente',
            'identificacion_frente_cliente' => 'Identificación Oficial (Frente)',
            'identificacion_reverso_cliente' => 'Identificación Oficial (Reverso)',
            'comprobante_domicilio_cliente' => 'Comprobante de Domicilio',
            'acta_de_nacimiento_cliente' => 'Acta de Nacimiento',
            'curp_cliente' => 'CURP (Documento)',
            'comprobante_ingresos_cliente' => 'Comprobante de Ingresos',
            'fachada_casa_cliente' => 'Fachada de Casa',
            'fachada_negocio_cliente' => 'Fachada de Negocio',

            // Campos de referencias
            'referencia1_nombre' => 'Nombre de la Referencia 1',
            'referencia1_telefono' => 'Teléfono de la Referencia 1',
            'referencia1_domicilio' => 'Domicilio de la Referencia 1',
            'referencia2_nombre' => 'Nombre de la Referencia 2',
            'referencia2_telefono' => 'Teléfono de la Referencia 2',
            'referencia2_domicilio' => 'Domicilio de la Referencia 2',

            // Campos Información laboral
            'tipo_de_trabajo' => 'Tipo de Trabajo',
            'nombre_de_la_empresa' => 'Nombre de la Empresa',
            'rfc_de_la_empresa' => 'RFC de la Empresa',
            'telefono_empresa' => 'Teléfono de la Empresa',
            'direccion_de_la_empresa' => 'Dirección de la Empresa',
            'referencia_de_la_empresa' => 'Referencia de la Empresa',

            // Campos Información financiera
            'ingreso_mensual_promedio' => 'Ingreso Mensual Promedio',
            'otros_ingresos_mensuales' => 'Otros Ingresos Mensuales',
            'total_ingreso_mensual' => 'Total Ingreso Mensual',
            'gasto_alimento' => 'Gasto en Alimento',
            'gasto_luz' => 'Gasto en Luz',
            'gasto_telefono' => 'Gasto en Teléfono',
            'gasto_transporte' => 'Gasto en Transporte',
            'gasto_renta' => 'Gasto en Renta',
            'gasto_inversion_negocio' => 'Gasto en Inversión de Negocio',
            'gasto_otros_creditos' => 'Gasto en Otros Créditos',
            'gasto_otros' => 'Otros Gastos',
            'total_gasto_mensual' => 'Total Gasto Mensual',
            'total_disponible_mensual' => 'Total Disponible Mensual',
            'tipo_vivienda' => 'Tipo de Vivienda',
            'refrigerador' => 'Refrigerador',
            'estufa' => 'Estufa',
            'lavadora' => 'Lavadora',
            'television' => 'Televisión',
            'licuadora' => 'Licuadora',
            'horno' => 'Horno',
            'computadora' => 'Computadora',
            'sala' => 'Sala',
            'celular' => 'Celular',
            'vehiculo' => 'Vehículo',
            'vehiculo_marca' => 'Marca del Vehículo',
            'vehiculo_modelo' => 'Modelo del Vehículo',
        ];
    }
}

