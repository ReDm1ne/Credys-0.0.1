<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
        'conyuge_nombre',
        'conyuge_telefono',
        'conyuge_trabajo',
        'conyuge_direccion_trabajo',
        'conyuge_foto',
        'conyuge_identificacion',
        'referencia1_nombre',
        'referencia1_telefono',
        'referencia1_domicilio',
        'referencia2_nombre',
        'referencia2_telefono',
        'referencia2_domicilio',
        'sucursal_id',
        'user_id',
    ];

    protected $dates = [
        'fecha_nacimiento',
        'deleted_at',
    ];

    // Relación con la documentación del cliente
    public function documentacion()
    {
        return $this->hasOne(ClienteDocumentacion::class);
    }

    // Relación con la información laboral y financiera del cliente
    public function laboralFinanciera()
    {
        return $this->hasOne(ClienteLaboralFinanciera::class);
    }

    // Relación con la sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    // Relación con el usuario (quien registró al cliente)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Método para obtener el nombre completo del cliente
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno;
    }
}
