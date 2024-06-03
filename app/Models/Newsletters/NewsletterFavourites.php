<?php

namespace App\Models\Newsletters;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Acl\AclGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Clients\Client;
use App\Models\Newsletters\NewsletterManual;

class NewsletterFavourites extends Model
{
    use SoftDeletes;

    protected $table = 'newsletters_favourites';

    /**
     * Atributos asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'newsletter_id',
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Obtener el usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adminUser()
    {
        return $this->belongsTo(\Hawkins\Models\AdminUser::class,'user_id');
    }

    /**
     * Obtener el cliente al que está vinculado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function newsletter()
    {
        return $this->belongsTo(NewsletterManual::class,'newsletter_id');
    }


}
