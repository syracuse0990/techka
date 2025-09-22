<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PhilippineRegion, PhilippineProvince, PhilippineCity, PhilippineBarangay};

class LocationController extends BaseController
{
    public function fetchRegions()
    {
        $data = PhilippineRegion::all();
        $regions = [];

        foreach ($data as $item) {
            $regions[] = [
                'value' => $item->region_code,
                'label' => $item->region_description
            ];
        }

        return $this->sendResponse($regions, "Region lists.");
    }

    // public function fetchProvinces(Request $request){

    //     $region = $request->get('region');

    //     $data = PhilippineProvince::when(($request->filled('region')), function($query) {
    //         $query->where('region_code',$region);
    //     })->get();
    //     $provinces = [];

    //     foreach ($data as $item) {
    //         $provinces[] = [
    //             'value' => $item->province_code,
    //             'label' => ucwords($item->province_description)
    //         ];
    //     }

    //     return $this->sendResponse($provinces, "Province lists.");
    // }


    public function fetchProvinces(Request $request)
    {
        $region = $request->get('region');

        $data = PhilippineProvince::when($request->filled('region'), function ($query) use ($region) {
            $query->where('region_code', $region);
        })->get();

        $provinces = [];

        foreach ($data as $item) {
            $provinces[] = [
                'value' => $item->province_code,
                'label' => ucwords($item->province_description)
            ];
        }

        return $this->sendResponse($provinces, "Province lists.");
    }


    public function fetchCities(Request $request){

        $province = $request->get('province');

        $data = PhilippineCity::where('province_code',$province)->get();
        $cities = [];

        foreach ($data as $item) {
            $cities[] = [
                'value' => $item->city_code,
                'label' => ucwords(strtolower($item->city_name))
            ];
        }

        return $this->sendResponse($cities, "City lists.");
    }

    public function fetchBarangays(Request $request){

        $city = $request->get('city');

        $data = PhilippineBarangay::where('city_code',$city)->get();
        $barangays = [];

        foreach ($data as $item) {
            $barangays[] = [
                'value' => $item->id,
                'label' => ucwords($item->barangay_name)
            ];
        }

        return $this->sendResponse($barangays, "Barangay lists.");
    }
}
