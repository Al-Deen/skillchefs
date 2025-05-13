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
            $data['books'] = Book::search($request)->paginate($request->show ?? 10); // data
            $data['title'] = "Book List";

            $data['selectedInstructor'] = null;
            if ($request->instructor_id) {
                $data['selectedInstructor'] = User::find($request->instructor_id);
            }
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

    public function edit($id)
    {
        try {
            $data['instructors'] = User::where('role_id','!=',4 )->where('status',1)->get();
            $data['book'] = Book::find($id);
            $data['title'] ="Edit Book";
            $data['languages'] = $this->language->all();
            return view('backend.books.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function shortFilePDFView($id)
    {
        $book = Book::find($id);
        $filePath = public_path($book->short_file);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found!');
        }
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        if ($fileExtension === 'docx') {
            $phpWord = IOFactory::load($filePath);
            $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
            $tempHtmlFile = storage_path('app/temp-story.html');
            $htmlWriter->save($tempHtmlFile);
            $dompdf = new Dompdf();
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'SolaimanLipi'); // Set the default Bangla font
            $dompdf->setOptions($options);
            $dompdf->loadHtml(file_get_contents($tempHtmlFile));
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            return $dompdf->stream('story.pdf', [
                'Attachment' => false,  // Set to true to force download
            ]);
        } elseif ($fileExtension === 'pdf') {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
            ]);
        }
        return redirect()->back()->with('error', 'Unsupported file format!');
    }

    public function fullFilePDFView($id)
    {
        $book = Book::find($id);
        $filePath = public_path($book->full_file);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found!');
        }
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        if ($fileExtension === 'docx') {
            $phpWord = IOFactory::load($filePath);
            $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
            $tempHtmlFile = storage_path('app/temp-story.html');
            $htmlWriter->save($tempHtmlFile);
            $dompdf = new Dompdf();
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'SolaimanLipi'); // Set the default Bangla font
            $dompdf->setOptions($options);
            $dompdf->loadHtml(file_get_contents($tempHtmlFile));
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            return $dompdf->stream('story.pdf', [
                'Attachment' => false,  // Set to true to force download
            ]);
        } elseif ($fileExtension === 'pdf') {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
            ]);
        }
        return redirect()->back()->with('error', 'Unsupported file format!');
    }

    public function update(Request $request, $slug)
    {
        try {
            $book =Book::where('slug', $slug)->first();
            if (!$book) {
                return redirect()->back()->with('danger','Book not Found !');
            }

            $data = $request->all();
            if ($request->title != $book->title) {
                $data['slug'] = Str::slug($request->title) . '-' . Str::random(8);
            }

            if ($request->point_title){
                $data['point_title']=json_encode($request->point_title);
            }
            if ($request->point_description){
                $data['point_description']=json_encode($request->point_description);
            }
            $data['updated_by'] = auth()->user()->id;


            if ($request->hasFile('thumbnail')) {
                if ($book->thumbnail && file_exists(public_path($book->thumbnail))) {
                    unlink(public_path($book->thumbnail));
                }
                $image = $request->file('thumbnail');
                $imageName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('uploads/book/thumbnail/' . $imageName);
                Image::make($image)->resize(600, 600)->save($imagePath);
                $data['thumbnail'] = 'uploads/book/thumbnail/' . $imageName;
            }

            if ($request->hasFile('short_file')) {
                if ($book->short_file && file_exists(public_path($book->short_file))) {
                    unlink(public_path($book->short_file));
                }
                $file = $request->file('short_file');
                $fileName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/book/file/' . $fileName;
                $file->move(public_path('uploads/book/file'), $fileName);
                $data['short_file'] = $filePath;
            }

            if ($request->hasFile('full_file')) {
                if ($book->full_file && file_exists(public_path($book->full_file))) {
                    unlink(public_path($book->full_file));
                }
                $file = $request->file('full_file');
                $fileName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $filePath = 'uploads/book/file/' . $fileName;
                $file->move(public_path('uploads/book/file'), $fileName);
                $data['full_file'] = $filePath;
            }
            $book->update($data);
            return redirect()->route('book.index')->with('success', 'Book Updated Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function delete($id)
    {
        try {
            $book =Book::find($id);
            $uploadImage = $this->deleteFile($book->thumbnail, 'delete'); // delete file from storage
            if (!$uploadImage['status']) {
                return $this->responseWithError($uploadImage['message'], [], 400); // return error response
            }

            $uploadShortFile = $this->deleteFile($book->short_file, 'delete'); // delete file from storage
            if (!$uploadShortFile['status']) {
                return $this->responseWithError($uploadShortFile['message'], [], 400); // return error response
            }
            $uploadFullFile = $this->deleteFile($book->full_file, 'delete'); // delete file from storage
            if (!$uploadFullFile['status']) {
                return $this->responseWithError($uploadFullFile['message'], [], 400); // return error response
            }
            $book->delete();
            return redirect()->back()->with('success', 'Book Deleted Successfully');

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

}
