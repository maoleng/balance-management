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
                'required',
            ],
            'is_credit' => [
                'required',
            ],
        ];
    }

}
