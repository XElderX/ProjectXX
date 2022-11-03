<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([

            'first_name'  => ['required|string|min:3|max:45'],
            'last_name'   => ['required|string|min:3|max:45'],
            'value'       => ['nullable|integer'],
            'salary'      => ['nullable|integer'],
            'height'      => ['required|integer'],
            'weight'      => ['required|integer'],
            'age'         => ['nullable|integer'],
            'potential'   => ['nullable|integer'],
            'bookings'    => ['nullable'],
            'injury_days' => ['nullable'],
            'fatigue'     => ['nullable|integer'],
            'position'    => ['nullable'],
    
            'gk'      => ['required|float|digits_between: 0, 25'],//0
            'def'     => ['required|float|digits_between: 0, 25'],//1
            'pm'      => ['required|float|digits_between: 0, 25'],//2
            'pace'    => ['required|float|digits_between: 0, 25'],//3
            'tech'    => ['required|float|digits_between: 0, 25'],//4
            'pass'    => ['required|float|digits_between: 0, 25'],//5
            'heading' => ['required|float|digits_between: 0, 25'],//6
            'str'     => ['required|float|digits_between: 0, 25'],//7
            
            'stamina'    => ['required|float|digits_between: 0, 25'],//8
            'exp'        => ['nullable|float|digits_between: 0, 10'],
            'lead'       => ['nullable|float|digits_between: 0, 10'],
            'form'       => ['nullable|float|digits_between: 0, 10'],
            'club_id'    => ['nullable|integer'],
            'country_id' => ['required|integer'],

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
            'first_name'  => $request->first_name, 
            'last_name'   => $request->last_name,  
            'value'       => $request->value,
            'salary'      => $request->salary, 
            'height'      => $request->height,  
            'weight'      => $request->weight, 
            'age'         => $request->age,  
            'potential'   => $request->potential, 
            'bookings'    => $request->bookings,
            'injury_days' => $request->injury_days,  
            'fatigue'     => $request->fatigue,
            'position'    => $request->position,
    
            'gk'      => $request->gk,//0
            'def'     => $request->def,  //1
            'pm'      => $request->pm,//2
            'pace'    => $request->pace,  //3
            'tech'    => $request->tech,//4
            'pass'    => $request->pass,  //5
            'heading' => $request->heading,  //6
            'str'     => $request->str, //7
            
            'stamina'    => $request->stamina, //8
            'exp'        => $request->exp,
            'lead'       => $request->lead, 
            'form'       => $request->form,
            'club_id'    => $request->club_id,
            'country_id' => $request->country_id,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
