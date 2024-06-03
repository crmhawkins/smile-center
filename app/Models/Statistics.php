<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hawkins\Contracts\Acl\AclGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statistics extends Model
{
    use SoftDeletes;

    protected $table = 'balance_trimester';
    /**
     * Atributos asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'trimester',
        'month',
        'year',
        'quantity',
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
