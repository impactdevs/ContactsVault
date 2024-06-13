<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyInfobipSignature
{
      /*** The URIs that should be excluded from CSRF verification.*
        * @var array<int, string>
        */
        protected $except = ['webhook/whatsapp_outbox'];
        
    
}
