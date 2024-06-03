<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ServicioPack;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "servicios";

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'iva',
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
