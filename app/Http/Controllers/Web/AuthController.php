<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\{Auth, Log, Validator,Hash};
use Illuminate\Http\Request;
use App\Models\{Maintenance, User};


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
        $user->update(['online' => true]);

        return $this->sendResponse(
            [
                'user' => $user,
                'permissions' =>  $user->role_data?->permissions?->data_array ?: [],
            ],
            'Login Successfully.'
        );
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'class' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $role = '';
        $class = $request->class;


        if($class == 'professional'){
            $role = Maintenance::where('meta_value', 'role-techkalista')->first();
        }else if($class == 'client'){
            $role = Maintenance::where('meta_value', 'role-techkliyente')->first();
        }else{
            return $this->sendError( 'You are not authorized to register.', [], 422 );
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role_id' => $role->id,
            'password' => Hash::make($request->password),
        ]);

        $user->update(['online' => true]);

        return $this->sendResponse(
            [
                'user' => $user,
                'permissions' => $user->role_data && $user->role_data->permissions ? $user->role_data->permissions->data_array : [],
            ],
            'Registration successful'
        );
    }



    public function logout()
    {
        $user = Auth::user();
        Auth::logout();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
