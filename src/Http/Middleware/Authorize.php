<?php

namespace Lifeonscreen\Google2fa\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lifeonscreen\Google2fa\Google2fa;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        return resolve(Google2fa::class)->authorize($request) ? $next($request) : abort(403);
    }
}
