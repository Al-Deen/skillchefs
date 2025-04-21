<?php

namespace Modules\Report\Http\Controllers;

use App\Exports\CourseCompletionExport;
use App\Exports\InstructorExport;
use App\Exports\PurchaseHistoryExport;
use App\Exports\StudentExport;
use App\Exports\StudentPerformanceExport;
use App\Exports\TransactionExport;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Report\Interfaces\ReportInterface;

class ReportController extends Controller
{

    use ApiReturnFormatTrait;
    protected $report;

    // constructor injection
    public function __construct(
        ReportInterface $reportInterface
    ) {
        $this->report = $reportInterface;
    }

    public function studentEngagement(Request $request)
    {
        try {
            $data['students'] = $this->report->studentEngagement($request);
            $data['title'] = ___('report.Student_Engagement_Report'); // title
            return view('report::student_engagement', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function studentEngagementExport(Request $request)
    {
        try {
            $student = $this->report->studentEngagementExport();
            return Excel::download(new StudentExport($student), 'student-engagement-export.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function instructorEngagement(Request $request)
    {
        try {
            $data['instructors'] = $this->report->instructorEngagement($request);
            $data['title'] = ___('report.Instructor_Engagement_Report'); // title
            return view('report::instructor_engagement', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function instructorEngagementExport(Request $request)
    {
        try {
            $instructor = $this->report->instructorEngagementExport();
            return Excel::download(new InstructorExport($instructor), 'instructor-engagement-export.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function purchaseHistory(Request $request)
    {
        try {
            $data['purchase_histories'] = $this->report->purchaseHistory($request);
            $data['title'] = ___('report.Purchase_History_Report'); // title
            return view('report::purchase_history', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function purchaseHistoryExport(Request $request)
    {
        try {
            $purchase_histories = $this->report->purchaseHistoryExport();
            return Excel::download(new PurchaseHistoryExport($purchase_histories), 'purchase-histories-export.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function courseCompletion(Request $request)
    {
        try {
            $data['course_completions'] = $this->report->courseCompletion($request);
            $data['title'] = ___('report.Course_Completion_Report'); // title
            return view('report::course_completion', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function courseCompletionExport(Request $request)
    {
        try {

            $course_completions = $this->report->courseCompletionExport();
            return Excel::download(new CourseCompletionExport($course_completions), 'course-completions-export.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function studentPerformance(Request $request)
    {
        try {
            $data['student_performances'] = $this->report->studentPerformance($request);
            $data['title'] = ___('report.Student_Performance_Report'); // title
            return view('report::student_performances', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function studentPerformanceExport(Request $request)
    {
        try {
            $student_performances = $this->report->studentPerformanceExport();
            return Excel::download(new StudentPerformanceExport($student_performances), 'student-performances-export.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
    public function transaction(Request $request)
    {
        try {
            $data['transactions'] = $this->report->transaction($request);
            $data['title'] = ___('report.Transaction_Report_List'); // title
            return view('report::transactions', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function transactionExport(Request $request)
    {
        try {
            $transactions = $this->report->transactionExport();
            return Excel::download(new TransactionExport($transactions), 'transactions-export.csv');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
