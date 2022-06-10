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

use Modules\Mail\Http\Controllers\DraftController;

Route::prefix('mail')->middleware(['auth', 'check.role.web:admin'])->name('admin.')->group(function () {
    Route::resource('drafts', DraftController::class);
    Route::post('uploadAttachment', 'AttachmentController@uploadAttachment')->name('draft.uploadAttachment');
    Route::post('removeAttachment', 'AttachmentController@removeAttachment')->name('draft.removeAttachment');

    Route::get('connection', 'MailingController@connection')->name('mail.connection');
    Route::get('reConnect', 'MailingController@reConnectGMail')->name('mail.reConnect');

    Route::get('send/{session}', 'MailingController@startMailing')->name('mail.startMailing');
    Route::post('getEmail/{session}', 'MailingController@getEmail')->name('mail.getEmail');
    Route::post('sendEmail/{session}', 'MailingController@sendEmail')->name('mail.sendEmail');
});

Route::get('email/img/{compose}', 'MailingController@emailOpenTrack')->name('openTrack.img');
