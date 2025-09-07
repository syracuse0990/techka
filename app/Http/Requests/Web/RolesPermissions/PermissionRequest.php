<?php

namespace App\Http\Requests\Web\RolesPermissions;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'role_id' => 'required',
            'permissions' => 'required',
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
            "role_id.required" => "Role name is required.",
            "permissions.required" => "Permissions are required.",
        ];
    }

}
