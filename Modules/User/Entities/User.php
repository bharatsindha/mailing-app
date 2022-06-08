<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    const USER_ROLE = 'user';
    const ADMIN_ROLE = 'admin';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get user profile
     *
     * @param $userId
     * @return mixed
     */
    public static function getUserProfile($userId)
    {
        return static::select('id', 'name', 'email', 'party_id', 'role')
            ->where('id', $userId)
            ->allRoles()
            ->first();
    }

    /**
     * Return all users
     *
     * @return mixed
     */
    public static function getAllUsers()
    {
        return self::select('*')
            ->when(request()->filled('q'), function ($q) {
                $keyword = request()->input('q');
                $q->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('role', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->orderBy('id', 'desc');
    }

    /**
     * Get roles
     *
     * @return array
     */
    public static function getRoles()
    {
        return [
            self::USER_ROLE  => ucfirst(self::USER_ROLE),
            self::ADMIN_ROLE => ucfirst(self::ADMIN_ROLE)
        ];
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUser($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAllRoles($query)
    {
        return $query->whereIn('role', ['user', 'admin']);
    }
}
