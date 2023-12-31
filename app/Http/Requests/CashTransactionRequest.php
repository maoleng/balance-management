<?php

namespace App\Http\Requests;

class CashTransactionRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'price' => [
                'required',
                'numeric',
            ],
            'type' => [
                'required',
            ],
            'reason' => [
                'nullable',
            ],
            'is_credit' => [
                'required',
            ],
        ];
    }

}
