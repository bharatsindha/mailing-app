<?php

namespace App\Facades;

use Carbon\Carbon;
use Illuminate\Support\Facades\Facade;

Class General extends Facade
{
    /**
     * Get the date in format
     *
     * @param $date
     * @return string|null
     */
    public static function dateFormat($date)
    {
        if (is_null($date) || empty($date)) return null;

        return Carbon::parse($date)->toDateString();
    }

    protected static function getFacadeAccessor()
    {
        return 'general';
    }
}
