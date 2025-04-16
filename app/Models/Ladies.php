<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ladies extends Model
{
    use BasicAudit, SoftDeletes, HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'ladies';

    protected $fillable = [
        'profile',
        'name',
        'nrc',
        'phone_number',
        'serial_number',
        'nrc',
        'nrc_front',
        'nrc_back',
        'dob',
        'address',
        'join_date',
        'leave_date',
        'father_name',
        'mother_name',
        'remark',
        'status',
        'lady_type'
    ];

    protected $casts = [
        'dob' => 'date',
        'join_date' => 'datetime',
        'leave_date' => 'datetime',
    ];

    // Automatically generate a UUID when creating a new Employee.
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ladies) {
            if (empty($ladies->id)) {
                $ladies->id = (string) Str::uuid();
            }
        });
    }
}
