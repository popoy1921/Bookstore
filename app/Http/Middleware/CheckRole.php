<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * handle requests if has the access for the page
     *
     * @param  mixed $oRequest
     * @param  mixed $next
     * @param  mixed $aRoles
     * @return Response
     */
    public function handle(Request $oRequest, Closure $next, mixed ...$aRoles): Response
    {
        // Check if the user is authenticated and has the required role
        if (in_array($oRequest->user()->role, $aRoles) === false) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        return $next($oRequest);
    }
}
