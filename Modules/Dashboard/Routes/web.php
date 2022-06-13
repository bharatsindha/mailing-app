<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\User\Entities\User;

$role = User::ADMIN_ROLE . ',' . User::USER_ROLE;

Route::prefix('dashboard')
    ->middleware(['auth', "check.role.web:$role"])
    ->name('admin.')
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
    });
