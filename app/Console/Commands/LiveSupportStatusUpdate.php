<?php

namespace App\Console\Commands;

use App\Models\LiveSupport;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LiveSupportStatusUpdate extends Command
{
    protected $signature = 'live-support:update-status';
    protected $description = 'Update live support status based on current time';

    public function handle()
    {
        $now = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        LiveSupport::where('status', 1)
            ->where('end_time', '<=', $now)
            ->each(function ($support) use ($now) {
                $support->status = 2; // Completed
                $support->save();

                // Step 2: Find next pending request for same support_id & course_id
                $next = LiveSupport::where('status', 0)
                    ->where('support_id', $support->support_id)
                    ->where('course_id', $support->course_id)
                    ->where('start_time','<=', $now)
                    ->orderBy('start_time', 'asc')
                    ->first();

                if ($next) {
                    $next->status = 1; // Activate next
                    $next->save();
                }
            });

        // Step 3: Activate those whose start_time is now (in case missed by earlier step)
        LiveSupport::where('status', 0)
            ->where('start_time','<=', $now)
            ->each(function ($support) {
                $support->status = 1;
                $support->save();
            });

        $this->info('Live support statuses updated successfully.');
    }
}
