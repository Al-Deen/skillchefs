<?php

namespace Modules\CMS\Entities;

use App\Traits\Relationship\StatusRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    use HasFactory, StatusRelationTrait;

    protected $fillable = [];

    // booted
    protected static function booted()
    {
        static::created(function ($footer_menus) { // when footer_menus created then forget cache
            cache()->forget('footer_menus');
        });

        static::saved(function ($footer_menus) { // when footer_menus created then forget cache
            cache()->forget('footer_menus');
        });

        static::updated(function ($footer_menus) { // when footer_menus updated then forget cache
            cache()->forget('footer_menus');
        });

        static::deleted(function ($footer_menus) { // when footer_menus deleted then forget cache
            cache()->forget('footer_menus');
        });
    }

    // search by title
    public function scopeSearch($query, $req)
    {
        $where = [];
        if (@$req->search) {
            $where[] = ['name', 'like', '%' . @$req->search . '%'];
        }
        if (@$req->status) {
            $where[] = ['status_id', @$req->status];
        }

        return $query->where($where);
    }

    public function allLink()
    {
        return json_decode($this->links);
    }
}
