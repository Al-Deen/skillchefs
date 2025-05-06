<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\LanguageInterface;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Course\Http\Requests\Instructor\CourseRequest;
use Modules\Course\Http\Requests\Instructor\UpdateCourseRequest;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Order\Interfaces\EnrollInterface;

class BookController extends Controller
{

    use ApiReturnFormatTrait, FileUploadTrait;
    // constructor injection
    protected $course;
    protected $courseCategory;
    protected $language;
    protected $enrollInterface;

    public function __construct(
        CourseInterface $courseInterface,
        CourseCategoryInterface $courseCategoryInterface,
        LanguageInterface $languageInterface,
        EnrollInterface $enrollInterface
    ) {
        $this->course = $courseInterface;
        $this->courseCategory = $courseCategoryInterface;
        $this->language = $languageInterface;
        $this->enrollInterface = $enrollInterface;
    }


    public function books(Request $request)
    {

        try {
            $data['title'] = 'My Books';
            $data['courses'] = Book::where('created_by', auth()->user()->id)->paginate(10);
            return view('panel.instructor.book.my_books', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function addBook()
    {
        try {
            if (Auth::user()->status_id != 4) {
                return redirect()->route('instructor.books')->with('danger','You can not create book !');
            }
            $data['categories'] = $this->courseCategory->model()->active()->where('parent_id', null)->get(); // data
            $data['languages'] = $this->language->all(); // data
            $data['title'] = 'Add New Book';
            return view('panel.instructor.book.add_book', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function storeBook(Request $request)
    {
        try {
            $data = $request->all();
            if ($request->point_title){
                $data['point_title']=json_encode($request->point_title);
            }
            if ($request->point_description){
                $data['point_description']=json_encode($request->point_description);
            }
            $data['slug'] = Str::slug($request->title) . '-' . Str::random(8);
            $data['created_by'] = auth()->user()->id;
            $data['instructor_id'] = auth()->user()->id;



            if ($request->hasFile('thumbnail')) {
                $upload = $this->uploadFile($request->thumbnail, 'book/thumbnail/thumbnail', [[100, 100], [300, 300], [600, 600]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $data['image'] = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
            // Short File upload
            if ($request->hasFile('short_file')) {
                $upload = $this->uploadFile($request->short_file, 'book/file/short_file', [], '', 'file'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $data['short_file'] = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            if ($request->hasFile('full_file')) {
                $upload = $this->uploadFile($request->full_file, 'book/file/full_file', [], '', 'file'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $data['full_file'] = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }
              Book::create($data);
            return redirect()->route('instructor.books')->with('success', 'Subscription Plan Created successfully.');

        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
