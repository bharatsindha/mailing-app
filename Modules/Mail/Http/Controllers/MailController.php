<?php

namespace Modules\Mail\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Domain\Entities\Domain;
use Modules\Mail\Entities\Attachment;
use Modules\Mail\Http\Requests\StoreComposeRequest;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
//        dd((string) Str::uuid());

//        dd(storage_path(Attachment::ATTACHMENT_PATH) . '/logo.png');

//        dd(Storage::get(storage_path(Attachment::ATTACHMENT_PATH) . '/logo.png'));

        $domains = Domain::getDomainOptions();
        return view('mail::index', compact('domains'));
    }

    /**
     * @param StoreComposeRequest $request
     */
    public function store(StoreComposeRequest $request)
    {
        dd($request->all());
    }

}
