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
        $rules = [
            'price' => [
                'required',
                'numeric',
            ],
            'type' => [
                'nullable',
            ],
            'new_reason_label' => [
                'nullable',
            ],
        ];
        $reason_rules = [
            'reason_id' => [
                $this->type === null ? 'nullable' : 'required_without:new_reason',
            ],
            'new_reason' => [
                $this->type === null ? 'nullable' : 'required_without:reason_id',
            ],
        ];

        return array_merge($rules, $reason_rules);
    }

}
