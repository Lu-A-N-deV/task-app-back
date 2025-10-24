<?php

namespace Modules\Genres;

use Database\Factories\GenreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenreModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'genres';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return GenreFactory::new();
    }

    // Campos de la tabla
    protected $fillable = ['key', 'name'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con UserModel
    public function users()
    {
        return $this->hasMany(\Modules\Users\UserModel::class, 'genre_id');
    }
}
