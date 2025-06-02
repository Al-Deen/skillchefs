<?php

namespace App\Console\Commands;

use App\Models\LiveSupport;
use App\Models\Support;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateSupportStatus extends Command
{
    protected $signature = 'support:update-status';
    protected $description = 'Update support status based on start_time and end_time';

    public function handle()
    {
        $now = Carbon::now('Asia/Dhaka');

        $activatedSupports = Support::whereTime('start_time','<=', $now)->whereTime('end_time','>=', $now)->update(['status' => 1]);
        if ($activatedSupports) {
            $this->info("Support(s) activated.");
        }
        $supportsToDeactivate = Support::whereTime('end_time','<=', $now)->get();


        if (count($supportsToDeactivate) > 0){
        foreach ($supportsToDeactivate as $support) {
            $support->status = 0;
            $support->save();
            LiveSupport::where('support_id', $support->id)
                ->where('course_id', $support->course_id)
                ->delete();

            $this->info("Support ID {$support->id} deactivated and related live supports deleted.");
        }
         }

        return 0;


    }
}
