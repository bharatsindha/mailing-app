<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        if (!(request()->ajax())) {
            return view('user::index');
        }

        $results = User::getAllUsers()->paginate(15);

        return view('user::indexAjax', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = User::getRoles();
        return view('user::create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User($request->all());
            $user->password = Hash::make($user->password);
            $user->save();

            return redirect()->route('admin.users.index')->with('alert-success', 'User added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'Failed to add user. Please try again.');
        }
    }

    /**
     * Show the specified resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function show(User $user)
    {
        return view('user::show')->with('result', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        $roles = User::getRoles();

        return view('user::edit')->with('result', $user)->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(StoreUserRequest $request, User $user)
    {
        try {
            $user->fill($request->all());
            if (isset($user->password) && !is_null($user->password) && !empty($user->password))
                $user->password = Hash::make($user->password);
            else
                unset($user->password);
            $user->save();

            return redirect()->route('admin.users.index')->with('alert-success', 'User updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'Failed to update user. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->route('admin.users.index')->with('alert-success', 'User deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'Failed to delete user. Please try again.');
        }
    }
}
