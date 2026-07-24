<?php

namespace App\Services;

use App\Enums\AuthLogEvent;
use App\Models\AuthLog;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Records every authentication / user-management event for the admin-facing
 * audit log. Logging is deliberately more detailed internally (real failure
 * reasons in `metadata`, attempted emails even for unknown accounts) than
 * what is ever revealed in an HTTP response to an end user.
 */
class AuthLogService
{
    public function record(
        AuthLogEvent $event,
        ?User $user,
        Request $request,
        ?string $emailAttempted = null,
        array $metadata = [],
    ): AuthLog {
        $ua = UserAgentParser::parse($request->userAgent());

        return AuthLog::create([
            'user_id' => $user?->id,
            'event' => $event,
            'email_attempted' => $emailAttempted,
            'ip_address' => $request->ip(),
            'user_agent_raw' => $request->userAgent(),
            'browser' => $ua['browser'],
            'platform' => $ua['platform'],
            'metadata' => $metadata,
        ]);
    }
}
