<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = [
        'method',
        'url',
        'endpoint',
        'ip_address',
        'api_key',
        'user_id',
        'request_body',
        'query_params',
        'user_agent',
        'response_status',
        'response_time_ms',
        'is_suspicious',
        'suspicious_reason',
    ];

    protected $casts = [
        'is_suspicious' => 'boolean',
    ];
}
