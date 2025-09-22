<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, UserAddress, UserEducation, UserLanguages};
use App\Models\Maintenance;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Services\ImageService;
use Illuminate\Support\Str;
use App\Http\Requests\Web\Users\PrimaryDetailsRequest;
use Illuminate\Support\Facades\Storage;


class UsersController extends BaseController
{
    public function __construct(private ImageService $imageService)
    {

    }

    public function updatePrimaryDetails(PrimaryDetailsRequest $request)
    {
        $user = User::find(auth()->id());

        $data = [
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'middle_name' => $request->middle_name,
            'mobile'      => $request->mobile,
            'email'       => $request->email,
        ];

        if (preg_match('/^data:image\/(\w+);base64,/', $request->get('avatar'), $match)) {
            if ($user->avatar) {
                $sizes = ['100x100', '500x500', '250x150'];
                foreach ($sizes as $size) {
                    $path = public_path("logo/{$size}/{$user->avatar}");
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            $data['avatar'] = $this->imageService->processLogo($request->get('avatar'), $request->first_name);
        }

        foreach( $request->education as $item){
            UserEducation::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'school_name'  => $item['school_name'],
                ],
                [
                    'from_year'   => $item['from_year'],
                    'to_year' => $item['to_year'],
                    'degree'     => $item['degree'],
                    'area_study' => $item['area_study'],
                ]
            );
        }

        foreach ($request->languages as $item) {
            UserLanguages::updateOrCreate(
                [
                    'user_id'  => $user->id,
                    'language' => $item['language'],
                ],
                [
                    'proficiency_level' => $item['proficiency_level'],
                ]
            );
        }

        UserAddress::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'address'     => $request->address,
                'region_id'   => $request->region,
                'province_id' => $request->province,
                'city_id'     => $request->city,
                'barangay_id' => $request->barangay,
            ]
        );

        $user->update($data);

        return $this->sendResponse($user, 'Profile data has been updated.');
    }

    public function userData(Request $request){
        $user = User::find($request->id);

        $data  = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'middle_name' => $user->middle_name,
            'mobile' => $user->mobile,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'address' => $user->address->address,
            'region' => $user->address->region,
            'province' => $user->address->province,
            'city' => $user->address->city,
            'barangay' => $user->address->barangay,
            'educations' => $user->educations,
            'languages' => $user->languages,
        ];

        return $this->sendResponse($data, 'User data.');
    }

}

