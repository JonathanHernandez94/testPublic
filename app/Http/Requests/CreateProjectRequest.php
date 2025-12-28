<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class CreateProjectRequest extends BaseFormRequest
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
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'organization_id' => 'required|exists:organizations,id',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'organization_id' => Auth::guard('api')->getOrganizationId(),
        ]);
    }
}
