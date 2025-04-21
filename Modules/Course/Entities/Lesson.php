<?php

namespace Modules\Course\Entities;

use App\Models\Upload;
use Modules\Course\Entities\Section;
use Modules\Course\Entities\Question;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\QuizResult;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // Course relationship
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // search by title
    public function scopeSearch($query, $req)
    {
        $where = [];
        if (@$req->search) {
            $where[] = ['title', 'like', '%' . @$req->search . '%'];
        }

        return $query->where($where);
    }

    // image upload relation 
    public function image(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'image_file');
    }

    // video upload relation
    public function video(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'video_file');
    }

    // attachment upload relation
    public function attachmentFile(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'attachment');
    }

    // section relationship
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // question relationship
    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id')->orderBy('order', 'asc');
    }

    // relation with submission 
    public function submissions()
    {
        return $this->hasMany(QuizResult::class, 'quiz_id');
    }
}
