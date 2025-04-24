<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'direccion'
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
