<?php

namespace App\Http\Requests\Web\Maintenance;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->isMethod('post') ? $this->createRules() : $this->updateRules();
    }

    private function createRules(): array
    {
        return [
            'meta_parent' => 'required',
            'meta_name' => 'required',
            'meta_value' => 'required',
        ];
    }

    private function updateRules(): array
    {
        return [
            'meta_parent' => 'required',
            'meta_name' => 'required',
            'meta_value' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            "meta_name.required" => "This field is required.",
            "meta_value.required" => "This field is required.",
        ];
    }
}
