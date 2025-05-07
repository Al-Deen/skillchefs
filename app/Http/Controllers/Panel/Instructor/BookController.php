<?php

namespace App\Http\Controllers\Panel\Instructor;

use App\Enums\Role;
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


    public function books(Request $request)
    {

        try {
            $data['title'] = 'My Books';
            $data['books'] = Book::where('created_by', auth()->user()->id)->search($request)->paginate(10);
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


//
//            if ($request->hasFile('thumbnail')) {
//                $upload = $this->uploadFile($request->thumbnail, 'book/thumbnail/thumbnail', [[100, 100], [300, 300], [600, 600]], '', 'image'); // upload file and resize image 35x35
//                if ($upload['status']) {
//                    $data['thumbnail'] = $upload['upload_id'];
//                } else {
//                    return $this->responseWithError($upload['message'], [], 400);
//                }
//            }
//            // Short File upload
//            if ($request->hasFile('short_file')) {
//                $upload = $this->uploadFile($request->short_file, 'book/file/short_file', [], '', 'file'); // upload file and resize image 35x35
//                if ($upload['status']) {
//                    $data['short_file'] = $upload['upload_id'];
//                } else {
//                    return $this->responseWithError($upload['message'], [], 400);
//                }
//            }
//
//            if ($request->hasFile('full_file')) {
//                $upload = $this->uploadFile($request->full_file, 'book/file/full_file', [], '', 'file'); // upload file and resize image 35x35
//                if ($upload['status']) {
//                    $data['full_file'] = $upload['upload_id'];
//                } else {
//                    return $this->responseWithError($upload['message'], [], 400);
//                }
//            }

            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $imageName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('uploads/book/thumbnail/' . $imageName);
                // Save Original Image
                Image::make($image)->resize(400, 255)->save($imagePath);
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
            return redirect()->route('instructor.books')->with('success', 'Subscription Plan Created successfully.');

        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function bookDetails($slug)
    {
        try {
            $data['title'] = 'Book Details';
            $data['book'] = Book::where('slug',$slug)->first();
            if($data['book']->user->role_id == Role::INSTRUCTOR){
                $data['user_type'] = ___('frontend.Instructor');
                $data['profile'] = view('frontend.partials.book.instructor_profile', compact('data'))->render();

            }
            if ($data['book']) {
                return view('frontend.book.book_details', compact('data'));
            } else {
                return redirect('/')->with('danger','Book Not Found!');
            }
        } catch (\Throwable $th) {
            dd($th);
            return redirect('/')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function editBook($slug)
    {
        try {
            $data['book'] = Book::where('slug', $slug)->where('created_by', auth()->user()->id)->first(); // data
            if (!$data['book']) {
                return redirect()->back()->with('danger','Book not Found !');
            }
            $data['languages'] = $this->language->all(); // data
            $data['title'] = 'Edit Book';
            return view('panel.instructor.book.edit_book', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function updateBook(Request $request, $slug)
    {
        try {
           $book =Book::where('slug', $slug)->where('created_by', auth()->user()->id)->first(); // data
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

//            if ($request->hasFile('thumbnail')) {
//                $upload = $this->uploadFile($request->thumbnail, 'book/thumbnail/thumbnail', [[100, 100], [300, 300], [600, 600]], '', 'image'); // upload file and resize image 35x35
//                if ($upload['status']) {
//                    $data['thumbnail'] = $upload['upload_id'];
//                } else {
//                    return $this->responseWithError($upload['message'], [], 400);
//                }
//            }
            // Short File upload
//            if ($request->hasFile('short_file')) {
//                $upload = $this->uploadFile($request->short_file, 'book/file/short_file', [], '', 'file'); // upload file and resize image 35x35
//                if ($upload['status']) {
//                    $data['short_file'] = $upload['upload_id'];
//                } else {
//                    return $this->responseWithError($upload['message'], [], 400);
//                }
//            }

//            if ($request->hasFile('full_file')) {
//                $upload = $this->uploadFile($request->full_file, 'book/file/full_file', [], '', 'file'); // upload file and resize image 35x35
//                if ($upload['status']) {
//                    $data['full_file'] = $upload['upload_id'];
//                } else {
//                    return $this->responseWithError($upload['message'], [], 400);
//                }
//            }

            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $imageName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('uploads/book/thumbnail/' . $imageName);
                // Save Original Image
                Image::make($image)->resize(400, 255)->save($imagePath);
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

            $book->update($data);
            return redirect()->route('instructor.books')->with('success', 'Book Updated Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function deleteBook($book_id)
    {
        try {
            $book =Book::find($book_id);
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

    public function allbooks(Request $request)
    {
        try {
            $data['title']     = "Books";
            $data['books']  = Book::orderBy('id','DESC')->search($request)->paginate(10);
            return view('frontend.book.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
}
