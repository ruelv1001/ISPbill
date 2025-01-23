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

class Port extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'port';
    protected $fillable = [
        'port',
        'description',

    ];


}
