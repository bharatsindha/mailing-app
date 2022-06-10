<?php

namespace Modules\Mail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Domain\Entities\Domain;
use Modules\Email\Entities\Email;

class Session extends Model
{
//    use SoftDeletes;

    const YET_TO_START = 0;
    const IN_PROCESS = 1;
    const COMPLETED = 2;

    /**
     * @var array
     */
    protected $fillable = [
        'domain_id', 'email_id', 'user_id', 'subject', 'mail_content', 'total_emails',
        'total_sent', 'total_opened', 'total_bounced', 'is_completed'
    ];

    /**
     * Delete the compose(s) and attachment(s) of the session
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($session) {
            $session->composes()->delete();
            $session->attachments()->delete();
        });
    }

    /**
     * Return all users
     *
     * @return mixed
     */
    public static function getAllSessions()
    {


        return self::select(['sessions.*', 'domains.name', 'emails.sender_email'])
            ->join((new Domain())->getTable(), 'sessions.domain_id', (new Domain())->getTable() . '.id')
            ->join((new Email())->getTable(), 'sessions.email_id', (new Email())->getTable() . '.id')
            ->when(request()->filled('q'), function ($q) {
                $keyword = request()->input('q');
                $q->where(function ($query) use ($keyword) {
                    $query->where('domains.name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('emails.sender_email', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('subject', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('total_emails', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->groupBy('sessions.id')
            ->orderBy('sessions.id', 'desc');
    }

    /**
     * Get the attachments for the session
     *
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Get the composes for the session
     *
     * @return HasMany
     */
    public function composes()
    {
        return $this->hasMany(Compose::class);
    }
}
