<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Role\UserRole;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (Auth::guest() || !Auth::user()->hasRole(UserRole::ROLE_ADMIN) ) {
            $users = User::teachers()->get();
        } else {
            $users = User::all();
        }
        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('user.form')->with('user', new User())->with('roles', UserRole::getRoleList());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @return RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        User::create($request->toArray());

        return redirect()->route('users.index')->with('success', 'User successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user)
    {
        return view('user.form')->with('user', $user)->with('roles', UserRole::getRoleList());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->toArray());

        return redirect()->route('users.index')->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User successfully deleted!');
    }
}
