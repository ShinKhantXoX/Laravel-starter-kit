<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $connection;

    public function __construct()
    {
        $this->connection = env('spa_api');
    }

    protected $tables = "roles";

    protected $fillable = [
        'name', 'guard_name', 'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_merchant' => 'boolean',
    ];
}