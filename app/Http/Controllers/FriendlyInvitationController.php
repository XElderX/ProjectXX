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
                'host'        => FriendlyInvitation::statusHost()->first() ?? "You are't hosting any match",
                'invitations' => FriendlyInvitation::statusInvited()->whereNot('host_id', auth()->user()->id)
                    ->where(function ($query) use ($hostTeam) {
                        $query->where('host_team_id', $hostTeam)
                            ->orWhere('opponent_team_id', $hostTeam);
                    })->paginate(10)
            ]
        );
    }

    public function proposeFriendly(Request $request, MatchProposialService $matchProposialService)
    {
        try {
            $status = $matchProposialService->processProposial($request, FriendlyInvitation::STATUS_INVITED);

            if ($status === true) {
                return redirect()->route('friendlyView')->with('status_success', 'Your request has been processed successfully.');
            } else {
                throw new \Exception('An error occurred while processing your request.');
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function cancelFriendly(string $id, Request $request, MatchProposialService $matchProposialService)
    {
        try {
            $status = $matchProposialService->processProposial($request, FriendlyInvitation::STATUS_CANCELED, $id);

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

    public function acceptMatch(string $id, Request $request, MatchProposialService $matchProposialService)
    {
        try {
            $status = $matchProposialService->processProposial($request, FriendlyInvitation::STATUS_ACCEPTED, $id);

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
