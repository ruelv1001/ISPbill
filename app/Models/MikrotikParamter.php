<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Detail
 *
 * @mixin Eloquent
 */

class MikrotikParamter extends Model
{
    use HasFactory;
    protected $table = 'miktrotik_parameters';
    public $timestamps = false;
    protected $fillable = [
        'uptime',
        'down_time',
        'last_login',
        'last_logout',
        'router_name',
        'router_ip',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service_details()
    {
        return $this->hasOne(ServiceDetails::class, 'user_id', 'user_id');
    }

    
}
