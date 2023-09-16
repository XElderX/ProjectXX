<?php

namespace App\Services\MatchServices;

use App\Models\FriendlyInvitation;
use App\Models\MatchSchedule;
use Exception;

class MatchProposialService
{
    /**
     * @var MatchSchedule;
     */
    protected $match;

    public function __construct()
    {
        $this->match = new MatchSchedule();
    }

    public function processProposial($request, string $status = 'host', string $id = null)
    {
        if (null === auth()->user()->club_id) {
            throw new Exception("No active team assigned to user", 1);
        }
        if ($status === FriendlyInvitation::STATUS_INVITED) {
            return $this->invited($request);
        }
        if ($status === FriendlyInvitation::STATUS_HOST) {
            return $this->hosted($request);
        }
        if ($status === FriendlyInvitation::STATUS_CANCELED) {
            return $this->canceled($id);
        }
        if ($status === FriendlyInvitation::STATUS_ACCEPTED) {
            return $this->accepted($id);
        }
        if ($status === FriendlyInvitation::STATUS_PENDING) {
            return $this->pending($id);
        }
        throw new \Exception('Unable to make an action');
    }

    private function invited($request)
    {
        $invitation = new FriendlyInvitation();
        $opponent = $request->opponent_id;
        $hostTeam = auth()->user()->club_id;

        if ($this->isOpponentUnavailable($hostTeam, $opponent, $invitation->pickWednesday())) {
            return false;
        }

        $invitation->type = FriendlyInvitation::TYPE_FRIENDLY;
        $invitation->public = false;
        $invitation->host_vanue = $request->vanue === '1' ? true : false;
        $invitation->status = FriendlyInvitation::STATUS_INVITED;
        $invitation->host_id = auth()->user()->id;
        $invitation->host_team_id = auth()->user()->club_id;
        $invitation->opponent_team_id = (int) $request->opponent_id;
        $invitation->match_date = $invitation->pickWednesday();

        $invitation->save();

        return true;
    }

    private function hosted($request)
    {
        $invitation = new FriendlyInvitation();

        if ($this->isAlreadyHosting($request, $invitation->pickWednesday())) {
            return false;
        }

        $invitation->type = $request->type;
        $invitation->public = true;
        $invitation->host_vanue = $request->vanue === '1' ? true : false;
        $invitation->status = FriendlyInvitation::STATUS_HOST;
        $invitation->host_id = auth()->user()->id;
        $invitation->host_team_id = auth()->user()->club_id;
        $invitation->match_date = $invitation->pickWednesday();

        $invitation->save();

        return true;
    }

    private function canceled($id)
    {
        $invitation = FriendlyInvitation::findOrFail($id);

        $invitation->status = FriendlyInvitation::STATUS_CANCELED;
        $invitation->save();

        return true;
    }

    private function accepted($id)
    {
        $invitation = FriendlyInvitation::findOrFail($id);

        $invitation->status = FriendlyInvitation::STATUS_ACCEPTED;

        $preMatch = new PreMatchService();
        $invitation->save();

        $preMatch->matchSchedule($invitation);

        return true;
    }

    private function pending($id)
    {
        $host = FriendlyInvitation::findOrFail($id);
        $invitation = new FriendlyInvitation();

        $opponent = auth()->user()->club_id;
        $hostTeam = $host->host_team_id;

        if ($this->isOpponentUnavailable($hostTeam, $opponent, $invitation->pickWednesday())) {
            return false;
        }

        $invitation->type = $host->type;
        $invitation->public = false;
        $invitation->host_vanue = $host->host_vanue;
        $invitation->status = FriendlyInvitation::STATUS_PENDING;
        $invitation->host_id = $host->host_id;
        $invitation->host_team_id = $host->host_team_id;
        $invitation->opponent_team_id = auth()->user()->club_id;
        $invitation->match_date = $host->match_date;
        $invitation->save();

        return true;
    }

    private function isOpponentUnavailable($hostTeam, $opponent, $date)
    {
        $exist = FriendlyInvitation::where(function ($query) use ($opponent, $date, $hostTeam) {
            $query->where('status', FriendlyInvitation::STATUS_ACCEPTED)
                ->where('match_date', $date)
                ->where(function ($query) use ($opponent, $hostTeam) {
                    $query->where(function ($query) use ($opponent,) {
                        $query->where('opponent_team_id', $opponent)
                            ->orWhere('host_team_id', $opponent);
                    })
                        ->orWhere(function ($query) use ($hostTeam) {
                            $query->where('host_team_id', $hostTeam)
                                ->orWhere('opponent_team_id', $hostTeam);
                        });
                });
        })->orWhere(function ($query) use ($opponent, $date, $hostTeam) {
            $query->where('status', FriendlyInvitation::STATUS_ACCEPTED)
                ->where('match_date', $date)
                ->where('host_team_id', $hostTeam)
                ->where('opponent_team_id', $opponent);
        })
        ->orWhere(function ($query) use ($opponent, $date, $hostTeam) {
            $query->where('status', FriendlyInvitation::STATUS_PENDING)
                ->where('match_date', $date)
                ->where('host_team_id', $hostTeam)
                ->where('opponent_team_id', $opponent);
        })->exists();
        //TODO finish implementing pending logic. hosting match user should have able to acceot pending match offer

        return $exist;
    }

    private function isAlreadyHosting($request, $date)
    {
        $hostTeam = auth()->user()->club_id;

        $exist = FriendlyInvitation::where(function ($query) use ($date, $hostTeam) {
            $query->where('match_date', $date)
                ->where('status', FriendlyInvitation::STATUS_ACCEPTED)
                ->where(function ($query) use ($hostTeam) {
                    $query->where('host_team_id', $hostTeam)
                        ->orwhere('opponent_team_id', $hostTeam);
                })->orWhere(function ($query) use ($hostTeam, $date) {
                    $query->where('match_date', $date)
                        ->where('host_team_id', $hostTeam)
                        ->where('status', FriendlyInvitation::STATUS_HOST);
                });
        })->exists();

        return $exist;
    }

    protected function cancelRemainingInvitations($invitation): void
    {
        $team1 = $invitation->host_team_id;
        $team2 = $invitation->opponent_team_id;
        $date = $invitation->match_date;


        $invitations = FriendlyInvitation::where(function ($query) use ($date, $team1, $team2) {
            $query->where('match_date', $date)
                ->whereNot('status', FriendlyInvitation::STATUS_ACCEPTED)
                ->where(function ($query) use ($team1, $team2) {
                    $query->where(function ($query) use ($team1) {
                        $query->where('host_team_id', $team1)
                            ->orWhere('opponent_team_id', $team1);
                    })->orWhere(function ($query) use ($team2) {
                        $query->where('host_team_id', $team2)
                            ->orWhere('opponent_team_id', $team2);
                    });
                });
        })->get();

        $invitations->each(function ($invitation) {
            $invitation->status = FriendlyInvitation::STATUS_CANCELED;
            $invitation->save();
        });
    }
}
