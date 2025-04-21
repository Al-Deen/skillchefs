<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class HitRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hit:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $routes = Route::getRoutes();

        // foreach ($routes as $route) {
        //     $uri = $route->uri();
        //     $methods = $route->methods();

        //     // Skip routes without a URI or with a HEAD method
        //     if (empty($uri) || in_array('HEAD', $methods)) {
        //         continue;
        //     }

        //     Log::info("Hitting route: $uri");

        //     try {
        //         $response = Http::get(url($uri));

        //         $statusCode = $response->status();
        //         Log::info("Response: $statusCode");
        //     } catch (\Exception $e) {
        //         Log::error('Failed to hit the route: ' . $e->getMessage());
        //     }
        // }

        // Log::info('All routes have been hit.');

        return Command::SUCCESS;
    }
}
