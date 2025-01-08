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
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isUser()
    {
        return $this->role == 'user';
    }

    public function isCashier()
    {
        return $this->role == 'cashier';
    }


    public function isTechnician()
    {
        return $this->role == 'technician';
    }

    public function due_amount($id)
    {
        $user = self::where('id', $id)->firstOrFail();

        $bill = Billing::where('user_id', $user->id)->sum('package_price');
        $pay = Payment::where('user_id', $user->id)->sum('package_price');

        return $bill - $pay;
    }

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }

    public function service_details()
    {
        return $this->hasOne(ServiceDetails::class);
    }

    public function billing()
    {
        return $this->hasMany(Billing::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
    public function archieve_details()
    {
        return $this->hasOne(ArchieveDetail::class);
    }

    public function userLimit()
    {
        return $this->hasOne(UserLimit::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->userLimit()->delete();
        });
    }
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
    

}
