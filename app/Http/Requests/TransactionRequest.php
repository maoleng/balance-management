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
                'required_without:new_reason',
            ],
            'type' => [
                'required',
            ],
            'new_reason' => [
                'required_without:reason_id',
            ],
            'new_reason_label' => [
                'nullable',
            ],
        ];
    }

}
