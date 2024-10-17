<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $table = 'bitacora';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'evento',
        'tipo_evento',
        'descripcion',
        'empresa_id'
    ];
}
