<?php

namespace App\Services\TeamServices;

use App\Services\TeamServices\GenerateTeamTemplates\GenerateTeamProcess;

class GenerateTeamService
{
    public function __construct(GenerateTeamProcess $generateTeamProcess)
    {
        $this->generateTeamProcess = $generateTeamProcess;
    }

    public function processRequest($request)
    {
        if ($request->team_type === '1') {
            return $this->generateTeamProcess->process($request->team_type, $request);
        }
        if ($request->team_type === '2') {
            return $this->generateTeamProcess->process($request->team_type, $request);
        }
        if ($request->team_type === '3') {
            return $this->generateTeamProcess->process($request->team_type, $request);
        }
        throw new \Exception('Unable to generate player ');
    }
}
