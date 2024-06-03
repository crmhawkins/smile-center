<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alertas extends Model
{
    use HasFactory;

    protected $table = "alertas";
    protected $fillable = [
        'user_id',
        'estado_id',
        'referencia_id',
        'tipo',
        'titulo',
        'descripcion',

    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];









}
