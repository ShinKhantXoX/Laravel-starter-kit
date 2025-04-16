<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, BasicAudit, SoftDeletes, HasRoles, HasPermissions;

    protected $primaryKey = 'id';
    protected $keyType = 'string'; // Ensure UUID is treated as a string
    public $incrementing = false; // Disable auto-incrementing ID

    protected $guard_name = ['dashboard'];

    protected $fillable = [
        'id', // Ensure `id` is fillable
        'username',
        'email',
        'phone',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = (string) Str::uuid(); // Assign UUID before creating
            }
        });
    }
}
