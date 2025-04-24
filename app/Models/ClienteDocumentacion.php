<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteDocumentacion extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'cliente_documentacion';

    // Desactivar timestamps ya que no los tenemos en esta tabla
    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'foto_cliente',
        'identificacion_frente_cliente',
        'identificacion_reverso_cliente',
        'comprobante_domicilio_cliente',
        'acta_de_nacimiento_cliente',
        'curp_cliente',
        'comprobante_ingresos_cliente',
        'fachada_casa_cliente',
        'fachada_negocio_cliente',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
