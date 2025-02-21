<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ajusta esto según sea necesario.
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono_oficina' => 'required|string|regex:/^[0-9]{10}$/',
            'telefono_particular' => 'required|string|regex:/^[0-9]{10}$/',
            'telefono_celular' => 'required|string|regex:/^[0-9]{10}$/',
            'fecha_nacimiento' => 'required|date',
            'lugar_nacimiento' => 'required|string|max:255',
            'estado_civil' => 'required|string|max:255',
            'sexo' => 'required|string|max:6',
            'curp' => 'required|string|max:18',
            'direccion' => 'required|string|max:255',
            'conyuge_nombre' => 'nullable|string|max:255',
            'conyuge_telefono' => 'nullable|string|regex:/^[0-9]{10}$/',
            'conyuge_trabajo' => 'nullable|string|max:255',
            'conyuge_direccion_trabajo' => 'nullable|string|max:255',
            'referencia1_nombre' => 'required|string|max:255',
            'referencia1_telefono' => 'required|string|regex:/^[0-9]{10}$/',
            'referencia1_domicilio' => 'required|string|max:255',
            'referencia2_nombre' => 'required|string|max:255',
            'referencia2_telefono' => 'required|string|regex:/^[0-9]{10}$/',
            'referencia2_domicilio' => 'required|string|max:255',
            'ingreso_mensual_promedio' => 'required|numeric',
            'otros_ingresos_mensuales' => 'required|numeric',
            'gasto_alimento' => 'required|numeric',
            'gasto_luz' => 'required|numeric',
            'gasto_telefono' => 'required|numeric',
            'gasto_transporte' => 'required|numeric',
            'gasto_renta' => 'required|numeric',
            'gasto_inversion_negocio' => 'required|numeric',
            'gasto_otros_creditos' => 'required|numeric',
            'gasto_otros' => 'required|numeric',
            'tipo_vivienda' => 'required|string|max:255',
            'vehiculo' => 'required|boolean',
            'vehiculo_marca' => 'nullable|string|max:255',
            'vehiculo_modelo' => 'nullable|string|max:255',
            'identificacion' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            // Otros mensajes de validación...
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'email' => 'Correo Electrónico',
            'telefono_oficina' => 'Teléfono De Oficina',
            'telefono_particular' => 'Teléfono Particular',
            'telefono_celular' => 'Teléfono Celular',
            'fecha_nacimiento' => 'Fecha De Nacimiento',
            'lugar_nacimiento' => 'Lugar De Nacimiento',
            'estado_civil' => 'Estado Civil',
            'sexo' => 'Sexo',
            'curp' => 'CURP',
            'direccion' => 'Dirección',
            'referencia1_nombre' => 'Nombre De La Persona (1)',
            'referencia1_telefono' => 'Teléfono (1)',
            'referencia1_domicilio' => 'Domicilio (1)',
            'referencia2_nombre' => 'Nombre De La Persona (2)',
            'referencia2_telefono' => 'Teléfono (2)',
            'referencia2_domicilio' => 'Domicilio (2)',
            'ingreso_mensual_promedio' => 'Ingreso Mensual Promedio',
            'otros_ingresos_mensuales' => 'Otros Ingresos Mensuales',
            'gasto_alimento' => 'Gasto En Alimentos',
            'gasto_luz' => 'Gasto En Luz',
            'gasto_telefono' => 'Gasto En Teléfono',
            'gasto_transporte' => 'Gasto En Transporte',
            'gasto_renta' => 'Gasto En Renta',
            'gasto_inversion_negocio' => 'Gasto En Inversión Del Negocio',
            'gasto_otros_creditos' => 'Otros Créditos',
            'gasto_otros' => 'Otros Gastos',
            'tipo_vivienda' => 'Tipo De Vivienda',
            'vehiculo' => 'Vehículo',
            'vehiculo_marca' => 'Marca Del Vehículo',
            'vehiculo_modelo' => 'Modelo Del Vehículo',
        ];
    }
}