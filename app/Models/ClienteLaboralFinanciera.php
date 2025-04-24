<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteLaboralFinanciera extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'clientes_laboral_financiera';

    // Desactivar timestamps ya que no los tenemos en esta tabla
    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'tipo_de_trabajo',
        'nombre_de_la_empresa',
        'rfc_de_la_empresa',
        'telefono_empresa',
        'direccion_de_la_empresa',
        'referencia_de_la_empresa',
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
    ];

    // Convertir campos booleanos
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
        'ingreso_mensual_promedio' => 'decimal:2',
        'otros_ingresos_mensuales' => 'decimal:2',
        'total_ingreso_mensual' => 'decimal:2',
        'gasto_alimento' => 'decimal:2',
        'gasto_luz' => 'decimal:2',
        'gasto_telefono' => 'decimal:2',
        'gasto_transporte' => 'decimal:2',
        'gasto_renta' => 'decimal:2',
        'gasto_inversion_negocio' => 'decimal:2',
        'gasto_otros_creditos' => 'decimal:2',
        'gasto_otros' => 'decimal:2',
        'total_gasto_mensual' => 'decimal:2',
        'total_disponible_mensual' => 'decimal:2',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
