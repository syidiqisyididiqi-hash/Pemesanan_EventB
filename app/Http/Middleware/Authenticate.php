<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Untuk API, jangan pernah redirect ke halaman login web.
     */
    protected function redirectTo($request)
    {
        return null;
    }
}