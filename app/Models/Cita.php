<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = "citas";

    protected $fillable = [
        "presupuesto_id",
        "paciente_id",
        "fecha",
        "hora",
        "asistencia",
        "observacion",
        "user_id"

    ];



    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class, 'presupuesto_id');
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

