<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('user.index')->with('users', User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        User::create($request)->setRole($request->role);

        return redirect()->route('users.index')->with('success', 'User successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('user.form')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'password']));
        $user->setRole($request->role);
        $user->save();

        return redirect()->route('users.index')->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User successfully deleted!');
    }
}
