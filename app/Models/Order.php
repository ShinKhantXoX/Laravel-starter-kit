<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, SoftDeletes, BasicAudit;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        "bed_id",
        "room_id",
        "total_amount",
        "pay_amount",
        "refund_amount",
        "remark",
        "payment_type",
        "status"
    ];

    // Automatically generate a UUID when creating a new Employee.
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->id)) {
                $order->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationship: Order belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Relationship: Order belongs to a Bed.
     */
    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }

    public function getRoomNameAttribute()
    {
        return optional($this->room)->name; // Correct relationship reference
    }

    public function getBedNameAttribute()
    {
        return optional($this->bed)->label; // Correct relationship reference
    }

    protected $appends = ['room_name', 'bed_name'];
    protected $hidden = ['room', 'bed'];


}
