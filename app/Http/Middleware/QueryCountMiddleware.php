<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class QueryCountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        //todo remove this middleware
        DB::connection()->enableQueryLog();

        $result = $next($request);

        $queryLog = DB::getQueryLog();
        $queryCount = count($queryLog);

        if ($queryCount > 20) {
            Log::warning('Query count: ' . $queryCount);
        }

        return $result;
    }
}
