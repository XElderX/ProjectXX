<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryStoreRequest;
use App\Models\Country;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'countries.index',
            [
                'countries' => Country::orderBy('id')->paginate(10),
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
        return view('countries.create');
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
            'country'    => ['required', 'string', 'max:255', 'unique:countries'],
            'population' => ['nullable', 'min:1', 'max:255'],
            'flag'       => ['nullable'],
        ]);
  
        $country = Country::create([
            'country'    => $request->country,
            'population' => (integer) $request->population,
            'flag'       => $request->flag,
        ]);
        
        return redirect()->route('national')->with('status_success', 'country ' . $country->country . ' was added.');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(CountryStoreRequest $request, $id)
    {
        
        $country = Country::findOrFail($id);
        $country->fill($request->all());
        $country->save();

        return redirect()->route('national')->with('status_success', 'Country ' . $country->country . ' was updated successfully.');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        
        $country->delete();
        return redirect()->route('national')->with('status_success', 'Country ' . $country->country . ' was deleted.');;
    }
}
