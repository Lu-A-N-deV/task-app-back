<?php

namespace Modules\Users;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use SoftDeletes, HasFactory, Notifiable;

    protected $table = 'users';

    // Indicar que la clave primaria no es incrementable
    public $incrementing = false;

    // Indicar que la clave primaria es de tipo string (UUID es string)
    protected $keyType = 'string';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return UserFactory::new();
    }

    // Campos de la tabla
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'second_last_name',
        'email',
        'password',
        'genre_id',
        'system_role_id',
    ];

    protected $hidden = ['password', 'created_at', 'updated_at', 'deleted_at'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    // Generar UUID al crear el modelo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relación con GenreModel
    public function genre()
    {
        return $this->belongsTo(\Modules\Genres\GenreModel::class, 'genre_id');
    }

    // Relación con SystemRoleModel
    public function systemRole()
    {
        return $this->belongsTo(\Modules\SystemRoles\SystemRoleModel::class, 'system_role_id');
    }

    // Falta relación con las demás tablas que dependen de users
}
