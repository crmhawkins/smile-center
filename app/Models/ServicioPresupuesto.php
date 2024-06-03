<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioPresupuesto extends Model
{
    use HasFactory;


    protected $table = "servicios_presupuestos";

    protected $fillable = [
        'presupuesto_id',
        'nombre',
        'descripcion',
        'precio',
        'iva',
    ];

    public function presupuestos() {
        return $this->belongsToMany("App\Models\Presupuesto", "presupuesto_id", "id");
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
