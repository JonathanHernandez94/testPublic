<?php

namespace App\Http\Requests;

use App\Helpers\JsonResponseWrapperHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ValidationException(
            $validator,
            JsonResponseWrapperHelper::ErrorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->toArray())
        );
    }
}
