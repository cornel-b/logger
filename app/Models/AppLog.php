<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    protected $fillable = [
        'stack_trace',
        'verbosity_level',
        'route_name',
        'route_url',
        'route_path',
        'route_method',
        'route_params',
        'user_id',
        'db_connections',
    ];

    protected $casts = [
        'route_params' => 'array',
        'db_connections' => 'array',
    ];
}
