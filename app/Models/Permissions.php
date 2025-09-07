<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $guarded = [];
    protected $casts = [
        'data_array' => 'array'
    ];
}
