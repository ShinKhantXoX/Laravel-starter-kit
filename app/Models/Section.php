<?php

namespace App\Models;

use App\Models\Lady;
use App\Models\Room;
use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use BasicAudit, SoftDeletes;

    protected $table = "sections";

    protected $fillable = [
        "lady_id",
        "room_id",
        "check_in",
        "check_out",
        "section"
    ];

    protected $casts = [
        "check_in" => "datetime",
        "check_out" => "datetime"
    ];

    public function lady()
    {
        return $this->belongTo(Lady::class);
    }

    public function getLadyNameAttribute()
    {
        return $this->lady->name;
    }

    public function room()
    {
        return $this->belongTo(Room::class);
    }

    public function getRoomNameAttribute()
    {
        return $this->room->room_number;
    }
}
