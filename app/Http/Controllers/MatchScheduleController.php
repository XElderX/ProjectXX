<?php

namespace App\Http\Controllers;

use App\Models\MatchSchedule;

class MatchScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'matchSchedules.index',
            [
                'matches' => MatchSchedule::latest()->paginate(20),
            ]
        );
    }

    public function proposeFriendlyView()
    {
        return view('matchSchedules.propose');
    }
}
