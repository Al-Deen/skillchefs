<?php

namespace Modules\Course\Repositories;

use App\Models\Status;
use App\Models\User;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Lesson;
use Modules\Course\Entities\Section;
use Modules\Course\Interfaces\LessonInterface;

class LessonRepository implements LessonInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;
    private $courseModel;
    private $sectionModel;
    protected $userModel;
    protected $statusModel;

    public function __construct(Lesson $lessonModal, Section $sectionModel, Course $courseModel, User $userModel, Status $statusModel)
    {
        $this->model = $lessonModal;
        $this->sectionModel = $sectionModel;
        $this->courseModel = $courseModel;
        $this->userModel = $userModel;
        $this->statusModel = $statusModel;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
            ___('common.Title'),
            ___('course.Section'),
            ___('common.Content'),
            ___('course.Lesson Type'),
            ___('ui_element.action'),
        ];
    }

    public function model()
    {
        return $this->model;
    }

    public function filter($filter = null)
    {
        $model = $this->model;
        if (@$filter) {
            $model = $this->model->where($filter);
        }
        return $model;
    }

    public function params($params = null)
    {
        $instructor = $params->instructor_id ?? null;
        $search = $params->search ?? null;
        return [
            'instructor' => $this->userModel->where('id', $instructor)->first()->name ?? null,
            'search' => $search,
        ];
    }

    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {
            // find sections by section_id
            $section = $this->sectionModel->where('id', $request->section_id)->first();
            if (!$section) {
                return $this->responseWithError(___('alert.course_section_not_found'), [], 400);
            }
            $newLessonModel = new $this->model; // create new object of model for store data in database table
            $newLessonModel->title = $request->title;
            if ($request->is_quiz) {
                $newLessonModel->is_quiz = $request->is_quiz;
                $newLessonModel->is_timer = $request->is_timer ?? 0;
                $newLessonModel->marks = @$request->marks;
                $newLessonModel->pass_marks = @$request->pass_marks;
                $newLessonModel->instruction = @$request->instruction;
                $newLessonModel->duration = $request->duration;
                $message = ___('alert.Course quiz created successfully.');
            } else {
                $newLessonModel->order = $this->model->where('section_id', $request->section_id)->count() + 1;
                $newLessonModel->lesson_type = @$request->lesson_type;
                // is lesson_type ==  VideoFile
                if ($request->lesson_type == 'VideoFile') {
                    $newLessonModel->duration = $request->duration;
                    if ($request->hasFile('video_file')) {
                        $path = 'course/lessons/videos/' . date('m') . '/lesson';
                        $upload = $this->uploadFile($request->video_file, $path, [], '', 'video'); // upload file in storage
                        if ($upload['status']) {
                            $newLessonModel->video_file = $upload['upload_id'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                } elseif ($request->lesson_type == 'Youtube' || $request->lesson_type == 'Vimeo' || $request->lesson_type == 'GoogleDrive') {
                    $newLessonModel->duration = $request->duration;
                    $newLessonModel->video_url = $request->video_url;
                } elseif ($request->lesson_type == 'DocumentFile') {
                    if ($request->hasFile('attachment')) {
                        $path = 'course/lessons/attachments/' . date('m') . '/lesson';
                        $upload = $this->uploadFile($request->attachment, $path, [], '', 'file'); // upload file in storage
                        if ($upload['status']) {
                            $newLessonModel->attachment = $upload['upload_id'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $newLessonModel->attachment_type = $request->document_file_type;
                } elseif ($request->lesson_type == 'Text') {
                    $newLessonModel->lesson_text = $request->lesson_text;
                } elseif ($request->lesson_type == 'IframeEmbed') {
                    $newLessonModel->iframe = $request->iframe;
                } elseif ($request->lesson_type == 'ImageFile') {
                    if ($request->hasFile('image_file')) {
                        $path = 'course/lessons/images/' . date('m') . '/lesson';
                        $upload = $this->uploadFile($request->image_file, $path, [], '', 'image'); // upload file in storage
                        if ($upload['status']) {
                            $newLessonModel->image_file = $upload['upload_id'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                }
                $newLessonModel->content = @$request->content;
                $message = ___('alert.Course lesson created successfully.');

            }
            $newLessonModel->course_id = $request->course_id;
            $newLessonModel->section_id = @$request->section_id;
            $newLessonModel->is_free = @$request->is_free ?? 0;

            $newLessonModel->created_by = auth()->user()->id;
            $newLessonModel->updated_by = auth()->user()->id;
            $newLessonModel->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess($message); // return success response
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $newLessonModel = $this->model->find($id);
            if (!$newLessonModel) {
                return $this->responseWithError(___('alert.course_lesson_not_found'), [], 400);
            }
            $newLessonModel->title = $request->title;
            if ($request->is_quiz) {
                $newLessonModel->is_quiz = $request->is_quiz;
                $newLessonModel->is_timer = $request->is_timer;
                $newLessonModel->marks = @$request->marks;
                $newLessonModel->pass_marks = @$request->pass_marks;
                $newLessonModel->instruction = @$request->instruction;
                $newLessonModel->duration = $request->duration;
                $message = ___('alert.Course quiz update successfully.');
            } else {
                $newLessonModel->content = $request->content;
                $newLessonModel->lesson_type = $request->lesson_type;
                // is lesson_type ==  VideoFile
                if ($request->lesson_type == 'VideoFile') {
                    $newLessonModel->duration = $request->duration;
                    if ($request->hasFile('video_file')) {
                        $path = 'course/lessons/videos/' . date('m') . '/lesson';
                        $upload = $this->uploadFile($request->video_file, $path, [], @$newLessonModel->video_file, 'video'); // upload file in storage
                        if ($upload['status']) {
                            $newLessonModel->video_file = $upload['upload_id'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                } elseif (in_array(@$newLessonModel->lesson_type, ['Youtube', 'Vimeo', 'GoogleDrive'])) {
                    $newLessonModel->duration = $request->duration;
                    $newLessonModel->video_url = $request->video_url;
                } elseif ($request->lesson_type == 'DocumentFile') {
                    if ($request->hasFile('attachment')) {
                        $path = 'course/lessons/attachments/' . date('m') . '/lesson';
                        $upload = $this->uploadFile($request->attachment, $path, [], @$newLessonModel->attachment, 'file'); // upload file in storage
                        if ($upload['status']) {
                            $newLessonModel->attachment = $upload['upload_id'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $newLessonModel->attachment_type = $request->document_file_type;
                } elseif ($request->lesson_type == 'Text') {
                    $newLessonModel->lesson_text = $request->lesson_text;
                } elseif ($request->lesson_type == 'IframeEmbed') {
                    $newLessonModel->iframe = $request->iframe;
                } elseif ($request->lesson_type == 'ImageFile') {
                    if ($request->hasFile('image_file')) {
                        $path = 'course/lessons/images/' . date('m') . '/lesson';
                        $upload = $this->uploadFile($request->image_file, $path, [], @$newLessonModel->image_file, 'image'); // upload file in storage
                        if ($upload['status']) {
                            $newLessonModel->image_file = $upload['upload_id'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                }
                $message = ___('alert.Course lesson updated successfully.');
            }
            $newLessonModel->last_modified = date('Y-m-d H:i:s');

            $newLessonModel->updated_by = auth()->user()->id;
            $newLessonModel->save(); // save data in database table
            DB::commit();
            return $this->responseWithSuccess($message); // return success response
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function sortable($request, $id)
    {
        DB::beginTransaction();
        try {
            $course = $this->courseModel->where('id', $id)->where('created_by', auth()->user()->id)->first();
            if (!$course) {
                return $this->responseWithError(___('alert.Course not found.'), [], 400);
            }
            foreach ($request->data as $key => $lesson_id) {
                $lesson = $this->model->find($lesson_id);
                $lesson->order = $key + 1;
                $lesson->save();
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.Lesson ordered successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $newLessonModel = $this->model->find($id);
            if ($newLessonModel->lesson_type == 'VideoFile') {
                $upload = $this->deleteFile($newLessonModel->video_file, 'delete'); // delete file from storage
                if (!$upload['status']) {
                    return $this->responseWithError($upload['message'], [], 400); // return error response
                }
            } elseif ($newLessonModel->lesson_type == 'DocumentFile') {
                $upload = $this->deleteFile($newLessonModel->attachment, 'delete'); // delete file from storage
                if (!$upload['status']) {
                    return $this->responseWithError($upload['message'], [], 400); // return error response
                }
            } elseif ($newLessonModel->lesson_type == 'ImageFile') {
                $upload = $this->deleteFile($newLessonModel->image_file, 'delete'); // delete file from storage
                if (!$upload['status']) {
                    return $this->responseWithError($upload['message'], [], 400); // return error response
                }
            }
            $newLessonModel->delete();
            return $this->responseWithSuccess(___('alert.Course lesson deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
