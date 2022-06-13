<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\User\Entities\User;

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

Route::get('/', function () {
    return !is_null(Auth::user()) ?
        (Auth::user()->role == User::ADMIN_ROLE
            ? redirect()->route('admin.domains.index')
            : redirect()->route('admin.drafts.index')) :
        redirect()->route('login');
})->name('home');

require __DIR__ . '/auth.php';
