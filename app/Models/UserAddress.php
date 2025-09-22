<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //

    protected $guarded = [];

    public function region(){
        return $this->belongsTo(PhilippineRegion::class, 'region_id', 'region_code')->selectRaw("id,region_code,region_description as region");
    }
    public function province(){
        return $this->belongsTo(PhilippineProvince::class, 'province_id', 'province_code')->selectRaw("id, province_code, province_description as province");
    }
    public function city(){
        return $this->belongsTo(PhilippineCity::class, 'city_id', 'city_code')->selectRaw("id, city_code, city_name as city");
    }
    public function barangay(){
        return $this->belongsTo(PhilippineBarangay::class, 'barangay_id', 'id')->selectRaw("id, barangay_name as barangay");
    }
}
