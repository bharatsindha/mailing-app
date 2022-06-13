<?php

namespace Modules\Mail\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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
    public static function getAllDraftSessions()
    {
        return self::getModelObj()->whereIn('sessions.is_completed', [self::YET_TO_START, self::IN_PROCESS]);
    }

    /**
     * Get model reference
     *
     * @return mixed
     */
    public static function getModelObj()
    {
        return self::select(['sessions.*', 'domains.name', 'emails.sender_email', 'emails.sender_name'])
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
     * Get the sent sessions
     *
     * @return mixed
     */
    public static function getSentSessions()
    {
        return self::getModelObj()
            ->when(request()->filled('domain'), function ($domain) {
                if (request()->input('domain') > 0 && request()->input('domain') != 'all') {
                    $domain->where('domains.id', request()->input('domain'));
                }
            })
            ->when(request()->filled('from') && request()->filled('to'), function ($domain) {
                if (!is_null(request()->input('from')) && !is_null(request()->input('to'))) {
                    $domain->whereBetween(DB::raw('date(sessions.created_at)'), [
                        Carbon::parse(request()->input('from'))->toDateString(),
                        Carbon::parse(request()->input('to'))->toDateString()
                    ]);
                }
            })
            ->whereIn('sessions.is_completed', [self::COMPLETED]);
    }

    /**
     * Get pending session data
     *
     * @param $sessionId
     * @return array
     */
    public static function getPendingSessionData($sessionId)
    {
        return self::with('composesPending')->find($sessionId)->toArray();
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

    /**
     * Has many relation with composes
     *
     * @return HasMany
     */
    public function composesSent()
    {
        return $this->hasMany(Compose::class)
            ->whereIn('status', [Compose::SENT, Compose::OPENED, Compose::BOUNCED]);
    }

    /**
     * Has many relation with composes
     *
     * @return HasMany
     */
    public function composesOpened()
    {
        return $this->hasMany(Compose::class)->where('status', Compose::OPENED);
    }

    /**
     * Has many relation with composes
     *
     * @return HasMany
     */
    public function composesBounced()
    {
        return $this->hasMany(Compose::class)->where('status', Compose::BOUNCED);
    }

    /**
     * @return HasOne
     */
    public function composesPending()
    {
        return $this->hasOne(Compose::class)->where('status', Compose::NOT_SENT);
    }

    /**
     * @return BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    /**
     * @return BelongsTo
     */
    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
