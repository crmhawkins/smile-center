<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aseguradora extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
    "nombre",
    "telefono",
    "email",
    "codigoPostal",
    "direccion",
    "poblacion",
    "provincia",
    "plataforma_id",
];
public function plataforma()
{
    return $this->belongsTo(Plataforma::class, 'aseguradora_id');
}
public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'aseguradora_id');
    }
protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
