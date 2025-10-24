<?php

namespace Modules\SystemRoles;

use Database\Factories\SystemRoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemRoleModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'system_roles';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return SystemRoleFactory::new();
    }

    // Campos de la tabla
    protected $fillable = ['key', 'name', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con UserModel
    public function users()
    {
        return $this->hasMany(\Modules\Users\UserModel::class, 'system_role_id');
    }

    // Relación con RolePermissionsModel
    // public function rolePermissions()
    // {
    //     return $this->hasMany(\Modules\RolePermissions\RolePermissionModel::class, 'system_role_id');
    // }
}
