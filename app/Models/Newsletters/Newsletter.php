<?php

namespace App\Models\Newsletters;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Acl\AclGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Clients\Client;
use App\Models\Newsletters\NewsletterManual;
use App\Models\Paciente;

class Newsletter extends Model
{
    use SoftDeletes;

    protected $table = 'newsletters';

    /**
     * Atributos asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'newsletter_id',
        'campaign',
        'email',
        'sent',
        'open',
        'times_opened',
        'date_sent',
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
     * Obtener el cliente al que está vinculado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Paciente::class,'client_id');
    }

     /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function newsletter()
    {
        return $this->belongsTo(NewsletterManual::class,'newsletter_id');
    }

}
