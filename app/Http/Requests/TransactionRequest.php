<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price' => [
                'required',
                'numeric',
            ],
            'reason_id' => [
                'required',
            ],
            'type' => [
                'required',
            ],
        ];
    }

}
