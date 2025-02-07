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

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'dob',
        'pin',
        'router_password',
        'package_name',
        'package_price',
        'package_start',
        'due',
        'status',
        'account_number',
        'name',
        'router_id',
        'area',
        'coordinates',
        'is_lock',
        'subscription',
        'my_profile',
        'remarks',
        'router_name',
        'olt',
        'pon',
        'nap',
        'port',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service_details()
    {
        return $this->hasOne(ServiceDetails::class, 'user_id', 'user_id');
    }

    public function miktrotikParameters()
{
    return $this->hasOne(MikrotikParamter::class, 'user_id', 'user_id');
}
}
