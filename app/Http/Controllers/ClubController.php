<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'club_name'          => ['required', 'string', 'min:3', 'max:30', 'unique:clubs'],
            'club_rating_points' => ['nullable', 'integer', 'min:1', 'max:5'],
            'supporters'         => ['nullable', 'integer', 'min:1', 'max:5'],
            'supporters_mood'    => ['nullable', 'string'],
            'budget'             => ['nullable', 'integer', 'min:1', 'max:10'],
            'country_id'         => ['nullable', 'integer'],
            'town_id'            => ['nullable', 'integer'],
            'user_id'            => ['nullable', 'integer'],
        ]);
    
        $club = Club::create([
            'club_name'          => $request->club_name,
            'club_rating_points' => $request->club_rating_points,
            'supporters'         => $request->supporters,
            'supporters_mood'    => $request->supporters_mood,
            'budget'             => $request->budget,
            'country_id'         => $request->country_id,
            'town_id'            => $request->town_id,
            'user_id'            => $request->user_id,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        //
    }
}
