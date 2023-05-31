<?php

namespace App\Http\Controllers;

use App\Http\Requests\LineupRequest;
use App\Models\Club;
use App\Models\MatchSchedule;
use App\Models\Player;
use App\Services\MatchServices\PreMatchService;
use Illuminate\Http\Request;


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

    public function scheduledMatches()
    {
        $schedules = MatchSchedule::where('home_team_id', auth()->user()->club_id)->orWhere('away_team_id', auth()->user()->club_id)->paginate(15);
        return view(
            'matchSchedules.schedule',
            [
                'schedules' => $schedules
            ]
        );
    }

    public function matchDetails(string $id)
    {
        $schedule = MatchSchedule::findOrfail($id);
        $report = $schedule->report;
        

        // $arr = ['min' => 15, 'event' => 'some event happened5'];
        // $newArr = $schedule->report ?? [];

        // array_push($newArr, $arr);
        // $schedule->report = $newArr;
        // $schedule->save();


// $arrayData = json_encode($report , true);
// dd(json_decode($arrayData));

// foreach ($report as  $value) {
//     dd($value['min']);
// }



        return view(
            'matchSchedules.matchReport',
            [
                'schedule' => $schedule,
                'report'   => $report
            ]
        );
    }

    public function matchForm(string $id)
    {
        $schedule = MatchSchedule::findOrfail($id);
        $team = Club::findOrFail(auth()->user()->club_id);
        $players = Player::where('club_id', $team->id)->get();
        $positions = ['DEF', 'MID', 'FOW'];
        return view(
            'matchSchedules.matchForm',
            [
                'schedule'  => $schedule,
                'team'      => $team,
                'options'   => $players,
                'positions' => $positions 
            ]
        );
    }

    public function lineup(string $id, LineupRequest $request, PreMatchService $preMatchService)
    {
        try {
            $preMatchService->setTacticAndLineup($id, $request);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('status_success', 'Your request has been processed successfully.');
    }
}
