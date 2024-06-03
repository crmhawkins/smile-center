<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "empresas";

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'codigoPostal',
        'direccion',
        'poblacion',
        'provincia',
        'contacto',
        'cargo',
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'empresa_id');
    }
    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
