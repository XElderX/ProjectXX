<?php

namespace App\Services\MatchServices;

use App\Models\FriendlyInvitation;

class PreMatchService extends MatchProposialService
{
    protected function matchSchedule(FriendlyInvitation $invitation)
    {
        $this->match->fillMatchData($invitation);
        $this->cancelRemainingInvitations($invitation);
        $this->match->save();
    }
}
