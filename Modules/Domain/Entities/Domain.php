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
        'name', 'url', 'secret_key', 'credential'
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
                        ->orWhere('secret_key', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('credential', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->orderBy('id', 'desc');
    }

}
