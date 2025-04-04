<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        // Campos principales del cliente
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'telefono_celular',
        'telefono_particular',
        'fecha_nacimiento',
        'lugar_nacimiento',
        'estado_civil',
        'sexo',
        'rfc',
        'curp',
        'direccion',

        // Campos del cónyuge
        'conyuge_nombre',
        'conyuge_telefono',
        'conyuge_trabajo',
        'conyuge_direccion_trabajo',
        'conyuge_foto',
        'conyuge_identificacion',

        // Campos de documentación digital del cliente
        'foto_cliente',
        'identificacion_frente_cliente',
        'identificacion_reverso_cliente',
        'comprobante_domicilio_cliente',
        'acta_de_nacimiento_cliente',
        'curp_cliente',
        'comprobante_ingresos_cliente',
        'fachada_casa_cliente',
        'fachada_negocio_cliente',

        // Campos de referencias
        'referencia1_nombre',
        'referencia1_telefono',
        'referencia1_domicilio',
        'referencia2_nombre',
        'referencia2_telefono',
        'referencia2_domicilio',

        // Campos Información laboral
        'tipo_de_trabajo',
        'nombre_de_la_empresa',
        'rfc_de_la_empresa',
        'telefono_empresa',
        'direccion_de_la_empresa',
        'referencia_de_la_empresa',

        // Campos Información financiera
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

        // Identificadores
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

    // Relación con tipo de trabajo
    public function tipoTrabajo()
    {
        return $this->belongsTo(TipoTrabajo::class, 'tipo_de_trabajo', 'nombre');
    }

    // Convertir automáticamente los campos booleanos
    protected $casts = [
        'refrigerador' => 'boolean',
        'estufa' => 'boolean',
        'lavadora' => 'boolean',
        'television' => 'boolean',
        'licuadora' => 'boolean',
        'horno' => 'boolean',
        'computadora' => 'boolean',
        'sala' => 'boolean',
        'celular' => 'boolean',
        'vehiculo' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];
}

