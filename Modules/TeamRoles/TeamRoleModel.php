<?php

namespace Modules\TeamRoles;

use Database\Factories\TeamRoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamRoleModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'team_roles';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return TeamRoleFactory::new();
    }

    // Campos de la tabla
    protected $fillable = ['key', 'team_id', 'name', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con TeamModel
    public function team()
    {
        return $this->belongsTo(\Modules\Teams\TeamModel::class, 'team_id');
    }

    // Relación con TeamUserModel
    public function teamUsers()
    {
        return $this->hasMany(\Modules\TeamUsers\TeamUserModel::class, 'team_role_id');
    }
}
