<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'domain_id', 'sender_name', 'sender_email'
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

}
