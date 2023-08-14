<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioPack extends Model
{
    use HasFactory;

    protected $table = "servicio_packs";

    protected $fillable = [
        'nombre',
    ];

    public function servicios() {
       return $this->hasMany("app\Models\Servicio", "id_pack", "id");
    }

    public function presupuestos()
    {
        return $this->belongsToMany(Presupuesto::class, 'servicio_presupuesto', 'pack_id', 'presupuesto_id')->withPivot('numero_monitores', 'precioFinal');
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
