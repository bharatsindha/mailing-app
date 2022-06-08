<?php

namespace Modules\Mail\Entities;

use Illuminate\Database\Eloquent\Model;
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
        'email_id', 'user_id', 'session_id', 'list_name', 'subject', 'mail_content', 'total_emails',
        'total_sent', 'total_opened', 'total_bounced', 'is_completed'
    ];

}
