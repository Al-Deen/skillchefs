<?php

namespace Modules\Report\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Modules\Accounts\Interfaces\AccountInterface;
use Modules\Instructor\Interfaces\InstructorInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Report\Interfaces\ReportInterface;
use Modules\Student\Interfaces\StudentInterface;

class ReportRepository implements ReportInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    protected $student;
    protected $instructor;
    protected $enroll;
    protected $account;

    public function __construct(
        StudentInterface $StudentInterface,
        InstructorInterface $InstructorInterface,
        EnrollInterface $enrollRepository,
        AccountInterface $accountInterface
    ) {
        $this->student = $StudentInterface;
        $this->instructor = $InstructorInterface;
        $this->enroll = $enrollRepository;
        $this->account = $accountInterface;
    }

    public function studentEngagement($request)
    {
        return $this->student->model()->filter($request->search)->paginate($request->show ?? 10); // data
    }

    public function studentEngagementExport()
    {
        return $this->student->model()->get(); // data
    }

    public function instructorEngagement($request)
    {
        return $this->instructor->model()->filter($request->search)->active()->paginate($request->show ?? 10); // data
    }

    public function instructorEngagementExport()
    {
        return $this->instructor->model()->get(); // data
    }

    public function purchaseHistory($request)
    {
        return $this->enroll->model()->with('orderItem')->search($request)->orderBy('id', 'DESC')->paginate(10);
    }

    public function purchaseHistoryExport()
    {
        return $this->enroll->model()->select('order_item_id', 'course_id', 'user_id', 'instructor_id')->with('orderItem')->get();
    }

    public function courseCompletion($request)
    {
        return $this->enroll->model()->where('is_completed', 1)->with('course:id,title,course_duration,point,course_category_id,slug')
            ->search($request)
            ->latest()
            ->paginate(10);
    }

    public function courseCompletionExport()
    {
        return $this->enroll->model()->where('is_completed', 1)->with('course:id,title,course_duration,point,course_category_id,slug')->get();
    }

    public function studentPerformance($request)
    {
        return $this->student->model()->filter($request->search)->orderBy('points', 'DESC')->paginate($request->show ?? 10); // data
    }

    public function studentPerformanceExport()
    {
        return $this->student->model()->orderBy('points', 'DESC')->get(); // data
    }

    public function transaction($request)
    {
        return $this->account->transactionModel()->search($request)->orderBy('id', 'DESC')->paginate($request->show ?? 10); // data
    }

    public function transactionExport()
    {
        return $this->account->transactionModel()->get(); // data
    }
}
