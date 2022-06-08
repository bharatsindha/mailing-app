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

Route::middleware(['auth', 'check.role.web:admin'])->name('admin.')->group(function () {
    Route::resource('emails', EmailController::class);
});
