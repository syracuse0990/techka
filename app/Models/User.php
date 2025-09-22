<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

     protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Maintenance::class, 'role_id')->selectRaw("id, meta_name as role");
    }

    public function role_data()
    {
        return $this->belongsTo(Maintenance::class, 'role_id');
    }

    public function permissions(){
       return $this->belongsTo(Permissions::class, 'role_id', 'maintenance_role_id');
    }

    public function address(){
       return $this->hasOne(UserAddress::class, 'user_id');
    }

    public function educations(){
       return $this->hasMany(UserEducation::class, 'user_id');
    }

    public function languages(){
       return $this->hasMany(UserLanguages::class, 'user_id');
    }


}
