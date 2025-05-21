<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaNegra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lista_negra';

    protected $fillable = [
        'cliente_id',
        'motivo',
        'nivel_riesgo',
        'fecha_registro',
        'fecha_vencimiento',
        'observaciones',
        'reportado_por_id',
        'user_id',
        'sucursal_id',
        'activo'
    ];

    protected $dates = [
        'fecha_registro',
        'fecha_vencimiento',
        'deleted_at',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con el usuario que registró
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el usuario que reportó
    public function reportadoPor()
    {
        return $this->belongsTo(User::class, 'reportado_por_id');
    }

    // Relación con la sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    // Método para verificar si el registro está vencido
    public function getEstaVencidoAttribute()
    {
        if (!$this->fecha_vencimiento) {
            return false;
        }

        return now()->greaterThan($this->fecha_vencimiento);
    }

    // Método para verificar si un cliente está en la lista negra
    public static function clienteEstaEnListaNegra($clienteId)
    {
        return self::where('cliente_id', $clienteId)
            ->where('activo', true)
            ->where(function($q) {
                $q->whereNull('fecha_vencimiento')
                    ->orWhere('fecha_vencimiento', '>=', now());
            })
            ->first();
    }

    // Método para verificar si una persona está en la lista negra por CURP, RFC, email o teléfono
    // Mantenemos este método para compatibilidad con el código existente
    public static function estaEnListaNegra($curp = null, $rfc = null, $email = null, $telefono = null)
    {
        if (empty($curp) && empty($rfc) && empty($email) && empty($telefono)) {
            return null;
        }

        // Buscar clientes que coincidan con los criterios
        $clientesQuery = Cliente::query();

        if (!empty($curp)) {
            $clientesQuery->where('curp', $curp);
        }

        if (!empty($rfc)) {
            if (!empty($curp)) {
                $clientesQuery->orWhere('rfc', $rfc);
            } else {
                $clientesQuery->where('rfc', $rfc);
            }
        }

        if (!empty($email)) {
            if (!empty($curp) || !empty($rfc)) {
                $clientesQuery->orWhere('email', $email);
            } else {
                $clientesQuery->where('email', $email);
            }
        }

        if (!empty($telefono)) {
            if (!empty($curp) || !empty($rfc) || !empty($email)) {
                $clientesQuery->orWhere('telefono_celular', $telefono);
            } else {
                $clientesQuery->where('telefono_celular', $telefono);
            }
        }

        // Obtener los IDs de los clientes que coinciden
        $clienteIds = $clientesQuery->pluck('id')->toArray();

        if (empty($clienteIds)) {
            return null;
        }

        // Buscar en la lista negra por cliente_id
        return self::whereIn('cliente_id', $clienteIds)
            ->where('activo', true)
            ->where(function($q) {
                $q->whereNull('fecha_vencimiento')
                    ->orWhere('fecha_vencimiento', '>=', now());
            })
            ->first();
    }
}
