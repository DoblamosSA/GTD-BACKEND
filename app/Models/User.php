<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
        'name',
        'password',
        'Nombre_Empleado',
        'role_id',
		 'usersap',
        'usersappassword',
		'EsAprobador',
		'email',
        'usuarioaprobador'
    ];
public $timestamps = false;
protected $perPage = 20;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullName()
    {
        return  $this->name . " " . $this->lastname;
    }

  
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles'); // Utiliza el nombre de la tabla personalizado
    }
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id'); // Utiliza el nombre de la tabla y las columnas personalizadas
    }
    

    public function costonocalidad()
    {
        return $this->hasMany(CostoNocalidad::class);
    }

    public function usuarioAprobador()
    {
        return $this->belongsTo(User::class, 'usuarioaprobador');
    }
}
