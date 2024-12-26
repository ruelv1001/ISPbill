<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetails extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['subscription_date', 'previous_due_date', 'active_due_date', 'billing_date', 'user_id'];
    protected $casts = [
        'active_due_date' => 'datetime',
        'billing_date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
