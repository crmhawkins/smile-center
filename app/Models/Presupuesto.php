<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuesto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "presupuestos";

    protected $fillable = [
        'paciente_id',
        'aseguradora_id',
        'estado_id',
        'observacion',
        'fechaEmision',
    ];


    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    public function servicios()
    {
        return $this->hasMany(ServicioPresupuesto::class, 'presupuesto_id');
    }
    public function citas()
    {
        return $this->hasMany(Cita::class, 'presupuesto_id');
    }
    public function estado()
    {
        return $this->hasOne(EstadoPresupuesto::class, 'id','estado_id');
    }
    public function paciente()
    {
        return $this->hasOne(Paciente::class,'id', 'paciente_id');
    }
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];




}
