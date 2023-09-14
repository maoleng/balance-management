<?php

namespace App\Http\Requests;

class TransactionRequest extends BaseRequest
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
        ];
    }

}
