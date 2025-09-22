<?php

namespace App\Http\Requests\Web\Users;

use Illuminate\Foundation\Http\FormRequest;

class PrimaryDetailsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->isMethod('post') ? $this->createRules() : $this->updateRules();
        return [];
    }

    private function createRules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'region' => 'required',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
        ];
    }

    private function updateRules(): array
    {
        return [
            'role_id' => 'required',
            'permissions' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            "first_name.required" => "First name is required.",
            "last_name.required" => "Last name is required.",
            "mobile.required" => "Mobile number is required.",
            "email.required" => "Email is required.",
            "address.required" => "Address is required.",
            "region.required" => "Region is required.",
            "province.required" => "Province is required.",
            "city.required" => "City is required.",
            "barangay.required" => "Barangay is required.",
        ];
    }

}
