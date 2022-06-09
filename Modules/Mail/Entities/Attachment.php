<?php

namespace Modules\Mail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    const ATTACHMENT_PATH = 'attachments';

    /**
     * @var array
     */
    protected $fillable = ['session_id', 'filename', 'path', 'filename_origin'];

    /**
     * Get the session by attachment
     *
     * @return BelongsTo
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
