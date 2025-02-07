<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User
 *
 * @mixin Eloquent
 */
class UserLimit extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'user_limit';

    protected $fillable = [
        'dashboard_create',
        'dashboard_edit',
        'dashboard_delete',
        'dashboard_view',
        'packages_create',
        'packages_edit',
        'packages_delete',
        'packages_view',
        'customer_create',
        'customer_edit',
        'customer_delete',
        'customer_view',
        'service_detail_create',
        'service_detail_edit',
        'service_detail_delete',
        'service_detail_view',
        'transaction_create',
        'transaction_edit',
        'transaction_delete',
        'transaction_view',
        'router_create',
        'router_edit',
        'router_delete',
        'router_view',
        'user_management_create',
        'user_management_edit',
        'user_management_delete',
        'user_management_view',
        'tickets_create',
        'tickets_edit',
        'tickets_delete',
        'tickets_view'
        ,
        'dashboard_table',
        'package_table',
        'customer_table',
        'service_detail_table',
        'transaction_table',
        'router_table',
        'user_management_table',
        'ticket_table'
        ,
        'user_type'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
