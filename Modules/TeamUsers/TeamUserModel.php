<?php

namespace Modules\TeamUsers;

use Database\Factories\TeamUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamUserModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'team_users';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return TeamUserFactory::new();
    }

    // Campos de la tabla
    protected $fillable = ['team_id', 'user_id', 'team_role_id'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con TeamModel
    public function team()
    {
        return $this->belongsTo(\Modules\Teams\TeamModel::class, 'team_id');
    }

    // Relación con UserModel
    public function user()
    {
        return $this->belongsTo(\Modules\Users\UserModel::class, 'user_id');
    }

    // Relación con TeamRoleModel
    public function teamRole()
    {
        return $this->belongsTo(\Modules\TeamRoles\TeamRoleModel::class, 'team_role_id');
    }
}
