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

class Pon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pon';
    protected $fillable = [
        'pon',
        'description',

    ];


}
