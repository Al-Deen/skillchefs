<?php

namespace Modules\Certificate\Entities;

use App\Models\Status;
use App\Models\Upload;
use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = ['default_id'];

    // relation with upload
    public function image()
    {
        return $this->belongsTo(Upload::class, 'image_id');
    }

    function default() {

        return $this->belongsTo(Status::class, 'default_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeSearch($query, $request)
    {
        $where = [];
        if (@$request->search) {
            $where[] = ['title', 'like', '%' . $request->search . '%'];
        }

        return $query->where($where);
    }

}
