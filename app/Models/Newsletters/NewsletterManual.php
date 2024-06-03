<?php

namespace App\Models\Newsletters;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Acl\AclGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Clients\Client;
use App\Models\Services\ServicesCategories;

class NewsletterManual extends Model
{
    use SoftDeletes;

    protected $table = 'newsletters_manual';

    /**
     * Atributos asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'pacientes_array_id',
        'category',
        'date_sent',
        'first_title_newsletter',
        'banner_description',
        'second_title_newsletter',
        'images_promo',
        'urls',
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
