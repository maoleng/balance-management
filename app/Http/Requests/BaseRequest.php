<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = array_column((new ValidationException($validator))->errors(), 0);
        session()->flash('errors', $errors);

        throw new HttpResponseException(
            back()->withInput($this->input())
        );
    }

}
