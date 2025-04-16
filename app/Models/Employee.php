<?php

namespace App\Models;

use App\Models\User;
use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory, SoftDeletes, BasicAudit;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'employee_no',
        'name',
        'phone',
        'date',
        'nrc',
        'nrc_front',
        'nrc_back',
        'address',
        'father_name',
        'mother_name',
        'join_date',
        'leave_date',
        'remark',
        'status',
        'employee_type'
    ];

    protected $casts = [
        'date' => 'datetime',
        'join_date' => 'datetime',
        'leave_date' => 'datetime',
    ];

    // Automatically generate a UUID when creating a new Employee.
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($employee) {
            if (empty($employee->id)) {
                $employee->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationship: Employee belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor for user_name attribute.
     */
    public function getUserNameAttribute()
    {
        return optional($this->user)->username;
    }

    /**
     * Append computed attributes and hide relationships.
     */
    protected $appends = ['user_name'];
    protected $hidden = ['user']; // This hides the user relationship in JSON
}

