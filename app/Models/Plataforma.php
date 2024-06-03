<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plataforma extends Model
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
];
public function aseguradora()
{
    return $this->hasMany(Aseguradora::class, 'Aseguradora_id');
}
protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}

