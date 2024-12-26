<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = ['user_id', 'payment_method', 'payment_amount', 'payment_date', 'remarks', 'ref_code'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
