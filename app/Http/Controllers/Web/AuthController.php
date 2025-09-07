<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\{Auth, Log};

class AuthController extends BaseController
{
    // use RolePermissionTrait, Base64ConverterTraits, EmployeeFilterTrait;
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->sendError(
                'Invalid credentials.',
                [
                    'errors' => [
                        'email' => ['Invalid credentials.'],
                        'password' => ['Invalid credentials.'],
                    ],
                ],
                422
            );
        }

        $user = Auth::user();
        // $response = Http::post('http://localhost:8080/broadcast', [
        //     'channel' => "dcoder",
        //     'message' => "Hello ". $user->first_name. "!",
        // ]);


        $user->update(['online' => true]);

        return $this->sendResponse(
            [
                'user' => $user,
                'permissions' => $user->role_data ? $user->role_data->permissions->data_array : [],
            ],
            'Login Successful.'
        );
    }

    public function logout()
    {
        $user = Auth::user();
        Auth::logout();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
