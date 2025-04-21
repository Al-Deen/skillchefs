<?php

namespace Modules\Certificate\Entities;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateGenerate extends Model
{
    use HasFactory;

    protected $fillable = [];

    // relation with upload
    public function image()
    {
        return $this->belongsTo(Upload::class, 'upload_id');
    }

    // relation with user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // relation with enroll
    public function enroll()
    {
        return $this->belongsTo(\Modules\Order\Entities\Enroll::class, 'enroll_id');
    }
}
