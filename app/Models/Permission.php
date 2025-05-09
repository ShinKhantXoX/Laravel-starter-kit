<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $connection;

    public function __construct()
    {
        $this->connection = env('spa_api');
    }

    protected $tables = "permissions";

    protected $fillable = [
        'name', 'guard_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}