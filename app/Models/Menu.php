<?php

namespace App\Models;

use App\Models\MenuCategory;
use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory, SoftDeletes, BasicAudit;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "menus";

    protected $fillable = [
        "menu_category_id",
        "name",
        "description",
        "price",
        "photo",
        "status"
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($menu) {
            if (empty($menu->id)) {
                $menu->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationship: Menu belongs to a MenuCategory.
     */
    public function menu_categories()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id');
    }

    public function getMenuCategoryAttribute()
    {
        return optional($this->menu_categories)->label; // Correct relationship reference
    }

    protected $appends = ['menu_category'];
    protected $hidden = ['menu_categories'];
}

