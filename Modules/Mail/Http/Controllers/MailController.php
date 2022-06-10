<?php

namespace Modules\Mail\Http\Controllers;

use App\Imports\ComposeImport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Domain\Entities\Domain;
use Modules\Mail\Http\Requests\StoreComposeRequest;
use Throwable;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('mail::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $domains = Domain::getDomainOptions();
        return view('mail::create', compact('domains'));
    }

    /**
     * Store data into storage
     *
     * @param StoreComposeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreComposeRequest $request)
    {
        try {
            $import = new ComposeImport($request);
            Excel::import($import, $request->file('excelFile'));

            if (!$import->isValidated()) {
                $errorMessages = $import->getErrorMessages();
                dd($errorMessages);
                return redirect()->back()
                    ->with('alert-danger', 'Error in validating data.')
                    ->withErrors($errorMessages);
            } else {
                return redirect()->route('admin.drafts.index')
                    ->with('alert-success', 'Draft added successfully.');
            }
        } catch (Throwable $e) {
            return redirect()->back()
                ->with('alert-danger', 'Something went wrong. Error: ' . $e->getMessage());
        }

    }

}
