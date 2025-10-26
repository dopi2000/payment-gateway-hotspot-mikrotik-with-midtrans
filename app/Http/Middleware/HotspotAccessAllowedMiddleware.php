<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class HotspotAccessAllowedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $allowedIps = [
            '10.10.10.0/24',
            '20.20.20.0/24',
        ];

        $isValidRequest = false;

        if(!$isValidRequest) {
            $clientIp = $request->ip();
            if(IpUtils::checkIp($clientIp, $allowedIps)) {
                    $isValidRequest = true;
              if(IpUtils::checkIp($clientIp, '10.10.10.0/24')) {
                  session()->put('link-hotspot-login', 'http://nama_domain/login');
                } else {
                  session()->put('link-hotspot-login', 'http://nama_domain/login');
              }
            }
        }

        if(!$isValidRequest) {
            $title = "Akses Ditolak - Adeeva Grosir Hotspot";
            return response()->view('frontend.denied-page', ['title' => $title], 403);
        }


        return $next($request);
    }
}
