<?php

namespace App\Console\Commands;

use App\Models\MatchSchedule;
use App\Services\MatchServices\MatchEngine;
use App\Services\MatchServices\Team as MatchServicesTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Team;

class ProcessMatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:process-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending matches';

    // /**
    //  * MatchService constructor.
    //  * @param MatchService $matchService
    //  */
    // public function __construct(
    //     MatchService $matchService,
    // ) {
    //     $this->matchService = $matchService;
    // }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the current date and time
        $now = now();

        // Query pending matches where match_date is less than today and time is less or equal to now
        $matches = MatchSchedule::where('status', 'pending')
            ->whereDate('match_date', '<', $now->toDateString())
            // ->whereTime('time', '<=', $now->toTimeString())  // Uncomment this line if you need to compare with the time as well
            ->get();

        // Process each match
        foreach ($matches as $matchSchedule) {
            // Instantiate the two teams with their respective tactics and lineups
            $teamA = new MatchServicesTeam($matchSchedule->home_team_id, $matchSchedule->home_lineup, $matchSchedule->home_tactic);
            $teamB = new MatchServicesTeam($matchSchedule->away_team_id, $matchSchedule->away_lineup, $matchSchedule->away_tactic);

            // Create a new match engine with the teams
            $match = new MatchEngine($teamA, $teamB);

            // Simulate the match
            $match->simulateMatch();

           dd($match);
            $matchReport = $match->matchReport;

            // Output for debugging (you can remove these or log them later)
            // dd($matchSchedule);
            // dd($match);

            // Save the match result to the database
            $matchSchedule->status = 'finished';  // Update the status to 'finished'
            // dd($teamA->getTeamAtempts());
            $matchSchedule->home_goals = $teamA->getTeamGoals();  // Store the home team's goals
            $matchSchedule->away_goals = $teamB->getTeamGoals();  // Store the away team's goals
            $matchSchedule->home_shots = $teamA->getTeamAtempts();  // Store the home team's shots
            $matchSchedule->away_shots = $teamB->getTeamAtempts();  // Store the away team's shots
            // $matchSchedule->home_on_target = $match->getHomeOnTarget();  // Store the home team's shots on target
            // $matchSchedule->away_on_target = $match->getAwayOnTarget();  // Store the away team's shots on target
            $matchSchedule->report = json_encode($matchReport);  // Optionally save the match report (or any other match data)
            dd($matchSchedule);

            // Save the updated match schedule to the database
            $matchSchedule->save();
        }

        // Final output for debugging (you can remove this line or log it)
        dd('Finished processing matches');
    }
}
