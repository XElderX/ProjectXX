<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\MatchSchedule;

class UpdateMatchStatusCommand extends Command
{
    protected $signature = 'matches:update-status';
    
    protected $description = 'Update match status based on the current date';

    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        MatchSchedule::where('match_date', $today)
            ->where('time', '<=', $currentTime)
            ->where('status', 'pending')
            ->update(['status' => 'accepted']);

        $this->info('Match status updated successfully.');
    }
}
