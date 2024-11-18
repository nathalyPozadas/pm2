<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'movimiento';
    public $timestamps = true;
    protected $fillable = [
        'empaque_id',
        'fecha',
        'hora',
        'tipo_movimiento',
        'ubicacion_origen_id',
        'ubicacion_destino_id',
        'nota',
        'cliente',
        'destino',
        'usuario_id',
        'empresa_id'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'encargado_id');
    }
    
    
    public function ubicacionOrigen()
    {
        return $this->belongsTo(UbicacionAlmacen::class, 'ubicacion_origen_id');
    }

    public function ubicacionDestino()
    {
        return $this->belongsTo(UbicacionAlmacen::class, 'ubicacion_destino_id');
    }

}
