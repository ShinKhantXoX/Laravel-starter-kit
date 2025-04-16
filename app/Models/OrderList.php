<?php

namespace App\Models;

use App\Models\{
    Order,
    Menu
};
use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OrderList extends Model
{
    use HasFactory, SoftDeletes, BasicAudit;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        "order_id",
        "menu_id",
        "name",
        "price",
        "quantity",
        "amount",
        "status"
    ];

    // Automatically generate a UUID when creating a new Employee.
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($orderList) {
            if (empty($orderList->id)) {
                $orderList->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationship: OrderList belongs to a Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getOrderStatusAttribute()
    {
        return optional($this->order)->status; // Correct relationship reference
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function getMenuNameAttribute()
    {
        return optional($this->menu)->name; // Correct relationship reference
    }

    protected $appends = ['order_status', 'menu_name'];
    protected $hidden = ['order', 'menu'];
}
