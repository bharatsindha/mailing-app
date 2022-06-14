<?php

namespace Modules\Mail\Http\Controllers;

use App\Imports\ComposeImport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Domain\Entities\Domain;
use Modules\Mail\Entities\Session;
use Modules\Mail\Http\Requests\StoreComposeRequest;
use Throwable;

class DraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if (isset($request->logout)) {
            \Illuminate\Support\Facades\Session::forget('access_token');
        }

        if (!(request()->ajax())) {
            return view('mail::index');
        }

        $results = Session::getAllDraftSessions()->paginate(15);

        return view('mail::indexAjax', compact('results'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function sentReport(Request $request)
    {
        if (!(request()->ajax())) {
            $domains = Domain::getDomainOptions();

            return view('mail::sentReport', compact('domains'));
        }

        $results = Session::getSentSessions()->paginate(15);

        return view('mail::sentReportAjax', compact('results'));
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

    /**
     * Show the resource
     *
     * @param $id
     * @return Factory|View
     */
    public function show($id)
    {
        $session = Session::find($id);

        return view('mail::show', compact('session'));
    }

    /**
     * Show sent details
     *
     * @param $sessionId
     * @return Factory|View
     */
    public function sentReportDetails($sessionId)
    {
        if (!(request()->ajax())) {
            return view('mail::sentDetails', compact('sessionId'));
        }

        $results = Session::getSentDetails($sessionId)->paginate(100);

        return view('mail::sentDetailsAjax', compact('results'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $session = Session::find($id);
            $session->delete();

            return redirect()->route('admin.drafts.index')
                ->with('alert-success', 'Draft deleted successfully.');
        } catch (Throwable $e) {
            return redirect()->back()
                ->with('alert-danger', 'Failed to delete draft. Error: ' . $e->getMessage());
        }
    }

}
