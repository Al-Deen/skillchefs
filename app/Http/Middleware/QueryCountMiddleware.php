<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueryCountMiddleware
{
    public function handle($request, Closure $next)
    {
        DB::enableQueryLog();

        $response = $next($request);

        $queries = DB::getQueryLog();

        // foreach ($queries as $query) {
        //     Log::info('Query: ' . $query['query']);
        // }

        $queryCount = count($queries);

        Log::info('Query Count: ' . $queryCount);

        return $response;
    }
}
