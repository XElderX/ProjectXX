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
}
