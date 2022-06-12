<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Domain\Entities\Domain;
use Modules\Mail\Entities\Session;

class Email extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'domain_id', 'sender_name', 'sender_email', 'bounce_track_date'
    ];

    /**
     * Return all users
     *
     * @return mixed
     */
    public static function getAllEmails()
    {
        return self::select(['emails.*', 'domains.name'])
            ->join('domains', 'emails.domain_id', 'domains.id')
            ->when(request()->filled('q'), function ($q) {
                $keyword = request()->input('q');
                $q->where(function ($query) use ($keyword) {
                    $query->where('domains.name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('sender_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('sender_email', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->orderBy('id', 'desc');
    }

    /**
     * Get the domain that owns the sender emails.
     *
     * @return BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    /**
     * Get the sessions
     *
     * @return HasMany
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the first session
     *
     * @return HasOne
     */
    public function firstSession()
    {
        return $this->hasOne(Session::class);
    }
}
