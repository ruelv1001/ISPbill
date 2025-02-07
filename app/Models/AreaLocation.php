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

class AreaLocation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'area_location';
    protected $fillable = [
        'area',
        'description',

    ];


}
