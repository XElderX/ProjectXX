<?php

namespace App\Http\Controllers;

use App\Models\FriendlyInvitation;
use App\Services\MatchServices\MatchProposialService;
use Illuminate\Http\Request;

class FriendlyInvitationController extends Controller
{
    public function friendlyInvitations()
    {
        $hostTeam = auth()->user()->club_id;

        return view(
            'matchSchedules.invitations',
            [
                'host'         => FriendlyInvitation::statusHost()->where('host_team_id', auth()->user()->club_id)->first() ?? "You are't hosting any match",
                'pendingMatches' => FriendlyInvitation::statusPending()->where('host_id', auth()->user()->id)->get(),
                'invitations'  => FriendlyInvitation::statusInvited()->whereNot('host_team_id', auth()->user()->club_id)
                    ->where(function ($query) use ($hostTeam) {
                        $query->where('host_team_id', $hostTeam)
                            ->orWhere('opponent_team_id', $hostTeam);
                    })->paginate(10),
                'friendlies'    => FriendlyInvitation::statusHost()
                    ->whereNot('host_team_id', auth()->user()->club_id)
                    ->paginate(10),
            ]
        );
    }

    public function proposialAction(Request $request,  MatchProposialService $matchProposialService, string $id = null, string $action = 'host')
    {
        try {
            $status = $matchProposialService->processProposial($request, $action, $id);

            if ($status === true) {
                return back()->with('status_success', 'Your request has been processed successfully.');
            } else {
                throw new \Exception('An error occurred while processing your request.');
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function hostFriendly(Request $request, MatchProposialService $matchProposialService)
    {
        try {
            $status = $matchProposialService->processProposial($request);

            if ($status === true) {
                return back()->with('status_success', 'Your request has been processed successfully.');
            } else {
                throw new \Exception('An error occurred while processing your request.');
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
