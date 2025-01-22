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

class UserType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_type';
    protected $fillable = [
        'role',
        'description',

    ];


}
