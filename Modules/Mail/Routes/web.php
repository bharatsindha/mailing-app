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

use Modules\Mail\Http\Controllers\MailController;

Route::prefix('mail')->middleware(['auth', 'check.role.web:admin'])->name('admin.')->group(function () {
    Route::get('compose', 'MailController@index')->name('compose.index');
    Route::post('compose', 'MailController@store')->name('compose.store');

    Route::post('compose/uploadAttachment', 'AttachmentController@uploadAttachment')->name('compose.uploadAttachment');
    Route::post('compose/removeAttachment', 'AttachmentController@removeAttachment')->name('compose.removeAttachment');
});
