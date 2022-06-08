<?php

namespace Modules\Domain\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Domain\Entities\Domain;
use Modules\Domain\Http\Requests\StoreDomainRequest;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        if (!(request()->ajax())) {
            return view('domain::index');
        }

        $results = Domain::getAllDomains()->paginate(15);

        return view('domain::indexAjax', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        return view('domain::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDomainRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDomainRequest $request)
    {
        try {
            $domain = new Domain($request->all());
            $domain->save();

            return redirect()->route('admin.domains.index')->with('alert-success', 'Domain added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'Failed to add domain. Please try again.');
        }
    }

    /**
     * Show the specified resource.
     *
     * @param Domain $domain
     * @return Factory|View
     */
    public function show(Domain $domain)
    {
        return view('domain::show')->with('result', $domain);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Domain $domain
     * @return Factory|View
     */
    public function edit(Domain $domain)
    {
        return view('domain::edit')->with('result', $domain);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreDomainRequest $request
     * @param Domain $domain
     * @return RedirectResponse
     */
    public function update(StoreDomainRequest $request, Domain $domain)
    {
        try {
            $domain->fill($request->all());
            $domain->save();

            return redirect()->route('admin.domains.index')->with('alert-success', 'Domain updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'Failed to update domain. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Domain $domain
     * @return RedirectResponse
     */
    public function destroy(Domain $domain)
    {
        try {
            $domain->delete();

            return redirect()->route('admin.domains.index')->with('alert-success', 'Domain deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'Failed to delete domain. Please try again.');
        }
    }
}
