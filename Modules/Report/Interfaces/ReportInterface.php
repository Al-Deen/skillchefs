<?php

namespace Modules\Report\Interfaces;

use Illuminate\Http\Request;

interface ReportInterface
{

    public function studentEngagement($request);

    public function studentEngagementExport();

    public function instructorEngagement($request);

    public function instructorEngagementExport();

    public function purchaseHistory($request);

    public function purchaseHistoryExport();

    public function courseCompletion($request);

    public function courseCompletionExport();

    public function studentPerformance($request);

    public function studentPerformanceExport();

    public function transaction($request);
    
    public function transactionExport();


}
