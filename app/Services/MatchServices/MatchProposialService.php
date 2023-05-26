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
        throw new \Exception('Unable to make an action');
    }

    private function invited($request)
    {
        $invitation = new FriendlyInvitation();

        if ($this->isOpponentUnavailable($request, $invitation->pickWednesday())) {
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

    private function isOpponentUnavailable($request, $date)
    {
        $opponent = $request->opponent_id;
        $hostTeam = auth()->user()->club_id;

        $exist = FriendlyInvitation::where(function ($query) use ($opponent, $date, $hostTeam) {
            $query->where('status', FriendlyInvitation::STATUS_ACCEPTED)
                ->where(function ($query) use ($opponent, $date, $hostTeam) {
                    $query->where(function ($query) use ($opponent, $date) {
                        $query->where('opponent_team_id', $opponent)
                            ->where('match_date', $date);
                    })
                        ->orWhere(function ($query) use ($opponent, $hostTeam) {
                            $query->where('host_team_id', $opponent)
                                ->where('opponent_team_id', $hostTeam);
                        });
                });
        })->orWhere(function ($query) use ($opponent, $date, $hostTeam) {
            $query->where('match_date', $date)
                ->where('host_team_id', $hostTeam)
                ->where('opponent_team_id', $opponent);
        })->exists();

        return $exist;
        //TODO check if host already planned match; check if host planed match as opponent and check if opponent planed match as host
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
        //TODO check if host already planned match; check if host planed match as opponent and check if opponent planed match as host
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

        // $invitations = FriendlyInvitation::where(function ($query) use ($date, $team1, $team2) {
        //     $query->where('match_date', $date)
        //         ->whereNot('status', FriendlyInvitation::STATUS_ACCEPTED)
        //         ->where(function ($query) use ($team1) {
        //             $query->where(function ($query) use ($team1) {
        //                 $query->where('host_team_id', $team1)
        //                     ->orWhere('opponent_team_id', $team1);
        //             });
        //         })->where(function ($query) use ($team2) {
        //             $query->where(function ($query) use ($team2) {
        //                 $query->where('host_team_id', $team2)
        //                     ->orWhere('opponent_team_id', $team2);
        //             });
        //         });
        // })->get();

        $invitations->each(function ($invitation) {
            $invitation->status = FriendlyInvitation::STATUS_CANCELED;
            $invitation->save();
        });
    }
}
