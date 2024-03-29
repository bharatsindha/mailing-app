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

use Modules\Email\Http\Controllers\EmailController;
use Modules\User\Entities\User;

$role = User::ADMIN_ROLE;

Route::prefix('emails')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('getSenderEmailsByDomain', 'EmailController@getSenderEmailsByDomain')->name('emails.gsebd');
});

Route::middleware(['auth', "check.role.web:$role"])->name('admin.')->group(function () {
    Route::resource('emails', EmailController::class);
});
