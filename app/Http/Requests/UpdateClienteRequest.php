<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
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
            'telefono_oficina' => 'nullable|string|max:15',
            'telefono_particular' => 'nullable|string|max:15',
            'telefono_celular' => 'nullable|string|max:15',
            'fecha_nacimiento' => 'nullable|date',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'estado_civil' => 'nullable|string|max:255',
            'sexo' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:13',
            'curp' => 'required|string|max:18',
            'direccion' => 'nullable|string|max:255',
            'conyuge_nombre' => 'nullable|string|max:255',
            'conyuge_telefono' => 'nullable|string|max:15',
            'conyuge_trabajo' => 'nullable|string|max:255',
            'conyuge_direccion_trabajo' => 'nullable|string|max:255',
            'referencia1_nombre' => 'nullable|string|max:255',
            'referencia1_telefono' => 'nullable|string|max:15',
            'referencia1_domicilio' => 'nullable|string|max:255',
            'referencia2_nombre' => 'nullable|string|max:255',
            'referencia2_telefono' => 'nullable|string|max:15',
            'referencia2_domicilio' => 'nullable|string|max:255',
            'ingreso_mensual_promedio' => 'nullable|numeric',
            'otros_ingresos_mensuales' => 'nullable|numeric',
            'total_ingreso_mensual' => 'nullable|numeric',
            'gasto_alimento' => 'nullable|numeric',
            'gasto_luz' => 'nullable|numeric',
            'gasto_telefono' => 'nullable|numeric',
            'gasto_transporte' => 'nullable|numeric',
            'gasto_renta' => 'nullable|numeric',
            'gasto_inversion_negocio' => 'nullable|numeric',
            'gasto_otros_creditos' => 'nullable|numeric',
            'gasto_otros' => 'nullable|numeric',
            'total_gasto_mensual' => 'nullable|numeric',
            'total_disponible_mensual' => 'nullable|numeric',
            'tipo_vivienda' => 'nullable|string|max:255',
            'refrigerador' => 'nullable|boolean',
            'estufa' => 'nullable|boolean',
            'lavadora' => 'nullable|boolean',
            'television' => 'nullable|boolean',
            'licuadora' => 'nullable|boolean',
            'horno' => 'nullable|boolean',
            'computadora' => 'nullable|boolean',
            'sala' => 'nullable|boolean',
            'celular' => 'nullable|boolean',
            'vehiculo' => 'nullable|boolean',
            'vehiculo_marca' => 'nullable|string|max:255',
            'vehiculo_modelo' => 'nullable|string|max:255',
            'identificacion' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}