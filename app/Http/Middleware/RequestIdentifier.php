<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Throwable;

class RequestIdentifier
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // Generate a unique request ID (UUID)
        $incidentId= Str::uuid()->toString();

        // Add the request ID to the current request object
        $request->request->add(['incident_id' => $incidentId]);

        // Share this ID globally across all log entries
        Log::withContext(['incident_id' => $incidentId]);

        return $next($request);
    }
}
