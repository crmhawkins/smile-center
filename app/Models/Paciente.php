<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "pacientes";

    protected $fillable = [
        "nombre",
        "apellido",
        "email",
        "telefono",
        "codigoPostal",
        "direccion",
        "poblacion",
        "provincia",
        "estado_id",
        "referido_id",
        "empresa_id",
        "estado_id",
        "aseguradora_id",
        "origen",
        "newsletter",
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function aseguradora()
    {
        return $this->belongsTo(Aseguradora::class, 'aseguradora_id');
    }

    public function referido()
    {
        return $this->belongsTo(Paciente::class, 'referido_id');
    }

    public function referidos()
    {
        return $this->hasMany(Paciente::class, 'referido_id');
    }
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
