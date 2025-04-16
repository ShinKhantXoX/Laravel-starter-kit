<?php

namespace App\Models;

use App\Models\RoomType;
use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Room extends Model
{
     use HasFactory, SoftDeletes, BasicAudit;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = "rooms";

    protected $fillable = [
        "room_type_id",
        "name",
        "room_number",
        "status"
    ];

    // Automatically generate a UUID when creating a new Employee.
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($room) {
            if (empty($room->id)) {
                $room->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationship: Room belongs to a RoomTypes.
     */
    public function room_types()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }

    public function getRoomTypeAttribute()
    {
        return optional($this->room_types)->label; // Correct relationship reference
    }

    protected $appends = ['room_type'];
    protected $hidden = ['room_types'];
}
