<?php

namespace Modules\Tags;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'team_id',
        'name',
        'color',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected static function newFactory()
    {
        return \Database\Factories\TagFactory::new();
    }

    public function team()
    {
        return $this->belongsTo(\Modules\Teams\TeamModel::class, 'team_id');
    }

    public function taskTags()
    {
        return $this->hasMany(\Modules\TaskTags\TaskTagModel::class, 'tag_id');
    }
}
