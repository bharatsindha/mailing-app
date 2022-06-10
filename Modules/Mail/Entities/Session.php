<?php

namespace Modules\Mail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

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
