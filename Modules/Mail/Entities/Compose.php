<?php

namespace Modules\Mail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compose extends Model
{
    use SoftDeletes;

    const NOT_SENT = 0;
    const SENT = 1;
    const OPENED = 2;
    const BOUNCED = 3;

    /**
     * @var array
     */
    protected $fillable = [
        'session_id', 'receiver_email', 'first_name', 'last_name', 'designation', 'company', 'curl',
        'project', 'status'
    ];

}
