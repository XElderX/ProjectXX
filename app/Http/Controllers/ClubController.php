<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubStoreRequest;
use App\Models\Club;
use App\Models\Country;
use App\Models\Town;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'clubs.index',
            [
                'clubs'     => Club::orderBy('id')->paginate(10),
                'moods'     => Club::SUPPORTERS_MOOD,
                'countries' => Country::with('town')->get(),
            ]
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClubStoreRequest $request)
    {
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

        return redirect()->route('clubs')->with('status_success', 'Club ' . $club->club_name . ' was added.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(ClubStoreRequest $request, $id)
    {
        $club = Club::findOrFail($id);
        $club->fill($request->all());
        $club->save();

        return redirect()->route('clubs')->with('status_success', 'Club ' . $club->club_name . ' was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $club = Club::findOrFail($id);

        $club->delete();
        return redirect()->route('clubs')->with('status_success', 'Club ' . $club->club_name . ' was deleted.');
    }

    public static function getTowns($countryID)
    {
        $townz = Town::where('country_id', $countryID)->get();
        return $townz;
    }

    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('towns')
            ->where($select, $value)
            ->get();
        $output = '<option value="">Select ' . ucfirst($dependent) . '</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->$dependent . '</option>';
        }
        echo $output;
    }
}
