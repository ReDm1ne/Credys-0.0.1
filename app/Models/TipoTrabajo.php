<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
    use HasFactory;

    protected $table = 'tipos_trabajo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo'
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'tipo_de_trabajo', 'nombre');
    }
}

