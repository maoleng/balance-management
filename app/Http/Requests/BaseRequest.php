<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    abstract public function rules(): array;

    protected function failedValidation(Validator $validator): void
    {
        $response = new Response([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 200);

        throw new ValidationException($validator, $response);
    }

    protected function throwValidationException($message): void
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $message,
        ]));
    }

}
