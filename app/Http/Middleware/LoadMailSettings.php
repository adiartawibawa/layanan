<?php

namespace App\Http\Middleware;

use App\Settings\MailSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadMailSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $mailSettings = app(MailSettings::class);
        $mailSettings->loadMailSettingsToConfig();

        return $next($request);
    }
}
