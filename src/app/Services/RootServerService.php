<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RootServerService
{
    protected string $rootServer;

    public function __construct()
    {
        $this->rootServer = env("BMLT_ROOT_SERVER");
    }

    public function getServiceBodies()
    {
        try {
            $response = Http::get($this->rootServer . '/client_interface/json/?switcher=GetServiceBodies');

            if ($response->successful()) {
                return $response->json();
            } else {
                // Handle non-successful responses
                return [];
            }
        } catch (\Exception $e) {
            // Handle connection errors, timeouts, etc.
            return [];
        }
    }

}
