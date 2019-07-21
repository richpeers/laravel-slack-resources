<?php

namespace Richpeers\LaravelSlackResources\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Richpeers\LaravelSlackResources\Exceptions\SlackResourceException;

class SlackSigningSecretMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $version = 'v0';
        $secret = config('slack-resources.signing_secret');
        $body = $request->getContent();
        $timestamp = $request->header('X-Slack-Request-Timestamp');
        $remoteSignature = $request->header('X-Slack-Signature');

        // check timestamp is within slack api timeout
        if (Carbon::now()->diffInMinutes(Carbon::createFromTimestamp($timestamp)) > 5) {
            throw new SlackResourceException('Invalid timestamp');
        }

        // local signature
        $sigBaseString = "{$version}:{$timestamp}:{$body}";
        $hash = \hash_hmac('sha256', $sigBaseString, $secret);
        $localSignature = "{$version}={$hash}";

        // check local and remote signatures match
        if ($remoteSignature !== $localSignature) {
            throw new SlackResourceException("Invalid signature");
        }

        return $next($request);
    }
}
