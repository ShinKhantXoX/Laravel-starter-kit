<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MenuCategory extends Model
{
    use HasFactory, SoftDeletes, BasicAudit;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "menu_categories";

    protected $fillable = [
        "label",
        "description",
        "status"
    ];

    // Automatically generate a UUID when creating a new Employee.
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($menuCategory) {
            if (empty($menuCategory->id)) {
                $menuCategory->id = (string) Str::uuid();
            }
        });
    }
}
