<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyInfobipSignature
{
      /*** The URIs that should be excluded from CSRF verification.*
        * @var array<int, string>
        */
        protected $except = ['/whatsapp_inbox'];
        
    public function handle(Request $request, Closure $next)
    {

      
        // Verify the signature (implementation depends on Infobip's signature method)
        // Example: check for a specific header value
        if ($request->header('X-Infobip-Signature') !== config('services.infobip.webhook_secret')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
