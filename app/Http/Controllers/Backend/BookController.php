<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\Role;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\LanguageInterface;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Modules\Course\Http\Requests\Instructor\CourseRequest;
use Modules\Course\Http\Requests\Instructor\UpdateCourseRequest;
use Modules\Course\Interfaces\CourseCategoryInterface;
use Modules\Course\Interfaces\CourseInterface;
use Modules\Order\Interfaces\EnrollInterface;

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\IOFactory;

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


    public function index(Request $request)
    {
        try {
           // $data['params'] = $this->course->params($request); // table header
            $data['books'] = Book::search($request)->paginate($request->show ?? 10); // data
            $data['title'] = "Books";
            return view('backend.books.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function create()
    {
        try {
            $data['instructors'] = User::where('role_id','!=',4 )->where('status',1)->get(); // data
            $data['languages'] = $this->language->all(); // data
            $data['title'] = 'Create Book';
            return view('backend.books.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function store(Request $request)
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
            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $imageName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('uploads/book/thumbnail/' . $imageName);
                // Save Original Image
                Image::make($image)->resize(600, 600)->save($imagePath);
                $data['thumbnail'] = 'uploads/book/thumbnail/' . $imageName;
            }
            if ($request->hasFile('short_file')) {
                $file = $request->file('short_file');
                $fileName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/book/file/' . $fileName;
                $file->move(public_path('uploads/book/file'), $fileName);
                $data['short_file'] = $filePath;
            }

            if ($request->hasFile('full_file')) {
                $file = $request->file('full_file');
                $fileName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/book/file/' . $fileName;
                $file->move(public_path('uploads/book/file'), $fileName);
                $data['full_file'] = $filePath;
            }
            Book::create($data);
            return redirect()->route('book.index')->with('success', 'Book Created successfully.');
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
