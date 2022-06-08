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

use Modules\Domain\Http\Controllers\DomainController;

Route::middleware(['auth', 'check.role.web:admin'])->name('admin.')->group(function () {
    Route::resource('domains', DomainController::class);
});