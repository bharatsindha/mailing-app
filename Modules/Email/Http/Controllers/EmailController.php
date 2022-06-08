<?php

namespace Modules\Email\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Domain\Entities\Domain;
use Modules\Email\Entities\Email;
use Modules\Email\Http\Requests\StoreEmailRequest;
use Throwable;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        if (!(request()->ajax())) {
            return view('email::index');
        }

        $results = Email::getAllEmails()->paginate(15);

        return view('email::indexAjax', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $domains = Domain::getDomainOptions();
        return view('email::create', compact('domains'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmailRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEmailRequest $request)
    {
        try {
            $email = new Email($request->all());
            $email->save();

            return redirect()->route('admin.emails.index')->with('alert-success', 'Email added successfully.');
        } catch (Throwable $e) {
            return redirect()->back()
                ->with('alert-danger', 'Failed to add email. Error: ' . $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     *
     * @param Email $email
     * @return Factory|View
     */
    public function show(Email $email)
    {
        return view('email::show')->with('result', $email);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Email $email
     * @return Factory|View
     */
    public function edit(Email $email)
    {
        $domains = Domain::getDomainOptions();

        return view('email::edit', compact('domains'))->with('result', $email);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreEmailRequest $request
     * @param Email $email
     * @return RedirectResponse
     */
    public function update(StoreEmailRequest $request, Email $email)
    {
        try {
            $email->fill($request->all());
            $email->save();

            return redirect()->route('admin.emails.index')->with('alert-success', 'Email updated successfully.');
        } catch (Throwable $e) {
            return redirect()->back()
                ->with('alert-danger', 'Failed to update email. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Email $email
     * @return RedirectResponse
     */
    public function destroy(Email $email)
    {
        try {
            $email->delete();

            return redirect()->route('admin.emails.index')->with('alert-success', 'Email deleted successfully.');
        } catch (Throwable $e) {
            return redirect()->back()
                ->with('alert-danger', 'Failed to delete email. Error: ' . $e->getMessage());
        }
    }
}
