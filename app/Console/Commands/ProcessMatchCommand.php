<?php

namespace App\Console\Commands;

use App\Models\MatchSchedule;
use App\Services\MatchServices\MatchService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ProcessMatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:process-match';

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
        $now = Carbon::now();

        // Query pending matches where match_date is less than today and time is less or equal to now
        $matches = MatchSchedule::where('status', 'pending')
            ->whereDate('match_date', '<', $now->toDateString())
            // ->whereTime('time', '<=', $now->toTimeString())
            ->get();
            
            // Process each match
        foreach ($matches as $match) {
            $matchService = new MatchService($match);
            // dd($matchService);

            $matchService->simulateMatch();
            dd('stop');

        }

        return Command::SUCCESS;
    }


    function simulateMatch() {
        $matchDuration = 90; // 90 minutes
        $homeGoals = 0;
        $awayGoals = 0;
    
        for ($minute = 1; $minute <= $matchDuration; $minute++) {
            // Simulate events for each minute
            $event = rand(1, 100); // Random number to determine events probability
    
            // Probability of a goal being scored (you can adjust these probabilities as needed)
            $goalProbability = 2; // 2% chance of a goal
    
            // Probability of a foul happening
            $foulProbability = 5; // 5% chance of a foul
    
            // Probability of a card being shown
            $cardProbability = 2; // 2% chance of a card
    
            // Simulate a goal
            if ($event <= $goalProbability) {
                $scorer = rand(1, 2); // Randomly select the team that scores (1: Home, 2: Away)
                if ($scorer === 1) {
                    $homeGoals++;
                } else {
                    $awayGoals++;
                }
                echo "Goal at minute $minute! Home: $homeGoals - Away: $awayGoals\n";
            }
    
            // Simulate a foul
            if ($event <= $foulProbability) {
                $foulTeam = rand(1, 2); // Randomly select the team committing the foul (1: Home, 2: Away)
                echo "Foul at minute $minute! Foul by Team $foulTeam\n";
            }
    
            // Simulate a card being shown
            if ($event <= $cardProbability) {
                $cardTeam = rand(1, 2); // Randomly select the team receiving the card (1: Home, 2: Away)
                $cardType = rand(0, 1); // Randomly choose between yellow (0) and red (1) card
                $cardColor = ($cardType === 0) ? 'Yellow' : 'Red';
                echo "$cardColor card shown at minute $minute! Team $cardTeam\n";
            }
    
            // Simulate other events and actions as needed
    
            // Add a delay or sleep to create the real-time effect
            // You can adjust the duration to control the match speed.
            sleep(1);
        }
    
        echo "Match Finished! Final Score: Home $homeGoals - Away $awayGoals\n";
    }

    function calculateMidfieldSkill($players) {
        $totalSkill = 0;
        foreach ($players as $player) {
            $totalSkill += $player['midfield_skill'];
        }
        return $totalSkill;
    }
    
    function simulateMidfieldPossession() {
        $homePlayers = [
            ['midfield_skill' => rand(70, 90)],
            ['midfield_skill' => rand(70, 90)],
            ['midfield_skill' => rand(70, 90)],
        ];
    
        $awayPlayers = [
            ['midfield_skill' => rand(70, 90)],
            ['midfield_skill' => rand(70, 90)],
            ['midfield_skill' => rand(70, 90)],
        ];
    
        $homePossessionCount = 0;
        $awayPossessionCount = 0;
        $consecutivePossessionTeam = null;
        $matchDuration = 10; // 10 minutes for demonstration purposes
    
        for ($minute = 1; $minute <= $matchDuration; $minute++) {
            $homeMidfieldSkill = calculateMidfieldSkill($homePlayers);
            $awayMidfieldSkill = calculateMidfieldSkill($awayPlayers);
    
            // Calculate the probability of each team winning possession based on their midfield skill
            $totalMidfieldSkill = $homeMidfieldSkill + $awayMidfieldSkill;
            $homePossessionProbability = $homeMidfieldSkill / $totalMidfieldSkill;
    
            // Determine which team wins possession for this minute
            $possessingTeam = (rand(0, 100) / 100 <= $homePossessionProbability) ? 'home' : 'away';
    
            // Decrease the possibility of the same team getting consecutive possessions
            if ($consecutivePossessionTeam === $possessingTeam) {
                $consecutivePossessionTeam = null;
            } else {
                $consecutivePossessionTeam = $possessingTeam;
            }
    
            // Update possession count
            if ($possessingTeam === 'home') {
                $homePossessionCount++;
            } else {
                $awayPossessionCount++;
            }
        }
    
        echo "Midfield Possession Stats:\n";
        echo "Home Possession Count: $homePossessionCount\n";
        echo "Away Possession Count: $awayPossessionCount\n";
    }
    
    // Call the function to simulate midfield possession
    // simulateMidfieldPossession();
    
    
    // Call the function to simulate the match
    // simulateMatch();
}
