<?php

namespace Modules\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
