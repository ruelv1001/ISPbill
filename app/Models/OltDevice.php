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

class OltDevice extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'olt';
    protected $fillable = [
        'olt_device',
        'description',

    ];


}
