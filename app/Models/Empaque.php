<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empaque extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'empaque';
    public $timestamps = true;
    protected $fillable = [
        'tipo',
        'numero',
        'cantidad_cajas',
        'peso',
        'unidad_medida',
        'descripcion',
        'estado',
        'observacion_estado',
        'lista_empaques_id',
        'fecha_registro',
        'encargado_id',
        'ubicacion_almacen_id',
        'criterio1',
        'criterio2',
        'criterio3',
        'empresa_id'
    ];
}
