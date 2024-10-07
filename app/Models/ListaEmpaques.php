<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaEmpaques extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'lista_empaques';
    public $timestamps = true;
    protected $fillable = [
        'codigo',
        'factura',
        'canal_aduana',
        'proveedor_id',
        'stock_esperado',
        'stock_registrado',
        'stock_actual',
        'fecha_recepcion',
        'fecha_llegada',
        'transporte',
        'almacen_id',
        'encargado_id',
        'empresa_id'
    ];
}
