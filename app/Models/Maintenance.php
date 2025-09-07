<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $guarded = [];
    protected $casts = [
        'meta_array' => 'array'
    ];

    public function permissions()
    {
        return $this->belongsTo(Permissions::class, 'id', 'maintenance_role_id');
    }
}
