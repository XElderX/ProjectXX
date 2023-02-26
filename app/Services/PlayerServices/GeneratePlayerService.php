<?php

namespace App\Services\PlayerServices;

use App\Services\PlayerServices\GeneratePlayerTemplates\GeneratePlayerProcess;

class GeneratePlayerService
{
    public function __construct(GeneratePlayerProcess $generatePlayerProcess)
    {
        $this->generatePlayerProcess = $generatePlayerProcess;
    }

    public function processRequest($request)
    {
        if ($request->type === '1') {
            return $this->generatePlayerProcess->process($request);
        }
        if ($request->type === '2') {
            return $this->generatePlayerProcess->process($request);
        }
        if ($request->type === '3') {
            return $this->generatePlayerProcess->process($request);
        }
        throw new \Exception('Unable to generate player ');
    }
}
