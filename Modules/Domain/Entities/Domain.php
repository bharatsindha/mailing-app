<?php

namespace Modules\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Email\Entities\Email;

class Domain extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'client_id', 'client_secret'
    ];

    /**
     * Return all users
     *
     * @return mixed
     */
    public static function getAllDomains()
    {
        return self::select('*')
            ->when(request()->filled('q'), function ($q) {
                $keyword = request()->input('q');
                $q->where(function ($query) use ($keyword) {
                    $query->where('url', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('client_id', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('client_secret', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->orderBy('id', 'desc');
    }

    /**
     * Get domain options
     *
     * @return mixed
     */
    public static function getDomainOptions()
    {
        return self::select(['id', 'name', 'url'])->orderBy('name', 'asc')->get()->toArray();
    }

    /**
     * Get the sender emails by domain
     *
     * @param $domainId
     * @return mixed
     */
    public static function getSenderEmailsByDomain($domainId)
    {
        return self::find($domainId)->senderEmails()->get()->toArray();
    }

    /**
     * Get domain credential
     *
     * @param $domainId
     * @return mixed
     */
    public static function getDomainCredential($domainId)
    {
        return self::select('client_id', 'client_secret')->find($domainId)->toArray();
    }

    /**
     * Get the sender emails for the domain.
     */
    public function senderEmails()
    {
        return $this->hasMany(Email::class);
    }
}
