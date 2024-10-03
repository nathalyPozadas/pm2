<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    public $timestamps = true;
    protected $fillable = [
        'nombre_comercial',
        'nit',
        'razon_social',
        'direccion',
        'icono'
    ];
}
