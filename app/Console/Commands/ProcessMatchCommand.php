<?php

namespace App\Console\Commands;

use App\Models\MatchSchedule;
use App\Models\Player;
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

            // Get the match report
            $matchReport = $match->matchReport;

            $goalScorers = $match->getGoalScorers();  // Use getter method for goal scorers
            $yellowCards = $match->getYellowCards();  // Use getter method for yellow cards
            $redCards = $match->getRedCards();

            // Process goal scorers and assists
            foreach ($goalScorers as $goal) {
                $scorer = Player::find($goal['scorer']); // Find the player who scored
                if ($scorer) {
                    // Update the player's statistics
                    $scorerStats = $scorer->playerStatistics()->firstOrCreate();

                    // Increment goals and assists
                    $scorerStats->increment('friendly_goals');
                    if (isset($goal['assister']) && $goal['assister']) {
                        $assister = Player::find($goal['assister']);
                        if ($assister) {
                            $assisterStats = $assister->playerStatistics()->firstOrCreate();
                            $assisterStats->increment('friendly_assists');
                        }
                    }

                    // Save the updated statistics
                    $scorerStats->save();
                }
            }

            if ($matchSchedule->type === 'league') {
                // Process yellow cards
                foreach ($yellowCards as $playerId => $yellowCardCount) {
                    $player = Player::find($playerId);
                    if ($player) {
                        $playerStats = $player->playerStatistics()->firstOrCreate();
                        // You can track the yellow cards, for now, we just increment them
                        $playerStats->increment('yellow_cards', $yellowCardCount);
                        $playerStats->save();
                    }
                }

                // Process red cards
                foreach ($redCards as $playerId) {
                    $player = Player::find($playerId);
                    if ($player) {
                        $playerStats = $player->playerStatistics()->firstOrCreate();
                        // You can track the red cards as well
                        $playerStats->increment('red_cards');
                        $playerStats->save();
                    }
                }
            }

            // Save the match result to the database
            $matchSchedule->status = 'finished';  // Update the status to 'finished'
            $matchSchedule->home_goals = $teamA->getTeamGoals();  // Store the home team's goals
            $matchSchedule->away_goals = $teamB->getTeamGoals();  // Store the away team's goals
            $matchSchedule->home_shots = $teamA->getTeamAtempts();  // Store the home team's shots
            $matchSchedule->away_shots = $teamB->getTeamAtempts();  // Store the away team's shots
            // $matchSchedule->home_on_target = $match->getHomeOnTarget();  // Store the home team's shots on target
            // $matchSchedule->away_on_target = $match->getAwayOnTarget();  // Store the away team's shots on target
            $matchSchedule->report = json_encode($matchReport);  // Optionally save the match report (or any other match data)

            // Save the updated match schedule to the database
            $matchSchedule->save();
        }

        // Final output for debugging (you can remove this line or log it)
        dd('Finished processing matches');
    }
}
