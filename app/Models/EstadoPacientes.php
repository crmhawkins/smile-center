<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoPacientes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "estados_pacientes";

    protected $fillable = [
        'estado',
    ];
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
