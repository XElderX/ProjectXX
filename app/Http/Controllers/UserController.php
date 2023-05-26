<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'users.index',
            [
                'users' => User::orderBy('id')->paginate(10),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $user = User::where('uuid', '=', $uuid)->firstOrFail();

        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function disable($uuid)
    {
        $user = User::where('uuid', '=', $uuid)->firstOrFail();
        ($user->disabled == false) ? $user->disabled = true : $user->disabled = false;
        $user->save();

        return redirect()->route('users')->with('status_success', 'disabled');
    }

     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
        $user = auth()->user();
        $clubs = Club::where('user_id', $user->id)->get();
        // dd($clubs);
        return view('users.accountInfo', [
            'user'  => $user,
            'clubs' => $clubs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function infoUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // dd($user->userClub);
        $user->setClub($request->club_id);
        $user->save();

        return redirect()->route('users.info')->with('status_success', 'User assigned' . $user->userClub->club_name . ' as active club.');
    }
}
