<?php

namespace Modules\Mail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'session_id', 'first_name', 'last_name', 'to', 'cc', 'bcc', 'designation',
        'project_name', 'company_name', 'status'
    ];

    /**
     * Get the session of compose
     *
     * @return BelongsTo
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
