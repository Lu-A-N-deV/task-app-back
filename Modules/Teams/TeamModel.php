<?php

namespace Modules\Teams;

use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'teams';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return TeamFactory::new();
    }

    // Campos de la tabla
    protected $fillable = ['name', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Agregar relaciones
}
