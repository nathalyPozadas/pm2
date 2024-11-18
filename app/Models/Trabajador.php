<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajador extends Model
{
    use HasFactory;

    use SoftDeletes;

    // Especifica las columnas que manejan fechas, incluyendo 'deleted_at'
    protected $dates = ['deleted_at'];  
    protected $table = 'trabajador';
    public $timestamps = true;
    // Campos que se pueden asignar en masa (mass assignment)
    protected $fillable = [
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'cargo',
        'telefono',
        'direccion',
        'ci',
        'sexo',
        'empresa_id'
    ];

    
}
