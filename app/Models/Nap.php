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

class Nap extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'nap';
    protected $fillable = [
        'nap',
        'description',

    ];


}
