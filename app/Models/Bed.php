<?php

namespace App\Models;

use App\Models\Room;
use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bed extends Model
{
    use BasicAudit, SoftDeletes, HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'beds';

    protected $fillable = [
        'room_id',
        'label',
        'bed_number',
        'remark',
        'status'
    ];

    // Automatically generate a UUID when creating a new Bed.
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($bed) {
            if (empty($bed->id)) {
                $bed->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationship: Bed belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }   

    public function getRoomNameAttribute()
    {
        return optional($this->room)->name; // Correct relationship reference
    }       

    protected $appends = ['room_name'];
    protected $hidden = ['room'];
}
