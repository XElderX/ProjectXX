<?php

namespace App\Http\Controllers;

use App\Http\Requests\TownStoreRequest;
use App\Models\Country;
use App\Models\Town;


class TownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'towns.index',
            [
                'towns'      => Town::with('country')->paginate(10),
                'countries'  => Country::all(),
                'allweather' => Town::WEATHER,
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
    public function store(TownStoreRequest $request)
    {
        $town = Town::create([
            'town_name'  => $request->town_name,
            'country_id' => $request->country_id,
            'population' => (integer) $request->population,
            'weather'    => $request->weather,
        ]);
        
        return redirect()->route('towns')->with('status_success', 'Town ' . $town->town_name. ' was added.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function show(Town $town)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function edit(Town $town)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function update(TownStoreRequest $request, $id)
    {   
        $town = Town::findOrFail($id);
        $town->fill($request->all());
        $town->save();

        return redirect()->route('towns')->with('status_success', 'Town ' . $town->town_name . ' was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $town = Town::findOrFail($id);
        
        $town->delete();
        return redirect()->route('towns')->with('status_success', 'Town ' . $town->town_name . ' was deleted.');
    }
}
