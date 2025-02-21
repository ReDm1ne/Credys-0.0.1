<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'telefono_oficina',
        'telefono_particular',
        'telefono_celular',
        'fecha_nacimiento',
        'lugar_nacimiento',
        'estado_civil',
        'sexo',
        'rfc',
        'curp',
        'direccion',
        'conyuge_nombre',
        'conyuge_telefono',
        'conyuge_trabajo',
        'conyuge_direccion_trabajo',
        'referencia1_nombre',
        'referencia1_telefono',
        'referencia1_domicilio',
        'referencia2_nombre',
        'referencia2_telefono',
        'referencia2_domicilio',
        'ingreso_mensual_promedio',
        'otros_ingresos_mensuales',
        'total_ingreso_mensual',
        'gasto_alimento',
        'gasto_luz',
        'gasto_telefono',
        'gasto_transporte',
        'gasto_renta',
        'gasto_inversion_negocio',
        'gasto_otros_creditos',
        'gasto_otros',
        'total_gasto_mensual',
        'total_disponible_mensual',
        'tipo_vivienda',
        'refrigerador',
        'estufa',
        'lavadora',
        'television',
        'licuadora',
        'horno',
        'computadora',
        'sala',
        'celular',
        'vehiculo',
        'vehiculo_marca',
        'vehiculo_modelo',
        'sucursal_id',
        'user_id',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}